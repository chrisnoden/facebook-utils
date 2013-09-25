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

namespace Graph\Tests\Object;

use Graph\GraphObjectType;
use Graph\Object\ObjectFactory;

class ObjectFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Iterate round all the GraphObjectType supported Object names
     * and instantiate a new Object using the Factory::create method
     */
    public function testObjectCreation()
    {
        foreach (GraphObjectType::members() as $graph_object) {
            /** @var GraphObjectType $graph_object */
            $this->assertInstanceOf('Graph\GraphObjectType', $graph_object);
            $class_name = $graph_object->value();
            $obj = ObjectFactory::create($class_name);
            $this->assertInstanceOf('Graph\Object\ObjectAbstract', $obj);
            $this->assertInstanceOf('Graph\Object\\'.$class_name, $obj);
            $this->assertEquals($class_name, $obj->__toString());
            // all objects have an ID field - if not then this will throw an InvalidArgumentException
            $obj->getFieldDetails('id');

            // dispose of the object before next iteration
            $obj = null;
            unset($obj);
        }
    }


    /**
     * A valid Facebook object but currently not supported by this library
     */
    public function testUnsupportedObjectType()
    {
        $this->setExpectedException('Graph\Exception\UnsupportedObjectException');
        $obj = ObjectFactory::create('review');
    }
}
