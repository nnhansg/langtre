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

if($objLogin->IsLoggedInAsCustomer()){

	if(Modules::IsModuleInstalled('booking') &&
	   in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))
	){
		
		$action 	= MicroGrid::GetParameter('action');
		$operation 	= MicroGrid::GetParameter('opearation');
		$operation_field = MicroGrid::GetParameter('operation_field');
		$rid    	= MicroGrid::GetParameter('rid');
		$mode   	= 'view';
		$msg 		= '';
		$customers_cancel_reservation = ModulesSettings::Get('booking', 'customers_cancel_reservation');	
		
		$objBookings = new Bookings($objLogin->GetLoggedID());
		
		if($action=='add'){		
			$mode = 'add';
		}else if($action=='create'){
			if($objBookings->AddRecord()){
				$msg = draw_success_message(_ADDING_OPERATION_COMPLETED, false);
				$mode = 'view';
			}else{
				$msg = draw_important_message($objBookings->error, false);
				$mode = 'add';
			}
		}else if($action=='edit'){
			$mode = 'edit';
		}else if($action=='update'){
			if($objBookings->UpdateRecord($rid)){
				$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
				$mode = 'view';
			}else{
				$msg = draw_important_message($objBookings->error, false);
				$mode = 'edit';
			}		
		}else if($action=='delete' && $customers_cancel_reservation > '0'){
			if($objBookings->DeleteRecord($rid)){
				$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
			}else{
				$msg = draw_important_message($objBookings->error, false);
			}
			$mode = 'view';
		}else if($action=='cancel' && $customers_cancel_reservation > '0'){
			if($objBookings->CancelRecord($rid)){
				$msg  = draw_success_message(str_replace('_BOOKING_', '', _BOOKING_CANCELED_SUCCESS), false);
				// send email to customer about reservation cancelation
				$objReservation = new Reservation();
				if($objReservation->SendCancelOrderEmail($rid)){
					$msg .= draw_success_message(_EMAIL_SUCCESSFULLY_SENT, false);
				}else{
					$msg .= draw_important_message($objReservation->error, false);
				}			
			}else{
				$msg = draw_important_message($objBookings->error, false);
			}
			$mode = 'view';
		}else if($action=='details'){		
			$mode = 'details';		
		}else if($action=='cancel_add'){		
			$mode = 'view';		
		}else if($action=='cancel_edit'){				
			$mode = 'view';
		}else if($action=='description'){				
			$mode = 'description';
		}else if($action=='invoice'){				
			$mode = 'invoice';
		}
		
		// Start main content
		draw_title_bar(
			prepare_breadcrumbs(array(_BOOKINGS=>'',_BOOKINGS_MANAGEMENT=>'',ucfirst($action)=>'')),
			(($mode == 'invoice' || $mode == 'description') ? '<a href="javascript:appPreview(\''.$mode.'\');"><img src="images/printer.png" alt="" /> '._PRINT.'</a>' : '')
		);
			
		//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
		echo $msg;
	
		//draw_content_start();
		echo '<div id="divMyBookings">';
		if($mode == 'view'){			
			echo '<script type="text/javascript">
				function __mgMyDoPostBack(tbl, type, key){
					if(confirm("'._ALERT_CANCEL_BOOKING.'")){
						__mgDoPostBack(tbl, type, key);
					}					
				}
			  </script>';
			$objBookings->DrawViewMode();	
		}else if($mode == 'add'){		
			$objBookings->DrawAddMode();		
		}else if($mode == 'edit'){		
			$objBookings->DrawEditMode($rid, $operation, $operation_field);		
		}else if($mode == 'details'){		
			$objBookings->DrawDetailsMode($rid);		
		}else if($mode == 'description'){		
			$objBookings->DrawBookingDescription($rid);		
		}else if($mode == 'invoice'){		
			$objBookings->DrawBookingInvoice($rid);		
		}	
		//draw_content_end();
		echo '</div>';

	}else{
		draw_title_bar(prepare_breadcrumbs(array(_CUSTOMERS=>'')));
		draw_important_message(_NOT_AUTHORIZED);
	}
}else{
	draw_title_bar(prepare_breadcrumbs(array(_CUSTOMERS=>'')));
	draw_important_message(_NOT_AUTHORIZED);
}

?>