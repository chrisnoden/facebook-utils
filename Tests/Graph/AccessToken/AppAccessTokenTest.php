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

namespace Graph\Tests\AccessToken;

use Graph\AccessToken\AppAccessToken;
use Graph\GraphObjectType;
use Graph\Object\ObjectFactory;
use Graph\Object\Application;

class AppAccessTokenTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var int
     */
    private $test_app_id = 2439131959;
    /**
     * @var Application
     */
    private $application;

    public function setUp()
    {
        $this->application = ObjectFactory::load(GraphObjectType::APPLICATION(), $this->test_app_id);
    }

    public function testBasicObject()
    {
        $obj = new AppAccessToken($this->application);
        $this->assertInstanceOf('Graph\AccessToken\AppAccessToken', $obj);
        $this->assertInstanceOf('Graph\AccessToken\AccessTokenAbstract', $obj);
    }

}
