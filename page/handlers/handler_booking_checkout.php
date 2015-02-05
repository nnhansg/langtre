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
		//======================================================================================
		// Add new booking to cart
		$room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : '0';
		$from_date = isset($_POST['from_date']) ? prepare_input($_POST['from_date']) : '';
		$to_date = isset($_POST['to_date']) ? prepare_input($_POST['to_date']) : '';
		$nights  = isset($_POST['nights']) ? (int)$_POST['nights'] : '';
		$rooms_quantity = isset($_POST['rooms_quantity']) ? (int)$_POST['rooms_quantity'] : '0';
		$room_price = isset($_POST['room_price']) ? (float)$_POST['room_price'] : '0';
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
			// $objReservation->AddToReservation($room_id, $from_date, $to_date, $nights, $rooms, $price, $adults, $children, $meal_plan_id, $hotel_id, $guests, $guest_fee);
			$objReservation->AddToReservation($room_id, $from_date, $to_date, $nights, $rooms_quantity, $rooms_quantity * $room_price, $adults, $children, $meal_plan_id, $hotel_id, $guests, $guest_fee);
		}

		//======================================================================================
		// booking details
		$m = isset($_REQUEST['m']) ? prepare_input($_REQUEST['m']) : '';
		$act = isset($_POST['act']) ? prepare_input($_POST['act']) : '';
		
		if(!$objLogin->IsLoggedIn()){
			$current_customer_id = (int)Session::Get('current_customer_id'); 
		}else{
			$current_customer_id = $objLogin->GetLoggedID();
		}
		
		$objReservation = new Reservation(); 
		//--------------------------------------------------------------------------
		// *** redirect if reservation cart is empty
		if($objReservation->IsCartEmpty()){
			header('location: index.php?page=booking');
			echo '<p>if your browser doesn\'t support redirection please click <a href="index.php?page=booking">here</a>.</p>';        
			exit;		
		}

		$allow_booking_without_account = ModulesSettings::Get('booking', 'allow_booking_without_account');
		$image_verification_allow = ModulesSettings::Get('customers', 'image_verification_allow');
		
		include_once('modules/captcha/securimage.php');
		$objImg = new Securimage();
		
		$send_updates = isset($_POST['send_updates']) ? (int)$_POST['send_updates'] : '1';
		$first_name  = isset($_POST['first_name']) ? prepare_input($_POST['first_name']) : '';
		$last_name   = isset($_POST['last_name']) ? prepare_input($_POST['last_name']) : '';
		
		$birth_date_year = isset($_POST['birth_date__nc_year']) ? prepare_input($_POST['birth_date__nc_year']) : '';
		$birth_date_month = isset($_POST['birth_date__nc_month']) ? prepare_input($_POST['birth_date__nc_month']) : '';
		$birth_date_day = isset($_POST['birth_date__nc_day']) ? prepare_input($_POST['birth_date__nc_day']) : '';
		$birth_date = $birth_date_year.'-'.$birth_date_month.'-'.$birth_date_day;
		if($birth_date == '--') $birth_date = '0000-00-00';
		
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
		$user_name   = isset($_POST['user_name']) ? prepare_input($_POST['user_name']) : '';
		$user_password1 = isset($_POST['user_password1']) ? prepare_input($_POST['user_password1']) : '';
		$user_password2 = isset($_POST['user_password2']) ? prepare_input($_POST['user_password2']) : '';
		$agree       = isset($_POST['agree']) ? (int)$_POST['agree'] : '';	
		$captcha_code = isset($_POST['captcha_code']) ? prepare_input($_POST['captcha_code']) : '';
		$focus_field  = 'first_name';
		
		$msg_default = draw_message(_ACCOUNT_CREATE_MSG, false);
		$msg = '';
		
		$account_created = false;
		
		if($act == 'create' || $act == 'update')
		{
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
			}else{
				if($allow_booking_without_account == 'no' && $m != 'edit'){
					if($user_name == ''){
						$msg = draw_important_message(_USERNAME_EMPTY_ALERT, false);
						$focus_field = 'user_name';
					}else if(($user_name != '') && (strlen($user_name) < 6)){
						$msg = draw_important_message(_USERNAME_LENGTH_ALERT, false);
						$focus_field = 'user_name';
					}else if($user_password1 == ''){
						$msg = draw_important_message(_PASSWORD_IS_EMPTY, false);					
						$user_password1 = $user_password2 = '';
						$focus_field = 'user_password1';
					}else if(($user_password1 != '') && (strlen($user_password1) < 6)){
						$msg = draw_important_message(_PASSWORD_IS_EMPTY, false);
						$user_password1 = $user_password2 = '';
						$focus_field = 'user_password1';
					}else if(($user_password1 != '') && ($user_password2 == '')){
						$msg = draw_important_message(_CONF_PASSWORD_IS_EMPTY, false);
						$user_password1 = $user_password2 = '';
						$focus_field = 'user_password2';
					}else if(($user_password1 != '') && ($user_password2 != '') && ($user_password1 != $user_password2)){
						$msg = draw_important_message(_CONF_PASSWORD_MATCH, false);
						$user_password1 = $user_password2 = '';
						$focus_field = 'user_password2';
					}				
				}			
				if($msg == '' && $m != 'edit'){
					if($agree == ''){
						$msg = draw_important_message(_CONFIRM_TERMS_CONDITIONS, false);
					}else if($image_verification_allow == 'yes' && !$objImg->check($captcha_code)){				
						$msg = draw_important_message(_WRONG_CODE_ALERT, false);
						$focus_field = 'captcha_code';
					}
				}
			}		
		}
		
		if($act == 'create'){ 
			if($allow_booking_without_account == 'no'){
				if($msg == ''){
					// check if email already exists                    
					$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\'';
					$result = database_query($sql, DATA_AND_ROWS);
					if($result[1] > 0){
						$msg = draw_important_message(_USER_EMAIL_EXISTS_ALERT, false);
					}			
				}
		
				if($msg == ''){
					// check if such user already exists                    
					$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE user_name != \'\' AND user_name = \''.$user_name.'\'';
					$result = database_query($sql, DATA_AND_ROWS);
					if($result[1] > 0){
						$msg = draw_important_message(_USER_EXISTS_ALERT, false);
					}
				}			
			}else{
				if($msg == ''){
					// check if such user already exists
					$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\' AND user_name != \'\'';
					$result = database_query($sql, DATA_AND_ROWS);
					if($result[1] > 0){
						$msg = draw_important_message(_USER_EMAIL_EXISTS_ALERT, false);
					}			
				}
			}
		
			// deny all operations in demo version
			if(strtolower(SITE_MODE) == 'demo'){
				$msg = draw_important_message(_OPERATION_BLOCKED, false);
			}
			
			if($msg == ''){			
				$user_ip = get_current_ip();
				
				$registration_code = '';
		
				if($allow_booking_without_account == 'yes'){
					$user_password = '\'\'';
				}else{
					if(!PASSWORDS_ENCRYPTION){
						$user_password = '\''.$user_password1.'\'';
					}else{
						if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){					
							$user_password = 'AES_ENCRYPT(\''.$user_password1.'\', \''.PASSWORDS_ENCRYPT_KEY.'\')';
						}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
							$user_password = 'MD5(\''.$user_password1.'\')';
						}				
					}
				}
			
				// insert new user
				$sql = 'INSERT INTO '.TABLE_CUSTOMERS.'(
							first_name,
							last_name,
							birth_date,
							company,
							b_address,
							b_address_2,
							b_city,
							b_zipcode,
							b_country,
							b_state,
							phone,						
							fax,
							email,
							url,
							user_name,
							user_password,
							preferred_language,
							date_created,
							registered_from_ip,
							last_logged_ip,
							email_notifications,
							comments,
							is_active,
							is_removed,
							registration_code)
						VALUES(
							\''.$first_name.'\',
							\''.$last_name.'\',
							\''.$birth_date.'\',
							\''.$company.'\',
							\''.$b_address.'\',
							\''.$b_address_2.'\',
							\''.$b_city.'\',
							\''.$b_zipcode.'\',
							\''.$b_country.'\',
							\''.$b_state.'\',
							\''.$phone.'\',
							\''.$fax.'\',
							\''.$email.'\',
							\''.$url.'\',
							\''.$user_name.'\',
							'.$user_password.',
							\''.Application::Get('lang').'\',
							\''.date('Y-m-d H:i:s').'\',
							\''.$user_ip.'\',
							\'\',
							\''.$send_updates.'\',
							\'\',
							1,
							0,
							\''.$registration_code.'\') 
						ON DUPLICATE KEY UPDATE
							first_name  = VALUES(first_name),
							last_name   = VALUES(last_name),
							company     = VALUES(company),
							b_address   = VALUES(b_address),
							b_address_2 = VALUES(b_address_2),
							b_city      = VALUES(b_city),
							b_zipcode   = VALUES(b_zipcode),
							b_country   = VALUES(b_country),
							b_state     = VALUES(b_state),
							phone       = VALUES(phone),
							fax         = VALUES(fax),
							email       = VALUES(email),
							url         = VALUES(url),
							last_logged_ip = VALUES(last_logged_ip),
							email_notifications = VALUES(email_notifications),
							notification_status_changed = \''.date('Y-m-d H:i:s').'\'';
				if(database_void_query($sql) > 0){
					$account_created = true;
					Session::Set('current_customer_id', mysql_insert_id());
					
					if($allow_booking_without_account == 'yes'){
						$email_template = 'new_account_created_without';
					}else{
						$email_template = 'new_account_created';
					}
					/////////////////////////////////////////////////////////////
					send_email(
						$email,
						$objSettings->GetParameter('admin_email'),
						'new_account_created',
						array(
							'{FIRST NAME}'    => $first_name,
							'{LAST NAME}'     => $last_name,
							'{USER NAME}'     => $user_name,
							'{USER PASSWORD}' => $user_password1,
							'{WEB SITE}'      => $_SERVER['SERVER_NAME'],
							'{REGISTRATION CODE}' => '',
							'{BASE URL}'      => APPHP_BASE,
							'{YEAR}' 	      => date('Y')
						)
					);
					/////////////////////////////////////////////////////////////
					
					header('location: index.php?page=booking_checkout&m=edit&mbkco=1');
					exit;		
				}else{
					$msg = draw_important_message(_CREATING_ACCOUNT_ERROR, false);
				}                    		
			}		
		}else if($act == 'update'){
		
			// check if email already exists                    
			$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\' AND id != '.$current_customer_id;
			// $result = database_query($sql, DATA_ONLY);
			// if($result[0]['cnt'] > 0){
			// 	$msg = draw_important_message(_USER_EMAIL_EXISTS_ALERT, false);
			// }			
			
			// deny all operations in demo version
			if(strtolower(SITE_MODE) == 'demo'){
				$msg = draw_important_message(_OPERATION_BLOCKED, false);
			}				
		
			if($msg == ''){			
				// insert new user
				$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET
							first_name = \''.$first_name.'\',
							last_name = \''.$last_name.'\',
							company = \''.$company.'\',
							b_address = \''.$b_address.'\',
							b_address_2 = \''.$b_address_2.'\',
							b_city = \''.$b_city.'\',
							b_state = \''.$b_state.'\',
							b_country = \''.$b_country.'\',
							b_zipcode = \''.$b_zipcode.'\',
							phone = \''.$phone.'\',
							fax = \''.$fax.'\',
							email = \''.$email.'\',
							url = \''.$url.'\'
						WHERE id = '.$current_customer_id;
				if(database_void_query($sql) > 0){		
					$account_created = true;
					header('location: index.php?page=booking_checkout&m=edit&mbkco=2');
					exit;		
				}else{
					$msg = draw_important_message(_UPDATING_ACCOUNT_ERROR, false);
				}
			}
		}
		
		
		if($current_customer_id != '' && $m == 'edit'){		
			$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE id = '.(int)$current_customer_id;
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] > 0){
				$send_updates = $result[0]['email_notifications'];
				$first_name  = $result[0]['first_name'];
				$last_name   = $result[0]['last_name'];
				$birth_date  = $result[0]['birth_date'];
				$company     = $result[0]['company'];
				$b_address   = $result[0]['b_address'];
				$b_address_2 = $result[0]['b_address_2'];
				$b_city      = $result[0]['b_city'];
				$b_zipcode   = $result[0]['b_zipcode'];
				$b_country   = $result[0]['b_country'];
				$b_state     = $result[0]['b_state'];
				$phone       = $result[0]['phone'];
				$fax         = $result[0]['fax'];
				$email       = $result[0]['email'];
				$url         = $result[0]['url'];
				$user_name   = $result[0]['user_name'];
				$user_password1 = $result[0]['user_password'];
				$user_password2 = $result[0]['user_password'];
			}
		}

		//======================================
		// booking checkout
		$objReservation = new Reservation();
		//--------------------------------------------------------------------------
		// *** redirect if reservation cart is empty
		if($objReservation->IsCartEmpty()){
			header('location: index.php?page=booking');
			echo '<p>if your browser doesn\'t support redirection please click <a href="index.php?page=booking">here</a>.</p>';        
			exit;		
		}
	}
}

?>