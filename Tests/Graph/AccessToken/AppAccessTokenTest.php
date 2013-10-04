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
    private $test_app_id = '186973868081324';
    /**
     * @var string
     */
    private $test_app_secret = '1bf86d8f9ba5e4ac22689a78ea1e8996';
    /**
     * @var string
     */
    private $access_token;


    public function testBasicObject()
    {
        $obj = AppAccessToken::create($this->test_app_id, $this->test_app_secret);
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\AccessToken\AppAccessToken', $obj);
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\AccessToken\AccessTokenAbstract', $obj);
    }


    public function testObjectLoadFromFacebook()
    {
        $obj = new AppAccessToken();
        $obj->setAppId($this->test_app_id);
        $obj->setAppSecret($this->test_app_secret);
        $access_token = $obj->getAccessToken();
        $arr = explode('|', $access_token);
        $this->assertEquals($this->test_app_id, $arr[0]);
        $this->access_token = $access_token;

        $token_info = $obj->getTokenInfo($access_token);
    }

}