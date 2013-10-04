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
 * @category  Parent Class
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace ChrisNoden\Facebook\Graph\Object;

use ChrisNoden\Facebook\Graph\Api\GraphRequest;
use ChrisNoden\Facebook\Exception\FacebookInvalidNodeException;
use ChrisNoden\Facebook\Exception\InvalidArgumentException;
use ChrisNoden\Facebook\Exception\InvalidTypeException;

/**
 * Class ObjectAbstract
 * Object classes extend this class
 *
 * @category  Graph\Object
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class ObjectAbstract
{

    /**
     * Main graph parameters/properties for this object
     * possible types for the 'returns' element:
     * Four scalar types:
        boolean
        integer
        float (floating-point number, aka double)
        string
     * Compound types:
        array
        object
     * Special types:
        resource
        NULL
     * Pseudo-types for readability reasons:
        mixed
        number
        callback
     *
     * @var array
     */
    protected $fields = array(
        'id' => array(
            'description' => 'The object ID',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
    );
    /**
     * Object parameters that link to other objects in the Graph
     *
     * @var array
     */
    protected $connections = array();
    /**
     * @var bool have any values been modified that haven't been persisted to Facebook
     */
    protected $is_modified = false;
    /**
     * @var bool is this object new (not loaded from Facebook)
     */
    protected $is_new = true;
    /**
     * @var array
     */
    protected $modified_fields = array();


    /**
     * Load the node and return a populated object
     *
     * @param string $id     unique node id
     * @param array  $fields (optional) array of field names to fetch
     *
     * @return $this
     * @throws FacebookInvalidNodeException
     */
    public function load($id, $fields = array())
    {
        $request = new GraphRequest();
        $request->setNode($id);
        if (count($fields) > 0) {
            $request->setFields($fields);
        }
        $response = $request->send();
        $arr      = json_decode($response->getBody(true), true);
        if (is_array($arr)) {
            foreach ($arr as $key => $val) {
                $this->setFieldValue($key, $val);
            }

            $this->is_new = false;
            $this->is_modified = false;
            return $this;
        }

        throw new FacebookInvalidNodeException(
            sprintf('Id %s not valid', $id)
        );
    }


    /**
     * Implement getter and setter methods
     *
     * @example getId()
     * @example setId(1)
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        $field_name = $this->fixPropertyName($name);
        if (substr($name, 0, 3) == 'get') {
            return $this->getFieldValue($field_name);
        } elseif (substr($name, 0, 3) == 'set') {
            return $this->setFieldValue($field_name, $arguments[0]);
        } else {
            throw new InvalidArgumentException('Invalid call to unknown method ' . $name);
        }
    }


    /**
     * Fix the name to match the facebook object parameter format
     *
     * @param string $name
     *
     * @return string
     */
    protected function fixPropertyName($name)
    {
        $match         = array(
            '/(set|get)([A-Z]{1}[a-zA-Z0-9\_\-]+)/',
            '/[^a-zA-Z0-9]+/',
            '/[^a-zA-Z0-9]+/'
        );
        $replacements  = array(
            '$2',
            '_',
            ''
        );
        $property_name = strtolower(preg_replace($match, $replacements, $name));

        return $property_name;
    }


    /**
     * @return string name of the Graph Object child class
     */
    public function __toString()
    {
        return str_replace(__NAMESPACE__ . '\\', '', get_class($this));
    }


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
    public function getFieldDetails($field_name)
    {
        if (isset($this->fields[$field_name])) {
            return $this->fields[$field_name];
        }
        throw new InvalidArgumentException('Invalid field_name '.$field_name);
    }


    /**
     * @param string $field_name
     * @param string $element
     *
     * @return mixed|null
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function getFieldElementValue($field_name, $element)
    {
        if (isset($this->fields[$field_name]) && isset($this->fields[$field_name][$element])) {
            return $this->fields[$field_name][$element];
        } elseif (!isset($this->fields[$field_name])) {
            throw new InvalidArgumentException('Invalid field_name '.$field_name);
        }

        return null;
    }


    /**
     * All fields and their current values returned in one big associative array
     *
     * @return array
     */
    public function getFieldList()
    {
        return $this->fields;
    }


    /**
     * Return the value of the field
     *
     * @param string $field_name
     *
     * @return mixed
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function getFieldValue($field_name)
    {
        if (isset($this->fields[$field_name]) && isset($this->fields[$field_name]['value'])) {
            return $this->fields[$field_name]['value'];
        } else {
            if (!isset($this->fields[$field_name])) {
                throw new InvalidArgumentException('Invalid field_name '.$field_name);
            }
        }
    }


    /**
     * You can set values of fields that Facebook do not permit (eg to load the object) but you will
     * not be able to persist them to Facebook
     *
     * @param string $field_name
     * @param mixed  $value
     *
     * @return bool
     * @throws InvalidTypeException if the value type does not match what is required
     * @throws InvalidArgumentException if the field_name does not exist for this Graph object
     */
    public function setFieldValue($field_name, $value)
    {
        if (isset($this->fields[$field_name])) {
            $field = $this->fields[$field_name];

            // check the type matches
            if (isset($field['returns']) && gettype($value) != $field['returns']) {
                // type doesn't match
                // try to re-cast
                $try = $value;
                if (@settype($try, $field['returns']) && $try == $value) {
                    // type juggling seems to have worked
                    $value = $try;
                } else {
                    throw new InvalidTypeException(
                        sprintf(
                            '%s field %s expects %s type (%s given)',
                            str_replace(__NAMESPACE__ . '\\', '', get_class($this)),
                            $field_name,
                            $field['returns'],
                            gettype($value)
                        )
                    );
                }
            }

            // store any original value
            if (isset($field['value']) && !is_null($field['value'])) {
                if (isset($this->modified_fields[$field_name])) {
                    $this->modified_fields[$field_name]['last_modified'] = new \DateTime();
                } else {
                    $this->modified_fields[$field_name] = array(
                        'last_modified' => new \DateTime(),
                        'original_value' => $field['value']
                    );
                }
            }

            // set the value
            $field['value'] = $value;
            $this->is_modified = true;

            // save the new data
            $this->fields[$field_name] = $field;

            return true;
        } else {
            throw new InvalidArgumentException('Invalid field_name '.$field_name);
        }
    }


    /**
     * Reset the values of any modified fields to their original values
     */
    public function resetValues()
    {
        foreach ($this->modified_fields as $fieldname => $aData) {
            $this->fields[$fieldname]['value'] = $aData['original_value'];
        }
        $this->modified_fields = array();
        $this->is_modified = false;
    }


    /**
     * Associative array of modified fields with their last_modified time (DateTime) and original value
     *
     * @return array value of member
     */
    public function getModifiedFields()
    {
        return $this->modified_fields;
    }
}
