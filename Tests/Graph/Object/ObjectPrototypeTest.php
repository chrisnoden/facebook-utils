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

use Graph\Object\ObjectPrototype;

class ObjectPrototypeTest extends \PHPUnit_Framework_TestCase
{

//    public function testFactoryMethod()
//    {
//        $arr = Useful::getTestFacebookUserIds('chris');
//        $test_node = current($arr);
//        $obj = GraphObject::fetch($test_node);
//        $this->assertInstanceOf('GmbAdmin\Facebook\GraphObject', $obj);
//        $this->assertEquals('Chris Noden', $obj->getName());
//    }


    /**
     * Test the basic instantation
     */
    public function testBasicInstantiation()
    {
        $obj = new ObjectPrototype();
        $fld_description = $obj->getFieldElementValue('id', 'description');
        // test the ID field details are right
        $testArr = array(
            'description' => $fld_description,
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        );
        $this->assertEquals($testArr, $obj->getFieldDetails('id'));
        // set the ID
        $obj->setId('123456');
        $this->assertEquals('123456', $obj->getId());
        // re-test the field details, should now include the value
        $testArr = array(
            'description' => $fld_description,
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
            'value'       => '123456'
        );
        $this->assertEquals($testArr, $obj->getFieldDetails('id'));
    }


    /**
     * Test setting a field with a wrong data type (ID expects a string, let's try an integer)
     */
    public function testSetInvalidFieldType()
    {
        $obj = new ObjectPrototype();
        $fld_description = $obj->getFieldElementValue('id', 'description');
        $this->setExpectedException('Graph\Exception\InvalidTypeException');
        $obj->setId(123456);
        // test the ID field details are right
        $testArr = array(
            'description' => $fld_description,
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        );
        // 'value' element should not exist nor have a value
        $this->assertEquals($testArr, $obj->getFieldDetails('id'));
    }

}
