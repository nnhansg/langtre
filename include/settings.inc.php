<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

define('IMAGE_DIRECTORY', 'images/');     
define('CACHE_DIRECTORY', 'tmp/cache/');

define('CURRENT_VERSION', '4.0.3');
define('SITE_MODE', 'production');     // demo|development|production
define('DEFAULT_TEMPLATE', 'default'); // default
define('DEFAULT_DIRECTION', 'ltr');    // ltr|rtl

// (list of supported Timezones - http://us3.php.net/manual/en/timezones.php)    
define('TIME_ZONE', 'Asia/Saigon');

// return types for database_query function
// --------------------------------------------------------------
define('ALL_ROWS', 0);
define('FIRST_ROW_ONLY', 1);
define('DATA_ONLY', 0);
define('ROWS_ONLY', 1);
define('DATA_AND_ROWS', 2);
define('FIELDS_ONLY', 3);
define('FETCH_ASSOC', 'mysql_fetch_assoc');
define('FETCH_ARRAY', 'mysql_fetch_array');

// definition of tables constants
// --------------------------------------------------------------
define('TABLE_ACCOUNTS', DB_PREFIX.'accounts');      
define('TABLE_BANLIST', DB_PREFIX.'banlist');      
define('TABLE_BANNERS', DB_PREFIX.'banners');      
define('TABLE_BANNERS_DESCRIPTION', DB_PREFIX.'banners_description');      
define('TABLE_BOOKINGS', DB_PREFIX.'bookings');      
define('TABLE_BOOKINGS_ROOMS', DB_PREFIX.'bookings_rooms');      
define('TABLE_CAMPAIGNS', DB_PREFIX.'campaigns');      
define('TABLE_COMMENTS', DB_PREFIX.'comments');      
define('TABLE_COUNTRIES', DB_PREFIX.'countries');
define('TABLE_COUPONS', DB_PREFIX.'coupons');
define('TABLE_CURRENCIES', DB_PREFIX.'currencies');
define('TABLE_CUSTOMERS', DB_PREFIX.'customers');
define('TABLE_CUSTOMER_GROUPS', DB_PREFIX.'customer_groups');      
define('TABLE_EMAIL_TEMPLATES', DB_PREFIX.'email_templates');      
define('TABLE_EVENTS_REGISTERED', DB_PREFIX.'events_registered');
define('TABLE_EXTRAS', DB_PREFIX.'extras');
define('TABLE_EXTRAS_DESCRIPTION', DB_PREFIX.'extras_description');
define('TABLE_FAQ_CATEGORIES', DB_PREFIX.'faq_categories');
define('TABLE_FAQ_CATEGORY_ITEMS', DB_PREFIX.'faq_category_items');      
define('TABLE_GALLERY_ALBUMS', DB_PREFIX.'gallery_albums');      
define('TABLE_GALLERY_ALBUMS_DESCRIPTION', DB_PREFIX.'gallery_albums_description');      
define('TABLE_GALLERY_ALBUM_ITEMS', DB_PREFIX.'gallery_album_items');      
define('TABLE_GALLERY_ALBUM_ITEMS_DESCRIPTION', DB_PREFIX.'gallery_album_items_description');      
define('TABLE_HOTELS', DB_PREFIX.'hotels');      
define('TABLE_HOTELS_DESCRIPTION', DB_PREFIX.'hotels_description');      
define('TABLE_HOTELS_LOCATIONS', DB_PREFIX.'hotels_locations');
define('TABLE_HOTELS_LOCATIONS_DESCRIPTION', DB_PREFIX.'hotels_locations_description');      
define('TABLE_LANGUAGES', DB_PREFIX.'languages');
define('TABLE_MEAL_PLANS', DB_PREFIX.'meal_plans');      
define('TABLE_MEAL_PLANS_DESCRIPTION', DB_PREFIX.'meal_plans_description');      
define('TABLE_MENUS', DB_PREFIX.'menus');      
define('TABLE_MODULES', DB_PREFIX.'modules');      
define('TABLE_MODULES_SETTINGS', DB_PREFIX.'modules_settings');      
define('TABLE_NEWS', DB_PREFIX.'news');
define('TABLE_NEWS_SUBSCRIBED', DB_PREFIX.'news_subscribed');
define('TABLE_PACKAGES', DB_PREFIX.'packages');
define('TABLE_PAGES', DB_PREFIX.'pages');
define('TABLE_PRIVILEGES', DB_PREFIX.'privileges');
define('TABLE_ROLES', DB_PREFIX.'roles');
define('TABLE_ROLE_PRIVILEGES', DB_PREFIX.'role_privileges');		   
define('TABLE_ROOMS', DB_PREFIX.'rooms');      
define('TABLE_ROOMS_AVAILABILITIES', DB_PREFIX.'rooms_availabilities');      
define('TABLE_ROOMS_DESCRIPTION', DB_PREFIX.'rooms_description');      
define('TABLE_ROOM_FACILITIES', DB_PREFIX.'room_facilities');
define('TABLE_ROOM_FACILITIES_DESCRIPTION', DB_PREFIX.'room_facilities_description');      
define('TABLE_ROOMS_PRICES', DB_PREFIX.'rooms_prices');      
define('TABLE_SEARCH_WORDLIST', DB_PREFIX.'search_wordlist');      
define('TABLE_SETTINGS', DB_PREFIX.'settings');      
define('TABLE_SITE_DESCRIPTION', DB_PREFIX.'site_description');
define('TABLE_TESTIMONIALS', DB_PREFIX.'testimonials');      
define('TABLE_VOCABULARY', DB_PREFIX.'vocabulary');

define('TABLE_ROOMS_PRICES_EXTEND', DB_PREFIX_NTDT.'rooms_prices_extend');

//------------------------------------------------------------------------------
// set errors handling
if(SITE_MODE == 'development'){
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');    
}else{
	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
}

?>