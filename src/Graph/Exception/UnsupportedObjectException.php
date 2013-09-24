<?php
/**
 * Created by Chris Noden using JetBrains PhpStorm.
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

namespace Graph\Exception;

/**
 * Class UnsupportedObjectException
 * Thrown if you are trying to create/instantiate/load a GraphObject type that isn't supported
 *
 * @category  Graph\Exception
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class UnsupportedObjectException extends FacebookException
{

}