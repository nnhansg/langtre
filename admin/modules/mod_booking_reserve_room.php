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

if($objLogin->IsLoggedInAsAdmin() &&
   Modules::IsModuleInstalled('booking') &&
   in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'back-end'))
){

	// Start main content
	draw_title_bar(prepare_breadcrumbs(array(_BOOKINGS=>'',_BOOKINGS_MANAGEMENT=>'',_RESERVATION=>'')));

	draw_content_start();
	echo '<input class="mgrid_button" type="button" name="btnAddNew" value="'._RESERVATION_CART.'" onclick="javascript:appGoTo(\'page=booking\');"></a> &nbsp;';
	echo '<input class="mgrid_button" type="button" name="btnAddNew" value="'._CHECKOUT.'" onclick="javascript:appGoTo(\'page=booking_checkout\');"></a> <br /><br />';
	
	Rooms::DrawSearchAvailabilityBlock();
	draw_content_end();	
	
	Rooms::DrawSearchAvailabilityFooter();
	
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>