<?php
/**
 * Created by Chris Noden using PhpStorm.
 *
 * PHP version 5
 *
 * This code is copyright and is the intellectual property
 * of the copyright holder named below. It may not be copied,
 * re-distributed, modified, reverse engineered or used without
 * the express written permission of the copyright holder.
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
 * @license   https://www.chrisnoden.com/CLIENT-LICENSE.md Proprietary
 * @link      https://github.com/chrisnoden
 */

namespace Graph\Object;

use Graph\AccessToken\AccessTokenType;
use GmbAdmin\Exception\FacebookInvalidObjectException;
use GmbAdmin\Exception\InvalidArgumentException;
use GmbAdmin\Exception\InvalidTypeException;

/**
 * Class GraphObject
 *
 * @category GmbAdmin\Facebook
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class GraphObject
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
     * @var string originally loaded json
     */
    protected $loaded_json;
    /**
     * @var bool have any values been modified that haven't been persisted to Facebook
     */
    protected $is_modified = false;
    /**
     * @var bool is this object new (not loaded from Facebook)
     */
    protected $is_new = true;


    /**
     * Load the node and return a populated object
     *
     * @param mixed $node
     * @param array $fields (optional) array of field names to fetch (defaults to all)
     *
     * @return static
     * @throws \GmbAdmin\Exception\FacebookInvalidObjectException
     */
    public static function fetch($node, $fields = array())
    {
        $request = new GraphRequest();
        $request->setNode($node);
        if (count($fields) > 0) {
            $request->setFields($fields);
        }
        $response = $request->send();
        $arr      = json_decode($response->getBody(true), true);
        if (is_array($arr)) {
            $obj = new static();
            $obj->setLoadedJson($response->getBody(true));
            foreach ($arr as $key => $val) {
                $obj->$key = $val;
            }

            return $obj;
        }

        throw new FacebookInvalidObjectException(
            sprintf('Node %s not valid', $node)
        );
    }


    protected function fetchValuesFromFacebook($fields = array())
    {
        if (!is_array($fields)) {
            $fields = array($fields);
        }

        $auth_type = false;
        foreach ($fields as $fieldname) {
            if (isset($this->fields[$fieldname]) &&
                isset($this->fields[$fieldname]['permissions']) &&
                $this->fields[$fieldname]['permissions'] !== false
            ) {
                $auth_type = $this->fields[$fieldname]['permissions'];
                break;
            }
        }

        $request = new GraphRequest();
        $request->setNode($this->id);
        if (isset($this->session)) {
            $request->setSession($this->session);
        }
        $response = $request->send();
        $arr      = json_decode($response->getBody(true), true);
        if (is_array($arr)) {
            $this->setLoadedJson($response->getBody(true));
            $this->setMemberValuesFromArray($arr);

            return true;
        }

        throw new FacebookInvalidObjectException(
            sprintf('Node %s not valid', $this->id)
        );
    }


    /**
     * Return a Facebook GraphObject object
     *
     * @param string $class_name graph object name (eg Application, Payment/s, User)
     *
     * @return GraphObject
     * @throws \GmbAdmin\Exception\InvalidArgumentException
     */
    public static function create($class_name)
    {
        if ($class_name == 'payments') {
            $class_name = 'payment';
        }
        $class_name = __NAMESPACE__ . '\\' . ucfirst($class_name);
        if (class_exists($class_name)) {
            /** @var GraphObject $obj */
            $obj = new $class_name;
            return $obj;
        } else {
            throw new InvalidArgumentException('Class not found for ' . $class_name);
        }
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
     * Set the value of loaded_json member
     *
     * @param string $loaded_json
     *
     * @return void
     */
    protected function setLoadedJson($loaded_json)
    {
        $this->loaded_json = $loaded_json;
    }


    /**
     * Value of member loaded_json
     *
     * @return string value of member
     */
    public function getLoadedJson()
    {
        return $this->loaded_json;
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
     * @return mixed NULL if the element does not exist
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
                var_dump($value);
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

}
