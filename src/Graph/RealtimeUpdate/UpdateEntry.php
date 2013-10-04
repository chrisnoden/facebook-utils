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
 * @category  Class
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace Graph\RealtimeUpdate;

/**
 * Class UpdateEntry
 *
 * @category GmbAdmin\Facebook\UpdateEntry
 * @package  facebook-graph
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/chrisnoden/synergy
 */
class UpdateEntry
{

    /**
     * @var string
     */
    protected $object_name;
    /**
     * @var string
     */
    protected $uid;
    /**
     * @var array
     */
    protected $changed_fields = array();
    /**
     * @var int
     */
    protected $time;


    /**
     * Set the value of changed_fields member
     *
     * @param array $changed_fields
     *
     * @return void
     */
    public function setChangedFields($changed_fields)
    {
        $this->changed_fields = $changed_fields;
    }


    /**
     * Value of member changed_fields
     *
     * @return array value of member
     */
    public function getChangedFields()
    {
        return $this->changed_fields;
    }


    /**
     * Set the value of object_name member
     *
     * @param string $object_name
     *
     * @return void
     */
    public function setObjectName($object_name)
    {
        $this->object_name = $object_name;
    }


    /**
     * Value of member object_name
     *
     * @return string value of member
     */
    public function getObjectName()
    {
        return $this->object_name;
    }


    /**
     * Set the value of time member
     *
     * @param int $time
     *
     * @return void
     */
    public function setTime($time)
    {
        $this->time = $time;
    }


    /**
     * Value of member time
     *
     * @return int value of member
     */
    public function getTime()
    {
        return $this->time;
    }


    /**
     * Set the value of uid member
     *
     * @param string $uid
     *
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }


    /**
     * Value of member uid
     *
     * @return string value of member
     */
    public function getUid()
    {
        return $this->uid;
    }


}
