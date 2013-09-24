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
 * Class User
 * Models the Facebook User object from the Graph API
 *
 * @see https://developers.facebook.com/docs/reference/api/user/
 *
 * @category GmbAdmin\Facebook
 * @package   facebook-graph
 * @author    Chris Noden <chris.noden@gmail.com>
 * @copyright 2013 Chris Noden
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link      https://github.com/chrisnoden
 */
class User extends GraphObject
{

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $first_name;
    /**
     * @var string
     */
    protected $last_name;
    /**
     * @var string
     */
    protected $gender;
    /**
     * @var string containing the ISO Language Code and ISO Country Code
     */
    protected $locale;
    /**
     * @var string a valid URL of the profile for the user on Facebook
     */
    protected $link;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var object containing mix and max for the age range (13-17, 18-20, 21+ - max is not set for 21+)
     */
    protected $age_range;
    /**
     * @var object requires app access_token
     */
    protected $installed;
    /**
     * @var boolean
     */
    protected $verified;
    /**
     * @var number user's timezone offset from UTC (available only for the current user)
     */
    protected $timezone;
    /**
     * @var object with fields currency and id
     */
    protected $currency;
    /**
     * @var array of objects containing os (iOS or Android) and hardware (iPad or iPhone)
     */
    protected $devices;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var object containing name and id
     */
    protected $location;
    /**
     * @var object (json) with url and is_silhouette
     */
    protected $picture;


    /**
     * Set the value of age_range member
     *
     * @param object $age_range
     *
     * @return void
     */
    public function setAgeRange($age_range)
    {
        $this->age_range = $age_range;
    }


    /**
     * Value of member age_range
     *
     * @return object value of member
     */
    public function getAgeRange()
    {
        return $this->age_range;
    }


    /**
     * Set the value of currency member
     *
     * @param object $currency
     *
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }


    /**
     * Value of member currency
     *
     * @return object value of member
     */
    public function getCurrency()
    {
        return $this->currency;
    }


    /**
     * Set the value of devices member
     *
     * @param array $devices
     *
     * @return void
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;
    }


    /**
     * Value of member devices
     *
     * @return array value of member
     */
    public function getDevices()
    {
        return $this->devices;
    }


    /**
     * Set the value of email member
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * Value of member email
     *
     * @return string value of member
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set the value of first_name member
     *
     * @param string $first_name
     *
     * @return void
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }


    /**
     * Value of member first_name
     *
     * @return string value of member
     */
    public function getFirstName()
    {
        return $this->first_name;
    }


    /**
     * Set the value of gender member
     *
     * @param string $gender
     *
     * @return void
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }


    /**
     * Value of member gender
     *
     * @return string value of member
     */
    public function getGender()
    {
        return $this->gender;
    }


    /**
     * Set the value of installed member
     *
     * @param object $installed
     *
     * @return void
     */
    public function setInstalled($installed)
    {
        $this->installed = $installed;
    }


    /**
     * Value of member installed
     *
     * @return object value of member
     */
    public function getInstalled()
    {
        return $this->installed;
    }


    /**
     * Set the value of last_name member
     *
     * @param string $last_name
     *
     * @return void
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }


    /**
     * Value of member last_name
     *
     * @return string value of member
     */
    public function getLastName()
    {
        return $this->last_name;
    }


    /**
     * Set the value of link member
     *
     * @param string $link
     *
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }


    /**
     * Value of member link
     *
     * @return string value of member
     */
    public function getLink()
    {
        return $this->link;
    }


    /**
     * Set the value of locale member
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }


    /**
     * Value of member locale
     *
     * @return string value of member
     */
    public function getLocale()
    {
        return $this->locale;
    }


    /**
     * Set the value of location member
     *
     * @param object $location
     *
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


    /**
     * Value of member location
     *
     * @return object value of member
     */
    public function getLocation()
    {
        return $this->location;
    }


    /**
     * Set the value of name member
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Value of member name
     *
     * @return string value of member
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set the value of picture member
     *
     * @param object $picture
     *
     * @return void
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }


    /**
     * Value of member picture
     *
     * @return object value of member
     */
    public function getPicture()
    {
        return $this->picture;
    }


    /**
     * Set the value of timezone member
     *
     * @param number $timezone
     *
     * @return void
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }


    /**
     * Value of member timezone
     *
     * @return number value of member
     */
    public function getTimezone()
    {
        return $this->timezone;
    }


    /**
     * Set the value of username member
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /**
     * Value of member username
     *
     * @return string value of member
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Set the value of verified member
     *
     * @param boolean $verified
     *
     * @return void
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }


    /**
     * Value of member verified
     *
     * @return boolean value of member
     */
    public function getVerified()
    {
        return $this->verified;
    }


}
