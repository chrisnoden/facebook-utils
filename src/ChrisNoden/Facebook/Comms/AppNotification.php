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

namespace ChrisNoden\Facebook\Comms;

use ChrisNoden\Facebook\Exception\FacebookException;
use ChrisNoden\Facebook\Exception\InvalidArgumentException;
use ChrisNoden\Facebook\Graph\Api\GraphRequest;

/**
 * Class AppNotification
 * Sends a Facebook App Notification
 *
 * @see https://developers.facebook.com/docs/concepts/notifications/
 *
 * @category GmbAdmin\Facebook
 * @package  gmb-webv2
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  https://www.chrisnoden.com/CLIENT-LICENSE.md Proprietary
 * @link     https://github.com/chrisnoden/synergy
 */
class AppNotification
{

    /**
     * @var string
     */
    protected $access_token;
    /**
     * @var string the message to send
     */
    private $message;
    /**
     * @var array parameters encoded into the querystring for when people click on the notification
     */
    private $parameters = array();
    /**
     * @var string facebook unique user_id
     */
    private $facebook_user_id;


    /**
     * Create a new Facebook AppNotification object
     *
     * @return AppNotification
     */
    public static function create()
    {
        $obj = new AppNotification();
        return $obj;
    }


    /**
     * Send a notification to a Player using their Facebook userId
     *
     * @return boolean true if the message was successfully sent
     * @throws FacebookUnauthorisedUserException
     *      thrown if the facebook user has not given permission (or has revoked permission) to our app
     * @throws FacebookApiException
     * @throws FacebookConnectionException
     *      thrown if we are unable to connect to the Facebook HTTP Api
     */
    public function send()
    {
        $this->isValid();

        $href = $this->buildHrefString();
        $request = new GraphRequest();
        $request->setNode($this->facebook_user_id)
            ->setHttpMethod('POST')
            ->setPath('notifications')
            ->setAccessToken($this->access_token)
            ->setQueryParameters(
                array('template' => $this->message, 'href' => $href)
            );

        $response = $request->send();

        return $response->getBody();
    }


    /**
     * Send a notification to a Player using their Facebook userId
     *
     * @param string $facebook_userId Facebook userId
     * @param string $message message to send
     * @param array  $params array of parameters to be encoded into the notification click response
     *
     * @return boolean true if the message was successfully sent
     * @throws FacebookUnauthorisedUserException
     *      thrown if the facebook user has not given permission (or has revoked permission) to our app
     * @throws FacebookApiException
     * @throws FacebookException
     */
    public function sendToFacebookUserId($facebook_userId, $message, Array $params = array())
    {
        $this->setFacebookUserId($facebook_userId);
        $this->setMessage($message);
        $this->setParameters($params);

        return $this->send();
    }


    /**
     * Test if we have all required parameters before sending the notification
     *
     * @return bool
     * @throws FacebookException
     */
    public function isValid()
    {
        if (!isset($this->access_token)) {
            throw new FacebookException('Must set session (AppAccessToken object)');
        }
        if (!isset($this->facebook_user_id)) {
            throw new FacebookException('Must set facebook_user_id of recipient');
        }
        if (!isset($this->message)) {
            throw new FacebookException('Must set message');
        }

        return true;
    }


    /**
     * Constructs the FB href for our notification
     *
     * @return string|null
     */
    private function buildHrefString()
    {
        if (count($this->parameters) > 0) {
            $arr = array();
            foreach ($this->parameters as $key => $val) {
                $arr[] = sprintf('%s=%s', $key, urlencode($val));
            }
            $href = htmlentities('?' . implode('&', $arr));
            return $href;
        }

        return null;
    }


    /**
     * Set the notification message
     *
     * @param string $message max 180 chars
     *
     * @return AppNotification
     * @throws InvalidArgumentException
     */
    public function setMessage($message)
    {
        if (strlen($message) > 180) {
            throw new InvalidArgumentException(
                '$message is limited to 180 chars'
            );
        }
        $this->message = $message;

        return $this;
    }


    /**
     * Set the value of _parameters member
     * All parameters are made URL safe when sending the notification
     *
     * @param array $parameters
     *
     * @return AppNotification
     */
    public function setParameters(Array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }


    /**
     * Set the value of facebook_user_id member
     *
     * @param string $facebook_user_id
     *
     * @return AppNotification
     */
    public function setFacebookUserId($facebook_user_id)
    {
        $this->facebook_user_id = $facebook_user_id;

        return $this;
    }


    /**
     * Set the value of access_token member
     *
     * @param string $access_token
     *
     * @return void
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }
}
