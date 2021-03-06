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
 * @category  File
 * @package   gmb-webv2
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace ChrisNoden\Tests\Graph\Object;

use ChrisNoden\Facebook\Graph\AccessToken\AppAccessToken;
use ChrisNoden\Facebook\Graph\Object\Application;
use ChrisNoden\Facebook\Graph\Object\Application\Subscription;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var int The Graffiti app
     */
    private $test_app_id = 2439131959;

    private $testSubscriptionArray = array(
        array(
            "object"       => "user",
            "callback_url" => "http://realtime.myapp.com/callback",
            "fields"       => array("hometown", "friends"),
            "active"       => true
        ),
        array(
            "object"       => "page",
            "callback_url" => "http://realtime.myapp.com/callback",
            "fields"       => array("checkins"),
            "active"       => true
        )
    );


    public function testBasicObject()
    {
        $obj = new Application();
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\Object\Application', $obj);
        $this->assertEquals('Application', $obj->__toString());
    }


    public function testFactoryMethod()
    {
        $obj = new Application();
        $obj->load($this->test_app_id);
        $this->assertInstanceOf('ChrisNoden\Facebook\Graph\Object\Application', $obj);
        $this->assertEquals('Graffiti ', $obj->getName());
        $this->assertEquals(
            'http://www.facebook.com/apps/application.php?id=2439131959',
            $obj->getLink()
        );
        $this->assertEquals('graffitiwall', $obj->getNamespace());
    }


    /**
     * Ask for specific fields from Graph and ensure they are the only ones returned
     * (plus ID which is always returned)
     */
    public function testInclusiveFieldRequest()
    {
        $obj            = new Application();
        $include_fields = array(
            'description',
            'subcategory'
        );
        $obj->load($this->test_app_id, $include_fields);
        $fields = $obj->getFieldList();
        $this->assertEquals($this->test_app_id, $obj->getId());
        $this->assertEquals('Draw for your friends.', $obj->getDescription());
        $this->assertEquals('Other', $obj->getSubcategory());
        foreach ($fields as $field => $aData) {
            if ($field != 'id' && isset($aData['value']) && !in_array($field, $include_fields)) {
                $this->fail('ObjectAbstract->load() has fetched an unnecessary field from Graph - ' . $field);
            }
        }
    }


    public function testSetSubscriptionsFromArray()
    {
        $obj = new Application();
        $obj->setSubscriptions($this->testSubscriptionArray);
        $subs = $obj->getSubscriptions();
        $this->assertEquals(
            count($this->testSubscriptionArray),
            count($subs),
            'Expecting ' . count($this->testSubscriptionArray) . ' Subscriptions'
        );
        /** @var Subscription $subscription */
        foreach ($subs as $key => $subscription) {
            foreach ($subscription as $name => $value) {
                if (!isset($this->testSubscriptionArray[$key])) {
                    $this->fail('Extra Subscription object created');
                } elseif (!isset($this->testSubscriptionArray[$key][$name])) {
                    $this->fail('Extra Subscription parameter created');
                }
                $this->assertEquals($this->testSubscriptionArray[$key][$name], $value);
            }
        }
    }


    public function testSetSubscriptionsFromJson()
    {
        $obj = new Application();
        $obj->setSubscriptions(json_encode($this->testSubscriptionArray));
        $subs = $obj->getSubscriptions();
        $this->assertEquals(
            count($this->testSubscriptionArray),
            count($subs),
            'Expecting ' . count($this->testSubscriptionArray) . ' Subscriptions'
        );
        /** @var Subscription $subscription */
        foreach ($subs as $key => $subscription) {
            foreach ($subscription as $name => $value) {
                if (!isset($this->testSubscriptionArray[$key])) {
                    $this->fail('Extra Subscription object created');
                } elseif (!isset($this->testSubscriptionArray[$key][$name])) {
                    $this->fail('Extra Subscription parameter created');
                }
                $this->assertEquals($this->testSubscriptionArray[$key][$name], $value);
            }
        }
    }


    public function testSubscriptionLoadFromFacebook()
    {
        if (defined('TEST_APP_ID') && defined('TEST_APP_SECRET')) {
            $obj = new Application();
            $obj->setId(TEST_APP_ID);
            $obj->setSecret(TEST_APP_SECRET);
            $obj->fetchSubscriptions();
            $arr = $obj->getSubscriptions();
            if (!is_array($arr)) {
                $this->fail('Application::getSubscriptions() not returning an array');
            }
        }
    }

}
