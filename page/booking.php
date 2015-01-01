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
		
		$room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : '0';
		$from_date = isset($_POST['from_date']) ? prepare_input($_POST['from_date']) : '';
		$to_date = isset($_POST['to_date']) ? prepare_input($_POST['to_date']) : '';
		$nights  = isset($_POST['nights']) ? (int)$_POST['nights'] : '';
		$adults = isset($_POST['adults']) ? (int)$_POST['adults'] : '0';
		$children = isset($_POST['children']) ? (int)$_POST['children'] : '0';
		
		$available_rooms  = isset($_POST['available_rooms']) ? prepare_input($_POST['available_rooms']) : '';
		$available_rooms_parts = explode('-', $available_rooms);
		$rooms  = isset($available_rooms_parts[0]) ? (int)$available_rooms_parts[0] : '';
		$price  = isset($available_rooms_parts[1]) ? (float)$available_rooms_parts[1] : '';
		
		$available_guests = isset($_POST['available_guests']) ? prepare_input($_POST['available_guests']) : '';
		$available_guests_parts = explode('-', $available_guests);
		$guests    = isset($available_guests_parts[0]) ? (int)$available_guests_parts[0] : '';
		$guest_fee = isset($available_guests_parts[1]) ? (float)$available_guests_parts[1] : '';		
		
		$meal_plan_id = isset($_POST['meal_plans']) ? (int)$_POST['meal_plans'] : '';
		$hotel_id = isset($_POST['hotel_id']) ? (int)$_POST['hotel_id'] : '0';
		
		$objReservation = new Reservation();
		
		$act = isset($_GET['act']) ? prepare_input($_GET['act']) : '';
		$rid = isset($_GET['rid']) ? (int)$_GET['rid'] : '';
		
		if($act == 'remove'){
			$objReservation->RemoveReservation($rid);
		}else{
			$objReservation->AddToReservation($room_id, $from_date, $to_date, $nights, $rooms, $price, $adults, $children, $meal_plan_id, $hotel_id, $guests, $guest_fee);				
		}
		
		if($objLogin->IsLoggedInAsAdmin()) draw_title_bar(prepare_breadcrumbs(array(_BOOKING=>'')));
		
		draw_content_start();
		draw_reservation_bar('selected_rooms');		

		// test mode alert
		if(Modules::IsModuleInstalled('booking')){
			if(ModulesSettings::Get('booking', 'mode') == 'TEST MODE'){
				draw_message(_TEST_MODE_ALERT_SHORT, true, true);
			}        
		}

		Campaigns::DrawCampaignBanner('standard');
		Campaigns::DrawCampaignBanner('global');

		$objReservation->ShowReservationInfo();
		draw_content_end();
		
	}else{
		draw_title_bar(_BOOKINGS);
		draw_important_message(_NOT_AUTHORIZED);	
	}
}else{
	draw_title_bar(_BOOKINGS);
	draw_important_message(_NOT_AUTHORIZED);
}

?>