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

namespace ChrisNoden\Facebook\Graph\Object\Application;

use ChrisNoden\Facebook\Exception\InvalidArgumentException;

/**
 * Class Subscription
 *
 * @category Graph\Object
 * @package  facebook-graph
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/chrisnoden/synergy
 */
class Subscription
{

    /**
     * @var string
     */
    protected $object;
    /**
     * @var string
     */
    protected $callback_url;
    /**
     * @var array
     */
    protected $fields = array();
    /**
     * @var bool
     */
    protected $active = true;


    /**
     * @return string name of the Graph Object child class
     */
    public function __toString()
    {
        if (isset($this->object)) {
            return (string)$this->object;
        }
    }


    /**
     * Populate the object with data from a valid array
     *
     * @param array $subscription_array
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function loadFromArray($subscription_array)
    {
        if (is_array($subscription_array)) {
            if (isset($subscription_array['object'])) {
                $this->setObject($subscription_array['object']);
            }
            if (isset($subscription_array['callback_url'])) {
                $this->setCallbackUrl($subscription_array['callback_url']);
            }
            if (isset($subscription_array['fields']) && is_array($subscription_array['fields'])) {
                $this->setFields($subscription_array['fields']);
            }
            if (isset($subscription_array['active'])) {
                $this->setActive($subscription_array['active']);
            }
            if ($this->valid()) {
                return $this;
            } else {
                throw new InvalidArgumentException(
                    sprintf(
                        'Incomplete array of subscription data passed to %s',
                        __METHOD__
                    )
                );
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                '%s expects associative array of subscription object details',
                __METHOD__
            )
        );
    }


    /**
     * Populate the Subscription object from a json object
     *
     * @param string $json
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function loadFromJson($json)
    {
        $arr = json_decode($json, true);
        if ($arr && is_array($arr)) {
            return $this->loadFromArray($arr);
        }

        throw new InvalidArgumentException(
            sprintf(
                '%s expects subscription object in valid json format',
                __METHOD__
            )
        );

    }


    /**
     * Is the object properly and fully configured
     *
     * @return bool
     */
    public function valid()
    {
        if (isset($this->object) &&
            isset($this->callback_url) &&
            isset($this->fields) &&
            is_array($this->fields) &&
            isset($this->active)
        ) {
            return true;
        }

        return false;
    }


    /**
     * Set the value of active member
     *
     * @param boolean $active
     *
     * @return void
     */
    public function setActive($active)
    {
        if ($active === false) {
            $this->active = false;
        } else {
            $this->active = true;
        }
    }


    /**
     * Is this subscription active
     *
     * @return boolean value of member
     */
    public function getActive()
    {
        return $this->active;
    }


    /**
     * Set the value of callback_url member
     *
     * @param string $callback_url
     *
     * @return void
     */
    public function setCallbackUrl($callback_url)
    {
        $this->callback_url = $callback_url;
    }


    /**
     * Value of member callback_url
     *
     * @return string value of member
     */
    public function getCallbackUrl()
    {
        return $this->callback_url;
    }


    /**
     * Set the value of fields member
     *
     * @param array $fields
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function setFields($fields)
    {
        if (!is_array($fields)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects array');
        }
        $this->fields = $fields;
    }


    /**
     * array of fields that are monitored by this subscription
     *
     * @return array value of member
     */
    public function getFields()
    {
        return $this->fields;
    }


    /**
     * Set the value of object member
     *
     * @param string $object
     *
     * @return void
     */
    public function setObject($object)
    {
        $this->object = $object;
    }


    /**
     * Name of the facebook graph object that this subscription monitors
     *
     * @return string value of member
     */
    public function getObject()
    {
        return $this->object;
    }
}
