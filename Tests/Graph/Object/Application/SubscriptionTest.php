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

namespace ChrisNoden\Tests\Graph\Object\Application;

use ChrisNoden\Facebook\Graph\Object\Application\Subscription;

class SubscriptionTest extends \PHPUnit_Framework_TestCase
{

    private $testArray = array(
        "object" => "user",
        "callback_url" => "http://realtime.myapp.com/callback",
        "fields" => array("hometown", "friends"),
        "active" => true
    );

    public function testBasicObject()
    {
        $obj = new Subscription();
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\Object\Application\Subscription', $obj);
        $this->assertNull($obj->__toString());
    }


    public function testSubscriptionLoadFromArray()
    {
        $obj = new Subscription();
        $obj->loadFromArray($this->testArray);
        $this->assertEquals($this->testArray['object'], $obj->getObject());
        $this->assertEquals($this->testArray['callback_url'], $obj->getCallbackUrl());
        $this->assertEquals($this->testArray['fields'], $obj->getFields());
        $this->assertEquals($this->testArray['active'], $obj->getActive());
    }


    public function testSubscriptionLoadFromJson()
    {
        $obj = new Subscription();
        $obj->loadFromJson(json_encode($this->testArray));
        $this->assertEquals($this->testArray['object'], $obj->getObject());
        $this->assertEquals($this->testArray['callback_url'], $obj->getCallbackUrl());
        $this->assertEquals($this->testArray['fields'], $obj->getFields());
        $this->assertEquals($this->testArray['active'], $obj->getActive());
    }

}
