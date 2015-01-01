<?php

/**
 *	Class Customers (for ApPHP HotelSite ONLY)
 *  -------------- 
 *  Description : encapsulates Customers operations & properties
 *  Updated	    : 30.06.2011
 *	Written by  : ApPHP
 *	
 *	PUBLIC:					STATIC:					PRIVATE:
 *  -----------				-----------				-----------
 *  __construct				SendPassword						
 *  __destruct              GetStaticError
 *  BeforeEditRecord        DrawLoginFormBlock
 *  BeforeUpdateRecord      ResetAccount
 *  AfterUpdateRecord       Reactivate  
 *  AfterInsertRecord       AwaitingAprovalCount
 *  GetAllCustomers         DrawCustomerInfo
 *  
 **/

class Customers extends MicroGrid {
	
	protected $debug = false;
	
    //------------------------------
	private $email_notifications;
	private $user_password;
	private $allow_changing_password;
	private $reg_confirmation;
	private $sqlFieldDatetimeFormat = '';
	private $sqlFieldDateFormat = '';
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{
		parent::__construct();

		global $objSettings;
		global $objLogin;
		
		$this->params = array();
		if(isset($_POST['group_id']))   $this->params['group_id']    = (int)prepare_input($_POST['group_id']);
		if(isset($_POST['first_name'])) $this->params['first_name']  = prepare_input($_POST['first_name']);
		if(isset($_POST['last_name']))	$this->params['last_name']   = prepare_input($_POST['last_name']);
		if(isset($_POST['birth_date']) && ($_POST['birth_date'] != ''))  $this->params['birth_date'] = prepare_input($_POST['birth_date']); else $this->params['birth_date'] = '0000-00-00';	
		if(isset($_POST['company']))   	$this->params['company']     = prepare_input($_POST['company']);
		if(isset($_POST['b_address']))  $this->params['b_address']   = prepare_input($_POST['b_address']);
		if(isset($_POST['b_address_2']))$this->params['b_address_2'] = prepare_input($_POST['b_address_2']);
		if(isset($_POST['b_city']))   	$this->params['b_city']      = prepare_input($_POST['b_city']);
		if(isset($_POST['b_zipcode']))	$this->params['b_zipcode']   = prepare_input($_POST['b_zipcode']);
		if(isset($_POST['b_country']))	$this->params['b_country']   = prepare_input($_POST['b_country']);
		if(isset($_POST['b_state']))   	$this->params['b_state']     = prepare_input($_POST['b_state']);
		if(isset($_POST['phone'])) 		$this->params['phone'] 		 = prepare_input($_POST['phone']);
		if(isset($_POST['fax'])) 		$this->params['fax'] 		 = prepare_input($_POST['fax']);
		if(isset($_POST['email'])) 		$this->params['email'] 		 = prepare_input($_POST['email']);
		if(isset($_POST['url'])) 		$this->params['url'] 		 = prepare_input($_POST['url'], false, 'medium');
		if(isset($_POST['user_name']))  $this->params['user_name']   = prepare_input($_POST['user_name']);
		if(isset($_POST['user_password']))  	$this->params['user_password']  = prepare_input($_POST['user_password']);
		if(isset($_POST['preferred_language'])) $this->params['preferred_language'] = prepare_input($_POST['preferred_language']);
		if(isset($_POST['date_created']))  		$this->params['date_created']   = prepare_input($_POST['date_created']);
		if(isset($_POST['date_lastlogin']))  	$this->params['date_lastlogin'] = prepare_input($_POST['date_lastlogin']);
		if(isset($_POST['registered_from_ip'])) $this->params['registered_from_ip'] = prepare_input($_POST['registered_from_ip']);
		if(isset($_POST['last_logged_ip'])) 	$this->params['last_logged_ip'] 	= prepare_input($_POST['last_logged_ip']);
		if(isset($_POST['email_notifications'])) 		 $this->params['email_notifications'] 		  = (int)$_POST['email_notifications']; else $this->params['email_notifications'] = '0';
		if(isset($_POST['notification_status_changed'])) $this->params['notification_status_changed'] = prepare_input($_POST['notification_status_changed']);
		if(isset($_POST['orders_count'])) 		$this->params['orders_count'] 		= (int)$_POST['orders_count'];
		if(isset($_POST['rooms_count'])) 	    $this->params['rooms_count'] 		= (int)$_POST['rooms_count'];
		if(isset($_POST['is_active']))  		$this->params['is_active']  		= (int)$_POST['is_active']; else $this->params['is_active'] = '0';
		if(isset($_POST['is_removed'])) 		$this->params['is_removed'] 		= (int)$_POST['is_removed']; else $this->params['is_removed'] = '0';
		if(isset($_POST['comments'])) 			$this->params['comments'] 		 	= prepare_input($_POST['comments']);
		if(isset($_POST['registration_code'])) 	$this->params['registration_code'] 	= prepare_input($_POST['registration_code']);
		
		$this->email_notifications = '';
		$this->user_password = '';
		$this->allow_changing_password = ModulesSettings::Get('customers', 'password_changing_by_admin');
		$this->reg_confirmation = ModulesSettings::Get('customers', 'reg_confirmation');		
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_CUSTOMERS;
		$this->dataSet 		= array();
		$this->error 		= '';
		///$this->languageId  	= (isset($_REQUEST['language_id']) && $_REQUEST['language_id'] != '') ? $_REQUEST['language_id'] : Languages::GetDefaultLang();
		$this->formActionURL = 'index.php?admin=mod_customers_management';

		$allow_adding_by_admin = ModulesSettings::Get('customers', 'allow_adding_by_admin');
		$allow_adding = ($allow_adding_by_admin == 'yes') ? true : false;
		$allow_deleting = true;		
		$allow_editing = true;
		if($objLogin->IsLoggedInAs('hotelowner')){
			$allow_adding = $allow_editing = $allow_deleting = false;
		}		
		$this->actions      = array('add'=>$allow_adding, 'edit'=>$allow_editing, 'details'=>true, 'delete'=>$allow_deleting);
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = true;

		$this->allowLanguages = false;
		$this->WHERE_CLAUSE = '';		
		$this->ORDER_CLAUSE = 'ORDER BY id DESC';

		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$total_countries = Countries::GetAllCountries('priority_order DESC, name ASC');
		$arr_countries = array();
		foreach($total_countries[0] as $key => $val){
			$arr_countries[$val['abbrv']] = $val['name'];
		}

		$total_groups = CustomerGroups::GetAllGroups();
		$arr_groups = array();
		foreach($total_groups[0] as $key => $val){
			$arr_groups[$val['id']] = $val['name'];
		}
		
		$this->isFilteringAllowed = true;
		// define filtering fields
		$this->arrFilteringFields = array(
			_USERNAME   => array('table'=>'c', 'field'=>'user_name', 'type'=>'text', 'sign'=>'like%', 'width'=>'80px'),			
			_LAST_NAME  => array('table'=>'c', 'field'=>'last_name', 'type'=>'text', 'sign'=>'like%', 'width'=>'80px'),
			_EMAIL      => array('table'=>'c', 'field'=>'email', 'type'=>'text', 'sign'=>'like%', 'width'=>'100px'),
			_GROUP      => array('table'=>'c', 'field'=>'group_id', 'type'=>'dropdownlist', 'source'=>$arr_groups, 'sign'=>'=', 'width'=>'85px'),
		);

		$user_ip = get_current_ip();		
		$datetime_format = get_datetime_format();		
		$date_format_view = get_date_format('view');
		$date_format_edit = get_date_format('edit');
		
		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_is_removed = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_email_notification = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');

		// prepare languages array		
		$total_languages = Languages::GetAllActive();
		$arr_languages = array();
		foreach($total_languages[0] as $key => $val){
			$arr_languages[$val['abbreviation']] = $val['lang_name'];
		}

		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$this->sqlFieldDatetimeFormat = '%b %d, %Y %H:%i';
			$this->sqlFieldDateFormat = '%b %d, %Y';
		}else{
			$this->sqlFieldDatetimeFormat = '%d %b, %Y %H:%i';
			$this->sqlFieldDateFormat = '%d %b, %Y';
		}
		$this->SetLocale(Application::Get('lc_time_name'));

		//---------------------------------------------------------------------- 
		// VIEW MODE
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT
									c.'.$this->primaryKey.',
		                            c.*,
									CONCAT(c.first_name, " ", c.last_name) as full_name,
									IF(c.user_name != "", c.user_name, "<span class=gray>'._WITHOUT_ACCOUNT.'</span>") as mod_user_name,
									c.is_active,
									cnt.name as country_name,
									cg.name as group_name									
								FROM '.$this->tableName.' c
									LEFT OUTER JOIN '.TABLE_COUNTRIES.' cnt ON c.b_country = cnt.abbrv AND cnt.is_active = 1
									LEFT OUTER JOIN '.TABLE_CUSTOMER_GROUPS.' cg ON c.group_id = cg.id ';		
		// define view mode fields
		$this->arrViewModeFields = array(
			'full_name'    => array('title'=>_CUSTOMER_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'maxlength'=>'25'),
			'mod_user_name'=> array('title'=>_USERNAME, 'type'=>'label', 'align'=>'left', 'width'=>''),
			'email' 	   => array('title'=>_EMAIL_ADDRESS, 'type'=>'link', 'href'=>'mailto:{email}', 'align'=>'left', 'maxlength'=>'28', 'width'=>''),
			'country_name' => array('title'=>_COUNTRY, 'type'=>'label', 'align'=>'left', 'width'=>'120px'),
			'is_active'    => array('title'=>_ACTIVE, 'type'=>'enum', 'type'=>'enum',  'align'=>'center', 'width'=>'85px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
			'orders_count' => array('title'=>_BOOKINGS, 'type'=>'label', 'align'=>'center', 'width'=>'80px'),
			'group_name'   => array('title'=>_GROUP, 'type'=>'label', 'align'=>'center', 'width'=>'80px'),
			'id'           => array('title'=>'ID', 'type'=>'label', 'align'=>'center', 'width'=>'60px'),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	=> array('title'=>_FIRST_NAME,'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'last_name'    	=> array('title'=>_LAST_NAME, 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'birth_date'    => array('title'=>_BIRTH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>false, 'readonly'=>false, 'default'=>'', 'validation_type'=>'date', 'unique'=>false, 'visible'=>true, 'min_year'=>'90', 'max_year'=>'0', 'format'=>'date', 'format_parameter'=>$date_format_edit),
				'company' 		=> array('title'=>_COMPANY,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'255', 'required'=>false, 'validation_type'=>'text'),
				'url' 			=> array('title'=>_URL,		 'type'=>'textbox', 'width'=>'270px', 'maxlength'=>'128', 'required'=>false, 'validation_type'=>'text'),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_BILLING_ADDRESS),
				'b_address' 	=> array('title'=>_ADDRESS,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>true, 'validation_type'=>'text'),
				'b_address_2' 	=> array('title'=>_ADDRESS_2,'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>false, 'validation_type'=>'text'),
				'b_city' 		=> array('title'=>_CITY,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>true, 'validation_type'=>'text'),
				'b_zipcode' 	=> array('title'=>_ZIP_CODE, 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'b_country' 	=> array('title'=>_COUNTRY,	 'type'=>'enum',     'width'=>'210px', 'source'=>$arr_countries, 'required'=>true),
				'b_state' 		=> array('title'=>_STATE,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>false, 'validation_type'=>'text'),
			),
		    'separator_3'   =>array(
				'separator_info' => array('legend'=>_CONTACT_INFORMATION),
				'phone' 		 => array('title'=>_PHONE,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'fax' 		     => array('title'=>_FAX,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'email' 		 => array('title'=>_EMAIL_ADDRESS,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'70', 'required'=>false, 'validation_type'=>'email', 'unique'=>true, 'autocomplete'=>'off'),
			),
		    'separator_4'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'user_name' 	 => array('title'=>_USERNAME,  'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text', 'validation_minlength'=>'4', 'readonly'=>false, 'unique'=>true, 'username_generator'=>true),
				'user_password'  => array('title'=>_PASSWORD, 'type'=>'password', 'width'=>'210px', 'maxlength'=>'30', 'required'=>true, 'validation_type'=>'password', 'cryptography'=>PASSWORDS_ENCRYPTION, 'cryptography_type'=>PASSWORDS_ENCRYPTION_TYPE, 'aes_password'=>PASSWORDS_ENCRYPT_KEY, 'password_generator'=>true),
				'group_id'       => array('title'=>_CUSTOMER_GROUP, 'type'=>'enum', 'required'=>false, 'readonly'=>false, 'width'=>'', 'source'=>$arr_groups),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'120px', 'default'=>Application::Get('lang'), 'source'=>$arr_languages),
			),
		    'separator_5'   =>array(
				'separator_info' => array('legend'=>_OTHER),
				'date_created'		   => array('title'=>_DATE_CREATED,	'type'=>'hidden', 'width'=>'210px', 'required'=>true, 'default'=>date('Y-m-d H:i:s')),
				'registered_from_ip'   => array('title'=>_REGISTERED_FROM_IP, 'type'=>'hidden', 'width'=>'210px', 'required'=>true, 'default'=>$user_ip),
				'last_logged_ip'	   => array('title'=>_LAST_LOGGED_IP,	  'type'=>'hidden', 'width'=>'210px', 'required'=>false, 'default'=>''),
				'email_notifications'  => array('title'=>_EMAIL_NOTIFICATIONS,	'type'=>'checkbox', 'true_value'=>'1', 'false_value'=>'0'),
				'orders_count'		=> array('title'=>'',  			  'type'=>'hidden', 'width'=>'210px', 'required'=>true, 'default'=>'0'),
				'rooms_count'		=> array('title'=>_ROOMS,		  'type'=>'hidden', 'width'=>'210px', 'required'=>true, 'default'=>'0'),
				'is_active'			=> array('title'=>_ACTIVE,		  'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
				'is_removed'		=> array('title'=>_REMOVED,		  'type'=>'hidden', 'width'=>'210px', 'required'=>true, 'default'=>'0'),
				'comments'			=> array('title'=>_COMMENTS,	  'type'=>'textarea', 'width'=>'420px', 'height'=>'70px', 'required'=>false, 'readonly'=>false, 'validation_type'=>'text', 'validation_maxlength'=>'1024'),
				'registration_code'	=> array('title'=>_REGISTRATION_CODE, 'type'=>'hidden', 'width'=>'210px', 'required'=>false, 'default'=>''),
			),
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// * password field must be written directly in SQL!!!
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
									'.$this->tableName.'.'.$this->primaryKey.',
		                            '.$this->tableName.'.*,
									'.$this->tableName.'.user_password,
									IF('.$this->tableName.'.user_name != "", '.$this->tableName.'.user_name, "'._WITHOUT_ACCOUNT.'") as mod_user_name,
									DATE_FORMAT('.$this->tableName.'.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as date_created,
									DATE_FORMAT('.$this->tableName.'.date_lastlogin, \''.$this->sqlFieldDatetimeFormat.'\') as date_lastlogin,
									DATE_FORMAT('.$this->tableName.'.notification_status_changed, \''.$this->sqlFieldDatetimeFormat.'\') as notification_status_changed									
								FROM '.$this->tableName.'
								WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';

		// define edit mode fields
		$this->arrEditModeFields = array(
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	=> array('title'=>_FIRST_NAME,'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'last_name'    	=> array('title'=>_LAST_NAME, 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>true, 'validation_type'=>'text'),
				'birth_date'    => array('title'=>_BIRTH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>false, 'readonly'=>false, 'default'=>'', 'validation_type'=>'date', 'unique'=>false, 'visible'=>true, 'min_year'=>'90', 'max_year'=>'0', 'format'=>'date', 'format_parameter'=>$date_format_edit),
				'company' 		=> array('title'=>_COMPANY,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'255', 'required'=>false, 'validation_type'=>'text'),
				'url' 			=> array('title'=>_URL,		 'type'=>'textbox', 'width'=>'270px', 'maxlength'=>'128', 'required'=>false, 'validation_type'=>'text'),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_BILLING_ADDRESS),
				'b_address' 	=> array('title'=>_ADDRESS,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>true, 'validation_type'=>'text'),
				'b_address_2' 	=> array('title'=>_ADDRESS_2,'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>false, 'validation_type'=>'text'),
				'b_city' 		=> array('title'=>_CITY,		 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>true, 'validation_type'=>'text'),
				'b_zipcode' 	=> array('title'=>_ZIP_CODE,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'b_country' 	=> array('title'=>_COUNTRY,	 'type'=>'enum',     'width'=>'210px', 'source'=>$arr_countries, 'required'=>true),
				'b_state' 		=> array('title'=>_STATE,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'64', 'required'=>false, 'validation_type'=>'text'),
			),
		    'separator_3'   =>array(
				'separator_info' => array('legend'=>_CONTACT_INFORMATION),
				'phone' 		=> array('title'=>_PHONE,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'fax' 		     => array('title'=>_FAX,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'32', 'required'=>false, 'validation_type'=>'text'),
				'email' 		=> array('title'=>_EMAIL_ADDRESS,	 'type'=>'textbox', 'width'=>'210px', 'maxlength'=>'70', 'required'=>true, 'readonly'=>false, 'validation_type'=>'email', 'unique'=>true, 'autocomplete'=>'off'),
			),
		    'separator_4'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'mod_user_name'  => array('title'=>_USERNAME,	 'type'=>'label'),
				'user_password'  => array('title'=>_PASSWORD, 'type'=>'password', 'width'=>'210px', 'maxlength'=>'20', 'required'=>true, 'validation_type'=>'password', 'cryptography'=>PASSWORDS_ENCRYPTION, 'cryptography_type'=>PASSWORDS_ENCRYPTION_TYPE, 'aes_password'=>PASSWORDS_ENCRYPT_KEY, 'visible'=>(($this->allow_changing_password == 'yes') ? true : false)),
				'group_id'       => array('title'=>_CUSTOMER_GROUP, 'type'=>'enum', 'required'=>false, 'readonly'=>false, 'width'=>'', 'source'=>$arr_groups),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'120px', 'source'=>$arr_languages),
			),
		    'separator_5'   =>array(
				'separator_info' => array('legend'=>_OTHER),
				'date_created'	=> array('title'=>_DATE_CREATED, 'type'=>'label'),
				'date_lastlogin'=> array('title'=>_LAST_LOGIN,	'type'=>'label'),
				'registered_from_ip'   => array('title'=>_REGISTERED_FROM_IP, 'type'=>'label'),
				'last_logged_ip'	   => array('title'=>_LAST_LOGGED_IP,	 'type'=>'label'),
				'email_notifications' => array('title'=>_EMAIL_NOTIFICATIONS,	'type'=>'checkbox', 'true_value'=>'1', 'false_value'=>'0'),
				'notification_status_changed' => array('title'=>_NOTIFICATION_STATUS_CHANGED, 'type'=>'label', 'format'=>'date'),
				'orders_count'		=> array('title'=>_BOOKINGS,  'type'=>'label'),
				'rooms_count'		=> array('title'=>_ROOMS, 'type'=>'label'),
				'is_active'			=> array('title'=>_ACTIVE,		  'type'=>'checkbox', 'true_value'=>'1', 'false_value'=>'0'),
				'is_removed'		=> array('title'=>_REMOVED,		  'type'=>'checkbox', 'true_value'=>'1', 'false_value'=>'0'),
				'comments'			=> array('title'=>_COMMENTS,	  'type'=>'textarea', 'width'=>'420px', 'height'=>'70px', 'required'=>false, 'readonly'=>false, 'validation_type'=>'text', 'validation_maxlength'=>'1024'),
				'registration_code'	=> array('title'=>_REGISTRATION_CODE, 'type'=>'hidden', 'width'=>'210px', 'required'=>false, 'default'=>''),
			),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = 'SELECT
									c.'.$this->primaryKey.',
		                            c.*,
									IF(c.user_name != "", c.user_name, "<span class=darkred>'._WITHOUT_ACCOUNT.'</span>") as mod_user_name,
									DATE_FORMAT(c.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as date_created,
									DATE_FORMAT(c.date_lastlogin, \''.$this->sqlFieldDatetimeFormat.'\') as date_lastlogin,
									DATE_FORMAT(c.birth_date, \''.$this->sqlFieldDateFormat.'\') as birth_date,
									DATE_FORMAT(c.notification_status_changed, \''.$this->sqlFieldDatetimeFormat.'\') as notification_status_changed,
									c.email_notifications,
									c.is_active,
									c.is_removed,
									cnt.name as country_name,
									cg.name as group_name
								FROM '.$this->tableName.' c
									LEFT OUTER JOIN '.TABLE_COUNTRIES.' cnt ON c.b_country = cnt.abbrv AND cnt.is_active = 1
									LEFT OUTER JOIN '.TABLE_CUSTOMER_GROUPS.' cg ON c.group_id = cg.id
								WHERE c.'.$this->primaryKey.' = _RID_';
		$this->arrDetailsModeFields = array(			
		    'separator_1'   =>array(
				'separator_info' => array('legend'=>_PERSONAL_DETAILS),
				'first_name'  	=> array('title'=>_FIRST_NAME, 'type'=>'label'),
				'last_name'    	=> array('title'=>_LAST_NAME,  'type'=>'label'),
				'birth_date'    => array('title'=>_BIRTH_DATE,  'type'=>'label'),
				'company' 		=> array('title'=>_COMPANY,	   'type'=>'label'),
				'url' 			=> array('title'=>_URL,		 'type'=>'label'),
			),
		    'separator_2'   =>array(
				'separator_info' => array('legend'=>_BILLING_ADDRESS),
				'b_address' 	=> array('title'=>_ADDRESS,	 'type'=>'label'),
				'b_address_2' 	=> array('title'=>_ADDRESS_2,'type'=>'label'),
				'b_city' 		=> array('title'=>_CITY,	 'type'=>'label'),
				'b_zipcode' 	=> array('title'=>_ZIP_CODE, 'type'=>'label'),
				'country_name' 	=> array('title'=>_COUNTRY,	 'type'=>'label'),
				'b_state' 		=> array('title'=>_STATE,	 'type'=>'label'),
			),
		    'separator_3'   =>array(
				'separator_info' => array('legend'=>_CONTACT_INFORMATION),
				'phone' 		=> array('title'=>_PHONE,	 'type'=>'label'),
				'fax' 		     => array('title'=>_FAX,	 'type'=>'label'),
				'email' 		=> array('title'=>_EMAIL_ADDRESS, 'type'=>'label'),
			),
		    'separator_4'   =>array(
				'separator_info' => array('legend'=>_ACCOUNT_DETAILS),
				'mod_user_name'  => array('title'=>_USERNAME,	 'type'=>'label'),
				'group_name'     => array('title'=>_CUSTOMER_GROUP, 'type'=>'label'),
				'preferred_language' => array('title'=>_PREFERRED_LANGUAGE, 'type'=>'enum', 'source'=>$arr_languages),
			),
		    'separator_5'   =>array(
				'separator_info' => array('legend'=>_OTHER),
				'date_created'	=> array('title'=>_DATE_CREATED, 'type'=>'label'),
				'date_lastlogin'=> array('title'=>_LAST_LOGIN,	 'type'=>'label'),
				'registered_from_ip'   => array('title'=>_REGISTERED_FROM_IP, 'type'=>'label'),
				'last_logged_ip'	   => array('title'=>_LAST_LOGGED_IP,	 'type'=>'label'),
				'email_notifications' => array('title'=>_EMAIL_NOTIFICATIONS,	'type'=>'label', 'type'=>'enum', 'source'=>$arr_email_notification),
				'notification_status_changed' => array('title'=>_NOTIFICATION_STATUS_CHANGED, 'type'=>'label', 'format'=>'date', 'format_parameter'=>$datetime_format),
				'orders_count'		=> array('title'=>_BOOKINGS, 'type'=>'label'),
				'rooms_count'		=> array('title'=>_ROOMS, 'type'=>'label'),
				'is_active'	        => array('title'=>_ACTIVE,	 'type'=>'label', 'type'=>'enum', 'source'=>$arr_is_active),
				'is_removed'	    => array('title'=>_REMOVED,  'type'=>'label', 'type'=>'enum', 'source'=>$arr_is_removed),
				'comments'			=> array('title'=>_COMMENTS,  'type'=>'label', 'format'=>'nl2br'),
			),
		);

	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	//==========================================================================
    // PUBLIC METHODS
	//==========================================================================
	/**
	 * Draws login form in Front-End
	 * 		@param $draw
	 */
	public static function DrawLoginFormBlock($draw = true)
	{
		global $objLogin;		

		$username = '';
		$password = '';

		$output = draw_block_top(_AUTHENTICATION, '', 'maximized', false);
		$output .= '<form class="authentication-form" action="index.php?customer=login" method="post">
			<table border="0" cellspacing="2" cellpadding="1">
			<tr>
				<td>
					'.draw_hidden_field('submit_login', 'login', false).'
					'.draw_hidden_field('type', 'customer', false).'
					'.draw_token_field(false).'				
			    </td>
			</tr>
			<tr><td>'._USERNAME.':</td></tr>
			<tr><td><input type="text" name="user_name" id="user_name" class="inputtext100" maxlength="50" autocomplete="off" value="'.$username.'" /></td></tr>
			<tr><td>'._PASSWORD.':</td></tr>
			<tr><td><input type="password" name="password" id="password" class="inputtext100" maxlength="20" autocomplete="off" value="'.$password.'" /></td></tr>
			<tr><td style="height:5px"></td></tr>
			<tr><td>';
                if(ModulesSettings::Get('customers', 'remember_me_allow') == 'yes'){
                    $output .= '<input type="checkbox" class="form_checkbox" name="remember_me" id="chk_remember_me" value="1" /> <label for="chk_remember_me">'._REMEMBER_ME.'</label></td></tr>';
		}				
			
		$output .= '<tr><td><input class="form_button" type="submit" name="submit" value="'._BUTTON_LOGIN.'" /> ';
		
		$output .= '</td></tr>
			<tr><td></td></tr>';
			if(ModulesSettings::Get('customers', 'allow_registration') == 'yes') $output .= '<tr><td><a class="form_link" href="index.php?customer=create_account">'._CREATE_ACCOUNT.'</a></td></tr>';
			if(ModulesSettings::Get('customers', 'allow_reset_passwords') == 'yes') $output .= '<tr><td><a class="form_link" href="index.php?customer=password_forgotten">'._FORGOT_PASSWORD.'</a></td></tr>';
			$output .= '</table>		
		</form>';
		$output .= draw_block_bottom(false);
		
		if($draw) echo $output;
		else return $output;				
	}	

	/**
	 * Before-Update operation
	 */
	public function BeforeUpdateRecord()
	{
		$sql = 'SELECT email_notifications, user_password FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.(int)$this->curRecordId;
		$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
        if(isset($result['email_notifications'])) $this->email_notifications = $result['email_notifications'];
		if(isset($result['user_password'])) $this->user_password = $result['user_password'];
		return true;
	}

	/**
	 * After-Update operation
	 */
	public function AfterUpdateRecord()
	{
		global $objSettings;
		
		$registration_code = self::GetParameter('registration_code', false);
		$is_active         = self::GetParameter('is_active', false);
		$removed_update_clause = ((self::GetParameter('is_removed', false) == '1') ? ', is_active = 0' : '');
		$confirm_update_clause = '';
		
		$sql = 'SELECT user_name, user_password, preferred_language FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.$this->curRecordId;
		$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
		$preferred_language = isset($result['preferred_language']) ? $result['preferred_language'] : '';
		$user_password = isset($result['user_password']) ? $result['user_password'] : '';

		if(!empty($registration_code) && $is_active && $this->reg_confirmation == 'by admin'){
			$confirm_update_clause = ', registration_code=\'\'';	
			////////////////////////////////////////////////////////////
			send_email(
				self::GetParameter('email', false),
				$objSettings->GetParameter('admin_email'),
				'registration_approved_by_admin',
				array(
					'{FIRST NAME}' => self::GetParameter('first_name', false),
					'{LAST NAME}'  => self::GetParameter('last_name', false),
					'{USER NAME}'  => self::GetParameter('user_name', false),
					'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
					'{BASE URL}'   => APPHP_BASE,
					'{YEAR}' 	   => date('Y')
				),
				$preferred_language
			);
			////////////////////////////////////////////////////////////
		}		

		$sql = 'UPDATE '.$this->tableName.'
				SET notification_status_changed = IF(email_notifications <> \''.$this->email_notifications.'\', \''.date('Y-m-d H:i:s').'\', notification_status_changed)
				    '.$removed_update_clause.'
					'.$confirm_update_clause.'
				WHERE '.$this->primaryKey.' = '.$this->curRecordId;		
		database_void_query($sql);

        // send email, if password was changed
		if($user_password != $this->user_password){
			////////////////////////////////////////////////////////////
			send_email(
				self::GetParameter('email', false),
				$objSettings->GetParameter('admin_email'),
				'password_changed_by_admin',
				array(
					'{FIRST NAME}'    => self::GetParameter('first_name', false),
					'{LAST NAME}'     => self::GetParameter('last_name', false),
					'{USER NAME}'     => $result['user_name'],
					'{USER PASSWORD}' => self::GetParameter('user_password', false),
					'{WEB SITE}'      => $_SERVER['SERVER_NAME']
				),
				$preferred_language
			);
			////////////////////////////////////////////////////////////			
		}

		return true;
	}

	/**
	 * After-Addition operation
	 */
	public function AfterInsertRecord()
	{
		global $objSettings, $objSiteDescription;		

		////////////////////////////////////////////////////////////
		if(!empty($this->params['email'])){			
			send_email(
				$this->params['email'],
				$objSettings->GetParameter('admin_email'),
				'new_account_created_by_admin',
				array(
					'{FIRST NAME}' => $this->params['first_name'],
					'{LAST NAME}'  => $this->params['last_name'],
					'{USER NAME}'  => $this->params['user_name'],
					'{USER PASSWORD}' => $this->params['user_password'],
					'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
					'{BASE URL}'   => APPHP_BASE,
					'{YEAR}' 	   => date('Y')
				),
				$this->params['preferred_language']
			);		
		}
		////////////////////////////////////////////////////////////
	}

	/**
	 * Send activation email
	 *		@param $email
	 */
	public static function Reactivate($email)
	{		
		global $objSettings;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			self::$static_error = _OPERATION_BLOCKED;
			return false;
		}
		
		if(!empty($email)){
			if(check_email_address($email)){
				$sql = 'SELECT id, first_name, last_name, user_name, registration_code, preferred_language, is_active ';
				if(!PASSWORDS_ENCRYPTION){
					$sql .= ', user_password ';
				}else{
					if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
						$sql .= ', AES_DECRYPT(user_password, \''.PASSWORDS_ENCRYPT_KEY.'\') as user_password ';
					}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
						$sql .= ', \'\' as user_password ';
					}				
				}
				$sql .= 'FROM '.TABLE_CUSTOMERS.' WHERE email = \''.encode_text($email).'\'';				
				$temp = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
				if(is_array($temp) && count($temp) > 0){
					if($temp['registration_code'] != '' && $temp['is_active'] == '0'){
						////////////////////////////////////////////////////////		
						if(!PASSWORDS_ENCRYPTION){
							$user_password = $temp['user_password'];
						}else{
							if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
								$user_password = $temp['user_password'];
							}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
								$user_password = get_random_string(8);
								$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET user_password = \''.md5($user_password).'\' WHERE id = '.(int)$temp['id'];
								database_void_query($sql);
							}				
						}
						
						send_email(
							$email,
							$objSettings->GetParameter('admin_email'),
							'new_account_created_confirm_by_email',
							array(
								'{FIRST NAME}' => $temp['first_name'],
								'{LAST NAME}'  => $temp['last_name'],
								'{USER NAME}'  => $temp['user_name'],
								'{USER PASSWORD}' => $user_password,
								'{REGISTRATION CODE}' => $temp['registration_code'],
								'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
								'{BASE URL}'   => APPHP_BASE,
								'{YEAR}' 	   => date('Y')
							),
							$temp['preferred_language']
						);
						////////////////////////////////////////////////////////
						return true;					
					}else{
						self::$static_error = _EMAILS_SENT_ERROR;
						return false;						
					}
				}else{
					self::$static_error = _EMAIL_NOT_EXISTS;
					return false;
				}				
			}else{
				self::$static_error = _EMAIL_IS_WRONG;
				return false;								
			}
		}else{
			self::$static_error = _EMAIL_EMPTY_ALERT;
			return false;
		}
		return true;
	}

	/**
	 * Before Edit Record
	 */
	public function BeforeEditRecord()
	{
		$user_name = isset($this->result[0][0]['user_name']) ? $this->result[0][0]['user_name'] : '';		
		$registration_code = isset($this->result[0][0]['registration_code']) ? $this->result[0][0]['registration_code'] : '';
		$is_active = isset($this->result[0][0]['is_active']) ? $this->result[0][0]['is_active'] : '';
		$reactivation_html = '';
		
        if($registration_code != '' && !$is_active && $this->reg_confirmation == 'by email'){
			$reactivation_html = ' &nbsp;<a href="javascript:void(\'email|reactivate\')" onclick="javascript:if(confirm(\''._PERFORM_OPERATION_COMMON_ALERT.'\'))__mgDoPostBack(\''.TABLE_CUSTOMERS.'\', \'reactivate\');">[ '._REACTIVATION_EMAIL.' ]</a>';
		}
		$this->arrEditModeFields['separator_3']['email']['post_html'] = $reactivation_html;
		
		// hide password fields for "without account" customers
		if(empty($user_name)){
			$this->arrEditModeFields['separator_4']['user_password']['visible'] = false;
		}
	}

	/**
	 *	Returns DataSet array
	 *	    @param $where_clause
	 *		@param $order_clause
	 *		@param $limit_clause
	 */
	public function GetAllCustomers($where_clause = '', $order_clause = '', $limit_clause = '')
	{
		$sql = 'SELECT * FROM '.$this->tableName.' WHERE is_active = 1 '.$where_clause.' '.$order_clause.' '.$limit_clause;
		if($this->debug) $this->arrSQLs['select_get_all'] = $sql;					
		return database_query($sql, DATA_AND_ROWS);
	}

	//==========================================================================
    // STATIC METHODS
	//==========================================================================
	/**
	 * Send forgotten password
	 *		@param $email
	 */
	public static function SendPassword($email)
	{		
		global $objSettings;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			self::$static_error = _OPERATION_BLOCKED;
			return false;
		}
		
		if(!empty($email)) {
			if(check_email_address($email)){   
				if(!PASSWORDS_ENCRYPTION){
					$sql = 'SELECT id, first_name, last_name, user_name, user_password, preferred_language FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\' AND is_active = 1';
				}else{
					if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
						$sql = 'SELECT id, first_name, last_name, user_name, AES_DECRYPT(user_password, \''.PASSWORDS_ENCRYPT_KEY.'\') as user_password, preferred_language FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\' AND is_active = 1';
					}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
						$sql = 'SELECT id, first_name, last_name, user_name, \'\' as user_password, preferred_language FROM '.TABLE_CUSTOMERS.' WHERE email = \''.$email.'\' AND is_active = 1';
					}				
				}
				
				$temp = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
				if(is_array($temp) && count($temp) > 0){
					$sender = $objSettings->GetParameter('admin_email');
					$recipiant = $email;

					if(!PASSWORDS_ENCRYPTION){
						$user_password = $temp['user_password'];
					}else{
						if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){
							$user_password = $temp['user_password'];
						}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
							$user_password = get_random_string(8);
							$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET user_password = \''.md5($user_password).'\' WHERE id = '.$temp['id'];
							database_void_query($sql);
						}				
					}

					////////////////////////////////////////////////////////////
					send_email(
						$recipiant,
						$sender,
						'password_forgotten',
						array(
							'{FIRST NAME}' => $temp['first_name'],
							'{LAST NAME}'  => $temp['last_name'],
							'{USER NAME}'  => $temp['user_name'],
							'{USER PASSWORD}' => $user_password,
							'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
							'{BASE URL}'   => APPHP_BASE,
							'{YEAR}' 	   => date('Y')
						),
						$temp['preferred_language']
					);
					////////////////////////////////////////////////////////////
					
					return true;					
				}else{
					self::$static_error = _EMAIL_NOT_EXISTS;
					return false;
				}				
			}else{
				self::$static_error = _EMAIL_IS_WRONG;
				return false;								
			}
		}else{
			self::$static_error = _EMAIL_IS_EMPTY;
			return false;
		}
		return true;
	}
	
	/**
	 * Returns static error description
	 */
	public static function GetStaticError()
	{
		return self::$static_error;
	}	
	
	/**
	 * Reset customer account
	 * 		@param $email
	 */
	public static function ResetAccount($email)
	{
		global $objSettings;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			self::$static_error = _OPERATION_BLOCKED;
			return false;
		}
		
		if(!empty($email)) {
			if(check_email_address($email)){
			
				$sql = 'SELECT * FROM '.TABLE_CUSTOMERS.' WHERE user_name = \'\' AND email = \''.encode_text($email).'\'';
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){
					
					$user_name = $email;
					$new_password = get_random_string(8);
					if(!PASSWORDS_ENCRYPTION){
						$user_password = encode_text($new_password);
					}else{
						if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'aes'){					
							$user_password = 'AES_ENCRYPT(\''.encode_text($new_password).'\', \''.PASSWORDS_ENCRYPT_KEY.'\')';
						}else if(strtolower(PASSWORDS_ENCRYPTION_TYPE) == 'md5'){
							$user_password = 'MD5(\''.encode_text($new_password).'\')';
						}
					}
					
					$sql = 'UPDATE '.TABLE_CUSTOMERS.'
							SET user_name = \''.encode_text($user_name).'\', user_password = '.$user_password.'
							WHERE email = \''.encode_text($email).'\'';
					database_void_query($sql);

					////////////////////////////////////////////////////////////
					send_email(
						$email,
						$objSettings->GetParameter('admin_email'),
						'new_account_created',
						array(
							'{FIRST NAME}' => $result[0]['first_name'],
							'{LAST NAME}'  => $result[0]['last_name'],
							'{USER NAME}'  => $user_name,
							'{USER PASSWORD}' => $new_password,
							'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
							'{BASE URL}'   => APPHP_BASE
						),
						$result[0]['preferred_language']
					);
					////////////////////////////////////////////////////////////					
					return true;
				}else{
					self::$static_error = _WRONG_PARAMETER_PASSED;
					return false;
				}
			}else{
				self::$static_error = _EMAIL_IS_WRONG;
				return false;								
			}
		}else{
			self::$static_error = _EMAIL_IS_EMPTY;
			return false;
		}
	}
	
	/**
	 *	Get number of customers awaiting aproval
	 */
	public static function AwaitingAprovalCount()
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_CUSTOMERS.' WHERE is_active = 0 AND registration_code != \'\'';
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			return $result[0]['cnt'];
		}
		return '0';
	}
	
	/**
	 *	Returns customer info
	 *		@param $customer_id
	 *		@param $draw
	 */
	public static function DrawCustomerInfo($customer_id, $draw = true)
	{
		$sql = 'SELECT
				c.'.$this->primaryKey.',
				c.*,
				CONCAT(c.first_name, " ", c.last_name) as full_name,
				IF(c.user_name != "", c.user_name, "<span class=gray>'._WITHOUT_ACCOUNT.'</span>") as mod_user_name,
				c.is_active,
				cnt.name as country_name,
				cg.name as group_name									
			FROM '.$this->tableName.' c
				LEFT OUTER JOIN '.TABLE_COUNTRIES.' cnt ON c.b_country = cnt.abbrv AND cnt.is_active = 1
				LEFT OUTER JOIN '.TABLE_CUSTOMER_GROUPS.' cg ON c.group_id = cg.id ';		
		
	}
	
			
}
?>