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

namespace ChrisNoden\Tests\Graph\AccessToken;

use ChrisNoden\Facebook\Graph\AccessToken\AppAccessToken;
use ChrisNoden\Facebook\Graph\Object\Application;

class AppAccessTokenTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var string
     */
    private $access_token;


    public function testBasicObject()
    {
        if (defined('TEST_APP_ID') && defined('TEST_APP_SECRET')) {
            $obj = AppAccessToken::create(TEST_APP_ID, TEST_APP_SECRET);
            $this->assertInstanceOf('ChrisNoden\Facebook\Graph\AccessToken\AppAccessToken', $obj);
            $this->assertInstanceOf('ChrisNoden\Facebook\Graph\AccessToken\AccessTokenAbstract', $obj);
        } else {
            $this->fail(
                'Please create a test_settings.php file with two constants for TEST_APP_ID and TEST_APP_SECRET'
            );
        }
    }


    public function testObjectLoadFromFacebook()
    {
        if (defined('TEST_APP_ID') && defined('TEST_APP_SECRET')) {
            $obj = new AppAccessToken();
            $obj->setAppId(TEST_APP_ID);
            $obj->setAppSecret(TEST_APP_SECRET);
            $access_token = $obj->getAccessToken();
            $arr = explode('|', $access_token);
            $this->assertEquals(TEST_APP_ID, $arr[0]);
            $this->access_token = $access_token;

            $token_info = $obj->getTokenInfo($access_token);
        }
    }

}