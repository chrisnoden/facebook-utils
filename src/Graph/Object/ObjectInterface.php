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

namespace Graph\Object;

use Graph\Exception\FacebookInvalidNodeException;
use Graph\Exception\InvalidArgumentException;

/**
 * Class ObjectInterface
 *
 * @category Graph\Object
 * @package  facebook-graph
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/chrisnoden/synergy
 */
interface ObjectInterface
{

    /**
     * Load the node and return a populated object
     *
     * @param string $id unique node id
     * @param array  $fields (optional) array of field names to fetch
     *
     * @return $this
     * @throws FacebookInvalidNodeException
     */
    public function load($id, $fields = array());


    /**
     * @return string name of the Graph Object child class
     */
    public function __toString();


    /**
     * Associative array of info about the field
     * {
     *   'description' => 'The application ID', // helpful description
     *   'permissions' => false,                // what (if any) Facebook Access Token is required
     *   'returns'     => 'string',             // what type is returned
     *   'editable'    => false,                // does Facebook let us edit the value of the field
     *   'must_ask'    => false                 // must explicity ask for this field
     *   'value'       => mixed                 // only exists if a value has been loaded or set
     * }
     *
     * @param string $field_name
     *
     * @return array
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function getFieldDetails($field_name);


    /**
     * @param string $field_name
     * @param string $element
     *
     * @return mixed|null
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function getFieldElementValue($field_name, $element);


    /**
     * All fields and their current values returned in one big associative array
     *
     * @return array
     */
    public function getFieldList();


    /**
     * Return the value of the field
     *
     * @param string $field_name
     *
     * @return mixed
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function getFieldValue($field_name);


    /**
     * Associative array of modified fields with their last_modified time (DateTime) and original value
     *
     * @return array value of member
     */
    public function getModifiedFields();
}
