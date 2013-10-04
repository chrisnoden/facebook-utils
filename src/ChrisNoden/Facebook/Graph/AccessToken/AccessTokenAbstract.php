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
 * @category  Abstract Class
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace ChrisNoden\Facebook\Graph\AccessToken;

use ChrisNoden\Facebook\Graph\Api\GraphRequest;
use ChrisNoden\Facebook\ExceptionFacebookApiException;
use ChrisNoden\Facebook\ExceptionFacebookAuthException;
use ChrisNoden\Facebook\ExceptionFacebookConnectionException;
use ChrisNoden\Facebook\Graph\Object\Application;
use Guzzle\Http\Client;

/**
 * Class AccessTokenAbstract
 * Facebook Access Tokens inherit this class
 *
 * @category  Graph\AccessToken
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
abstract class AccessTokenAbstract
{

    /**
     * @var bool is the access token stale
     */
    protected $stale = false;
    /**
     * @var \DateTime when was this session loaded
     */
    protected $session_cached;
    /**
     * @var \DateTime when does this token expire
     */
    protected $expires_at;
    /**
     * @var bool
     */
    protected $is_valid = true;
    /**
     * @var string the server API token
     */
    protected $access_token;
    /**
     * @var array
     */
    protected $token_info;


    /**
     * Fetch and store a new App access_token from Facebook
     *
     * @return string the access_token
     * @throws FacebookAuthException if our request was denied
     * @throws FacebookApiException if some unexpected response was received from Facebook
     */
    abstract protected function fetchAccessToken();


    /**
     * Queries the access_token with Facebook to confirm it's validity, etc
     *
     * @param string $access_token token you want info on
     *
     * @return string the access_token
     * @throws FacebookApiException
     * @throws FacebookConnectionException if unable to connect to Facebook over HTTPS
     */
    protected function fetchTokenInfo($access_token)
    {
        $graph_request = new GraphRequest();
        $client   = $graph_request->getClient();
        $request  = $client->get(
            sprintf(
                '/debug_token?input_token=%s&access_token=%s',
                $access_token,
                $this->access_token
            )
        );
        $response = $request->send();
        if ($response->getStatusCode() == 200) {
            $json = $response->getBody(true);
            if ($arr = json_decode($json, true)) {
                $this->token_info = $arr;
                if (isset($arr['data']['is_valid'])) {
                    $this->is_valid = $arr['data']['is_valid'];
                }
            }
        } else {
            throw new FacebookConnectionException(
                sprintf('Facebook error: %s', $response->getBody(true))
            );
        }
    }


    /**
     * Array of token info from Facebook
     *
     * @param string $access_token token you want info on
     *
     * @return array
     */
    public function getTokenInfo($access_token)
    {
        if (is_null($this->token_info) && isset($this->access_token)) {
            $this->fetchTokenInfo($access_token);
        }

        if (isset($this->token_info) && is_array($this->token_info)) {
            return $this->token_info;
        }
    }


    /**
     * Value of member session_started
     *
     * @return \DateTime when this session was first authorised
     */
    public function getSessionCached()
    {
        return $this->session_cached;
    }


    /**
     * Value of member access_token
     *
     * @return string value of member
     */
    public function getAccessToken()
    {
        if (!isset($this->access_token) || $this->stale !== false || $this->is_valid == false) {
            $this->fetchAccessToken();
            $this->stale = false;
            $this->is_valid = true;
        }
        return $this->access_token;
    }


    /**
     * Has the Facebook access_token been fetched and stored
     *
     * @return bool the token has been fetched from facebook
     */
    public function isTokenCached()
    {
        if (!is_null($this->access_token) && !$this->stale) {
            return true;
        }
        return false;
    }


    /**
     * Request the token from Facebook again as soon as possible
     *
     * @return void
     */
    public function reset()
    {
        $this->stale = true;
    }


    /**
     * Prepare a Graph HTTP request
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function getGraphHttpRequest()
    {
        $graph_request = new GraphRequest();
        $client = $graph_request->getClient();
        $request = $this->buildFacebookHttpRequest($client);

        return $request;
    }


    /**
     * Prepare our HTTP Request for Facebook
     *
     * @param Client $client
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    abstract protected function buildFacebookHttpRequest(Client $client);
}
