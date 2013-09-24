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

namespace Graph\Object;

use Graph\Exception\UnsupportedObjectException;

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
     * Return a new Facebook GraphObject
     *
     * @param string $object graph object name (eg Application, Payment/s, User)
     *
     * @return ObjectPrototype
     * @throws UnsupportedObjectException unable to find a GraphObject class to support this
     */
    public static function create($object)
    {
        if ($object == 'payments') {
            $object = 'payment';
        }
        $object = __NAMESPACE__ . '\\' . ucfirst($object);
        if (class_exists($object)) {
            /** @var ObjectPrototype $obj */
            $obj = new $object;
            return $obj;
        } else {
            throw new UnsupportedObjectException('Unsupported Object, class not found for ' . $object);
        }
    }
}
