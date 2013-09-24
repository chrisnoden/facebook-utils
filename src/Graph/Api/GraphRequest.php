<?php
/**
 * Created by Chris Noden using PhpStorm.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category  Class
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace Graph\Api;

use Graph\AccessToken\AccessTokenAbstract;
use Graph\Exception\FacebookApiException;
use Graph\Exception\FacebookAuthException;
use Graph\Exception\FacebookConnectionException;
use Graph\Exception\FacebookUnauthorisedUserException;
use Graph\Exception\InvalidArgumentException;
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\CurlException;
use Graph\AccessToken\AppAccessToken;

/**
 * Class GraphRequest
 * Makes a HTTP GET/POST request to the Facebook Graph API
 *
 * @category  Graph\Api
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class GraphRequest
{

    /**
     * @var AppAccessToken
     */
    protected $access_token;
    /**
     * @var float seconds to wait for connection
     */
    protected $connection_timeout = 1.5;
    /**
     * @var int how many times to attempt sending the message
     */
    protected $max_connection_attempts = 5;
    /**
     * @var string GET or POST
     */
    protected $http_method = 'GET';
    /**
     * @var string id or object name of the facebook graph node
     */
    protected $node;
    /**
     * @var string path (after the node) of the URI
     */
    protected $path;
    /**
     * @var array associative array of querystring parameters
     * eg array( 'fields' => 'about,age_range' )
     * in the final URI becomes a querystring of ?fields=about,age_range
     */
    protected $query_parameters = array();
    /**
     * @var array fields to ask Graph for
     */
    protected $fields = array();
    /**
     * @var Client
     */
    protected $client;


    /**
     * Instantiate a Guzzle HTTP client object
     *
     * @return Client
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client(
                sprintf(
                    '%s://%s',
                    Config::GRAPH_USE_SSL === true ? 'https' : 'http',
                    Config::GRAPH_BASE_URL
                )
            );
            $this->client->setConfig(array('exceptions' => true));
        }

        return $this->client;
    }


    /**
     * @return array the options for the get/post call
     */
    protected function getClientOptions()
    {
        return array(
            'exceptions'      => true,
            'connect_timeout' => $this->connection_timeout,
        );
    }


    /**
     * Construct the full URI (minus the scheme and authority) for our RESTful query
     *
     * @return string
     */
    protected function buildUri()
    {
        // start with the root node
        $uri = $this->node;
        // add any path
        if (isset($this->path)) {
            $uri .= '/' . $this->path;
        }
        // build any query
        if (isset($this->access_token)) {
            $this->query_parameters['access_token'] = $this->access_token->getAccessToken();
        }
        if (count($this->fields) > 0) {
            $this->query_parameters['fields'] = join(',', $this->fields);
        }
        if (count($this->query_parameters) > 0) {
            $uri .= '?' . http_build_query($this->query_parameters);
        }

        return $uri;
    }


    /**
     * Instantiate the correct Guzzle Request Object
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        $client = $this->getClient();

        // create the request
        if ($this->http_method == 'POST') {
            $request = $client->post(
                $this->buildUri(),
                null,
                null,
                $this->getClientOptions()
            );
        } else {
            // GET
            $request = $client->get(
                $this->buildUri(),
                null,
                $this->getClientOptions()
            );
        }

        return $request;
    }


    /**
     * Send our RESTful Api call into Facebook Graph
     *
     * @return Response
     * @throws FacebookUnauthorisedUserException
     *      thrown if we don't have permission to access the specific node (eg a User who has removed the app)
     * @throws FacebookAuthException
     *      thrown if we have insufficient permissions
     * @throws FacebookApiException
     *      thrown is some unknown error came back from Facebook
     * @throws FacebookConnectionException
     *      thrown if we are unable to connect to the Facebook HTTP Api
     */
    public function send()
    {
        $request = $this->getRequest();

        $try = 1;
        do {
            try {
                // send the request and capture the response
                $response = $request->send();
                if ($response->getStatusCode() == 200) {
                    return $response;
                }
            } catch (ClientErrorResponseException $ex) {
                $response = $ex->getResponse();
                if ($response instanceof Response) {
                    if ($response->getStatusCode() == 403) {
                        // FB User is no longer our friend
                        throw new FacebookUnauthorisedUserException(
                            'Insufficient permissions'
                        );
                    } elseif ($response->getStatusCode() == 400) {
                        $json = $response->getBody(true);
                        $arr  = json_decode($json, true);
                        if (is_array($arr)) {
                            throw new FacebookAuthException($arr['error']['message']);
                        } else {
                            throw new FacebookAuthException('Facebook request rejected');
                        }
                    } else {
                        throw new FacebookApiException(
                            $response->getMessage()
                        );
                    }
                }
            } catch (BadResponseException $ex) {
                throw new FacebookApiException('Facebook Graph Request Failed: ' . $ex->getMessage());
            } catch (CurlException $ex) {
                $msg = preg_replace('/\[url\]\ .*$/', '', $ex->getMessage());
                $msg = preg_replace('/^\[curl\]\ [0-9]{1,}\: /', '', $msg);
                sleep($try);
            }
        } while (++$try < $this->max_connection_attempts);

        throw new FacebookConnectionException('Error connecting to Facebook API');
    }


    /**
     * How long to attempt to connect to the Facebook HTTP Api
     *
     * @param float $connection_timeout between 0.1 and 60 seconds
     *
     * @return GraphRequest
     * @throws InvalidArgumentException
     */
    public function setConnectionTimeout($connection_timeout)
    {
        if (!is_float($connection_timeout)) {
            throw new InvalidArgumentException(
                '$connection_timeout must be a float'
            );
        } elseif ($connection_timeout < 0.1) {
            throw new InvalidArgumentException(
                '$connection_timeout minimum value is 0.1 seconds'
            );
        } elseif ($connection_timeout > 60) {
            throw new InvalidArgumentException(
                '$connection_timeout must be less than 60 seconds'
            );
        }
        $this->connection_timeout = $connection_timeout;

        return $this;
    }


    /**
     * How many connection attempts to make (minimum 1)
     *
     * @param int $max_connection_attempts
     *
     * @return AppNotification
     * @throws InvalidArgumentException
     */
    public function setMaxConnectionAttempts($max_connection_attempts)
    {
        if (!is_int($max_connection_attempts)) {
            throw new InvalidArgumentException(
                '$max_connection_attempts must be an int'
            );
        } elseif ($max_connection_attempts < 1) {
            throw new InvalidArgumentException(
                '$max_connection_attempts minimum value is 1'
            );
        } elseif ($max_connection_attempts > 60) {
            throw new InvalidArgumentException(
                '$max_connection_attempts maximum is 60 attempt'
            );
        }
        $this->max_connection_attempts = $max_connection_attempts;

        return $this;
    }


    /**
     * The root facebook graph node (id or string) to query
     *
     * @param string $node
     *
     * @return GraphRequest
     */
    public function setNode($node)
    {
        $this->node = $node;
        return $this;
    }


    /**
     * Use GET or POST method
     *
     * @param string $http_method
     *
     * @return GraphRequest
     */
    public function setHttpMethod($http_method)
    {
        if (strtolower($http_method) == 'post') {
            $this->http_method = 'POST';
        } else {
            $this->http_method = 'GET';
        }
        return $this;
    }


    /**
     * Path (not including the node) for the Graph request
     * eg "notifications"
     * will make a HTTP URI that looks like https://graph.facebook.com/123456/notifications
     *
     * @param string $path
     *
     * @return GraphRequest
     */
    public function setPath($path)
    {
        if (substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }
        if (substr($path, -1) == '/') {
            $path = substr($path, 0, strlen($path) - 1);
        }
        $this->path = $path;
        return $this;
    }


    /**
     * Set the value of query_parameters member
     * eg array( 'message' => 'some value' )
     * in the final URI becomes a querystring of ?message=some+value
     *
     * @param array $query_parameters
     *
     * @return GraphRequest
     */
    public function setQueryParameters($query_parameters)
    {
        $this->query_parameters = $query_parameters;
        return $this;
    }


    /**
     * List of fields to fetch from Graph
     *
     * @param array $fields
     *
     * @return GraphRequest
     * @throws InvalidArgumentException thrown if a fieldname is invalid
     */
    public function setFields($fields)
    {
        if (is_array($fields)) {
            foreach ($fields as $fieldname) {
                if (preg_match('/[^a-zA-Z0-9\_]/', $fieldname)) {
                    throw new InvalidArgumentException(
                        sprintf('Invalid field name: %s', $fieldname)
                    );
                }
            }
            $this->fields = $fields;
        } else {
            $fieldname = $fields;
            if (preg_match('/[^a-zA-Z0-9\_]/', $fieldname)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid field name: %s', $fieldname)
                );
            }
            $this->fields = array($fieldname);
        }
        return $this;
    }


    /**
     * Set the value of access_token member
     *
     * @param object $access_token must inherit the AccessTokenAbstract class
     *
     * @return void
     * @throws InvalidArgumentException if the access_token is not a child class of AccessTokenAbstract
     */
    public function setAccessToken($access_token)
    {
        if ($access_token instanceof AccessTokenAbstract) {
            $this->access_token = $access_token;
        } else {
            throw new InvalidArgumentException(
                'access_token must inherit the Graph\\AccessToken\\AccessTokenAbstract class'
            );
        }
    }
}
