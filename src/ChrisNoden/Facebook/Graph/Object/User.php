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

namespace ChrisNoden\Facebook\Graph\Object;

use ChrisNoden\Facebook\Graph\AccessToken\AccessTokenType;

/**
 * Class User
 * Models the Facebook User object from the Graph API
 *
 * @see https://developers.facebook.com/docs/reference/api/user/
 *
 * @category  Graph\Object
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class User extends ObjectAbstract implements ObjectInterface
{

    /**
     * Main graph parameters/properties for this object
     *
     * @var array
     */
    protected $fields = array(
        'id' => array(
            'description' => 'The user\'s Facebook ID',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'name' => array(
            'description' => 'The user\'s full name',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'first_name' => array(
            'description' => 'The user\'s first name',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'middle_name' => array(
            'description' => 'The user\'s middle name',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'last_name' => array(
            'description' => 'The user\'s last name',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'gender' => array(
            'description' => 'The user\'s gender (male or female)',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'locale' => array(
            'description' => 'The user\'s locale',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'languages' => array(
            'description' => 'The user\'s languages',
            'permissions' => 'user_likes',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'link' => array(
            'description' => 'The URL of the profile for the user on Facebook',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'username' => array(
            'description' => 'The user\'s Facebook username',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'age_range' => array(
            'description' => 'The user\'s age range',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'third_party_id' => array(
            'description' => 'An anonymous, but unique identifier for the user',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'installed' => array(
            'description' => 'Specifies whether the user has installed the application associated with the app access token that is used to make the request',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'timezone' => array(
            'description' => 'The user\'s timezone offset from UTC',
            'permissions' => false,
            'returns'     => 'float',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'updated_time' => array(
            'description' => 'The last time the user\'s profile was updated',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'verified' => array(
            'description' => 'The user\'s account verification status, either true or false',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'boolean',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'bio' => array(
            'description' => 'The user\'s biography',
            'permissions' => 'user_about_me,friends_about_me',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'birthday' => array(
            'description' => 'The user\'s birthday',
            'permissions' => 'user_birthday,friends_birthday',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'cover' => array(
            'description' => 'The user\'s cover photo',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'currency' => array(
            'description' => 'The user\'s currency settings ',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'devices' => array(
            'description' => 'A list of the user\'s devices beyond desktop',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'education' => array(
            'description' => 'A list of the user\'s education history',
            'permissions' => 'user_education_history,friends_education_history',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'email' => array(
            'description' => 'The proxied or contact email address granted by the user',
            'permissions' => 'email',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'hometown' => array(
            'description' => 'The user\'s hometown',
            'permissions' => 'user_hometown,friends_hometown',
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'interested_in' => array(
            'description' => 'The genders the user is interested in',
            'permissions' => 'user_relationship_details,friends_relationship_details',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'location' => array(
            'description' => 'The user\'s current city',
            'permissions' => 'user_location,friends_location',
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'political' => array(
            'description' => 'The user\'s political view',
            'permissions' => 'user_religion_politics,friends_religion_politics',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'payment_pricepoints' => array(
            'description' => 'The mobile payment price-points available for that user, for use when processing payments using Facebook Credits',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'payment_mobile_pricepoints' => array(
            'description' => 'The mobile payment price-points available for that user, for use when processing payments using Local Currency',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'favorite_athletes' => array(
            'description' => 'The user\'s favorite athletes; this field is deprecated and will be removed in the near future',
            'permissions' => 'user_likes,friends_likes',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'favorite_teams' => array(
            'description' => 'The user\'s favorite teams; this field is deprecated and will be removed in the near future',
            'permissions' => 'user_likes,friends_likes',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'picture' => array(
            'description' => 'The user\'s profile pic',
            'permissions' => false,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'quotes' => array(
            'description' => 'The user\'s favourite quotes',
            'permissions' => 'user_about_me,friends_about_me',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'relationship_status' => array(
            'description' => 'The user\'s relationship status: Single, In a relationship, Engaged, Married, It\'s complicated, In an open relationship, Widowed, Separated, Divorced, In a civil union, In a domestic partnership',
            'permissions' => 'user_relationships,friends_relationships',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'religion' => array(
            'description' => 'The user\'s religion',
            'permissions' => 'user_religion_politics,friends_religion_politics',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'security_settings' => array(
            'description' => 'Information about security settings enabled on the user\'s account',
            'permissions' => false,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'significant_other' => array(
            'description' => 'The user\'s significant other',
            'permissions' => 'user_relationships,friends_relationships',
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'video_upload_limits' => array(
            'description' => 'The size of the video file and the length of the video that a user can upload',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'object',
            'editable'    => false,
            'must_ask'    => true,
        ),
        'website' => array(
            'description' => 'The URL of the user\'s personal website',
            'permissions' => 'user_website,friends_website',
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false,
        ),
        'work' => array(
            'description' => 'A list of the user\'s work history',
            'permissions' => 'user_work_history,friends_work_history',
            'returns'     => 'array',
            'editable'    => false,
            'must_ask'    => false,
        ),
    );

    /**
     * Object parameters that link to other objects in the Graph
     *
     * @todo finish adding connection items
     *
     * @var array
     */
    protected $connections = array(
        'accounts' => array(
            'description' => 'The Facebook pages of which the current user is an administrator',
            'permissions' => 'manage_pages',
            'returns'     => 'array',
        ),
        'adaccounts' => array(
            'description' => 'The Facebook Addvertising accounts to which the current user has access.',
            'permissions' => 'ads_management',
            'returns'     => 'array',
        ),
        'achievements' => array(
            'description' => 'The achievements for the user.',
            'permissions' => 'user_games_activity,friends_games_activity',
            'returns'     => 'array',
        ),
        'activities' => array(
            'description' => 'The activities listed on the user\'s profile.',
            'permissions' => 'user_activities,friends_activities',
            'returns'     => 'array',
        ),
        'albums' => array(
            'description' => 'The photo albums this user has created.',
            'permissions' => 'user_photos,friends_photos',
            'returns'     => 'array',
        ),
        'apprequests' => array(
            'description' => 'The user\'s outstanding requests from an app.',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array',
        ),
        'books' => array(
            'description' => 'The books listed on the user\'s profile.',
            'permissions' => 'user_likes,friends_likes',
            'returns'     => 'array',
        ),
        'checkins' => array(
            'description' => 'The places that the user has checked-into.',
            'permissions' => 'user_checkins,friends_checkins',
            'returns'     => 'array',
        ),
        'events' => array(
            'description' => 'The events this user is attending.',
            'permissions' => 'user_events,friends_events',
            'returns'     => 'array',
        ),
        'family' => array(
            'description' => 'The user\'s family relationships',
            'permissions' => 'user_relationships',
            'returns'     => 'array',
        ),
        'feed' => array(
            'description' => 'The user\'s wall.',
            'permissions' => 'read_stream',
            'returns'     => 'array',
        ),
        'friendlists' => array(
            'description' => 'The user\'s friend lists.',
            'permissions' => 'read_friendlists',
            'returns'     => 'array',
        ),
        'friendrequests' => array(
            'description' => 'The user\'s incoming friend requests.',
            'permissions' => 'user_requests',
            'returns'     => 'array',
        ),
        'friends' => array(
            'description' => 'The user\'s friends.',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'array',
        ),
        'games' => array(
            'description' => 'Games the user has added to the Arts and Entertainment section of their profile.',
            'permissions' => 'user_likes',
            'returns'     => 'array',
        ),
    );
}
