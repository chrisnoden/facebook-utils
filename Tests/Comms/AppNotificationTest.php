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
 * @category  Unit Test
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace ChrisNoden\Tests\Comms;

use ChrisNoden\Facebook\Comms\AppNotification;
use ChrisNoden\Facebook\Graph\Object\Application;

class AppNotificationTest extends \PHPUnit_Framework_TestCase
{



    public function testObjectInstantiation()
    {
        $obj = new AppNotification();
        $this->assertInstanceOf('ChrisNoden\Facebook\Comms\AppNotification', $obj);
    }


    public function testValidNotification()
    {
        if (defined('TEST_APP_ID') && defined('TEST_APP_SECRET') && defined('TEST_FACEBOOK_USER_ID')) {
            $application = new Application();
            $application->setId(TEST_APP_ID);
            $application->setSecret(TEST_APP_SECRET);
            $access_token = $application->getAccessToken();

            $notification = AppNotification::create()
                ->setAccessToken($access_token)
                ->setMessage('This is a test message')
                ->setFacebookUserId(TEST_FACEBOOK_USER_ID)
                ->send();
        }
    }


    public function testSendToInvalidUserId()
    {
        if (defined('TEST_APP_ID') && defined('TEST_APP_SECRET')) {
            $application = new Application();
            $application->setId(TEST_APP_ID);
            $application->setSecret(TEST_APP_SECRET);
            $access_token = $application->getAccessToken();

            $notification = AppNotification::create()
                ->setAccessToken($access_token)
                ->setMessage('This is a test message')
                ->setFacebookUserId('123456');
            $notification->isValid();
            $this->setExpectedException('ChrisNoden\Facebook\Exception\FacebookInsufficientPermissions');
            $notification->send();
        }
    }


}
