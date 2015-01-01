<?php

/**
 *	Class AdminsAccounts
 *  -------------- 
 *  Description : encapsulates Admins Accounts operations & properties
 *	Written by  : ApPHP
 *	Version     : 1.0.4
 *  Updated	    : 19.10.2012
 *	Usage       : Core (excepting MicroBlog)
 *	Differences : $PROJECT
 *	
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *	__construct                                     SetCompaniesViewState
 *	__destruct
 *	AfterInsertRecord
 *	AfterUpdateRecord
 *	AfterAddRecord
 *	AfterEditRecord
 *	AfterDetailsMode
 *
 *  1.0.4
 *      - added SetLocale()
 *      - added default value for preferred lang
 *      - added username and passwrod generators
 *      - added '{ACCOUNT TYPE}' => 'admin'
 *      -
 *  1.0.3
 *      - SQL _YES/_NO replaced with "enum"
 *      - last_login redone with date_lastlogin
 *      - added $PROJECT + changes for HotelSite
 *      - added $accountTypeOnChange
 *      - added AfterAddRecord/AfterEditRecord/AfterDetailsMode for HotelSite
 *  1.0.2
 *      - replaced " with '
 *      - improved working with #arr_languages
 *      - added patient=login
 *      - added sending emails in preferred language
 *      - removed clients for HotelSite
 *  1.0.1
 *      - added date_created, last_login labels in Edit Mode
 *      - get_date_format() -> get_datetime_format()
 *      - removed unnded 0000-00-00 from datetime fields
 *      - added maxlength for all fields
 *      - changed AfterInsertRecord send_email()
 *	
 **/

class AdminsAccounts extends MicroGrid {
	
	protected $debug = false;
	private $arrCompanies = array(); /* used to show companies where admin is owner */
	private $additionalFields = '';
	private $accountTypeOnChange = '';
	private $sqlFieldDatetimeFormat = '';

	//------------------------------
	// MicroCMS, HotelSite, ShoppingCart, BusinessDirectory, MedicalAppointments
	private static $PROJECT = 'HotelSite';

	//==========================================================================
    // Class Constructor
	//		@param $login_type
	//==========================================================================
	function __construct($login_type = '')	
	{
		parent::__construct();
		
		global $objSettings;

		$this->params = array();		
		if(isset($_POST['first_name'])) $this->params['first_name'] = prepare_input($_POST['first_name']);
		if(isset($_POST['last_name']))	$this->params['last_name']  = prepare_input($_POST['last_name']);
		if(isset($_POST['user_name']))  $this->params['user_name']  = prepare_input($_POST['user_name']);
		if(isset($_POST['password']))	$this->params['password']   = prepare_input($_POST['password']);
		if(isset($_POST['email']))   	$this->params['email']      = prepare_input($_POST['email']);
		if(isset($_POST['preferred_language']))  $this->params['preferred_language'] = prepare_input($_POST['preferred_language']);
		if(isset($_POST['account_type']))   $this->params['account_type'] = prepare_input($_POST['account_type']);
		if(isset($_POST['date_created']))   $this->params['date_created'] = prepare_input($_POST['date_created']);
		if(isset($_POST['is_active']))      $this->params['is_active']    = (int)$_POST['is_active']; else $this->params['is_active'] = '0';
		if(self::$PROJECT == 'HotelSite'){
			if(isset($_POST['hotels']))     $this->params['hotels'] = prepare_input($_POST['hotels']);
		} 
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_ACCOUNTS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=admins_management';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;

		$this->allowLanguages = false;

		if($login_type == 'owner'){
			$this->WHERE_CLAUSE = 'WHERE ('.TABLE_ACCOUNTS.'.account_type = \'mainadmin\' || '.TABLE_ACCOUNTS.'.account_type = \'admin\' || '.TABLE_ACCOUNTS.'.account_type = \'hotelowner\' || '.TABLE_ACCOUNTS.'.account_type = \'accounthotelmanageme\' || '.TABLE_ACCOUNTS.'.account_type = \'hotelmanagement\' || '.TABLE_ACCOUNTS.'.account_type = \'booking\')';
		}else if($login_type == 'mainadmin'){
			$this->WHERE_CLAUSE = 'WHERE ('.TABLE_ACCOUNTS.'.account_type = \'admin\' || '.TABLE_ACCOUNTS.'.account_type = \'hotelowner\')';
		}else if($login_type == 'admin'){
			$this->WHERE_CLAUSE = 'WHERE '.TABLE_ACCOUNTS.'.account_type = \'admin\'';
		}else if($login_type == 'hotelowner'){
			$this->WHERE_CLAUSE = 'WHERE '.TABLE_ACCOUNTS.'.account_type = \'hotelowner\'';
		}

		$this->ORDER_CLAUSE = 'ORDER BY id ASC';
		$this->isAlterColorsAllowed = true;
		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;
		
		$this->isFilteringAllowed = true;
		// define filtering fields
		$this->arrFilteringFields = array(
			_FIRST_NAME => array('table'=>$this->tableName, 'field'=>'first_name', 'type'=>'text', 'sign'=>'like%', 'width'=>'80px'),
			_LAST_NAME  => array('table'=>$this->tableName, 'field'=>'last_name', 'type'=>'text', 'sign'=>'like%', 'width'=>'80px'),
			_ACTIVE     => array('table'=>$this->tableName, 'field'=>'is_active', 'type'=>'dropdownlist', 'source'=>array('0'=>_NO, '1'=>_YES), 'sign'=>'=', 'width'=>'85px'),
		);

		// prepare languages array		
		$total_languages = Languages::GetAllActive();
		$arr_languages   = array();
		foreach($total_languages[0] as $key => $val){
			$arr_languages[$val['abbreviation']] = $val['lang_name'];
		}

		$arr_account_types = array('admin'=>_ADMIN, 'mainadmin'=>_MAIN_ADMIN);
		if(self::$PROJECT == 'HotelSite') $arr_account_types['hotelowner'] = _HOTEL_OWNER;
		
		//=== NTDT - NhanNKH Edited
		$arr_account_types['accounthotelmanageme'] = _ACCOUNT_HOTEL_MANAGEMENT;
		$arr_account_types['hotelmanagement'] = _HOTEL_MANAGEMENT;
		$arr_account_types['booking'] = _BOOKING;

		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$datetime_format = get_datetime_format();
		
		if(self::$PROJECT == 'HotelSite'){
			$total_hotels = Hotels::GetAllActive();
			$arr_hotels = array();
			foreach($total_hotels[0] as $key => $val){
				$this->arrCompanies[$val['id']] = $val['name'];
			}
			$this->additionalFields = ', hotels';
			$this->accountTypeOnChange = 'onchange="javascript:AccountType_OnChange(this.value)"';
		}

		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$this->sqlFieldDatetimeFormat = '%b %d, %Y %H:%i';
		}else{
			$this->sqlFieldDatetimeFormat = '%d %b, %Y %H:%i';
		}
		$this->SetLocale(Application::Get('lc_time_name'));
		
		//---------------------------------------------------------------------- 
		// VIEW MODE
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									first_name,
		                            last_name,
									CONCAT(first_name, \' \', last_name) as full_name,
									user_name,
									email,
									preferred_language,
									account_type,
									DATE_FORMAT(date_lastlogin, \''.$this->sqlFieldDatetimeFormat.'\') as date_lastlogin,
									is_active
									'.$this->additionalFields.'
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'full_name'   => array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>''),
			'user_name'   => array('title'=>_USER_NAME,  'type'=>'label', 'align'=>'left', 'width'=>''),
			'email' 	  => array('title'=>_EMAIL_ADDRESS, 'type'=>'link', 'maxlength'=>'35', 'href'=>'mailto:{email}', 'align'=>'left', 'width'=>''),
			'account_type' => array('title'=>_ACCOUNT_TYPE, 'type'=>'enum',  'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_account_types),
			'is_active'   => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'80px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
			'date_lastlogin'  => array('title'=>_LAST_LOGIN, 'type'=>'label', 'align'=>'center', 'width'=>'110px', 'format'=>'date', 'format_parameter'=>$datetime_format),
			'id'          => array('title'=>'ID', 'type'=>'label', 'align'=>'center', 'width'=>'40px'),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	 => array('title'=>_FIRST_NAME,	'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'maxlength'=>'32', 'validation_type'=>'text'),
				'last_name'    	 => array('title'=>_LAST_NAME, 	'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'maxlength'=>'32', 'validation_type'=>'text'),
				'email' 		 => array('title'=>_EMAIL_ADDRESS,'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'maxlength'=>'70', 'validation_type'=>'email', 'unique'=>true),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'user_name'  	 => array('title'=>_USER_NAME,	'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'maxlength'=>'32', 'validation_type'=>'alpha_numeric', 'unique'=>true, 'username_generator'=>true),
				'password'  	 => array('title'=>_PASSWORD, 	'type'=>'password', 'width'=>'210px', 'required'=>true, 'maxlength'=>'32', 'validation_type'=>'password', 'cryptography'=>PASSWORDS_ENCRYPTION, 'cryptography_type'=>PASSWORDS_ENCRYPTION_TYPE, 'aes_password'=>PASSWORDS_ENCRYPT_KEY, 'password_generator'=>true),
				'account_type'   => array('title'=>_ACCOUNT_TYPE, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'120px', 'source'=>$arr_account_types, 'javascript_event'=>$this->accountTypeOnChange),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'120px', 'default'=>Application::Get('lang'), 'source'=>$arr_languages),
			),
		    'separator_3'   =>array(
				'separator_info' => array('legend'=>_OTHER),
				'date_lastlogin' => array('title'=>'',      'type'=>'hidden',  'required'=>false, 'default'=>''),
				'date_created' 	 => array('title'=>'',      'type'=>'hidden',  'required'=>false, 'default'=>date('Y-m-d H:i:s')),
				'is_active'  	 => array('title'=>_ACTIVE,	'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
			)
		);
		if(self::$PROJECT == 'HotelSite'){
			$this->arrAddModeFields['separator_3']['hotels'] = array('title'=>_HOTELS, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrCompanies, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true);
		} 


		//---------------------------------------------------------------------- 
		// EDIT MODE
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.first_name,
								'.$this->tableName.'.last_name,
								'.$this->tableName.'.user_name,
								'.$this->tableName.'.password,
								'.$this->tableName.'.email,
								'.$this->tableName.'.account_type,
								'.$this->tableName.'.preferred_language,
								DATE_FORMAT('.$this->tableName.'.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as date_created,
								DATE_FORMAT('.$this->tableName.'.date_lastlogin, \''.$this->sqlFieldDatetimeFormat.'\') as date_lastlogin,
								'.$this->tableName.'.is_active
								'.$this->additionalFields.'
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	 => array('title'=>_FIRST_NAME,	'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'last_name'    	 => array('title'=>_LAST_NAME, 	'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'email' 		 => array('title'=>_EMAIL_ADDRESS,'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'70', 'required'=>true, 'validation_type'=>'email', 'unique'=>true),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'user_name'  	 => array('title'=>_USER_NAME,	'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'readonly'=>true, 'validation_type'=>'alpha_numeric', 'unique'=>true),
				'account_type'   => array('title'=>_ACCOUNT_TYPE, 'type'=>'enum', 'width'=>'120px', 'required'=>true, 'maxlength'=>'32', 'readonly'=>(($login_type == 'owner')?false:true), 'source'=>$arr_account_types, 'javascript_event'=>$this->accountTypeOnChange),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'width'=>'120px', 'required'=>true, 'readonly'=>false, 'source'=>$arr_languages),
			),
		    'separator_3'   =>array(
				'separator_info'   => array('legend'=>_OTHER),
				'date_created' => array('title'=>_DATE_CREATED, 'type'=>'label'),
				'date_lastlogin'  => array('title'=>_LAST_LOGIN, 'type'=>'label'),
				'is_active'  	   => array('title'=>_ACTIVE, 'type'=>'checkbox', 'true_value'=>'1', 'false_value'=>'0'),
			)
		);
		if(self::$PROJECT == 'HotelSite'){
			$this->arrEditModeFields['separator_3']['hotels'] = array('title'=>_HOTELS, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrCompanies, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true);
		} 

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.first_name,
								'.$this->tableName.'.last_name,
								'.$this->tableName.'.user_name,
								'.$this->tableName.'.password,
								'.$this->tableName.'.email,
								'.$this->tableName.'.preferred_language,
								'.$this->tableName.'.account_type,
								DATE_FORMAT('.$this->tableName.'.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as date_created,
								DATE_FORMAT('.$this->tableName.'.date_lastlogin, \''.$this->sqlFieldDatetimeFormat.'\') as date_lastlogin,
								'.$this->tableName.'.is_active
								'.$this->additionalFields.'
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		$this->arrDetailsModeFields = array(
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	=> array('title'=>_FIRST_NAME,	'type'=>'label'),
				'last_name'    	=> array('title'=>_LAST_NAME, 'type'=>'label'),
				'email'     	=> array('title'=>_EMAIL_ADDRESS, 	 'type'=>'label'),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'user_name'   	=> array('title'=>_USER_NAME, 'type'=>'label'),
				'account_type'  => array('title'=>_ACCOUNT_TYPE, 'type'=>'enum', 'source'=>$arr_account_types),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'source'=>$arr_languages),
			),
		    'separator_3'   =>array(
				'separator_info' => array('legend'=>_OTHER),
				'date_created'   => array('title'=>_DATE_CREATED, 'type'=>'label'),
				'date_lastlogin' => array('title'=>_LAST_LOGIN, 'type'=>'label'),
				'is_active'  	 => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
			)
		);
		if(self::$PROJECT == 'HotelSite'){
			$this->arrDetailsModeFields['separator_3']['hotels'] = array('title'=>_HOTELS, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrCompanies, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true);
		} 
	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	/**
	 * After-Addition operation
	 */
	public function AfterInsertRecord()
	{
		global $objSettings, $objSiteDescription;

		////////////////////////////////////////////////////////////
		send_email(
			$this->params['email'],
			$objSettings->GetParameter('admin_email'),
			'new_account_created_by_admin',
			array(
				'{FIRST NAME}'   => $this->params['first_name'],
				'{LAST NAME}'    => $this->params['last_name'],
				'{USER NAME}'    => $this->params['user_name'],
				'{USER PASSWORD}' => $this->params['password'],
				'{WEB SITE}'     => $_SERVER['SERVER_NAME'],
				'{BASE URL}'     => APPHP_BASE,
				'{YEAR}'         => date('Y'),
				'customer=login' => 'admin=login',
				'user=login'     => 'admin=login',
				'patient=login'  => 'admin=login',
				'{ACCOUNT TYPE}' => 'admin'
			),
			$this->params['preferred_language']
		);
		////////////////////////////////////////////////////////////
	}

	/**
	 * After-Updating operation
	 */
	public function AfterUpdateRecord()
	{
		global $objLogin;		
		$objLogin->UpdateLoggedEmail($this->params['email']);
	}
	
	/**
	 * After drawing Add Mode
	 */
	public function AfterAddRecord()
	{
		$this->SetCompaniesViewState();
	}
	
	/**
	 * After drawing Edit Mode
	 */
	public function AfterEditRecord()
	{
		$this->SetCompaniesViewState();
	}
	
	/**
	 * After drawing Details Mode
	 */
	public function AfterDetailsMode()
	{
		if(isset($this->result[0][0]['account_type']) && $this->result[0][0]['account_type'] != 'hotelowner') $this->SetCompaniesViewState(true);
	}
	
	/**
	 * Set companies view state
	 * 		@param $force_hidding
	 */
	private function SetCompaniesViewState($force_hidding = false)
	{
		if(self::$PROJECT == 'HotelSite'){
			if($force_hidding){
				echo '<script type="text/javascript">jQuery("#mg_row_hotels").hide();</script>';
			}else{
				echo '<script type="text/javascript">if(jQuery("#account_type").val() != "hotelowner"){ jQuery("#mg_row_hotels").hide(); }</script>';
			}			
		}				
	}
	
}
?>