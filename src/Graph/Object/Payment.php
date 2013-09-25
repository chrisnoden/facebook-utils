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

use Graph\AccessToken\AccessTokenType;

/**
 * Class Payment
 * Models the Facebook Payment object from the Graph API
 *
 * @see https://developers.facebook.com/docs/reference/api/payment/
 *
 * @category  Graph\Object
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class Payment extends ObjectAbstract implements ObjectInterface
{

    /**
     * Main graph parameters/properties for this object
     *
     * @var array
     */
    protected $fields = array(
        'id' => array(
            'description' => 'The payment ID',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'user' => array(
            'description' => 'The user\'s first and last name along with their user id',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'product' => array(
            'description' => 'The URL of the og:product object ordered',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'quantity' => array(
            'description' => 'The quantity of the product contained in the order',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'integer',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'request_id' => array(
            'description' => 'The unique, optional app-created identifier passed into the JS function (255 character maximum)',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'application' => array(
            'description' => 'The application associated with this payment',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'actions' => array(
            'description' => 'The type, status, amount, currency, time_created and time_updated for a Payment.',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'items' => array(
            'description' => 'The items associated with the payment containing type, product and quantity',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'country' => array(
            'description' => 'Buyer\'s ISO Country Code for tax purposes',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'created_time' => array(
            'description' => 'The time the Payment was originally created',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'payout_foreign_exchange_rate' => array(
            'description' => 'Exchange rate used to calculate payout amount which is remitted in USD',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'float',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'disputes' => array(
            'description' => 'Contains the information for a dispute including the user_comment, which is the information the user passed to FB when disputing the order, along with the time_created, this field is only returned if this payment is disputed',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'test' => array(
            'description' => 'Optional parameter that shows up when a payment is made by a payment tester listed in the developer app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'boolean',
            'editable'    => false,
            'must_ask'    => false,
        ),
    );

    /**
     * Object parameters that link to other objects in the Graph
     *
     * @var array
     */
    protected $connections = array(
        'refunds' => array(
            'description' => 'Refunds a payment',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object'
        ),
    );
}
