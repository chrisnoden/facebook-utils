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

namespace Graph\AccessToken;

use Graph\Api\GraphRequest;
use Graph\Exception\FacebookApiException;
use Graph\Exception\FacebookAuthException;
use Graph\Exception\FacebookConnectionException;
use Graph\Object\Application;
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
     * @return string the access_token
     * @throws FacebookApiException
     * @throws FacebookConnectionException if unable to connect to Facebook over HTTPS
     */
    protected function fetchTokenInfo()
    {
        $graph_request = new GraphRequest($this->access_token);
        $client   = $graph_request->getClient();
        $request  = $client->get(
            sprintf(
                '/debug_token?input_token=%s&access_token=%s',
                $this->access_token,
                $this->access_token
            )
        );
        $response = $request->send();
        if ($response->getStatusCode() == 200) {
            $json = $response->getBody(true);
            if ($arr = json_decode($json)) {
                $this->expires_at = new \DateTime('@' . $arr['data']['expires_at']);
                $this->is_valid   = $arr['data']['is_valid'];
                if (isset($arr['data']['scopes'])) {
                    $this->app_scope = $arr['data']['scopes'];
                }
            }
        } else {
            throw new FacebookConnectionException(
                sprintf('Facebook error: %s', $response->getBody(true))
            );
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
        if (!isset($this->access_token) || $this->stale !== false) {
            $this->fetchAccessToken();
            $this->stale = false;
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
