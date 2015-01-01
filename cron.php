<?php 
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

require_once('include/base.inc.php');
require_once('include/connection.php');

if(!$objLogin->IsLoggedIn()){

    ////////////////////////////////////////////////////////////////////////////
    // Cron - check if there is some work for cron 
    ////////////////////////////////////////////////////////////////////////////    

	Cron::Run();		

}    
    
?>