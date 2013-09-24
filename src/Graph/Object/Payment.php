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

/**
 * Class Payment
 * Models the Facebook Payment object from the Graph API
 *
 * @see https://developers.facebook.com/docs/reference/api/payment/
 *
 * @category GmbAdmin\Facebook
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class Payment extends GraphObject
{

    /**
     * @var object containing name and id parameters
     */
    protected $user;
    /**
     * @var string url of the og:product object ordered
     */
    protected $product;
    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var string unique, optional app created identifier passed in to the payment dialog
     */
    protected $request_id;
    /**
     * @var  object containing name, namespace and id
     */
    protected $application;
    /**
     * @var array of objects containing type, status, amount, currency, time_created and time_updated
     */
    protected $actions;
    /**
     * @var object containing type, product and quantity
     */
    protected $items;
    /**
     * @var string Buyer's ISO Country Code
     */
    protected $country;
    /**
     * @var string the time the payment was originally created
     */
    protected $created_time;
    /**
     * @var double exchange rate used to calculate payout amount
     */
    protected $payout_foreign_exchange_rate;
    /**
     * @var object containing user_comment and time_created
     */
    protected $disputes;
    /**
     * @var mixed shows up when a payment is made by a payment tester
     */
    protected $test;


    /**
     * Set the value of actions member
     *
     * @param array $actions
     *
     * @return void
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }


    /**
     * Value of member actions
     *
     * @return array value of member
     */
    public function getActions()
    {
        return $this->actions;
    }


    /**
     * Set the value of application member
     *
     * @param object $application
     *
     * @return void
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }


    /**
     * Value of member application
     *
     * @return object value of member
     */
    public function getApplication()
    {
        return $this->application;
    }


    /**
     * Set the value of country member
     *
     * @param string $country
     *
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    /**
     * Value of member country
     *
     * @return string value of member
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Set the value of created_time member
     *
     * @param string $created_time
     *
     * @return void
     */
    public function setCreatedTime($created_time)
    {
        $this->created_time = $created_time;
    }


    /**
     * Value of member created_time
     *
     * @return string value of member
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }


    /**
     * Set the value of disputes member
     *
     * @param object $disputes
     *
     * @return void
     */
    public function setDisputes($disputes)
    {
        $this->disputes = $disputes;
    }


    /**
     * Value of member disputes
     *
     * @return object value of member
     */
    public function getDisputes()
    {
        return $this->disputes;
    }


    /**
     * Set the value of extra_params member
     *
     * @param array $extra_params
     *
     * @return void
     */
    public function setExtraParams($extra_params)
    {
        $this->extra_params = $extra_params;
    }


    /**
     * Value of member extra_params
     *
     * @return array value of member
     */
    public function getExtraParams()
    {
        return $this->extra_params;
    }


    /**
     * Set the value of items member
     *
     * @param object $items
     *
     * @return void
     */
    public function setItems($items)
    {
        $this->items = $items;
    }


    /**
     * Value of member items
     *
     * @return object value of member
     */
    public function getItems()
    {
        return $this->items;
    }


    /**
     * Set the value of payout_foreign_exchange_rate member
     *
     * @param float $payout_foreign_exchange_rate
     *
     * @return void
     */
    public function setPayoutForeignExchangeRate($payout_foreign_exchange_rate)
    {
        $this->payout_foreign_exchange_rate = $payout_foreign_exchange_rate;
    }


    /**
     * Value of member payout_foreign_exchange_rate
     *
     * @return float value of member
     */
    public function getPayoutForeignExchangeRate()
    {
        return $this->payout_foreign_exchange_rate;
    }


    /**
     * Set the value of product member
     *
     * @param string $product
     *
     * @return void
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }


    /**
     * Value of member product
     *
     * @return string value of member
     */
    public function getProduct()
    {
        return $this->product;
    }


    /**
     * Set the value of quantity member
     *
     * @param int $quantity
     *
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


    /**
     * Value of member quantity
     *
     * @return int value of member
     */
    public function getQuantity()
    {
        return $this->quantity;
    }


    /**
     * Set the value of request_id member
     *
     * @param string $request_id
     *
     * @return void
     */
    public function setRequestId($request_id)
    {
        $this->request_id = $request_id;
    }


    /**
     * Value of member request_id
     *
     * @return string value of member
     */
    public function getRequestId()
    {
        return $this->request_id;
    }


    /**
     * Set the value of test member
     *
     * @param mixed $test
     *
     * @return void
     */
    public function setTest($test)
    {
        $this->test = $test;
    }


    /**
     * Value of member test
     *
     * @return mixed value of member
     */
    public function getTest()
    {
        return $this->test;
    }


    /**
     * Set the value of user member
     *
     * @param object $user
     *
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * Value of member user
     *
     * @return object value of member
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * List of fields to fetch from Graph
     *
     * @param array $fields
     *
     * @return GraphRequest
     */
    public function setFields($fields)
    {

    }

}
