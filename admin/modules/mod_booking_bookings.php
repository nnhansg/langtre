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

if($objLogin->IsLoggedInAsAdmin() && Modules::IsModuleInstalled('booking')){

	$action 		 = MicroGrid::GetParameter('action');
	$operation 		 = MicroGrid::GetParameter('opearation');
	$title_action    = $action;
	$operation_field = MicroGrid::GetParameter('operation_field');
	$rid    		 = MicroGrid::GetParameter('rid');	

	$booking_status  = MicroGrid::GetParameter('status', false);
	$booking_number  = MicroGrid::GetParameter('booking_number', false);
	$customer_id     = MicroGrid::GetParameter('customer_id', false);
	$room_numbers    = MicroGrid::GetParameter('room_numbers', false);
	$drid    	     = MicroGrid::GetParameter('rdid', false);
	$sel_extras      = MicroGrid::GetParameter('sel_extras', false);
	$extras_amount   = MicroGrid::GetParameter('extras_amount', false);

	$mode = 'view';
	$msg = '';
	$links = '';
	
	$objBookings = new Bookings();
	
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
			if($booking_status == '2'){
				$objBookings->UpdatePaymentDate($rid);
				// send email to customer
				$objReservation = new Reservation();
				$objReservation->SendOrderEmail($booking_number, 'completed', $customer_id);
			}
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objBookings->error, false);
			$mode = 'edit';
		}
	}else if($action=='delete'){
		if($objBookings->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'view';		
	}else if($action=='cancel'){
		if($objBookings->CancelRecord($rid)){			
			$msg = draw_success_message(str_replace('_BOOKING_', '', _BOOKING_CANCELED_SUCCESS), false);
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
	}else if($action=='download_invoice'){
		if(strtolower(SITE_MODE) == "demo"){
			$msg = draw_important_message(_OPERATION_BLOCKED, false);
		}else{		
			if($objBookings->PrepareInvoiceDownload($rid)){
				$msg = draw_success_message($objBookings->message, false);			
			}else{
				$msg = draw_important_message($objBookings->error, false);
			}
		}
		$mode = 'view';
		$title_action = _DOWNLOAD_INVOICE;		
	}else if($action=='send_invoice'){
		if($objBookings->SendInvoice($rid)){
			$msg = draw_success_message(_INVOICE_SENT_SUCCESS, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'view';
		$title_action = _SEND_INVOICE;
	}else if($action=='clean_credit_card'){				
		if($objBookings->CleanUpCreditCardInfo($rid)){
			$msg = draw_success_message(_OPERATION_COMMON_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'view';
		$title_action = 'Clean';
	}else if($action=='cleanup_bookings'){				
		if($objBookings->CleanUpBookings($rid)){
			$msg = draw_success_message(_OPERATION_COMMON_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'view';
		$title_action = _CLEANUP;
	}else if($action=='update_room_numbers'){
		if($objBookings->UpdateRoomNumbers($drid, $room_numbers)){
			$msg = draw_success_message(_OPERATION_COMMON_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'description';
		$title_action = _BUTTON_UPDATE;		
	}else if($action=='add_extras'){
		if($objBookings->RecalculateExtras($rid, $sel_extras, $extras_amount, 'add')){
			$msg = draw_success_message(_OPERATION_COMMON_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'description';
		$title_action = _BUTTON_UPDATE;
	}else if($action=='remove_extras'){
		if($objBookings->RecalculateExtras($rid, $sel_extras, 0, 'remove')){
			$msg = draw_success_message(_OPERATION_COMMON_COMPLETED, false);
		}else{
			$msg = draw_important_message($objBookings->error, false);
		}
		$mode = 'description';
		$title_action = _BUTTON_UPDATE;
	}
	
	// Start main content
	if($mode == 'invoice'){
		$links .= '<a href="javascript:void(\'invoice|send\')" onclick="if(confirm(\''._PERFORM_OPERATION_COMMON_ALERT.'\')) appGoToPage(\'index.php?admin=mod_booking_bookings\', \'&mg_action=send_invoice&mg_rid='.$rid.'&token='.Application::Get('token').'\', \'post\');"><img src="images/mail.png" alt="" /> '._SEND_INVOICE.'</a> &nbsp;|&nbsp; ';
		$links .= '<a href="javascript:void(\'invoice|download\')" onclick="if(confirm(\''._PERFORM_OPERATION_COMMON_ALERT.'\')) appGoToPage(\'index.php?admin=mod_booking_bookings\', \'&mg_action=download_invoice&mg_rid='.$rid.'&token='.Application::Get('token').'\', \'post\');"><img src="images/pdf.png" alt="" /> '._DOWNLOAD_INVOICE.'</a> &nbsp;|&nbsp; ';
		$links .= '<a href="javascript:void(\'invoice|preview\')" onclick="javascript:appPreview(\'invoice\');"><img src="images/printer.png" alt="" /> '._PRINT.'</a>';
	}else if($mode == 'description'){
		$links .= '<a href="javascript:void(\'description|preview\')" onclick="javascript:appPreview(\'description\');"><img src="images/printer.png" alt="" /> '._PRINT.'</a>';
	}
	draw_title_bar(
		prepare_breadcrumbs(array(_BOOKINGS=>'',_BOOKINGS_MANAGEMENT=>'',_BOOKINGS=>'',ucfirst($title_action)=>'')),
		$links		
	);
    	
	//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	echo $msg;

	draw_content_start();	
	if($mode == 'view'){
		$objBookings->DrawOperationLinks(prepare_permanent_link('javascript:void(\'cleaup\')', '[ '._CLEANUP.' ]', '', '', '', 'onclick="if(confirm(\''._PERFORM_OPERATION_COMMON_ALERT.'\')) appGoToPage(\'index.php?admin=mod_booking_bookings\', \'&mg_action=cleanup_bookings&token='.Application::Get('token').'\', \'post\');"').' <img class="help" src="images/question_mark.png" title="'._CLEANUP_TOOLTIP.'" />');		
		$objBookings->DrawViewMode();
		echo '<script type="text/javascript">
				function __mgMyDoPostBack(tbl, type, key){
					if(confirm("'._ALERT_CANCEL_BOOKING.'")){
						__mgDoPostBack(tbl, type, key);
					}					
				}
			  </script>';
		
		echo '<fieldset class="instructions" style="margin-top:10px;">
				<legend>Legend: </legend>
				<div style="padding:10px;">
					<span style="color:#0000a3">'._PREPARING.'</span> - '._LEGEND_PREPARING.'<br>
					<span style="color:#a3a300">'._RESERVED.'</span> - '._LEGEND_RESERVED.'<br>
					<span style="color:#00a300">'._COMPLETED.'</span> - '._LEGEND_COMPLETED.'<br>
					<span style="color:#660000">'._REFUNDED.'</span> - '._LEGEND_REFUNDED.'<br>
					<span style="color:#a30000">'._PAYMENT_ERROR.'</span> - '._LEGEND_PAYMENT_ERROR.'<br>
					<span style="color:#939393">'._CANCELED.'</span> - '._LEGEND_CANCELED.'<br>
				</div>
			</fieldset>';
		
	}else if($mode == 'add'){		
		$objBookings->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objBookings->DrawEditMode($rid, $operation, $operation_field);		
	}else if($mode == 'details'){		
		$objBookings->DrawDetailsMode($rid);		
	}else if($mode == 'description'){
		echo '<script type="text/javascript">
				function __RemoveExtras(rid, sel_extras){
					if(confirm("'._DELETE_WARNING.'")){
						appGoToPage("index.php?admin=mod_booking_bookings", "&mg_action=remove_extras&mg_rid="+rid+"&sel_extras="+sel_extras+"&token='.Application::Get('token').'", "post");
					}					
				}
			  </script>';
		$objBookings->DrawBookingDescription($rid);		
	}else if($mode == 'invoice'){		
		$objBookings->DrawBookingInvoice($rid);		
	}	

	draw_content_end();	
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>