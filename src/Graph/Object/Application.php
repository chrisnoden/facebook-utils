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

/**
 * Class Application
 *
 * @category GmbAdmin\Facebook
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class Application extends GraphObject
{

    /**
     * @var string
     */
    protected $app_secret;

    /**
     * Main graph parameters/properties for this object
     *
     * @var array
     */
    protected $fields = array(
        'id' => array(
            'description' => 'The application ID',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'name' => array(
            'description' => 'The title of the application',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'description' => array(
            'description' => 'The description of the application written by the 3rd party developers',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'category' => array(
            'description' => 'The category of the application',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'company' => array(
            'description' => 'The company the application belongs to',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'icon_url' => array(
            'description' => 'The URL of the application\'s icon',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'subcategory' => array(
            'description' => 'The subcategory of the application',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'link' => array(
            'description' => 'A link to the Application on Facebook',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'logo_url' => array(
            'description' => 'The URL of the application\'s logo',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'daily_active_users' => array(
            'description' => 'The number of daily active users the application has',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'daily_active_users_rank' => array(
            'description' => 'Ranking of this app vs other apps comparing daily active users',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'weekly_active_users' => array(
            'description' => 'The number of weekly active users the application has',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'monthly_active_users' => array(
            'description' => 'The number of monthly active users the application has',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'monthly_active_users_rank' => array(
            'description' => 'Ranking of this app vs other apps comparing monthly active users',
            'permissions' => false,
            'returns'     => 'string',
            'editable'    => false,
            'must_ask'    => false
        ),
        'migrations' => array(
            'description' => 'Migrations settings for app profile',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array',
            'editable'    => true,
            'must_ask'    => true
        ),
        'namespace' => array(
            'description' => 'The namespace for the app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true
        ),
        'restrictions' => array(
            'description' => 'Demographic restrictions set for this app',
            'permissions' => false,
            'returns'     => 'Object',
            'editable'    => true,
            'must_ask'    => true
        ),
        'app_domains' => array(
            'description' => 'Domains and subdomains this app can use',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array',
            'editable'    => true,
            'must_ask'    => true
        ),
        'auth_dialog_data_help_url' => array(
            'description' => 'The URL of a special landing page that helps users of an app begin publishing Open Graph activity',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'auth_dialog_headline' => array(
            'description' => 'One line description of an app that appears in the Auth Dialog',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'canvas_url' => array(
            'description' => 'The non-secure URL from which Canvas app content is loaded',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'contact_email' => array(
            'description' => 'Email address listed for users to contact developers',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'created_time' => array(
            'description' => 'Unix timestamp that indicates when the app was created',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'int',
            'editable'    => false,
            'must_ask'    => true
        ),
        'creator_uid' => array(
            'description' => 'User ID of the creator of this app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'int',
            'editable'    => false,
            'must_ask'    => true
        ),
        'deauth_callback_url' => array(
            'description' => 'URL that is pinged whenever a user removes the app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'page_tab_default_name' => array(
            'description' => 'The title of the app when used in a Page Tab',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'page_tab_url' => array(
            'description' => 'The non-secure URL from which Page Tab app content is loaded',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'privacy_policy_url' => array(
            'description' => 'The URL that links to a Privacy Policy for the app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'profile_section_url' => array(
            'description' => 'The desktop URL that is a direct link to the section created when your app creates objects for collections',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'secure_canvas_url' => array(
            'description' => 'The secure URL from which Canvas app content is loaded',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'secure_page_tab_url' => array(
            'description' => 'The secure URL from which Page Tab app content is loaded',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'server_ip_whitelist' => array(
            'description' => 'App requests must originate from this comma-separated list of IP addresses',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'social_discovery' => array(
            'description' => 'Indicates whether app usage stories show up in the Ticker or News Feed',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'bool',
            'editable'    => true,
            'must_ask'    => true
        ),
        'terms_of_service_url' => array(
            'description' => 'URL to Terms of Service which is linked to in Auth Dialog',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'user_support_email' => array(
            'description' => 'Main contact email for this app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'user_support_url' => array(
            'description' => 'URL of support for users of an app shown in Canvas footer',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
        'website_url' => array(
            'description' => 'URL of a website that integrates with this app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'string',
            'editable'    => true,
            'must_ask'    => true
        ),
    );

    /**
     * Object parameters that link to other objects in the Graph
     *
     * @var array
     */
    protected $connections = array(
        'accounts' => array(
            'description' => 'Test User accounts associated with the app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'achievements' => array(
            'description' => 'Achievements registered for the app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'banned' => array(
            'description' => 'Banned users from your app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'groups' => array(
            'description' => 'Groups for this app',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'insights' => array(
            'description' => 'Usage metrics for this application',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'payment_currencies' => array(
            'description' => 'Open Graph currency objects associated with this application',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'payments' => array(
            'description' => 'The list of Facebook Credits orders associated with the application',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'picture' => array(
            'description' => 'The application\'s profile picture with maximum dimensions of 75x75 pixels suitable for embedding as the source of an image tag',
            'permissions' => false,
            'returns'     => 'string'
        ),
        'roles' => array(
            'description' => 'The developer roles defined for this application',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'staticresources' => array(
            'description' => 'Usage stats about the canvas application\'s static resources, such as javascript and CSS, and which ones are being flushed to browsers early',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'subscriptions' => array(
            'description' => 'All of the subscriptions this application has for real-time notifications',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'translations' => array(
            'description' => 'The translated strings for this application',
            'permissions' => AccessTokenType::APP,
            'returns'     => 'array'
        ),
        'scores' => array(
            'description' => 'Scores for the user and their friends',
            'permissions' => AccessTokenType::USER,
            'returns'     => 'array'
        ),
    );


    /**
     * Set the secret of the application
     *
     * @param string $app_secret
     *
     * @return void
     */
    public function setSecret($app_secret)
    {
        $this->app_secret = $app_secret;
    }


    /**
     * Facebook app secret
     *
     * @return string value of member
     */
    public function getSecret()
    {
        return $this->app_secret;
    }
}
