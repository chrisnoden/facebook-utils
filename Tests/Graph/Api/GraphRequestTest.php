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

namespace Graph\Tests\Api;

use Graph\Api\Config;
use Graph\Api\GraphRequest;

class GraphRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicObject()
    {
        $obj = new GraphRequest();
        $this->assertInstanceOf('Graph\Api\GraphRequest', $obj);

        $client = $obj->getClient();
        $this->assertInstanceOf('Guzzle\Http\Client', $client);

        // test the base url matches our config
        $this->assertEquals(
            sprintf(
                '%s://%s',
                Config::GRAPH_USE_SSL === true ? 'https' : 'http',
                Config::GRAPH_BASE_URL
            ),
            $client->getBaseUrl()
        );

        // test the basic request
        $request = $obj->getRequest();
        $this->assertInstanceOf('Guzzle\Http\Message\RequestInterface', $request);
    }
}
