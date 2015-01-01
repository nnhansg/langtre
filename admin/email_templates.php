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

if($objLogin->IsLoggedInAsAdmin()){	

	$action = MicroGrid::GetParameter('action');
	$rid    = MicroGrid::GetParameter('rid');
	$mode   = 'view';
	$msg    = '';	

	$predefined_tags_text = '
		<fieldset>
		<legend>'._PREDEFINED_CONSTANTS.':</legend>
		<ul>
			<li>{FIRST NAME} - <span class=gray>'._PC_FIRST_NAME_TEXT.'</span></li>
			<li>{LAST NAME} - <span class=gray>'._PC_LAST_NAME_TEXT.'</span></li>
			<li>{USER NAME} - <span class=gray>'._PC_USER_NAME_TEXT.'</span></li>
			<li>{USER PASSWORD} - <span class=gray>'._PC_USER_PASSWORD_TEXT.'</span></li>
			<li>{USER EMAIL} - <span class=gray>'._PC_USER_EMAIL_TEXT.'</span></li>
			<li>{REGISTRATION CODE} - <span class=gray>'._PC_REGISTRATION_CODE_TEXT.'</span></li>
			<li>{BASE URL} - <span class=gray>'._PC_WEB_SITE_BASED_URL_TEXT.'</span></li>
			<li>{WEB SITE} - <span class=gray>'._PC_WEB_SITE_URL_TEXT.'</span></li>
			<li>{HOTEL INFO} - <span class=gray>'._PC_HOTEL_INFO_TEXT.'</span></li>
			<li>{BOOKING NUMBER} - <span class=gray>'._PC_BOOKING_NUMBER_TEXT.'</span></li>
			<li>{BOOKING DETAILS} - <span class=gray>'._PC_BOOKING_DETAILS_TEXT.'</span></li>
			<li>{STATUS DESCRIPTION} - <span class=gray>'._PC_STATUS_DESCRIPTION_TEXT.'</span></li>
			<li>{PERSONAL INFORMATION} - <span class=gray>'._PC_PERSONAL_INFORMATION_TEXT.'</span></li>
			<li>{BILLING INFORMATION} - <span class=gray>'._PC_BILLING_INFORMATION_TEXT.'</span></li>
			<li>{YEAR} - <span class=gray>'._PC_YEAR_TEXT.'</span></li>
			<li>{EVENT} - <span class=gray>'._PC_EVENT_TEXT.'</span></li>
		</ul>
		</fieldset>';

	$predefined_tags_short_text = '
		<fieldset>
		<legend>'._PREDEFINED_CONSTANTS.':</legend>
		<ul>
			<li>{FIRST NAME} - <span class=gray>'._PC_FIRST_NAME_TEXT.'</span></li>
			<li>{LAST NAME} - <span class=gray>'._PC_LAST_NAME_TEXT.'</span></li>
			<li>{USER NAME} - <span class=gray>'._PC_USER_NAME_TEXT.'</span></li>
			<li>{USER EMAIL} - <span class=gray>'._PC_USER_EMAIL_TEXT.'</span></li>
			<li>{BASE URL} - <span class=gray>'._PC_WEB_SITE_BASED_URL_TEXT.'</span></li>
			<li>{WEB SITE} - <span class=gray>'._PC_WEB_SITE_URL_TEXT.'</span></li>
			<li>{YEAR} - <span class=gray>'._PC_YEAR_TEXT.'</span></li>
		</ul>
		</fieldset>';

	$objEmailTemplates = new EmailTemplates();
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objEmailTemplates->AddRecord()){
			$msg = draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objEmailTemplates->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objEmailTemplates->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objEmailTemplates->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objEmailTemplates->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objEmailTemplates->error, false);
		}
		$mode = 'view';
	}else if($action=='details'){		
		$mode = 'details';		
	}else if($action=='cancel_add'){		
		$mode = 'view';		
	}else if($action=='cancel_edit'){				
		$mode = 'view';
	}
	
	// Start main content
	draw_title_bar(prepare_breadcrumbs(array(_MASS_MAIL_AND_TEMPLATES=>'',_EMAIL_TEMPLATES=>'',ucfirst($action)=>'')));

	echo $msg;
	
	draw_content_start();
	if($mode == 'view'){
		$objEmailTemplates->DrawOperationLinks(prepare_permanent_link('index.php?admin=settings&tabid=1_4', '[ '._EMAIL_SETTINGS.' ]'));		
		$objEmailTemplates->DrawViewMode();	
	}else if($mode == 'add'){		
		$objEmailTemplates->DrawAddMode();
		echo $predefined_tags_short_text;
	}else if($mode == 'edit'){		
		$objEmailTemplates->DrawEditMode($rid);		
		$template_record = $objEmailTemplates->GetInfoByID($rid);
		echo (isset($template_record['is_system_template']) && $template_record['is_system_template'] == '1') ? $predefined_tags_text : $predefined_tags_short_text;
	}else if($mode == 'details'){		
		$objEmailTemplates->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>