<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// *** Make sure the file isn't accessed directly
defined('APPHP_EXEC') or die('Restricted Access');
//--------------------------------------------------------------------------

if(Modules::IsModuleInstalled('booking')){
	if(ModulesSettings::Get('booking', 'is_active') == 'global' ||
	   ModulesSettings::Get('booking', 'is_active') == 'front-end' ||
	  (ModulesSettings::Get('booking', 'is_active') == 'back-end' && $objLogin->IsLoggedInAsAdmin())	
	){

		$objReservation = new Reservation();
		//--------------------------------------------------------------------------
		// *** redirect if reservation cart is empty
		if($objReservation->IsCartEmpty()){
			header('location: index.php?page=booking');
			echo '<p>if your browser doesn\'t support redirection please click <a href="index.php?page=booking">here</a>.</p>';        
			exit;		
		}
	}
}

?>