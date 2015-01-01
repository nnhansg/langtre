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

$hotel_id = isset($_GET['hid']) ? (int)$_GET['hid'] : '';

if($hotel_id != ''){	
	Hotels::DrawHotelDescription($hotel_id); 
}else{
	draw_title_bar(_HOTEL_DESCRIPTION);
	draw_important_message(_WRONG_PARAMETER_PASSED);		
}
	
?>