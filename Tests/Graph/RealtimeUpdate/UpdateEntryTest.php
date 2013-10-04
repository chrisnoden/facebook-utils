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

namespace Graph\Tests\RealtimeUpdate;

use Graph\RealtimeUpdate\UpdateEntry;

class UpdateEntryTest extends \PHPUnit_Framework_TestCase
{

    public function testObjectInstantiation()
    {
        $time = time();
        $obj = new UpdateEntry();
        $obj->setObjectName('payments');
        $obj->setTime($time);
        $obj->setChangedFields(array('name','picture'));
        $obj->setUid(123456);

        $this->assertEquals('payments', $obj->getObjectName());
        $this->assertEquals($time, $obj->getTime());
        $this->assertEquals(array('name','picture'), $obj->getChangedFields());
        $this->assertEquals(123456, $obj->getUid());
    }


}
