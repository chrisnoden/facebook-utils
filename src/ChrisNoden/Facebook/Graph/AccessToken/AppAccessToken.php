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

namespace ChrisNoden\Facebook\Graph\AccessToken;

use ChrisNoden\Facebook\Graph\Api\GraphRequest;
use ChrisNoden\Facebook\Exception\FacebookApiException;
use ChrisNoden\Facebook\Exception\FacebookAuthException;
use ChrisNoden\Facebook\Graph\Object\Application;
use Guzzle\Http\Client;

/**
 * Class FacebookGraphSession
 * Authenticates and manages a server-side OAuth Graph session
 * with Facebook - for Cli based projects
 *
 * @category GmbAdmin\Facebook
 * @package  gmb-webv2
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  https://www.chrisnoden.com/CLIENT-LICENSE.md Proprietary
 * @link     https://github.com/chrisnoden/synergy
 */
class AppAccessToken extends AccessTokenAbstract
{

    /**
     * @var string
     */
    private $app_id;
    /**
     * @var string
     */
    private $app_secret;


    /**
     * @param string $app_id
     * @param string $app_secret
     *
     * @return AppAccessToken
     */
    public static function create($app_id, $app_secret)
    {
        $token = new AppAccessToken();
        $token->setAppId($app_id);
        $token->setAppSecret($app_secret);
        return $token;
    }


    /**
     * Fetch and store a new App access_token from Facebook
     *
     * @return string the access_token
     * @throws FacebookAuthException if our request was denied
     * @throws FacebookApiException if some unexpected response was received from Facebook
     */
    protected function fetchAccessToken()
    {
        $request = new GraphRequest();
        $client = $request->getClient();
        $request = $this->buildFacebookHttpRequest($client);
        $response = $request->send();
        if ($response->getStatusCode() == 200) {
            parse_str($response->getBody(true), $arr);
            if (isset($arr['access_token'])) {
                $this->session_cached = new \DateTime();
                $this->access_token   = (string)$arr['access_token'];
            } else {
                throw new FacebookApiException(
                    'Unexpected Facebook error'
                );
            }
        } else {
            throw new FacebookAuthException(
                sprintf('Facebook error: %s', $response->getBody(true))
            );
        }
    }


    /**
     * Prepare our HTTP Request for Facebook
     *
     * @param Client $client
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    protected function buildFacebookHttpRequest(Client $client)
    {

        $request  = $client->get(
            sprintf(
                '/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
                $this->app_id,
                $this->app_secret
            )
        );

        return $request;
    }


    /**
     * Set the value of app_id member
     *
     * @param string $app_id
     *
     * @return void
     */
    public function setAppId($app_id)
    {
        $this->app_id = $app_id;
    }


    /**
     * Set the value of app_secret member
     *
     * @param string $app_secret
     *
     * @return void
     */
    public function setAppSecret($app_secret)
    {
        $this->app_secret = $app_secret;
    }
}
