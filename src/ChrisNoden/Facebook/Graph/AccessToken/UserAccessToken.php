<?php
/**
 * Created by Chris Noden using JetBrains PhpStorm.
 *
 * PHP version 5
 *
 * This code is copyright and is the intellectual property
 * of the copyright holder named below. It may not be copied,
 * re-distributed, modified, reverse engineered or used without
 * the express written permission of the copyright holder.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category  File
 * @package   gmb-webv2
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   https://www.chrisnoden.com/CLIENT-LICENSE.md Proprietary
 * @link      https://github.com/chrisnoden
 */

namespace GmbAdmin\Facebook\AccessToken;

/**
 * Class UserAccessToken
 *
 * @category GmbAdmin\Facebook
 * @package  gmb-webv2
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  https://www.chrisnoden.com/CLIENT-LICENSE.md Proprietary
 * @link     https://github.com/chrisnoden/synergy
 */
class UserAccessToken extends AccessTokenAbstract
{

    /**
     * @var string the facebook user_id of the web visitor
     */
    private $user_id;
    /**
     * @var string
     */
    private $user_email;
    /**
     * @var array
     */
    private $user_profile;
    /**
     * @var string
     */
    private $user_nicename;


    public function __construct($game)
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            throw new GambinoException(__CLASS__ . ' Unable to instantiate due to absence of HTTP_HOST in $_SERVER');
        }

        parent::__construct($game);

        try {
            $this->facebook       = new \Facebook($this->getFacebookConfig());
            $this->session_cached = new \DateTime();
            $this->user_id        = $this->facebook->getUser();
            $this->user_profile   = $this->facebook->api('/me');
            $this->user_email     = trim($this->user_profile['email']);
            $this->user_nicename  = trim($this->user_profile['username']);
        } catch (\FacebookApiException $ex) {
            // This is not usually thrown when getting the userId from Facebook
            // but when you try to do something that requires some elevated
            // permissions

            // Facebook token has expired
            Logger::critical(
                'Facebook OAuth (session) token invalid'
            );
        }

    }


    /**
     * Get the config array required for facebook login
     *
     * @return array
     */
    protected function getFacebookConfig()
    {
        $config = array(
            'appId'  => $this->app_id,
            'secret' => $this->client_secret
        );

        return $config;
    }


    /**
     * Gets a valid Login/Auth link for our Facebook app
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        $params = array(
            'scope'        => $this->app_scope,
            'redirect_uri' => sprintf(
                'https://apps.facebook.com/%s',
                $this->app_id
            )
        );

        return $this->facebook->getLoginUrl($params);
    }


    /**
     * Value of member _user_email
     *
     * @return string value of member
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }


    /**
     * Value of member _user_id
     *
     * @return string value of member
     */
    public function getUserId()
    {
        return $this->user_id;
    }


    /**
     * Value of member _user_profile
     *
     * @return array value of member
     */
    public function getUserProfile()
    {
        return $this->user_profile;
    }


    /**
     * Value of member _user_nicename
     *
     * @return string value of member
     */
    public function getUserNicename()
    {
        return $this->user_nicename;
    }


}