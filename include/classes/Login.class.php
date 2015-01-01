<?php

/**
 *	Class Login (for Hotel Site ONLY)
 *  -------------- 
 *  Description : encapsulates login properties
 *  Updated     : 16.09.2012
 *	Written by  : ApPHP
 *	
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *  __construct                                     DoLogin
 *  __destruct                                      UpdateAccountInfo 
 *  IsWrongLogin                                    GetAccountInformation
 *  IsIpAddressBlocked                              SetSessionVariables
 *  IsEmailBlocked                                  GetUniqueUrl
 *  DoLogout                                        PrepareLink 
 *  GetLastLoginTime                                Encrypt
 *  IsLoggedIn                                      Decrypt
 *  IsLoggedInAs                                    
 *  IsLoggedInAsAdmin
 *  IsLoggedInAsCustomer
 *  GetLoggedType
 *  GetLoggedEmail
 *  GetLoggedGroupID
 *  UpdateLoggedEmail
 *  GetLoggedName
 *  GetLoggedFirstName
 *  GetLoggedLastName
 *  UpdateLoggedFirstName
 *  UpdateLoggedLastName
 *  GetLoggedID
 *  GetPreferredLang
 *  SetPreferredLang
 *  GetActiveMenuCount
 *  DrawLoginLinks
 *  IpAddressBlocked
 *  EmailBlocked
 *  RemoveAccount
 *  GetLoginError
 *  HasPrivileges
 *  
 **/

class Login {

	private $wrongLogin;
	private $ipAddressBlocked;
	private $emailBlocked;
	private $activeMenuCount;
	private $accountType;
	private $loginError;

	private $cookieName;
	private $cookieTime;
	private $passwordKey = 'phphs_customer_area';
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		$this->ipAddressBlocked = false;
		$this->emailBlocked = false;
		$this->loginError = '';

		$this->cookieName = 'site_auth'.INSTALLATION_KEY;
		$this->cookieTime = (3600 * 24 * 14); // 14 days

		$submit_login  = isset($_POST['submit_login']) ? prepare_input($_POST['submit_login']) : '';
		$submit_logout = isset($_POST['submit_logout']) ? prepare_input($_POST['submit_logout']) : '';
		$user_name 	   = isset($_POST['user_name']) ? prepare_input($_POST['user_name'], true) : '';
		$password      = isset($_POST['password']) ? prepare_input($_POST['password'], true) : '';
		$this->accountType = isset($_POST['type']) ? prepare_input($_POST['type']) : 'customer';
		$remember_me   = isset($_POST['remember_me']) ? prepare_input($_POST['remember_me']) : '';
		
		$this->wrongLogin = false;		
		if(!$this->IsLoggedIn()){
			if($submit_login == 'login'){
				if(empty($user_name) || empty($password)){
					if(isset($_POST['user_name']) && empty($user_name)){
						$this->loginError = '_USERNAME_EMPTY_ALERT';						
					}else if(isset($_POST['password']) && empty($password)){
						$this->loginError = '_WRONG_LOGIN';
					}
					$this->wrongLogin = true;							
				}else{
					$this->DoLogin($user_name, $password, $remember_me);
				}
			}else{
				if(isset($_COOKIE[$this->cookieName])){
					parse_str($_COOKIE[$this->cookieName]);
					if(!empty($usr) && !empty($hash)){
						$user_name = $usr;
						$password = $this->Decrypt($hash, $this->passwordKey);					
						$this->DoLogin($user_name, $password, '2');
					}
				}				
			}
		}else if($submit_logout == 'logout'){
			$this->DoLogout();
		}
		$this->activeMenuCount = 0;
	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	/**
	 * 	Do login
	 * 		@param $user_name - system name of user
	 * 		@param $password - password of user
	 * 		@param $remember_me
	 * 		@param $do_redirect - prepare redirect or not
	 */
	private function DoLogin($user_name, $password, $remember_me = '', $do_redirect = true)
	{
		$ip_address = get_current_ip();

		if($account_information = $this->GetAccountInformation($user_name, $password)){
			
			if($account_information['is_active'] == '0'){
				if($account_information['registration_code'] != ''){
					$this->loginError = '_REGISTRATION_NOT_COMPLETED';	
				}else{
					$this->loginError = '_WRONG_LOGIN';
				}				
				$this->wrongLogin = true;
				return false;
			}
			
			ob_start();
			$this->SetSessionVariables($account_information);

			if($this->IsLoggedInAsCustomer(false)){
				if($this->IpAddressBlocked($ip_address)){
					$this->DoLogout();
					$this->ipAddressBlocked = true;
					$do_redirect = false;
				}else if($this->EmailBlocked($this->GetLoggedEmail(false))){
					$this->DoLogout();
					$this->emailBlocked = true;
					$do_redirect = false;			
				}
			}

			$this->UpdateAccountInfo($account_information);
			if($do_redirect){
				$GLOBALS['objSession']->SetFingerInfo();

				if($remember_me == '2'){
					// ignore and do nothing - allow cookies to expire in $this->cookieTime sec.
				}else if($remember_me == '1'){
					$password_hash = $this->Encrypt($password, $this->passwordKey);
					setcookie($this->cookieName, 'usr='.$user_name.'&hash='.$password_hash, time() + $this->cookieTime);
				}else{
					setcookie($this->cookieName, '', time() - 3600);
				}

				$redirect_page = 'index.php';
				if($this->IsLoggedInAsCustomer()){
					$redirect_page  = (Session::Get('last_visited') != '') ? Session::Get('last_visited') : 'index.php?customer=home';
					$redirect_page .= (preg_match('/\?/', $redirect_page) ? '&' : '?').'lang='.$this->GetPreferredLang();
				}
				header('location: '.$redirect_page);
				ob_end_flush();
				exit;
			}
		}else{
			$this->loginError = '_WRONG_LOGIN';
			$this->wrongLogin = true;
		}
	}
	
	/**
	 * 	Checks if login was wrong
	 */
	public function IsWrongLogin()
	{
		return ($this->wrongLogin == true) ? true : false;	
	}

	/**
	 * 	Checks if IP address was blocked
	 */
	public function IsIpAddressBlocked()
	{
		return ($this->ipAddressBlocked == true) ? true : false;	
	}

	/**
	 * 	Checks if IP address was blocked
	 * 	
	 */
	public function IsEmailBlocked()
	{
		return ($this->emailBlocked == true) ? true : false;	
	}

	/**
	 * 	Destroys the session and returns to the default page
	 */
	public function DoLogout()
	{
		$redirect = ($this->IsLoggedInAsAdmin()) ? 'index.php?admin=login' : '';
		$GLOBALS['objSession']->EndSession();
		setcookie($this->cookieName, '', time() - 3600);
		
		if($redirect != ''){
			header('location: '.$redirect);
			exit;			
		}
	}

	/**
	 * 	Checks Ip Address
	 * 		@param $ip_address
	 */
	public function IpAddressBlocked($ip_address)
	{
		$sql = 'SELECT ban_item
				FROM '.TABLE_BANLIST.'
				WHERE ban_item = \''.$ip_address.'\' AND ban_item_type = \'IP\'';
		return database_query($sql, ROWS_ONLY);		
	}

	/**
	 * 	Checks Email Address
	 * 		@param $email
	 */
	public function EmailBlocked($email)
	{
		$sql = 'SELECT ban_item
				FROM '.TABLE_BANLIST.'
				WHERE ban_item = \''.$email.'\' AND ban_item_type = \'Email\'';
		return database_query($sql, ROWS_ONLY);		
	}

	/**
	 * 	Returns the account information
	 * 		@param $user_name - system name of user
	 * 		@param $password - password of user
	 */
	private function GetAccountInformation($user_name, $password)
	{
		if(PASSWORDS_ENCRYPTION){			
			if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
				$password = 'AES_ENCRYPT(\''.$password.'\', \''.PASSWORDS_ENCRYPT_KEY.'\')';
			}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
				$password = 'MD5(\''.$password.'\')';
			}	
		}else{
			$password = '\''.$password.'\'';
		}
		if($this->accountType == 'admin'){
			$sql = 'SELECT '.TABLE_ACCOUNTS.'.*, user_name AS account_name
					FROM '.TABLE_ACCOUNTS.'
					WHERE
						user_name = \''.$user_name.'\' AND 
						password = '.$password;			
		}else{
			$sql = 'SELECT '.TABLE_CUSTOMERS.'.*, user_name AS account_name
					FROM '.TABLE_CUSTOMERS.'
					WHERE
						user_name = \''.$user_name.'\' AND 
						user_password = '.$password.' AND
						is_removed = 0';
		}
		///$sql .= ' AND is_active = 1';
		return database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
	}

	/**
	 * 	Checks if the user is logged in
	 */
	public function IsLoggedIn()
	{
		$logged = Session::Get('session_account_logged');
		$id = Session::Get('session_account_id');
	    if($logged == str_replace(array('modules/wysiwyg/addons/imagelibrary/', 'ajax/'), '', $this->GetUniqueUrl()).$id){
			if(!$GLOBALS['objSession']->AnalyseFingerInfo()){
				return false;
			}
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 	Returns last login time
	 */
	public function GetLastLoginTime()
	{
		$last_login = Session::Get('session_last_login');

		if($last_login != '' && $last_login != '0000-00-00 00:00:00' && $last_login != 'NULL'){
			return $last_login;
		}else{
			return '--';
		}
	}

	/**
	 * 	Checks if the user is logged in as a specific account type
	 * 		@return true if the user is logged in as specified account type, false otherwise
	 */
	public function IsLoggedInAs()
	{
		if(!$this->IsLoggedIn()) return false;

		$account_type = Session::Get('session_account_type');

		$types = func_get_args();
		foreach($types as $type){
			$type_parts = explode(',', $type);
			foreach($type_parts as $type_part){
				if($account_type == $type_part) return true;	
			}			
		}
		return false;
	}

	/**
	 * 	Checks if the user is logged in as a Admin
	 * 		@return true if the user is logged in as specified account type false otherwise
	 */
	public function IsLoggedInAsAdmin()
	{
		if (!$this->IsLoggedIn()) return false;
		$account_type = Session::Get('session_account_type');
		
		// NTDT - NhanNKH Edited
		if ($account_type == 'owner' 
			|| $account_type == 'mainadmin' 
			|| $account_type == 'admin' 
			|| $account_type == 'hotelowner'
			|| $account_type == 'accounthotelmanageme'
			|| $account_type == 'hotelmanagement'
			|| $account_type == 'booking') 
			return true;

		return false;
	}

	/**
	 * 	Checks to see if the customer is logged in as a specific account type
	 * 		@param $check
	 */
	public function IsLoggedInAsCustomer($check = true)
	{
		if(!$this->IsLoggedIn() && $check) return false;
		$account_type = Session::Get('session_account_type');
		if($account_type == 'customer') return true;
		return false;
	}
	
	/**
	 * 	Returns logged user type
	 */
	public function GetLoggedType()
	{
		if(!$this->IsLoggedIn()) return false;				
		return Session::Get('session_account_type');
	}

	/**
	 * 	Returns logged user email
	 */
	public function GetLoggedEmail($check = true)
	{
		if(!$this->IsLoggedIn() && $check) return false;
		return Session::Get('session_user_email');
	}

	/**
	 * 	Returns logged user group ID
	 */
	public function GetLoggedGroupID()
	{
		return ($this->IsLoggedIn()) ? Session::Get('session_account_group_id') : '0';
	}

	/**
	 * 	Sets the email of logged user 
	 */
	public function UpdateLoggedEmail($new_email)
	{
		if(!$this->IsLoggedIn()) return false;
		Session::Set('session_user_email', $new_email);
	}

	/**
	 * 	Returns logged user name
	 */
	public function GetLoggedName()
	{
		return Session::Get('session_user_name');
	}
	
	/**
	 * 	Returns the first name of logged user 
	 */
	public function GetLoggedFirstName()
	{
		return Session::Get('session_user_first_name');
	}
	
	/**
	 * 	Returns the last name of logged user 
	 */
	public function GetLoggedLastName()
	{
		return Session::Get('session_user_last_name');
	}

	/**
	 * 	Update first name of logged user 
	 */
	public function UpdateLoggedFirstName($first_name)
	{
		return Session::Set('session_user_first_name', $first_name);
	}

	/**
	 * 	Update last name of logged user 
	 */
	public function UpdateLoggedLastName($last_name)
	{
		return Session::Set('session_user_last_name', $last_name);
	}

	/**
	 * 	Returns logged user ID
	 */
	public function GetLoggedID()
	{
		return Session::Get('session_account_id');
	}	

	/**
	 * 	Returns preferred language
	 */
	public function GetPreferredLang()
	{
		return Session::Get('session_preferred_language');
	}	

	/**
	 * 	Sets preferred language
	 * 		@param $lang
	 */
	public function SetPreferredLang($lang)
	{
		Session::Set('session_preferred_language', $lang);
	}	

	/**
	 * 	Sets the session variables and performs the login
	 * 		@param $account_information - array
	 */
	private function SetSessionVariables($account_information)
	{		
		Session::Set('session_account_logged', (($account_information['id']) ? $this->GetUniqueUrl().$account_information['id'] : false));			
		Session::Set('session_account_id', $account_information['id']);
		Session::Set('session_user_name', $account_information['user_name']);
		Session::Set('session_user_first_name', $account_information['first_name']);
		Session::Set('session_user_last_name', $account_information['last_name']);		
		Session::Set('session_user_email', $account_information['email']);
		Session::Set('session_account_type', (($this->accountType == 'admin') ? $account_information['account_type'] : 'customer'));
		Session::Set('session_account_group_id', (($this->accountType == 'admin') ? '0' : $account_information['group_id']));
		Session::Set('session_last_login', $account_information['date_lastlogin']);

		// check if predefined lang still exists, if not set default language		
		if(isset($account_information['preferred_language']) && Languages::LanguageActive($account_information['preferred_language'])){
			$preferred_language = $account_information['preferred_language'];
		}else{
			$preferred_language = Languages::GetDefaultLang();
		}
		Session::Set('session_preferred_language', $preferred_language);

		// prepare role privileges
		$result = Roles::GetPrivileges(Session::Get('session_account_type'));
		$privileges_info = array();
		for($i = 0; $i < $result[1]; $i++){
			$privileges_info[$result[0][$i]['code']] = ($result[0][$i]['is_active'] == '1') ? true : false;
		}
		
		$hotels = @unserialize($account_information['hotels']);
		if(is_array($hotels)){
			$privileges_info['hotel_ids'] = array();
			foreach($hotels as $key => $val){
				$privileges_info['hotel_ids'][] = $val;
			}
		}
		
		Session::Set('session_user_privileges', $privileges_info);

		// clean some session variables
		Session::Set('preview', '');
	}

	/**
	 *  Returns unique URL 
	 */
	private function GetUniqueUrl()
	{
		$port = '';
		$http_host = $_SERVER['HTTP_HOST'];
		if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80'){
			if(!strpos($_SERVER['HTTP_HOST'], ':')){
				$port = ':'.$_SERVER['SERVER_PORT'];
			}
		}	
		$folder = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1);	
		return $http_host.$port.$folder;
	}
	
	/**
	 * 	Returns count of active menus
	 * 		@return number on menus
	 */
	public function GetActiveMenuCount()
	{
		return $this->activeMenuCount;
	}	
	
	/**
	 * 	Updates Account Info	
	 * 		@param $account_information - array
	 */
	private function UpdateAccountInfo($account_information)
	{
		if($this->accountType == 'admin'){
			$sql = 'UPDATE '.TABLE_ACCOUNTS.'
					SET date_lastlogin = \''.@date('Y-m-d H:i:s').'\'
					WHERE id = '.(int)$account_information['id'];
		}else{
			$sql = 'UPDATE '.TABLE_CUSTOMERS.'
					SET
						date_lastlogin = \''.@date('Y-m-d H:i:s').'\',
						last_logged_ip = \''.get_current_ip().'\'
					WHERE id = '.(int)$account_information['id'];			
		}
		return database_void_query($sql);
	}	

	/**
	 * 	Removes user account
	 */	
	public function RemoveAccount()
	{
		$sql = 'UPDATE '.TABLE_CUSTOMERS.'
				SET is_removed = 1, is_active = 0, comments = CONCAT(comments, "\r\n'.@date('Y-m-d H:i:s').' - account was removed by customer.") 
				WHERE id = '.(int)$this->GetLoggedID();
		return (database_void_query($sql) > 0 ? true : false);
	}

	/**
	 * 	Get Login Error
	 */	
	public function GetLoginError()
	{
		return defined($this->loginError) ? constant($this->loginError) : '';
	}

	/**
	 * Check if user has privilege
	 * 		@param $code
	 * 		@param $val
	 */
	public function HasPrivileges($code = '', $val = '')
	{
		$privileges_info = Session::Get('session_user_privileges');
		if(!empty($val)){
			if(isset($privileges_info[$code]) && is_array($privileges_info[$code])){
				return in_array($val, $privileges_info[$code]);
			}else{
				return ($privileges_info[$code] == $val);
			}			
		}else{
			return (isset($privileges_info[$code]) && $privileges_info[$code] == true) ? true : false;	
		}		
	}
	
	/**
	 * Return list of assigned hotels
	 */
	public function AssignedToHotels()
	{
		$privileges_info = Session::Get('session_user_privileges');
		return (isset($privileges_info['hotel_ids'])) ? $privileges_info['hotel_ids'] : array();
	}	

	/**
	 * 	Draws the login links and logout form
	 */
	public function DrawLoginLinks()
	{	
		if(Application::Get('preview') == 'yes') return '';
		
		$menu_index = '0';
		$text_align = (Application::Get('lang_dir') == 'ltr') ? 'text-align: left;' : 'text-align: right; padding-right:15px;';
		
		// ---------------------------------------------------------------------
		// MAIN ADMIN LINKS
		if($this->IsLoggedInAsAdmin()){
			draw_block_top(_MENUS.': [ <a id="lnk_all_open" href="javascript:void(0);" onclick="javascript:toggle_menus(1)">'._OPEN.'</a> | <a id="lnk_all_close" href="javascript:void(0);" onclick="javascript:toggle_menus(0)">'._CLOSE.'</a> ]');
			draw_block_bottom();

			draw_block_top(_GENERAL, $menu_index++, 'maximized');        
				echo '<ul>';
				echo '<li>'.$this->PrepareLink('home', _HOME).'</li>';
				if($this->IsLoggedInAs('owner','mainadmin')) echo '<li>'.$this->PrepareLink('settings', _SETTINGS).'</li>';
				if($this->IsLoggedInAs('owner','mainadmin','admin')) echo '<li>'.$this->PrepareLink('ban_list', _BAN_LIST).'</li>';
				if($this->IsLoggedInAs('owner','mainadmin')) echo '<li>'.$this->PrepareLink('countries_management', _COUNTRIES).'</li>';
				if(!$this->IsLoggedInAs('hotelowner')) echo '<li><a href="index.php?preview=yes">'._PREVIEW.' <img src="images/external_link.gif" alt="" /></a></li>';
				echo '</ul>';
			draw_block_bottom();

			draw_block_top(_ACCOUNTS_MANAGEMENT, $menu_index++);
				echo '<div class="menu_category">';
				echo '<ul>';
				echo '<li>'.$this->PrepareLink('my_account', _MY_ACCOUNT).'</li>';
				if($this->IsLoggedInAs('owner', 'mainadmin', 'accounthotelmanageme')) echo '<li>'.$this->PrepareLink('accounts_statistics', _STATISTICS).'</li>';
				if($this->IsLoggedInAs('owner')) echo '<li>'.$this->PrepareLink('roles_management', _ROLES_AND_PRIVILEGES, '', '', array('role_privileges_management')).'</li>';
				echo '</ul>';
				if($this->IsLoggedInAs('owner', 'mainadmin')){
					echo '<label>'._ADMINS_MANAGEMENT.'</label>';
					echo '<ul>';
					echo '<li>'.$this->PrepareLink('admins_management', _ADMINS).'</li>';
					echo '</ul>';
				}								
				if(Modules::IsModuleInstalled('customers') && $this->IsLoggedInAs('owner', 'mainadmin', 'hotelowner', 'accounthotelmanageme')){
					echo '<label>'._CUSTOMERS_MANAGEMENT.'</label>';
					echo '<ul>';
					echo '<li>'.$this->PrepareLink('mod_customers_groups', _CUSTOMER_GROUPS).'</li>';
					echo '<li>'.$this->PrepareLink('mod_customers_management', _CUSTOMERS).'</li>';
					echo '</ul>';
				}
				echo '</div>';
			draw_block_bottom();

			draw_block_top(_HOTELS_MANAGEMENT, $menu_index++); 
				echo '<div class="menu_category">';
					// NTDT - NhanNKH Edited
					if ($this->IsLoggedInAs('owner','mainadmin', 'accounthotelmanageme', 'hotelmanagement')){
						echo '<label>'._SETTINGS.'</label>';
						echo '<ul>';
						echo '<li>'.$this->PrepareLink('mod_rooms_integration', _INTEGRATION).'</li>';
						echo '<li>'.$this->PrepareLink('mod_room_facilities', _ROOM_FACILITIES).'</li>';
						echo '</ul>';
					}
					
					echo '<label>'._HOTELS_AND_ROMS.'</label>';
					echo '<ul>';
					echo '<li>'.$this->PrepareLink('hotels_info', _HOTELS_INFO, '', '', array('hotels_locations')).'</li>';
					if($this->IsLoggedInAs('owner','mainadmin', 'accounthotelmanageme', 'hotelmanagement') || ($this->IsLoggedInAs('hotelowner') && $this->HasPrivileges('edit_hotel_info'))) echo '<li>'.$this->PrepareLink('mod_booking_meal_plans', _MEAL_PLANS).'</li>';
					if($this->IsLoggedInAs('owner','mainadmin', 'accounthotelmanageme', 'hotelmanagement')) echo '<li>'.$this->PrepareLink('mod_rooms_settings', _ROOMS_SETTINGS).'</li>';
					if($this->IsLoggedInAs('owner','mainadmin', 'accounthotelmanageme', 'hotelmanagement') || ($this->IsLoggedInAs('hotelowner') && $this->HasPrivileges('edit_hotel_rooms'))) echo '<li>'.$this->PrepareLink('mod_rooms_management', _ROOMS_MANAGEMENT).'</li>';
					echo '</ul>';
				echo '</div>';						
			draw_block_bottom();				

			if (Modules::IsModuleInstalled('booking') && $this->IsLoggedInAs('owner', 'mainadmin', 'admin', 'booking')){				
				draw_block_top(_BOOKINGS, $menu_index++);
					echo '<div class="menu_category">';						
					if($this->IsLoggedInAs('owner','mainadmin')){
						echo '<label>'._SETTINGS.'</label>';
						echo '<ul>';
						echo '<li>'.$this->PrepareLink('mod_booking_currencies', _CURRENCIES).'</li>';
						echo '<li>'.$this->PrepareLink('mod_booking_packages', _PACKAGES).'</li>';
						echo '<li>'.$this->PrepareLink('mod_booking_extras', _EXTRAS).'</li>';
						echo '</ul>';
					}
					echo '<label>'._BOOKINGS_MANAGEMENT.'</label>';
					echo '<ul>';			
					if(Modules::IsModuleInstalled('booking')){				
						if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'back-end'))){
							echo '<li>'.$this->PrepareLink('mod_booking_reserve_room', _MAKE_RESERVATION).'</li>';
						}
					}
					echo '<li>'.$this->PrepareLink('mod_booking_bookings', _BOOKINGS).'</li>';
					echo '</ul>';
					
					if($this->IsLoggedInAs('owner','mainadmin')){
						echo '<label>'._PROMO_AND_DISCOUNTS.'</label>';
						echo '<ul>';			
						echo '<li>'.$this->PrepareLink('mod_booking_campaigns', _CAMPAIGNS).'</li>';
						echo '<li>'.$this->PrepareLink('mod_booking_coupons', _COUPONS).'</li>';
						echo '</ul>';
					}

					if($this->IsLoggedInAs('owner','mainadmin','admin') || ($this->IsLoggedInAs('hotelowner') && $this->HasPrivileges('view_hotel_reports'))){
						if(Modules::IsModuleInstalled('booking')){				
							if(ModulesSettings::Get('booking', 'is_active') != 'no'){
								echo '<label>'._INFO_AND_STATISTICS.'</label>';
								echo '<ul>';			
								echo '<li>'.$this->PrepareLink('mod_booking_rooms_occupancy', _ROOMS_OCCUPANCY).'</li>';
								echo '<li>'.$this->PrepareLink('mod_booking_reports', _REPORTS).'</li>';
								echo '<li>'.$this->PrepareLink('mod_booking_statistics', _STATISTICS).'</li>';
								echo '</ul>';
							}
						}
					}
					echo '</div>';						
				draw_block_bottom();				
			}

			if($this->HasPrivileges('add_menus') || $this->HasPrivileges('edit_menus') || $this->HasPrivileges('add_pages') || $this->HasPrivileges('edit_pages')){				
				draw_block_top(_MENUS_AND_PAGES, $menu_index++);
					echo '<div class="menu_category">';
					if($this->HasPrivileges('add_menus') || $this->HasPrivileges('edit_menus')){
						echo '<label>'._MENU_MANAGEMENT.'</label>';
						echo '<ul>';			
						if($this->HasPrivileges('add_menus')) echo '<li>'.$this->PrepareLink('menus_add', _ADD_NEW_MENU).'</li>';
						echo '<li>'.$this->PrepareLink('menus', _EDIT_MENUS, '', '', array('menus_edit')).'</li>';
						echo '</ul>';
					}
	
					if($this->HasPrivileges('add_pages') || $this->HasPrivileges('edit_pages')){
						echo '<label>'._PAGE_MANAGEMENT.'</label>';
						echo '<ul>';			
						if($this->HasPrivileges('add_pages')) echo '<li>'.$this->PrepareLink('pages_add', _PAGE_ADD_NEW).'</li>';
						if($this->HasPrivileges('edit_pages')) echo '<li>'.$this->PrepareLink('pages_edit', _PAGE_EDIT_HOME, 'type=home').'</li>';
						echo '<li>'.$this->PrepareLink('pages', _PAGE_EDIT_PAGES, 'type=general').'</li>';
						if($this->HasPrivileges('edit_pages')) echo '<li>'.$this->PrepareLink('pages', _PAGE_EDIT_SYS_PAGES, 'type=system').'</li>';				
						if($this->HasPrivileges('edit_pages')) echo '<li>'.$this->PrepareLink('pages_trash', _TRASH).'</li>';				
						echo '</ul>';						
					}
					echo '</div>';
				draw_block_bottom();
			}

			if($this->IsLoggedInAs('owner','mainadmin','admin')){
				draw_block_top(_LANGUAGES_SETTINGS, $menu_index++);
					echo '<ul>';			
					if($this->IsLoggedInAs('owner','mainadmin')) echo '<li>'.$this->PrepareLink('languages', _LANGUAGES, '', '', array('languages_add','languages_edit')).'</li>';
					if($this->IsLoggedInAs('owner','mainadmin','admin')) echo '<li>'.$this->PrepareLink('vocabulary', _VOCABULARY, 'filter_by=A').'</li>';
					echo '</ul>';
				draw_block_bottom();
			} 

			if($this->IsLoggedInAs('owner','mainadmin')){
				draw_block_top(_MASS_MAIL_AND_TEMPLATES, $menu_index++);
					echo '<ul>';			
					if($this->IsLoggedInAs('owner','mainadmin')) echo '<li>'.$this->PrepareLink('email_templates', _EMAIL_TEMPLATES).'</li>';
					if($this->IsLoggedInAs('owner','mainadmin')) echo '<li>'.$this->PrepareLink('mass_mail', _MASS_MAIL).'</li>';
					echo '</ul>';
				draw_block_bottom();
			}
			
			// MODULES
			$sql = 'SELECT * FROM '.TABLE_MODULES.' WHERE is_installed = 1 AND is_system = 0 ORDER BY priority_order ASC';
			$modules = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
			
			$modules_output = '';
			for($i=0; $i < $modules[1]; $i++){
				$output = '';
				if($modules[0][$i]['settings_access_by'] == '' || ($modules[0][$i]['settings_access_by'] != '' && $this->IsLoggedInAs($modules[0][$i]['settings_access_by']))){
					if($modules[0][$i]['settings_const'] != '') $output .= '<li>'.$this->PrepareLink($modules[0][$i]['settings_page'], constant($modules[0][$i]['settings_const'])).'</li>';
				}
				if($modules[0][$i]['management_access_by'] == '' || ($modules[0][$i]['management_access_by'] != '' && $this->IsLoggedInAs($modules[0][$i]['management_access_by']))){
					$management_pages = explode(',', $modules[0][$i]['management_page']);
					$management_consts = explode(',', $modules[0][$i]['management_const']);
					$management_pages_total = count($management_pages);
					for($j=0; $j < $management_pages_total; $j++){
						if(isset($management_pages[$j]) && isset($management_consts[$j]) && $management_consts[$j] != ''){
							$output .= '<li>'.$this->PrepareLink($management_pages[$j], constant($management_consts[$j])).'</li>';
						}
					}							
				}
				if($output){
					$modules_output .= '<label>'.constant($modules[0][$i]['name_const']).'</label>';
					$modules_output .= '<ul>'.$output.'</ul>';										
				}
			}				
			if(!empty($modules_output)){
				draw_block_top(_MODULES, $menu_index++);
					if($this->IsLoggedInAs('owner','mainadmin')){
						echo '<ul>';			
						echo '<li>'.$this->PrepareLink('modules', _MODULES_MANAGEMENT).'</li>';				
						echo '</ul>';
					}						
					echo '<div class="menu_category">'.$modules_output.'</div>';	
				draw_block_bottom();
			}
				
		}
	
		// ---------------------------------------------------------------------
		// CUSTOMERS LINKS
		if($this->IsLoggedInAsCustomer()){
			draw_block_top(_MY_ACCOUNT);
				echo '<ul style="margin-bottom:15px;">';
				echo '<li>'.$this->PrepareLink('home', _DASHBOARD).'</li>';
				echo '<li>'.$this->PrepareLink('my_account', _EDIT_MY_ACCOUNT).'</li>';
				if(Modules::IsModuleInstalled('booking')){				
					if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))){
						echo '<li>'.$this->PrepareLink('my_bookings', _MY_BOOKINGS).'</li>';
					}
				}
				echo '</ul>';

				// logout
				echo '<form action="index.php" style="margin-bottom:7px;" method="post">
					  '.draw_hidden_field('submit_logout', 'logout', false).'
					  &nbsp;&nbsp;
					  <input class="form_button" type="submit" name="btnLogout" value="'._BUTTON_LOGOUT.'" />&nbsp;&nbsp;
					  </form>';
			draw_block_bottom();
		}		
		
		$this->activeMenuCount = $menu_index;
	}
	
	/**
	 * Prepare admin panel link
	 * 		@param $href
	 * 		@param $link
	 * 		@param $params
	 * 		@param $class
	 * 		@param $href_array
	 */
	private function PrepareLink($href, $link, $params='', $class='', $href_array=array())
	{
		$output = '';
		$css_class = (($class != '') ? $class : '');
		$logged_as = ($this->IsLoggedInAsCustomer()) ? 'customer' : 'admin';
		
		if(Application::Get($logged_as) == $href || in_array(Application::Get($logged_as), $href_array)){
			$is_active = true;
			if(!empty($params)){
				$params_parts = explode('=', $params);
				$f_param  = (isset($params_parts[0]) && isset($_GET[$params_parts[0]])) ? $_GET[$params_parts[0]] : '';
				$s_param = isset($params_parts[1]) ? $params_parts[1] : '';
				if($f_param != $s_param) $is_active = false; 
			}
		}else{
			$is_active = false;
		}
		
		if(!empty($css_class)){
			$css_class = ($is_active ? $css_class.' active' : '');	
		}else{
			$css_class = ($is_active ? 'active' : '');	
		}
	
		$output = prepare_permanent_link('index.php?'.$logged_as.'='.$href.((!empty($params)) ? '&'.$params : $params), $link, '', $css_class);	
		return $output;
	}
	
	/**
	 * Encrypt
	 * 		@param $value
	 * 		@param $secret_key
	 */
	private function Encrypt($value, $secret_key)
    {
		return trim(strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $value, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))), '+/=', '-_,'));
    }
	
	/**
	 * Decrypt
	 * 		@param $value
	 * 		@param $secret_key
	 */
	private function Decrypt($value, $secret_key)
	{
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, base64_decode(strtr($value, '-_,', '+/=')), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
	
}

?>