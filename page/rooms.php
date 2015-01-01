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

$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : '';
$back_button = isset($_GET['b']) ? (boolean)$_GET['b'] : true;

$objRoom = new Rooms();

if($room_id != '') {
	draw_title_bar(_ROOM_DESCRIPTION);
	Rooms::DrawRoomDescription($room_id, $back_button); 
}else{
	draw_important_message(_WRONG_PARAMETER_PASSED);		
}
	
?>