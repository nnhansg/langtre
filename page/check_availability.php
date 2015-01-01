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

$room_id = isset($_POST['room_id']) ? prepare_input($_POST['room_id']) : '';

$checkin_year_month 	= isset($_POST['checkin_year_month']) ? prepare_input($_POST['checkin_year_month']) : date('Y').'-'.(int)date('m');
$checkin_year_month_parts = explode('-', $checkin_year_month);
$checkin_year 			= isset($checkin_year_month_parts[0]) ? $checkin_year_month_parts[0] : '';
$checkin_month 			= isset($checkin_year_month_parts[1]) ? convert_to_decimal($checkin_year_month_parts[1]) : '';
$checkin_day 			= isset($_POST['checkin_monthday']) ? convert_to_decimal($_POST['checkin_monthday']) : date('d');

$curr_date 				= mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
$checkout_year_month 	= isset($_POST['checkout_year_month']) ? prepare_input($_POST['checkout_year_month']) : date('Y').'-'.(int)date('m');
$checkout_year_month_parts = explode('-', $checkout_year_month);
$checkout_year 			= isset($checkout_year_month_parts[0]) ? $checkout_year_month_parts[0] : '';
$checkout_month 		= isset($checkout_year_month_parts[1]) ? convert_to_decimal($checkout_year_month_parts[1]) : '';
$checkout_day 			= isset($_POST['checkout_monthday']) ? convert_to_decimal($_POST['checkout_monthday']) : date('d', $curr_date);

$max_adults 			= isset($_POST['max_adults']) ? (int)$_POST['max_adults'] : '';
$max_children 			= isset($_POST['max_children']) ? (int)$_POST['max_children'] : '';
$sort_by                = isset($_POST['sort_by']) ? prepare_input($_POST['sort_by']) : '';
$hotel_sel_id           = isset($_POST['hotel_sel_id']) ? prepare_input($_POST['hotel_sel_id']) : '';
$hotel_sel_loc_id       = isset($_POST['hotel_sel_loc_id']) ? prepare_input($_POST['hotel_sel_loc_id']) : ''; 

$nights = nights_diff($checkin_year.'-'.$checkin_month.'-'.$checkin_day, $checkout_year.'-'.$checkout_month.'-'.$checkout_day);


draw_title_bar(_AVAILABLE_ROOMS);

// Check if there is a page 
if($checkin_year_month == '0' || $checkin_day == '0' || $checkout_year_month == '0' || $checkout_day == '0'){
	draw_important_message(_WRONG_PARAMETER_PASSED);
}else if(!checkdate($checkout_month, $checkout_day, $checkout_year)){
	draw_important_message(_WRONG_CHECKOUT_DATE_ALERT);
}else if(ModulesSettings::Get('booking', 'allow_booking_in_past') != 'yes' && $checkin_year.$checkin_month.$checkin_day < date('Ymd')){
	draw_important_message(_PAST_TIME_ALERT);		
}else if($nights < 1){
	draw_important_message(_BOOK_ONE_NIGHT_ALERT);
}else if(Modules::IsModuleInstalled('booking')){
	$min_nights = ModulesSettings::Get('booking', 'minimum_nights');
	$min_nights_packages = Packages::GetMinimumNights($checkin_year.'-'.$checkin_month.'-'.$checkin_day, $checkout_year.'-'.$checkout_month.'-'.$checkout_day);
	if($min_nights_packages['minimum_nights'] > '1') $min_nights = $min_nights_packages['minimum_nights'];

	$max_nights = ModulesSettings::Get('booking', 'maximum_nights');
	$max_nights_packages = Packages::GetMaximumNights($checkin_year.'-'.$checkin_month.'-'.$checkin_day, $checkout_year.'-'.$checkout_month.'-'.$checkout_day);
	if($max_nights_packages > '1') $max_nights = $max_nights_packages;

	if($min_nights > $nights){
		draw_important_message(
			str_replace(array('_NIGHTS_', '_FROM_', '_TO_'),
						array('<b>'.$min_nights.'</b>', '<b>'.format_date($min_nights_packages['start_date']).'</b>', '<b>'.format_date($min_nights_packages['finish_date']).'</b>'),
						_MINIMUM_NIGHTS_ALERT
			)
		);
	}else if($max_nights < $nights){
		draw_important_message(
			str_replace(array('_NIGHTS_', '_FROM_', '_TO_'),
						array('<b>'.$max_nights.'</b>', '<b>'.format_date($min_nights_packages['start_date']).'</b>', '<b>'.format_date($min_nights_packages['finish_date']).'</b>'),
						_MAXIMUM_NIGHTS_ALERT
			)
		);
	}else{		
		$nights_text = ($nights > 1) ? $nights.' '._NIGHTS : $nights.' '._NIGHT;
		
		draw_content_start();
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			draw_sub_title_bar(_FROM.': '.get_month_local($checkin_month).' '.$checkin_day.', '.$checkin_year.' '._TO.': '.get_month_local($checkout_month).' '.$checkout_day.', '.$checkout_year.' ('.$nights_text.')', true, 'h4');
		}else{
			draw_sub_title_bar(_FROM.': '.$checkin_day.' '.get_month_local($checkin_month).' '.$checkin_year.' '._TO.': '.$checkout_day.' '.get_month_local($checkout_month).' '.$checkout_year.' ('.$nights_text.')', true, 'h4');
		}
		
		$objRooms = new Rooms();
		$params = array(
			'room_id'     => $room_id,
			'from_date'	  => $checkin_year.'-'.$checkin_month.'-'.$checkin_day,
			'to_date'	  => $checkout_year.'-'.$checkout_month.'-'.$checkout_day,
			'nights'	  => $nights,
			'from_year'	  => $checkin_year,
			'from_month'  => $checkin_month,
			'from_day'	  => $checkin_day,
			'to_year'	  => $checkout_year,
			'to_month'	  => $checkout_month,
			'to_day'	  => $checkout_day,
			'max_adults'  => $max_adults,
			'max_children'     => $max_children,
			'sort_by'          => $sort_by,
			'hotel_sel_id'     => $hotel_sel_id,
			'hotel_sel_loc_id' => $hotel_sel_loc_id,
		);
		
		$rooms_count = $objRooms->SearchFor($params);
		
		if($rooms_count > 0){
			$objRooms->DrawSearchResult($params, $rooms_count);			
		}else{
			draw_important_message(_NO_ROOMS_FOUND);
			draw_message(_SEARCH_ROOM_TIPS);
			
			if(ModulesSettings::Get('rooms', 'allow_system_suggestion') == 'yes'){
				Rooms::DrawTrySystemSuggestionForm($room_id, $checkin_day, $checkin_year_month, $checkout_day, $checkout_year_month, $max_adults, $max_children);				
			}
		}
		draw_content_end();	
	}
}

?>