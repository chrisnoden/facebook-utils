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

namespace ChrisNoden\Tests\Graph\Object;

use ChrisNoden\Facebook\Graph\GraphObjectType;
use ChrisNoden\Facebook\Graph\Object\ObjectFactory;
use ChrisNoden\Facebook\Graph\Object\Payment;

class PaymentTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicObject()
    {
        $obj = new Payment();
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\Object\Payment', $obj);
        $this->assertEquals('Payment', $obj->__toString());
    }


    public function testFactoryMethod()
    {
        $obj = ObjectFactory::create(GraphObjectType::PAYMENT);
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\Object\Payment', $obj);
    }

}
