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

namespace Graph\Tests\Object;

use Graph\Object\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var int
     */
    private $test_app_id = 2439131959;

    public function testFactoryMethod()
    {
        $obj = new Application();
        $obj->load($this->test_app_id);
        $this->assertInstanceOf('Graph\Object\Application', $obj);
        var_dump($obj);
    }
}
