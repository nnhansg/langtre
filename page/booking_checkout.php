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

		$m   = isset($_REQUEST['m']) ? prepare_input($_REQUEST['m']) : '';
		$act = isset($_POST['act']) ? prepare_input($_POST['act']) : '';
		$discount_coupon = isset($_POST['discount_coupon']) ? prepare_input($_POST['discount_coupon']) : '';
		$submition_type = isset($_POST['submition_type']) ? prepare_input($_POST['submition_type']) : '';
		$payment_type = isset($_POST['payment_type']) ? prepare_input($_POST['payment_type']) : ''; 
		$msg = '';		

		draw_content_start();
		draw_reservation_bar('reservation');
		
		// test mode alert
		if(Modules::IsModuleInstalled('booking')){
			if(ModulesSettings::Get('booking', 'mode') == 'TEST MODE'){
				$msg = draw_message(_TEST_MODE_ALERT_SHORT, false, true);
			}        
		}
		
		if($m == '1'){
			if(ModulesSettings::Get('booking', 'allow_booking_without_account') == 'no'){
				$msg = draw_success_message(_ACCOUNT_WAS_CREATED, false);
			}
		}else if($m == '2'){
			if(ModulesSettings::Get('booking', 'allow_booking_without_account') == 'no'){
				$msg = draw_success_message(_ACCOUNT_WAS_UPDATED, false);
			}else{
				$msg = draw_success_message(_BILLING_DETAILS_UPDATED, false);
			}
		}
		
		if($submition_type == 'apply_coupon' && $discount_coupon != ''){
			if($objReservation->ApplyDiscountCoupon($discount_coupon)){
				$msg = draw_success_message(str_replace('_COUPON_CODE_', '<b>'.$discount_coupon.'</b>', _COUPON_WAS_APPLIED), false);
			}else{
				$msg = draw_important_message(_WRONG_COUPON_CODE, false);
			}
		}else if($submition_type == 'remove_coupon' && $discount_coupon != ''){
			if($objReservation->RemoveDiscountCoupon($discount_coupon)){
				$msg = draw_success_message(str_replace('_COUPON_CODE_', '<b>'.$discount_coupon.'</b>', _COUPON_WAS_REMOVED), false);
			}else{
				$msg = draw_important_message(_WRONG_COUPON_CODE, false);
			}			
		}

		if($msg != '') echo $msg;			
		
		$objReservation->ShowCheckoutInfo();
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