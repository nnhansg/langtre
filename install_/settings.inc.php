<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

    // -------------------------------------------------------------------------
    // 1. GENERAL SETTINGS
    // -------------------------------------------------------------------------
    // *** system mode (demo|debug|production)
    define('EI_MODE', 'production'); 

    // *** check for PHP minimal version number (true, false) -
    //     checks if minimal required version of PHP runs on a server
    define('EI_CHECK_PHP_MINIMAL_VERSION', true);  
    define('EI_PHP_MINIMAL_VERSION', '5.0.0');

    // *** check or not config directory for writability
    define('EI_CHECK_CONFIG_DIR_WRITABILITY', true);
        
    // *** admin username and password (true, false) - get admin username and password
    define('EI_USE_USERNAME_AND_PASWORD', true);        
    // *** encrypt or not admin password true|false
    define('EI_USE_PASSWORD_ENCRYPTION', true);        
    // *** type of encryption - AES|MD5
    define('EI_PASSWORD_ENCRYPTION_TYPE', 'AES');        
    // *** password encryption key 
    define('EI_PASSWORD_ENCRYPTION_KEY', 'apphp_hotel_site');
    
    
    // -------------------------------------------------------------------------
    // 2. CONFIG PARAMETERS
    // -------------------------------------------------------------------------
    // *** config file directory - directory, where config file must be placed
    //     for ex.: '../common/' or 'common/' - according to directory hierarchy
    define('EI_CONFIG_FILE_DIRECTORY', 'include/');

    // *** config file name - output file with cofig parameters (database, username etc.)
    define('EI_CONFIG_FILE_NAME', 'base.inc.php');
    define('EI_CONFIG_FILE_PATH', '../'.EI_CONFIG_FILE_DIRECTORY.EI_CONFIG_FILE_NAME);

    // *** sql dump file - file that includes SQL statements for instalation
    define('EI_SQL_DUMP_FILE_NEW', 'sql_dump/installation_new.sql');
    define('EI_SQL_DUMP_FILE_UPDATE', 'sql_dump/installation_update.sql');

    // *** defines using of utf-8 encoding and collation for SQL dump file
    define('EI_USE_ENCODING', true);
    define('EI_DUMP_FILE_ENCODING', 'utf8');
    define('EI_DUMP_FILE_COLLATION', 'utf8_unicode_ci');               
    

    // -------------------------------------------------------------------------
    // 3. CONFIG TEMPLATE PARAMETERS
    // -------------------------------------------------------------------------
    // *** config file name - config template file name
    define('EI_CONFIG_FILE_TEMPLATE', 'config.tpl');
   
    
    // -------------------------------------------------------------------------
    // 4. APPLICATION PARAMETERS
    // -------------------------------------------------------------------------
    // *** application name
    define('EI_APPLICATION_NAME', 'ApPHP Hotel Site Pro');
    define('EI_APPLICATION_VERSION', '4.0.3');
    
    // *** default start file name - application start file
    define('EI_APPLICATION_START_FILE', '../index.php');
    define('EI_APPLICATION_ADMIN_FILE', '../index.php?admin=login');
    
    // *** license agreement page
    define('EI_LICENSE_AGREEMENT_PAGE', 'license/GNU Lesser General Public License.txt');
   
    // *** text after successful installation
    define('EI_POST_TEXT', '<br />Please check access permissions to
        <ul>
            <li>images/uploads/</li>
            <li>images/flags/</li>
            <li>images/rooms_icons/</li>
            <li>images/banners/</li>
            <li>images/gallery/</li>
            <li>tmp/backup/</li>
            <li>tmp/export/</li>                    
            <li>tmp/cache/</li>
            <li>tmp/logs/</li>
            <li>feeds/</li>
        </ul>You have to grant write permission to these folders.<br /><br />');

?>