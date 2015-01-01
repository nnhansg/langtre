<?php

/***
 *	Class Accounts
 *  -------------- 
 *  Description : encapsulates account properties
 *	Written by  : ApPHP
 *	Version     : 1.0.2
 *  Updated	    : 17.05.2012
 *  Usage       : Core Class (excepting MicroBlog)
 *	Differences : no
 *
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *	__construct
 *	__destruct
 *	GetParameter
 *	ChangePassword
 *	ChangeEmail
 *	ChangeLang
 *	SendPassword
 *	SavePersonalInfo
 *
 *	ChangeLog:
 *  1.0.2
 *      -
 *      -
 *      -
 *      -
 *      -
 *  1.0.1
 *  	- added check for unique email for admins on updating
 *  	- changes in send_email()
 *  	- added first/last name for GetParameter()
 *  	- added SavePersonalInfo()
 *  	- added sending "forgotten password" email in a preferred language
 *	
 **/

class Accounts {

	public $account_name;	
	public $error;

	protected $account_id;
	
	private $account_password;
	private $account_email;
	private $first_name;
	private $last_name;
	private $preferred_language;
	private $account_type;
	
	//==========================================================================
    // Class Constructor
	// 		@param $account
	//==========================================================================
	function __construct($account = 0)
	{		
		$this->account_id = $account;
		$this->error      = '';
		
		// Get account information only if the class was created with some valid account_id
		if($this->account_id != '0'){
			$sql = 'SELECT * FROM '.TABLE_ACCOUNTS.' WHERE id = '.(int)$this->account_id;
			$temp = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
			if(is_array($temp)){
				$this->account_email = isset($temp['email']) ? $temp['email'] : '';
				$this->first_name = isset($temp['first_name']) ? $temp['first_name'] : '';
				$this->last_name = isset($temp['last_name']) ? $temp['last_name'] : '';
				$this->account_name = isset($temp['user_name']) ? $temp['user_name'] : '';
				$this->account_password = isset($temp['password']) ? $temp['password'] : '';
				$this->preferred_language = isset($temp['preferred_language']) ? $temp['preferred_language'] : '';
				$this->account_type = isset($temp['account_type']) ? $temp['account_type'] : ''; 
			}			
		}
	}

	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	/***
	 * Get Parameter
	 *		@param $param
	 **/
	public function GetParameter($param = '')
	{
		if($param == 'email'){
			return $this->account_email;
		}else if($param == 'preferred_language'){
			return $this->preferred_language;
		}else if($param == 'account_type'){
			return $this->account_type;
		}else if($param == 'first_name'){
			return $this->first_name;
		}else if($param == 'last_name'){
			return $this->last_name;
		}
		return '';
	}

	/***
	 * Change Password
	 *		@param $password
	 *		@param $confirmation - confirm password
	 **/
	public function ChangePassword($password, $confirmation)
	{
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			return draw_important_message(_OPERATION_BLOCKED, false);
		}
				
		if(!empty($password) && !empty($confirmation) && strlen($password) >= 6) {
			if($password == $confirmation){
				if(!PASSWORDS_ENCRYPTION){
					$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET password = '.quote_text(encode_text($password)).' WHERE id = '.(int)$this->account_id;
				}else{
					if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
						$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET password = AES_ENCRYPT('.quote_text($password).', '.quote_text(PASSWORDS_ENCRYPT_KEY).') WHERE id = '.(int)$this->account_id;
					}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
						$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET password = '.quote_text(md5($password)).' WHERE id = '.(int)$this->account_id;
					}else{
						$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET password = AES_ENCRYPT('.quote_text($password).', '.quote_text(PASSWORDS_ENCRYPT_KEY).') WHERE id = '.(int)$this->account_id;
					}
				}
				if(database_void_query($sql)){
					return draw_success_message(_PASSWORD_CHANGED, false);
				}else{
					return draw_important_message(_PASSWORD_NOT_CHANGED, false);
				}								
			}else return draw_important_message(_PASSWORD_DO_NOT_MATCH, false);
		}else return draw_important_message(_PASSWORD_IS_EMPTY, false);
	}

	/**
	 * Change Email
	 *		@param $email
	 */
	public function ChangeEmail($email)
	{
		global $objLogin;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			return draw_important_message(_OPERATION_BLOCKED, false);
		}
				
		if(!empty($email)){
			if(check_email_address($email)){

				$sql = 'SELECT * FROM '.TABLE_ACCOUNTS.' WHERE email = '.quote_text(mysql_real_escape_string($email)).' AND id != '.(int)$this->account_id;
				$temp = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($temp[1] > 0){
					return draw_important_message(_ADMIN_EMAIL_EXISTS_ALERT, false);
				}			

				$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET email = '.quote_text(encode_text($email)).' WHERE id = '.(int)$this->account_id;
				if(database_void_query($sql)){
					$this->account_email = $email;
					$objLogin->UpdateLoggedEmail($email);
					return draw_success_message(_CHANGES_SAVED, false);
				}else{
					return draw_important_message(_TRY_LATER, false);
				}
			}else return draw_important_message(_EMAIL_IS_WRONG, false);
		}else return draw_important_message(_EMAIL_EMPTY_ALERT, false);
	}

	/**
	 * Change personal info 
	 *		@param $email
	 */
	public function SavePersonalInfo($email, $first_name, $last_name)
	{
		global $objLogin;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			return draw_important_message(_OPERATION_BLOCKED, false);
		}
				
		if(empty($first_name)) return draw_important_message(str_replace('_FIELD_', _FIRST_NAME, _FIELD_CANNOT_BE_EMPTY), false);
		else if(empty($last_name)) return draw_important_message(str_replace('_FIELD_', _LAST_NAME, _FIELD_CANNOT_BE_EMPTY), false);
		else if(!empty($email)){
			if(check_email_address($email)){
				$sql = 'SELECT * FROM '.TABLE_ACCOUNTS.' WHERE email = '.quote_text(mysql_real_escape_string($email)).' AND id != '.(int)$this->account_id;
				$temp = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($temp[1] > 0){
					return draw_important_message(_ADMIN_EMAIL_EXISTS_ALERT, false);
				}
			}else return draw_important_message(_EMAIL_IS_WRONG, false);
		}else return draw_important_message(_EMAIL_EMPTY_ALERT, false);

		$sql = 'UPDATE '.TABLE_ACCOUNTS.'
				SET
					email = '.quote_text(encode_text($email)).',
					first_name = '.quote_text(encode_text($first_name)).',
					last_name = '.quote_text(encode_text($last_name)).'
				WHERE id = '.(int)$this->account_id;
		if(database_void_query($sql)){
			$this->account_email = $email;
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$objLogin->UpdateLoggedEmail($email);			
			return draw_success_message(_CHANGES_SAVED, false);
		}else{
			return draw_important_message(_TRY_LATER, false);
		}
	}

	/**
	 * Change Parameter
	 *		@param $param_val
	 */
	public function ChangeLang($param_val)
	{
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			return draw_important_message(_OPERATION_BLOCKED, false);
		}
		
		global $objLogin;
				
		if(!empty($param_val)){
			$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET preferred_language = '.quote_text(encode_text($param_val)).' WHERE id = '.(int)$this->account_id;
			if(database_void_query($sql)){
				$this->preferred_language = $param_val;
				$objLogin->SetPreferredLang($param_val);
				return draw_success_message(_SETTINGS_SAVED, false);
			}else{
				return draw_important_message(_TRY_LATER, false);
			}
		}else return draw_important_message(str_replace('_FIELD_', _PREFERRED_LANGUAGE, _FIELD_CANNOT_BE_EMPTY), false);
	}

	/**
	 * Send forgotten password
	 *		@param $email
	 */
	public function SendPassword($email)
	{
		global $objSettings;
		
		$lang = Application::Get('lang');
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}
				
		if(!empty($email)) {
			if(check_email_address($email)){   

				if(!PASSWORDS_ENCRYPTION){
					$sql = 'SELECT id, first_name, last_name, user_name, password, preferred_language FROM '.TABLE_ACCOUNTS.' WHERE email = '.quote_text(encode_text($email)).' AND is_active = 1';
				}else{
					if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
						$sql = 'SELECT id, first_name, last_name, user_name, AES_DECRYPT(password, '.quote_text(PASSWORDS_ENCRYPT_KEY).') as password, preferred_language FROM '.TABLE_ACCOUNTS.' WHERE email = '.quote_text(encode_text($email)).' AND is_active = 1';
					}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
						$sql = 'SELECT id, first_name, last_name, user_name, \'\' as password, preferred_language FROM '.TABLE_ACCOUNTS.' WHERE email = '.quote_text($email).' AND is_active = 1';
					}				
				}
				
				$temp = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
				if(is_array($temp) && count($temp) > 0){

					//////////////////////////////////////////////////////////////////
					if(!PASSWORDS_ENCRYPTION){
						$password = $temp['password'];
					}else{
						if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
							$password = $temp['password'];
						}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
							$password = get_random_string(8);
							$sql = 'UPDATE '.TABLE_ACCOUNTS.' SET password = '.quote_text(md5($password)).' WHERE id = '.(int)$temp['id'];
							database_void_query($sql);
						}				
					}
					
					send_email(
						$email,
						$objSettings->GetParameter('admin_email'),
						'password_forgotten',
						array(
							'{FIRST NAME}'    => $temp['first_name'],
							'{LAST NAME}'     => $temp['last_name'],
							'{USER NAME}'     => $temp['user_name'],
							'{USER PASSWORD}' => $password,
							'{BASE URL}'      => APPHP_BASE,
							'{WEB SITE}'      => $_SERVER['SERVER_NAME'],
							'{YEAR}'       	  => date('Y')
						),
						$temp['preferred_language']
					);
					//////////////////////////////////////////////////////////////////
					
					return true;					
				}else{
					$this->error = _EMAIL_NOT_EXISTS;
					return false;
				}				
			}else{
				$this->error = _EMAIL_IS_WRONG;
				return false;								
			}
		}else{
			$this->error = _EMAIL_EMPTY_ALERT;
			return false;
		}
		return true;
	}
	
}
?>