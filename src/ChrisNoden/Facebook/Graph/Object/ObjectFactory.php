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
 * @category  Factory Class
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */

namespace ChrisNoden\Facebook\Graph\Object;

use ChrisNoden\Facebook\Exception\UnsupportedObjectException;
use ChrisNoden\Facebook\Graph\GraphObjectType;

/**
 * Class ObjectFactory
 *
 * @category Graph\Object
 * @package  facebook-graph
 * @author   Chris Noden <chris.noden@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/chrisnoden/synergy
 */
class ObjectFactory
{

    /**
     * Return a new Facebook GraphObjectType
     *
     * @param string $object_name graph object_name name (eg Application, Payment/s, User)
     *
     * @return ObjectAbstract
     * @throws UnsupportedObjectException unable to find a GraphObjectType class to support this
     */
    public static function create($object_name)
    {
        if ($object_name == 'payments') {
            $object_name = 'payment';
        }
        $object_name = __NAMESPACE__ . '\\' . ucfirst($object_name);
        if (class_exists($object_name)) {
            /** @var ObjectAbstract $obj */
            $obj = new $object_name;
            return $obj;
        } else {
            throw new UnsupportedObjectException('Unsupported Object, class not found for ' . $object_name);
        }
    }


    /**
     * Return a GraphObject loaded with data from Facebook Graph API
     *
     * @param GraphObjectType $type
     * @param string|int      $id
     *
     * @return ObjectAbstract
     * @throws UnsupportedObjectException unable to find a class to support this
     */
    public static function load(GraphObjectType $type, $id)
    {
        $class_name = __NAMESPACE__ . '\\' . $type->value();
        if (class_exists($class_name)) {
            /** @var ObjectAbstract $obj */
            $obj = new $class_name;
            return $obj;
        } else {
            throw new UnsupportedObjectException('Unsupported Object, class not found for ' . $object);
        }

    }
}
