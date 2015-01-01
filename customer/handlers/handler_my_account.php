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

if(!$objLogin->IsLoggedInAsCustomer()){
	$objSession->SetMessage('notice', _MUST_BE_LOGGED);
	header('location: index.php?customer=login');
	exit;
}else{
	$task 		 = isset($_POST['task']) ? prepare_input($_POST['task']) : '';
	$send_updates = isset($_POST['send_updates']) ? (int)$_POST['send_updates'] : '0';
	$first_name  = isset($_POST['first_name']) ? prepare_input($_POST['first_name']) : '';
	$last_name   = isset($_POST['last_name']) ? prepare_input($_POST['last_name']) : '';

	$birth_date_year = isset($_POST['birth_date__nc_year']) ? prepare_input($_POST['birth_date__nc_year']) : '';
	$birth_date_month = isset($_POST['birth_date__nc_month']) ? prepare_input($_POST['birth_date__nc_month']) : '';
	$birth_date_day = isset($_POST['birth_date__nc_day']) ? prepare_input($_POST['birth_date__nc_day']) : '';
	$birth_date = $birth_date_year.'-'.$birth_date_month.'-'.$birth_date_day;
	if($birth_date == '--') $birth_date = '';

	$company     = isset($_POST['company']) ? prepare_input($_POST['company']) : '';
	$b_address   = isset($_POST['b_address']) ? prepare_input($_POST['b_address']) : '';
	$b_address_2 = isset($_POST['b_address_2']) ? prepare_input($_POST['b_address_2']) : '';
	$b_city      = isset($_POST['b_city']) ? prepare_input($_POST['b_city']) : '';
	$b_zipcode   = isset($_POST['b_zipcode']) ? prepare_input($_POST['b_zipcode']) : '';
	$b_country   = isset($_POST['b_country']) ? prepare_input($_POST['b_country']) : '';
	$b_state     = isset($_POST['b_state']) ? prepare_input($_POST['b_state']) : '';
	$phone       = isset($_POST['phone']) ? prepare_input($_POST['phone']) : '';
	$fax         = isset($_POST['fax']) ? prepare_input($_POST['fax']) : '';
	$email       = isset($_POST['email']) ? prepare_input($_POST['email']) : '';
	$url         = isset($_POST['url']) ? prepare_input($_POST['url'], false, 'medium') : '';
	$selLanguages = isset($_POST['selLanguages']) ? prepare_input($_POST['selLanguages']) : '';

	$user_password1 = isset($_POST['user_password1']) ? prepare_input($_POST['user_password1']) : '';
	$user_password2 = isset($_POST['user_password2']) ? prepare_input($_POST['user_password2']) : '';
	$user_password  = '';
	$agree       = isset($_POST['agree']) ? (int)$_POST['agree'] : '';	
	$focus_field = 'first_name';

	$msg_default = '';
	$msg = '';

	if($task == 'update'){
		
		if($first_name == ''){
			$msg = draw_important_message(_FIRST_NAME_EMPTY_ALERT, false);
		}else if($last_name == ''){
			$msg = draw_important_message(_LAST_NAME_EMPTY_ALERT, false);
		}else if($birth_date != '' && !check_date($birth_date)){
			$msg = draw_important_message(_BIRTH_DATE_VALID_ALERT, false);
		}else if($b_address == ''){
			$msg = draw_important_message(_ADDRESS_EMPTY_ALERT, false);
		}else if($b_city == ''){
			$msg = draw_important_message(_CITY_EMPTY_ALERT, false);
		}else if($b_zipcode == ''){
			$msg = draw_important_message(_ZIPCODE_EMPTY_ALERT, false);
		}else if($b_country == ''){
			$msg = draw_important_message(_COUNTRY_EMPTY_ALERT, false);
		}else if($phone == ''){
			$msg = draw_important_message(_PHONE_EMPTY_ALERT, false);
		}else if($email == ''){
			$msg = draw_important_message(_EMAIL_EMPTY_ALERT, false);
			$focus_field = 'email';
		}else if(($email != '') && (!check_email_address($email))){
			$msg = draw_important_message(_EMAIL_VALID_ALERT, false);
			$focus_field = 'email';
		}else if(($user_password1 != '') && (strlen($user_password1) < 6)){
			$msg = draw_important_message(_PASSWORD_IS_EMPTY, false);
			$user_password1 = $user_password2 = '';
			$focus_field = 'user_password1';
		}else if(($user_password1 == '') && ($user_password2 != '')){
			$msg = draw_important_message(_PASSWORD_IS_EMPTY, false);
			$user_password1 = $user_password2 = '';
			$focus_field = 'user_password';
		}else if(($user_password1 != '') && ($user_password2 == '')){
			$msg = draw_important_message(_CONF_PASSWORD_IS_EMPTY, false);
			$user_password1 = $user_password2 = '';
			$focus_field = 'user_password1';
		}else if(($user_password1 != '') && ($user_password2 != '') && ($user_password1 != $user_password2)){
			$msg = draw_important_message(_CONF_PASSWORD_MATCH, false);
			$user_password1 = $user_password2 = '';
			$focus_field = 'user_password1';
		}else{
			if(!PASSWORDS_ENCRYPTION){
				$user_password = 'user_password=\''.$user_password1.'\'';
			}else{
				if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){					
					$user_password = 'user_password=AES_ENCRYPT(\''.$user_password1.'\', \''.PASSWORDS_ENCRYPT_KEY.'\')';
				}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
					$user_password = 'user_password=MD5(\''.$user_password1.'\')';
				}
			}			
		}
		
		// check if email already exists                    
		$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE email = \''.mysql_real_escape_string($email).'\' AND id != '.(int)$objLogin->GetLoggedID();
		$result = database_query($sql, DATA_AND_ROWS);
		if($result[1] > 0){
			$msg = draw_important_message(_USER_EMAIL_EXISTS_ALERT, false);
		}			
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			$msg = draw_important_message(_OPERATION_BLOCKED, false);
		}		
		
		if($msg == ''){			
			// insert new user
			$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET
						first_name  = \''.encode_text($first_name).'\',
						last_name   = \''.encode_text($last_name).'\',
						birth_date  = \''.(($birth_date != '') ? encode_text($birth_date) : '0000-00-00').'\',
						company     = \''.encode_text($company).'\',
						b_address   = \''.encode_text($b_address).'\',
						b_address_2 = \''.encode_text($b_address_2).'\',
						b_city      = \''.encode_text($b_city).'\',
						b_zipcode   = \''.encode_text($b_zipcode).'\',
						b_country   = \''.encode_text($b_country).'\',
						b_state     = \''.encode_text($b_state).'\',
						phone       = \''.encode_text($phone).'\',
						fax         = \''.encode_text($fax).'\',
						email       = \''.encode_text($email).'\',
						url         = \''.encode_text($url).'\',						
						'.((($user_password1 != '') && ($user_password2 != '')) ? $user_password.',' : '').'
						preferred_language = \''.$selLanguages.'\',
						notification_status_changed = IF(email_notifications <> \''.(int)$send_updates.'\', \''.date('Y-m-d H:i:s').'\', notification_status_changed),
						email_notifications = '.(int)$send_updates.'
					WHERE id = '.(int)$objLogin->GetLoggedID();
					
			if(database_void_query($sql) > 0){
				$objLogin->UpdateLoggedEmail($email);
				$objLogin->UpdateLoggedFirstName(encode_text($first_name));
				$objLogin->UpdateLoggedLastName(encode_text($last_name));
				$msg = draw_success_message(_ACCOUNT_WAS_UPDATED, false);
			}else{
				$msg = draw_important_message(_UPDATING_ACCOUNT_ERROR, false);
			}                    		
		}		
	}

	$objCustomers = new Customers();
	$customer_info = $objCustomers->GetInfoByID($objLogin->GetLoggedID());

	$total_groups = CustomerGroups::GetAllGroups();
	$arr_groups = array();
	foreach($total_groups[0] as $key => $val){
		$arr_groups[$val['id']] = $val['name'];
	}
	
}
?>