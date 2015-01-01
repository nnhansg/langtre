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
	
if(Modules::IsModuleInstalled('rooms') && 
  ($objLogin->IsLoggedInAs('owner','mainadmin') || ($objLogin->IsLoggedInAs('hotelowner') && $objLogin->HasPrivileges('edit_hotel_rooms')))
){

	$rid = isset($_REQUEST['rid']) ? (int)$_REQUEST['rid'] : '';
	$room_type  = Rooms::GetRoomInfo($rid, 'room_type');
	
	draw_title_bar(
		prepare_breadcrumbs(array(_ROOMS_MANAGEMENT=>'',$room_type=>'',_PRICES=>'')),
		prepare_permanent_link('index.php?admin=mod_rooms_management', _BUTTON_BACK)
	);
	
	$task = isset($_REQUEST['task']) ? prepare_input($_REQUEST['task']) : '';
	$rpid  = isset($_POST['rpid']) ? (int)$_POST['rpid'] : '';
	
	$objRoom = new Rooms();

	if($task == 'add_new'){
		if($objRoom->AddRoomPrices($rid)){
			draw_success_message(_ROOM_PRICES_WERE_ADDED);	
		}else{
			draw_important_message($objRoom->error);
		}		
	}else if($task == 'update'){
		if($objRoom->UpdateRoomPrices($rid)){
			draw_success_message(_CHANGES_WERE_SAVED);	
		}else{
			draw_important_message($objRoom->error);
		}		
	}else if($task == 'delete'){
		if($objRoom->DeleteRoomPrices($rpid)){
			draw_success_message(_RECORD_WAS_DELETED_COMMON);	
		}else{
			draw_important_message($objRoom->error);
		}				
	}else if($task == 'refresh'){
		unset($_POST);
	}
	//echo $msg;

	if($rid > 0){
		draw_content_start();
		$objRoom->DrawRoomPricesForm($rid);		
		draw_content_end();		
	}else{
		draw_important_message(_WRONG_PARAMETER_PASSED);
	}
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>