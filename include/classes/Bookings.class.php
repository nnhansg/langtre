<?php

/**
 *	Class Bookings
 *  -------------- 
 *  Description : encapsulates bookings properties
 *	Usage       : HotelSite ONLY
 *  Updated	    : 11.06.2012
 *	Written by  : ApPHP
 *
 *	PUBLIC:						STATIC:						PRIVATE:                    PROTECTED
 *  -----------					-----------					-----------                 -------------------
 *  __construct             	RemoveExpired           	CalculateFirstNightPrice	OnItemCreated_ViewMode
 *  __destruct                  DrawBookingStatusBlock		GetVatPercentDecimalPoints
 *  DrawBookingDescription
 *  BeforeDeleteRecord
 *  AfterDeleteRecord
 *  OnItemCreated_ViewMode
 *  CleanUpBookings
 *  CleanUpCreditCardInfo
 *  UpdateRoomNumbers
 *  RecalculateExtras
 *  UpdatePaymentDate
 *  DrawBookingInvoice
 *  SendInvoice
 *  CancelRecord
 *  DrawBookingStatus
 *  GetBookingRoomsList
 *  GetBookingExtrasList
 *  PrepareInvoiceDownload
 *  OnItemCreated_ViewMode
 *  
 **/


class Bookings extends MicroGrid {
	
	protected $debug = false;
	
	//------------------------------
	public $message;
	
	//------------------------------
	private $page;
	private $user_id;
	private $rooms_amount;
	private $booking_number;
	private $booking_status;
	private $booking_customer_id;
	private $booking_is_admin_reserv;
	private $fieldDateFormat;
	private $vat_included_in_price;
	private $online_credit_card_required;
	private $customers_cancel_reservation;
	private $default_currency_info;
	private $currencyFormat;
	private $arr_payment_types;
	private $arr_payment_methods;
	private $statuses_vm;
	private $objBookingSettings = null;
	private $sqlFieldDatetimeFormat = '';
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct($user_id = '') {
		
		parent::__construct();
		
		global $objSettings, $objLogin;

		$this->params = array();		
		if(isset($_POST['status']))               $this->params['status'] = prepare_input($_POST['status']);
		if(isset($_POST['hotel_reservation_id'])) $this->params['hotel_reservation_id'] = prepare_input($_POST['hotel_reservation_id']);
		if(isset($_POST['additional_payment']))   $this->params['additional_payment'] = prepare_input($_POST['additional_payment']);
		if(isset($_POST['additional_info']))      $this->params['additional_info'] = prepare_input($_POST['additional_info']);

		$this->vat_included_in_price      	= ModulesSettings::Get('booking', 'vat_included_in_price');
		$this->online_credit_card_required 	= ModulesSettings::Get('booking', 'online_credit_card_required');
		$this->customers_cancel_reservation = ModulesSettings::Get('booking', 'customers_cancel_reservation');

		$this->params['language_id'] = MicroGrid::GetParameter('language_id');
		$rid = self::GetParameter('rid');
	
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_BOOKINGS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->message      = '';
		$this->booking_number = '';
		$this->rooms_amount = '';
		$this->booking_status = '';
		$this->booking_customer_id = '';
		$this->booking_is_admin_reserv = '0';
		$arr_statuses = array('0'=>_PREPARING, '1'=>_RESERVED, '2'=>_COMPLETED, '3'=>_REFUNDED);
		$this->statuses_vm = array('0' => '<span style=color:#0000a3>'._PREPARING.'</span>',
								 '1' => '<span style=color:#a3a300>'._RESERVED.'</span>',
								 '2' => '<span style=color:#00a300>'._COMPLETED.'</span>',
								 '3' => '<span style=color:#660000>'._REFUNDED.'</span>',
								 '4' => '<span style=color:#a30000>'._PAYMENT_ERROR.'!</span>',
								 '5' => '<span style=color:#939393>'._CANCELED.'</span>',
								 '-1' => _UNKNOWN);

		$this->arr_payment_types = array('0'=>_PAY_ON_ARRIVAL, '1'=>_ONLINE, '2'=>_PAYPAL, '3'=>'2CO', '4'=>'Authorize.Net', '5'=>_BANK_TRANSFER, '6'=>_UNKNOWN);
		$this->arr_payment_methods = array('0'=>_PAYMENT_COMPANY_ACCOUNT, '1'=>_CREDIT_CARD, '2'=>_ECHECK, '3'=>_UNKNOWN);

		if($user_id != ''){
			$this->user_id = $user_id;
			$this->page = 'customer=my_bookings';
			$this->actions   = array('add'=>false, 'edit'=>false, 'details'=>false, 'delete'=>false);
			$arr_statuses_filter = array('1'=>_RESERVED, '2'=>_COMPLETED, '3'=>_REFUNDED);
			$arr_statuses_edit = array('1'=>_RESERVED, '2'=>_COMPLETED);
			$arr_statuses_edit_completed = array('2'=>_COMPLETED, '3'=>_REFUNDED);
		}else{
			$this->user_id = '';
			$this->page = 'admin=mod_booking_bookings';
			$this->actions = array('add'=>false, 'edit'=>true, 'details'=>false, 'delete'=>true);
			$arr_statuses_filter = array('0'=>_PREPARING, '1'=>_RESERVED, '2'=>_COMPLETED, '3'=>_REFUNDED, '4'=>_PAYMENT_ERROR, '5'=>_CANCELED);
			$arr_statuses_edit = array('1'=>_RESERVED, '2'=>_COMPLETED, '3'=>_REFUNDED);
			$arr_statuses_edit_completed = array('2'=>_COMPLETED, '3'=>_REFUNDED);
		}
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->formActionURL = 'index.php?'.$this->page;		

		$this->allowLanguages = false;
		$this->languageId  	= ''; // ($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();

		$this->WHERE_CLAUSE = '';
		$hotels_list = '';
		if($this->user_id != ''){
			$this->WHERE_CLAUSE = 'WHERE '.$this->tableName.'.is_admin_reservation = 0 AND
				                         '.$this->tableName.'.status <> 0 AND
			                             '.$this->tableName.'.customer_id = '.(int)$this->user_id;
		}else if($objLogin->IsLoggedInAs('hotelowner')){
			$hotels = $objLogin->AssignedToHotels();
			$hotels_list = implode(',', $hotels);
			if(!empty($hotels_list)) $this->WHERE_CLAUSE .= 'WHERE '.TABLE_BOOKINGS_ROOMS.'.hotel_id IN ('.$hotels_list.') ';
		}
		$this->GROUP_BY_CLAUSE = 'GROUP BY '.$this->tableName.'.booking_number';
		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.created_date DESC'; // ORDER BY date_created DESC
		
		$this->isAlterColorsAllowed = true;
		$this->isPagingAllowed = true;
		$this->pageSize = 30;
		$this->isSortingAllowed = true;		
		$this->isExportingAllowed = ($user_id != '') ? false : true;
		$this->arrExportingTypes = array('csv'=>true);
		
		$date_format_settings = get_date_format('view', true);

		// prepare hotels array		
		$total_hotels = Hotels::GetAllActive((!empty($hotels_list) ? TABLE_HOTELS.'.id IN ('.$hotels_list.')' : ''));
		$arr_hotels = array();
		foreach($total_hotels[0] as $key => $val){
			$arr_hotels[$val['id']] = $val['name'];
		}

		// prepare countries array		
		$total_countries = Countries::GetAllCountries('priority_order DESC, name ASC');
		$arr_countries = array();
		foreach($total_countries[0] as $key => $val){
			$arr_countries[$val['abbrv']] = $val['name'];
		}
		
		$this->default_currency_info = Currencies::GetDefaultCurrencyInfo();
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$this->fieldDateFormat = 'M d, Y';
			$this->sqlFieldDateFormat = '%b %d, %Y';
			$this->sqlFieldDatetimeFormat = '%b %d, %Y %H:%i';
		}else{
			$this->fieldDateFormat = 'd M, Y';
			$this->sqlFieldDateFormat = '%d %b, %Y';
			$this->sqlFieldDatetimeFormat = '%d %b, %Y %H:%i';
		}
		$this->currencyFormat = get_currency_format();

		$this->isFilteringAllowed = true;
		// define filtering fields
		$this->arrFilteringFields = array(
			_BOOKING.' #' => array('table'=>$this->tableName, 'field'=>'booking_number', 'type'=>'text', 'sign'=>'like%', 'width'=>'90px'),
			_HOTELS       => array('table'=>TABLE_BOOKINGS_ROOMS, 'field'=>'hotel_id', 'type'=>'dropdownlist', 'source'=>$arr_hotels, 'sign'=>'=', 'width'=>'', 'visible'=>(($this->user_id != '') ? false : true)),
		);
		if($this->user_id == '') $this->arrFilteringFields[_CUSTOMER] = array('table'=>TABLE_CUSTOMERS, 'field'=>'user_name', 'type'=>'text', 'sign'=>'like%', 'width'=>'90px');
		$this->arrFilteringFields[_STATUS] = array('table'=>$this->tableName, 'field'=>'status', 'type'=>'dropdownlist', 'source'=>$arr_statuses_filter, 'sign'=>'=', 'width'=>'');
		$this->arrFilteringFields[_DATE]   = array('table'=>$this->tableName, 'field'=>'payment_date', 'type'=>'calendar', 'date_format'=>$date_format_settings, 'sign'=>'like%', 'width'=>'82px', 'visible'=>true);

		$this->isAggregateAllowed = true;
		// define aggregate fields for View Mode
		$this->arrAggregateFields = array(
			'tp_w_currency' => array('function'=>'SUM', 'align'=>'center', 'aggregate_by'=>'tp_wo_currency', 'decimal_place'=>2),
		);

		//---------------------------------------------------------------------- 
		// VIEW MODE
		//----------------------------------------------------------------------

        // set locale time names
		$this->SetLocale(Application::Get('lc_time_name'));
		
		$this->VIEW_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.booking_number,
								'.$this->tableName.'.hotel_reservation_id,
								'.$this->tableName.'.booking_description,
								'.$this->tableName.'.additional_info,
								'.$this->tableName.'.order_price,
								'.$this->tableName.'.vat_fee,
								'.$this->tableName.'.vat_percent,
								'.$this->tableName.'.payment_sum,
								'.$this->tableName.'.currency,
								'.$this->tableName.'.customer_id,
								'.$this->tableName.'.transaction_number,
								(SELECT GROUP_CONCAT(DATE_FORMAT(checkin, "'.$this->sqlFieldDateFormat.'"), " - " ,DATE_FORMAT(checkout, "'.$this->sqlFieldDateFormat.'") SEPARATOR "<br>") FROM '.TABLE_BOOKINGS_ROOMS.' br WHERE br.booking_number = '.$this->tableName.'.booking_number) as mod_checkin_checkout,
								DATE_FORMAT('.$this->tableName.'.created_date, "'.$this->sqlFieldDatetimeFormat.'") as created_date_formated,
								DATE_FORMAT('.$this->tableName.'.payment_date, "'.$this->sqlFieldDateFormat.'") as payment_date_formated,
								'.$this->tableName.'.payment_type,
								'.$this->tableName.'.payment_method,
								IF('.$this->tableName.'.status > 5, -1, '.$this->tableName.'.status) as status,
								IF('.$this->tableName.'.is_admin_reservation = 0, CONCAT("<a href=\"javascript:void(\'customer|view\')\" onclick=\"open_popup(\'popup.ajax.php\',\'customer\',\'", '.$this->tableName.'.customer_id, "\')\">", CONCAT('.TABLE_CUSTOMERS.'.last_name, " ", '.TABLE_CUSTOMERS.'.first_name), "</a>"), "{administrator}") as customer_name,
								'.TABLE_CURRENCIES.'.symbol,
								CASE
									WHEN '.TABLE_CURRENCIES.'.symbol_placement = \'left\' THEN
										CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.payment_sum + '.$this->tableName.'.additional_payment)
					                ELSE
										CONCAT('.$this->tableName.'.payment_sum + '.$this->tableName.'.additional_payment, '.TABLE_CURRENCIES.'.symbol)
								END as tp_w_currency,
								('.$this->tableName.'.payment_sum + '.$this->tableName.'.additional_payment) as tp_wo_currency,
								IF('.$this->tableName.'.status = 2, CONCAT("<nobr><a href=\"javascript:void(\'invoice\')\" onclick=\"javascript:__mgDoPostBack(\''.$this->tableName.'\', \'invoice\', \'", '.$this->tableName.'.'.$this->primaryKey.', "\')\">[ ", "'._INVOICE.'", " ]</a></nobr>"), "<span class=lightgray>'._INVOICE.'</span>") as link_order_invoice,
								CONCAT("<nobr><a href=\"javascript:void(\'description\')\" onclick=\"javascript:__mgDoPostBack(\''.$this->tableName.'\', \'description\', \'", '.$this->tableName.'.'.$this->primaryKey.', "\')\">[ ", "'._DESCRIPTION.'", " ]</a></nobr>") as link_order_description,
								IF(
									'.$this->tableName.'.status = 1 AND ((SELECT DATEDIFF(br.checkin, \''.@date('Y-m-d').'\') FROM '.TABLE_BOOKINGS_ROOMS.' br WHERE br.checkin > \''.@date('Y-m-d').'\' AND br.booking_number = '.$this->tableName.'.booking_number ORDER BY br.checkin ASC LIMIT 0, 1) >= '.$this->customers_cancel_reservation.'),
									CONCAT("<nobr><a href=\"javascript:void(0);\" title=\"'._BUTTON_CANCEL.'\" onclick=\"javascript:__mgMyDoPostBack(\''.TABLE_BOOKINGS.'\', \'cancel\', \'", '.$this->tableName.'.'.$this->primaryKey.', "\');\">[ '._BUTTON_CANCEL.' ]</a></nobr>"),
									"<span class=lightgray>'._BUTTON_CANCEL.'</span>"
								) as link_cust_order_cancel,
								IF('.$this->tableName.'.status != 5, CONCAT("<nobr><a href=\"javascript:void(0);\" title=\"'._BUTTON_CANCEL.'\" onclick=\"javascript:__mgMyDoPostBack(\''.TABLE_BOOKINGS.'\', \'cancel\', \'", '.$this->tableName.'.'.$this->primaryKey.', "\');\">[ '._BUTTON_CANCEL.' ]</a></nobr>"), "<span class=lightgray>'._BUTTON_CANCEL.'</span>") as link_admin_order_cancel,
								'.TABLE_CUSTOMERS.'.b_country
							FROM '.$this->tableName.'
								INNER JOIN '.TABLE_BOOKINGS_ROOMS.' ON '.$this->tableName.'.booking_number = '.TABLE_BOOKINGS_ROOMS.'.booking_number
								INNER JOIN '.TABLE_CURRENCIES.' ON '.$this->tableName.'.currency = '.TABLE_CURRENCIES.'.code
								LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.$this->tableName.'.customer_id = '.TABLE_CUSTOMERS.'.id
							';		

							//'.$this->tableName.'.coupon_code,
							//'.$this->tableName.'.discount_campaign_id,

		// define view mode fields
		if($this->user_id != ''){
			$this->arrViewModeFields = array(
				//'created_date_formated'  => array('title'=>_DATE_CREATED, 'type'=>'label', 'align'=>'left', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'booking_number'    	 => array('title'=>_BOOKING_NUMBER, 'type'=>'label', 'align'=>'left', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'mod_checkin_checkout'   => array('title'=>_CHECK_IN.' - '._CHECK_OUT, 'type'=>'label', 'align'=>'left', 'width'=>'100px', 'height'=>'', 'maxlength'=>''),
				'payment_type'           => array('title'=>_METHOD, 'type'=>'enum',  'align'=>'center', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'source'=>$this->arr_payment_types),
				'tp_w_currency'   		 => array('title'=>_PAYMENT_SUM, 'type'=>'label', 'align'=>'right', 'width'=>'100px', 'height'=>'', 'maxlength'=>'', 'sort_by'=>'tp_wo_currency', 'sort_type'=>'numeric', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
				'status'                 => array('title'=>_STATUS, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$this->statuses_vm),
				'link_order_description' => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap'),
				'link_order_invoice'     => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'75px', 'height'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap'),
				'link_cust_order_cancel' => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap', 'visible'=>(($this->customers_cancel_reservation > '0') ? true : false)),
			);			
		}else{
			$this->arrViewModeFields = array(
				//'created_date_formated'   => array('title'=>_DATE_CREATED, 'type'=>'label', 'align'=>'left', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'booking_number'    	  => array('title'=>_BOOKING_NUMBER, 'type'=>'label', 'align'=>'left', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'mod_checkin_checkout'    => array('title'=>_CHECK_IN.' - '._CHECK_OUT, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'payment_type'            => array('title'=>_METHOD, 'type'=>'enum',  'align'=>'center', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'source'=>$this->arr_payment_types),
				'customer_name'   		  => array('title'=>_CUSTOMER, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'b_country'               => array('title'=>_COUNTRY, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_countries),
				'tp_w_currency'   		  => array('title'=>_PAYMENT, 'type'=>'label', 'align'=>'right', 'width'=>'', 'height'=>'', 'maxlength'=>'', 'sort_by'=>'tp_wo_currency', 'sort_type'=>'numeric', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
				'status'                  => array('title'=>_STATUS, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$this->statuses_vm),
				'link_order_description'  => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'link_order_invoice'      => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
				'link_admin_order_cancel' => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
			);						
		}
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
			
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.booking_number,
								'.$this->tableName.'.hotel_reservation_id,
								'.$this->tableName.'.booking_number as booking_number_label,
								'.$this->tableName.'.booking_description,
								'.$this->tableName.'.additional_info,
								'.$this->tableName.'.order_price,
								CASE
									WHEN '.$this->tableName.'.pre_payment_type = "first night" THEN CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.pre_payment_value)
									WHEN '.$this->tableName.'.pre_payment_type = "fixed sum" THEN CONCAT("'.$this->default_currency_info['symbol'].'", '.$this->tableName.'.pre_payment_value)
									WHEN '.$this->tableName.'.pre_payment_type = "percentage" THEN CONCAT('.$this->tableName.'.pre_payment_value, "%")
									ELSE ""
								END as mod_pre_payment,
								CASE
									WHEN '.TABLE_CURRENCIES.'.symbol_placement = "left" THEN CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.payment_sum)
					                ELSE CONCAT('.$this->tableName.'.payment_sum, '.TABLE_CURRENCIES.'.symbol)
								END as mod_payment_sum,
								IF((('.$this->tableName.'.order_price - '.$this->tableName.'.discount_fee) + '.$this->tableName.'.initial_fee + '.$this->tableName.'.extras_fee + '.$this->tableName.'.vat_fee - ('.$this->tableName.'.payment_sum + '.$this->tableName.'.additional_payment) > 0),
								   (('.$this->tableName.'.order_price - '.$this->tableName.'.discount_fee) + '.$this->tableName.'.initial_fee + '.$this->tableName.'.extras_fee + '.$this->tableName.'.vat_fee - ('.$this->tableName.'.payment_sum + '.$this->tableName.'.additional_payment)),
									0) as mod_have_to_pay,								
								'.$this->tableName.'.additional_payment,
								'.$this->tableName.'.vat_fee,
								'.$this->tableName.'.vat_percent,
								CASE
									WHEN '.TABLE_CURRENCIES.'.symbol_placement = "left" THEN CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.vat_fee)
					                ELSE CONCAT('.$this->tableName.'.vat_fee, '.TABLE_CURRENCIES.'.symbol)
								END as mod_vat_fee,
								CASE
									WHEN '.TABLE_CURRENCIES.'.symbol_placement = "left" THEN CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.initial_fee)
					                ELSE CONCAT('.$this->tableName.'.initial_fee, '.TABLE_CURRENCIES.'.symbol)
								END as mod_initial_fee,
								'.$this->tableName.'.payment_sum,
								'.$this->tableName.'.currency,
								'.$this->tableName.'.customer_id,								
								'.$this->tableName.'.cc_type,
								'.$this->tableName.'.cc_holder_name,
								IF(
									LENGTH(AES_DECRYPT('.$this->tableName.'.cc_number, "'.PASSWORDS_ENCRYPT_KEY.'")) = 4,
									CONCAT("...", AES_DECRYPT('.$this->tableName.'.cc_number, "'.PASSWORDS_ENCRYPT_KEY.'"), " ('._CLEANED.')"),
									AES_DECRYPT('.$this->tableName.'.cc_number, "'.PASSWORDS_ENCRYPT_KEY.'")
								) as m_cc_number,								
								'.$this->tableName.'.cc_cvv_code,
								'.$this->tableName.'.cc_expires_month,
								'.$this->tableName.'.cc_expires_year,
								IF('.$this->tableName.'.cc_expires_month != "", CONCAT('.$this->tableName.'.cc_expires_month, "/", '.$this->tableName.'.cc_expires_year), "") as m_cc_expires_date,
								'.$this->tableName.'.transaction_number,
								'.$this->tableName.'.payment_date,
								DATE_FORMAT('.$this->tableName.'.payment_date, "'.$this->sqlFieldDateFormat.'") as payment_date_formated,								
								'.$this->tableName.'.payment_type,
								'.$this->tableName.'.payment_method,
								'.$this->tableName.'.status								
							FROM '.$this->tableName.'
								INNER JOIN '.TABLE_CURRENCIES.' ON '.$this->tableName.'.currency = '.TABLE_CURRENCIES.'.code
								LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.$this->tableName.'.customer_id = '.TABLE_CUSTOMERS.'.id
							';
		if($this->user_id != ''){
			$WHERE_CLAUSE = 'WHERE '.$this->tableName.'.is_admin_reservation = 0 AND
								   '.$this->tableName.'.customer_id = '.$this->user_id.' AND
			                       '.$this->tableName.'.'.$this->primaryKey.' = _RID_';
			$this->EDIT_MODE_SQL = $this->EDIT_MODE_SQL.' WHERE TRUE = FALSE';					   
		}else{
			$WHERE_CLAUSE = 'WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';
			$this->EDIT_MODE_SQL = $this->EDIT_MODE_SQL.$WHERE_CLAUSE;
		}		

		// prepare trigger
		$sql = 'SELECT
					vat_percent,
					status,
					payment_type,
					IF(TRIM(cc_number) = "" OR LENGTH(AES_DECRYPT(cc_number, "'.PASSWORDS_ENCRYPT_KEY.'")) <= 4, "hide", "show") as cc_number_trigger
				FROM '.$this->tableName.' WHERE id = '.(int)$rid;
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$cc_number_trigger = $result[0]['cc_number_trigger'];
			$status_trigger = $result[0]['status'];
			$payment_type = $result[0]['payment_type'];
			$vat_percent = ' ('.Currencies::PriceFormat($result[0]['vat_percent'], '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($result[0]['vat_percent'])).')';			
		}else{
			$cc_number_trigger = 'hide';
			$status_trigger = '0';
			$payment_type = '0';
			$vat_percent = '';
		}		

		// define edit mode fields
		$this->arrEditModeFields = array(
			'booking_number_label' => array('title'=>_BOOKING_NUMBER, 'type'=>'label'),			
			'hotel_reservation_id' => array('title'=>_HOTEL_RESERVATION_ID, 'header_tooltip'=>_INTERNAL_USE_TOOLTIP, 'type'=>'textbox', 'required'=>false, 'width'=>'210px', 'readonly'=>false, 'maxlength'=>'32', 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>(($this->user_id != '') ? false : true)),
			'booking_number'     => array('title'=>'', 'type'=>'hidden', 'required'=>false, 'default'=>''),
			'customer_id'        => array('title'=>'', 'type'=>'hidden', 'required'=>false, 'default'=>''),
			'payment_type'       => array('title'=>_PAYMENT_TYPE, 'type'=>'enum', 'width'=>'', 'required'=>true, 'readonly'=>true, 'default'=>'', 'source'=>$this->arr_payment_types, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>''),
			'payment_method'     => array('title'=>_PAYMENT_METHOD, 'type'=>'enum', 'width'=>'', 'required'=>true, 'readonly'=>true, 'default'=>'', 'source'=>$this->arr_payment_methods, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>''),
			'mod_initial_fee'    => array('title'=>_INITIAL_FEE, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
			'mod_vat_fee'        => array('title'=>_VAT, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2', 'post_html'=>$vat_percent),
			'mod_payment_sum'    => array('title'=>_PAYMENT_SUM, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
			'mod_pre_payment'    => array('title'=>_PRE_PAYMENT, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
			'additional_payment' => array('title'=>_ADDITIONAL_PAYMENT, 'header_tooltip'=>_ADDITIONAL_PAYMENT_TOOLTIP, 'type'=>'textbox',  'width'=>'100px', 'required'=>false, 'readonly'=>(($status_trigger == '1' || $status_trigger == '2') ? false : true), 'maxlength'=>'10', 'default'=>'', 'validation_type'=>'float', 'validation_maximum'=>'10000000', 'unique'=>false, 'visible'=>true, 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
			'mod_have_to_pay'    => array('title'=>_PAYMENT_REQUIRED, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2'),
			'status'  			 => array('title'=>_STATUS, 'type'=>'enum', 'width'=>'110px', 'required'=>true, 'readonly'=>(($status_trigger >= '2') ? true : false), 'source'=>$arr_statuses_edit),
		);
		if($this->user_id != ''){
			$this->arrEditModeFields['status'] = array('title'=>_STATUS, 'type'=>'enum', 'width'=>'110px', 'required'=>true, 'readonly'=>(($status_trigger >= '2') ? true : false), 'source'=>$arr_statuses_edit);
		}else{			
			$this->arrEditModeFields['status']      = array('title'=>_STATUS, 'type'=>'enum', 'width'=>'110px', 'required'=>true, 'readonly'=>false, 'source'=>(($status_trigger >= '2') ? $arr_statuses_edit_completed : $arr_statuses_edit));
			if($payment_type == '1'){ // on-line orders only!
				$this->arrEditModeFields['cc_type'] 	= array('title'=>_CREDIT_CARD_TYPE, 'type'=>'label');
				$this->arrEditModeFields['cc_holder_name'] 	= array('title'=>_CREDIT_CARD_HOLDER_NAME, 'type'=>'label');
				$this->arrEditModeFields['m_cc_number'] = array('title'=>_CREDIT_CARD_NUMBER, 'type'=>'label', 'post_html'=>(($cc_number_trigger == 'show') ? '&nbsp;[ <a href="javascript:void(0);" onclick="if(confirm(\''._PERFORM_OPERATION_COMMON_ALERT.'\')) __mgDoPostBack(\''.$this->tableName.'\', \'clean_credit_card\', \''.$rid.'\')">'._REMOVE.'</a> ]' : ''));
				$this->arrEditModeFields['m_cc_expires_date'] = array('title'=>_CREDIT_CARD_EXPIRES, 'type'=>'label');
				$this->arrEditModeFields['cc_cvv_code'] = array('title'=>_CVV_CODE, 'type'=>'label');
			}
			$this->arrEditModeFields['additional_info'] = array('title'=>_ADDITIONAL_INFO, 'type'=>'textarea', 'width'=>'390px', 'height'=>'90px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'required'=>false, 'validation_type'=>'', 'validation_maxlength'=>'1024', 'unique'=>false);
		}

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------		
		$this->DETAILS_MODE_SQL = $this->VIEW_MODE_SQL.$WHERE_CLAUSE;

		$this->arrDetailsModeFields = array(

			'booking_number'  	 => array('title'=>_BOOKING_NUMBER, 'type'=>'label'),
			'booking_description'  => array('title'=>_DESCRIPTION, 'type'=>'label'),
			'order_price'  		 => array('title'=>_ORDER_PRICE, 'type'=>'label'),
			'vat_fee'  		     => array('title'=>_VAT, 'type'=>'label'),
			'vat_percent'  		 => array('title'=>_VAT_PERCENT, 'type'=>'label'),
			'payment_sum'  		 => array('title'=>_PAYMENT_SUM, 'type'=>'label'),
			'currency'  		 => array('title'=>_CURRENCY, 'type'=>'label'),
			'customer_name'      => array('title'=>_CUSTOMER, 'type'=>'label'),
			'transaction_number' => array('title'=>_TRANSACTION, 'type'=>'label'),
			'payment_date_formated' => array('title'=>_DATE, 'type'=>'label'),
			'payment_type'       => array('title'=>_PAYMENT_TYPE, 'type'=>'enum', 'source'=>$this->arr_payment_types),
			'payment_method'     => array('title'=>_PAYMENT_METHOD, 'type'=>'enum', 'source'=>$this->arr_payment_methods),
			//'coupon_code'  	 => array('title'=>'', 'type'=>'label'),
			//'discount_campaign_id' => array('title'=>'', 'type'=>'label'),
			'status'  	         => array('title'=>_STATUS, 'type'=>'label'),
			'additional_info'    => array('title'=>_ADDITIONAL_INFO, 'type'=>'label'),
		);
	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }
	
	/**
	 *	Cancel record
	 */
	public function CancelRecord($rid)
	{
		global $objLogin;
		
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'UPDATE '.$this->tableName.'
				SET
					status = 5,
					status_changed = \''.date('Y-m-d H:i:s').'\',
					status_description = \''.(($objLogin->IsLoggedInAsAdmin() ? _CANCELED_BY_ADMIN : _CANCELED_BY_CUSTOMER)).'\'
				WHERE '.$this->primaryKey.' = '.(int)$rid;
		if(!database_void_query($sql)) return false;
		return true; 
	}	
	
	/**
	 *	Draws order invoice
	 */
	public function DrawBookingInvoice($rid, $text_only = false, $type = 'html', $draw = true)
	{
		global $objSiteDescription, $objSettings, $objLogin;
		
		$output = '';
		$output_pdf = array();
		$oid = isset($rid) ? (int)$rid : '0';
		$language_id = Languages::GetDefaultLang();
		$hotels_count = Hotels::HotelsCount();
		
		$sql = 'SELECT
					'.$this->tableName.'.'.$this->primaryKey.',
					'.$this->tableName.'.booking_number,
					'.$this->tableName.'.hotel_reservation_id,
					'.$this->tableName.'.booking_description,
					'.$this->tableName.'.additional_info,
					'.$this->tableName.'.discount_fee,
					'.$this->tableName.'.discount_percent,
					'.$this->tableName.'.coupon_code, 
					'.$this->tableName.'.order_price,
					'.$this->tableName.'.vat_fee,
					'.$this->tableName.'.vat_percent,
					'.$this->tableName.'.initial_fee,					
					'.$this->tableName.'.payment_sum,
					'.$this->tableName.'.pre_payment_type,
					'.$this->tableName.'.pre_payment_value,
					CASE
						WHEN '.$this->tableName.'.pre_payment_type = \'first night\' THEN CONCAT('.TABLE_CURRENCIES.'.symbol, '.$this->tableName.'.pre_payment_value)
						WHEN '.$this->tableName.'.pre_payment_type = \'fixed sum\' THEN CONCAT("'.$this->default_currency_info['symbol'].'", '.$this->tableName.'.pre_payment_value)
						WHEN '.$this->tableName.'.pre_payment_type = \'percentage\' THEN CONCAT('.$this->tableName.'.pre_payment_value, "%")
						ELSE \'\'
					END as mod_pre_payment,					
					'.$this->tableName.'.additional_payment,
					'.$this->tableName.'.extras,
					'.$this->tableName.'.extras_fee,
					'.$this->tableName.'.cc_type,
					'.$this->tableName.'.cc_holder_name,
					'.$this->tableName.'.cc_expires_month,
					'.$this->tableName.'.cc_expires_year,
					'.$this->tableName.'.cc_cvv_code, 					
					'.$this->tableName.'.currency,
					'.$this->tableName.'.customer_id,
					'.$this->tableName.'.transaction_number,
					'.$this->tableName.'.is_admin_reservation,
					DATE_FORMAT('.$this->tableName.'.created_date, \''.$this->sqlFieldDatetimeFormat.'\') as created_date_formated,					
					DATE_FORMAT('.$this->tableName.'.payment_date, \''.$this->sqlFieldDatetimeFormat.'\') as payment_date_formated,					
					'.$this->tableName.'.payment_type,
					'.$this->tableName.'.payment_method,
					'.TABLE_CURRENCIES.'.symbol,
					'.TABLE_CURRENCIES.'.symbol_placement,
					CONCAT("<a href=\"index.php?'.$this->page.'&mg_action=description&oid=", '.$this->tableName.'.'.$this->primaryKey.', "\">", "'._DESCRIPTION.'", "</a>") as link_order_description,
					'.TABLE_CUSTOMERS.'.first_name,
					'.TABLE_CUSTOMERS.'.last_name,					
					'.TABLE_CUSTOMERS.'.email as customer_email,
					'.TABLE_CUSTOMERS.'.company as customer_company,
					'.TABLE_CUSTOMERS.'.b_address,
					'.TABLE_CUSTOMERS.'.b_address_2,
					'.TABLE_CUSTOMERS.'.b_city,
					'.TABLE_CUSTOMERS.'.b_state,
					'.TABLE_CUSTOMERS.'.b_zipcode, 
					'.TABLE_COUNTRIES.'.name as country_name,
					'.TABLE_CAMPAIGNS.'.campaign_name
				FROM '.$this->tableName.'
					INNER JOIN '.TABLE_CURRENCIES.' ON '.$this->tableName.'.currency = '.TABLE_CURRENCIES.'.code
					LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.$this->tableName.'.customer_id = '.TABLE_CUSTOMERS.'.id
					LEFT OUTER JOIN '.TABLE_COUNTRIES.' ON '.TABLE_CUSTOMERS.'.b_country = '.TABLE_COUNTRIES.'.abbrv AND '.TABLE_COUNTRIES.'.is_active = 1
					LEFT OUTER JOIN '.TABLE_CAMPAIGNS.' ON '.$this->tableName.'.discount_campaign_id = '.TABLE_CAMPAIGNS.'.id
				WHERE
					'.$this->tableName.'.'.$this->primaryKey.' = '.(int)$oid;

				if($this->user_id != ''){
					$sql .= ' AND '.$this->tableName.'.is_admin_reservation = 0 AND '.$this->tableName.'.customer_id = '.(int)$this->user_id;
				}
					
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			// for pdf export
			if($type == 'pdf'){
				$output_pdf['is_admin_reservation'] = ($result[0]['is_admin_reservation'] == '1') ? '1' : '0';
				$output_pdf['invoice_number'] = $result[0]['id'];
				$output_pdf['first_name'] = ($result[0]['is_admin_reservation'] == '0') ? _FIRST_NAME.': '.$result[0]['first_name'] : '';
				$output_pdf['last_name'] = ($result[0]['is_admin_reservation'] == '0') ? _LAST_NAME.': '.$result[0]['last_name'] : '';
				$output_pdf['email'] = ($result[0]['is_admin_reservation'] == '0') ? _EMAIL_ADDRESS.': '.$result[0]['customer_email'] : '';
				$output_pdf['company'] = ($result[0]['is_admin_reservation'] == '0') ? _COMPANY.': '.$result[0]['customer_company'] : '';
				$output_pdf['address'] = ($result[0]['is_admin_reservation'] == '0') ? _ADDRESS.': '.$result[0]['b_address'].' '.$result[0]['b_address_2'] : '';
				$output_pdf['city'] = ($result[0]['is_admin_reservation'] == '0') ? $result[0]['b_city'].' '.$result[0]['b_state'] : '';
				$output_pdf['country'] = ($result[0]['is_admin_reservation'] == '0') ? $result[0]['country_name'].' '.$result[0]['b_zipcode'] : '';			
				$output_pdf['created_date'] = $result[0]['created_date_formated'];
				$output_pdf['booking_number'] = $result[0]['booking_number'];
				$output_pdf['booking_description'] = $result[0]['booking_description'];
				$output_pdf['transaction_number'] = $result[0]['transaction_number'];
				$output_pdf['payment_date'] = $result[0]['payment_date_formated'];
				$output_pdf['payment_type'] = $this->arr_payment_types[$result[0]['payment_type']];
				$output_pdf['payment_method'] = $this->arr_payment_methods[$result[0]['payment_method']];				
				$output_pdf['booking_price'] = Currencies::PriceFormat($result[0]['order_price'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
				$output_pdf['booking_currency'] = $result[0]['symbol'];

				if($result[0]['campaign_name'] != '') $output_pdf['discount'] = Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '.$result[0]['campaign_name'].')';
				else if($result[0]['coupon_code'] != '') $output_pdf['discount'] = Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '._COUPON_CODE.': '.$result[0]['coupon_code'].')';
				else $output_pdf['discount'] = '';
				
				$output_pdf['booking_subtotal'] = (($result[0]['campaign_name'] != '') ? '('._AFTER_DISCOUNT.') ' : '').Currencies::PriceFormat($result[0]['order_price']-$result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
				$output_pdf['extras_subtotal'] = (!empty($result[0]['extras'])) ? Currencies::PriceFormat($result[0]['extras_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat) : '';
				$output_pdf['initial_fee'] = (!empty($result[0]['initial_fee'])) ? Currencies::PriceFormat($result[0]['initial_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat) : '';
				$output_pdf['vat_fee'] = ($this->vat_included_in_price == 'no') ? (Currencies::PriceFormat($result[0]['vat_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['vat_percent'], '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($result[0]['vat_percent'])).') ') : '';

				if($result[0]['pre_payment_type'] == 'first night'){
					$output_pdf['pre_payment'] = Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('._FIRST_NIGHT.')';
				}else if($result[0]['pre_payment_type'] == 'percentage' && $result[0]['pre_payment_value'] > 0 && $result[0]['pre_payment_value'] < 100){
					$output_pdf['pre_payment'] = Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.$result[0]['pre_payment_value'].'%)';
				}else if($result[0]['pre_payment_type'] == 'fixed sum' && $result[0]['pre_payment_value'] > 0){
					$output_pdf['pre_payment'] = Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['pre_payment_value'], $result[0]['symbol'], $result[0]['symbol_placement']).')';
				}else{
					$output_pdf['pre_payment'] = _FULL_PRICE;
				}
				$output_pdf['additional_payment'] = Currencies::PriceFormat($result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
				$output_pdf['total'] = Currencies::PriceFormat($result[0]['payment_sum'] + $result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);				
			}
			

			$part = '<table '.((Application::Get('lang_dir') == 'rtl') ? 'dir="rtl"' : '').' width="100%" border="0" cellspacing="0" cellpadding="0">';
			if($text_only && ModulesSettings::Get('booking', 'mode') == 'TEST MODE'){
				$part .= '<tr><td colspan="2"><div style="text-align:center;padding:10px;color:#a60000;border:1px dashed #a60000;width:100px">TEST MODE!</div></td></tr>';
			}

			$part .= '<tr><td colspan="2">'._DATE_CREATED.': '.$result[0]['created_date_formated'].'</td></tr>
				      <tr><td colspan="2" nowrap="nowrap" height="10px"></td></tr>';
			$part .= '<tr>
					<td valign="top">						
						<h3>'._CUSTOMER_DETAILS.':</h3>';
						if($result[0]['is_admin_reservation'] == '1'){							
							$part .= _ADMIN_RESERVATION.'<br />';
						}else{
							$part .= _FIRST_NAME.': '.$result[0]['first_name'].'<br />';         
							$part .= _LAST_NAME.': '.$result[0]['last_name'].'<br />';           
							$part .= _EMAIL_ADDRESS.': '.$result[0]['customer_email'].'<br />';  
							$part .= _COMPANY.': '.$result[0]['customer_company'].'<br />';      
							$part .= _ADDRESS.': '.$result[0]['b_address'].' '.$result[0]['b_address_2'].'<br />';  
							$part .= $result[0]['b_city'].' '.$result[0]['b_state'].'<br />';    
							$part .= $result[0]['country_name'].' '.$result[0]['b_zipcode'];	 
						}
			$part .= '</td>
					<td valign="top" align="'.Application::Get('defined_right').'">';
					if($hotels_count == 1){
						$hotel_info = Hotels::GetHotelFullInfo(0, $language_id);
						$part .= '<h3>'.$hotel_info['name'].'</h3>';
						$part .= _ADDRESS.': '.$hotel_info['address'].'<br />';
						$part .= _PHONE.': '.$hotel_info['phone'].'<br />';
						$part .= _FAX.': '.$hotel_info['fax'].'<br />';
						$part .= _EMAIL_ADDRESS.': '.$hotel_info['email'].'<br />';
					}
					$part .= '</td>
				</tr>
				<tr><td colspan="2" nowrap="nowrap" height="10px"></td></tr>
				<tr>
					<td colspan="2">';						
						$part .= '<table width="100%" border="0" cellspacing="0" cellpadding="3" style="border:1px solid #d1d2d3">';
						$part .= '<tr style=background-color:#e1e2e3;font-weight:bold;font-size:13px;"><th align="left" colspan="2">&nbsp;<b>'._BOOKING_DETAILS.'</b></th></tr>';
						$part .= '<tr><td width="25%">&nbsp;'._BOOKING_NUMBER.': </td><td>'.$result[0]['booking_number'].'</td></tr>';
						if($objLogin->IsLoggedInAsAdmin() && $result[0]['hotel_reservation_id'] != '') $part .= '<tr><td>&nbsp;'._HOTEL_RESERVATION_ID.': </td><td>'.$result[0]['hotel_reservation_id'].'</td></tr>';
						$part .= '<tr><td>&nbsp;'._DESCRIPTION.': </td><td>'.$result[0]['booking_description'].'</td></tr>';
						$part .= '</table><br />';									
						
						$part .= '<table width="100%" border="0" cellspacing="0" cellpadding="3" style="border:1px solid #d1d2d3">';
						$part .= '<tr style="background-color:#e1e2e3;font-weight:bold;font-size:13px;"><th align="left" colspan="2">&nbsp;<b>'._PAYMENT_DETAILS.'</b></th></tr>';
						$part .= '<tr><td width="25%">&nbsp;'._TRANSACTION.': </td><td>'.$result[0]['transaction_number'].'</td></tr>';
						$part .= '<tr><td>&nbsp;'._DATE_PAYMENT.': </td><td>'.$result[0]['payment_date_formated'].'</td></tr>';
						$part .= '<tr><td>&nbsp;'._PAYMENT_TYPE.': </td><td>'.$this->arr_payment_types[$result[0]['payment_type']].'</td></tr>';
						$part .= '<tr><td>&nbsp;'._PAYMENT_METHOD.': </td><td>'.$this->arr_payment_methods[$result[0]['payment_method']].'</td></tr>';

						$part .= '<tr><td>&nbsp;'._BOOKING_PRICE.': </td><td>'.Currencies::PriceFormat($result[0]['order_price'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';

						if($result[0]['campaign_name'] != '') $part .= '<tr><td>&nbsp;'._DISCOUNT.': </td><td>- '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '.$result[0]['campaign_name'].')</td></tr>';
						else if($result[0]['coupon_code'] != '') $part .= '<tr><td>&nbsp;'._DISCOUNT.': </td><td>- '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '._COUPON_CODE.': '.$result[0]['coupon_code'].')</td></tr>';

						$part .= '<tr><td>&nbsp;'._BOOKING_SUBTOTAL.(($result[0]['campaign_name'] != '') ? ' ('._AFTER_DISCOUNT.')' : '').': </td><td>'.Currencies::PriceFormat($result[0]['order_price']-$result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						
						if(!empty($result[0]['extras'])) $part .= '<tr><td>&nbsp;'._EXTRAS_SUBTOTAL.': </td><td>'.Currencies::PriceFormat($result[0]['extras_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						if(!empty($result[0]['initial_fee'])) $part .= '<tr><td>&nbsp;'._INITIAL_FEE.': </td><td>'.Currencies::PriceFormat($result[0]['initial_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						if($this->vat_included_in_price == 'no') $part .= '<tr><td>&nbsp;'._VAT.': </td><td>'.Currencies::PriceFormat($result[0]['vat_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['vat_percent'], '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($result[0]['vat_percent'])).')</td></tr>';

						$part .= '<tr><td>&nbsp;'._PAYMENT_SUM.': </td><td>'.Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						
						if($result[0]['pre_payment_type'] == 'first night'){
							$part .= '<tr><td>&nbsp;'._PRE_PAYMENT.'</td><td>'.Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('._FIRST_NIGHT.')</td></tr>';
						}else if($result[0]['pre_payment_type'] == 'percentage' && $result[0]['pre_payment_value'] > 0 && $result[0]['pre_payment_value'] < 100){
							$part .= '<tr><td>&nbsp;'._PRE_PAYMENT.'</td><td>'.Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.$result[0]['pre_payment_value'].'%)</td></tr>';
						}else if($result[0]['pre_payment_type'] == 'fixed sum' && $result[0]['pre_payment_value'] > 0){
							$part .= '<tr><td>&nbsp;'._PRE_PAYMENT.'</td><td>'.Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['pre_payment_value'], $result[0]['symbol'], $result[0]['symbol_placement']).')</td></tr>';
						}else{
							$part .= '<tr><td>&nbsp;'._PRE_PAYMENT.'</td><td>'._FULL_PRICE.'</td></tr>';
						}
						$part .= '<tr><td>&nbsp;'._ADDITIONAL_PAYMENT.': </td><td>'.Currencies::PriceFormat($result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						$part .= '<tr><td>&nbsp;'._TOTAL.': </td><td>'.Currencies::PriceFormat($result[0]['payment_sum'] + $result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
						$part .= '</table><br />';															
				$part .= '</td>';
				$part .= '</tr>';
				$part .= '</table>';
				
			$content = @file_get_contents('html/templates/invoice.tpl');
			if($content){
				$content = str_replace('_TOP_PART_', $part, $content);
				$content = str_replace('_ROOMS_LIST_', $this->GetBookingRoomsList($oid, $language_id), $content);
				$content = str_replace('_EXTRAS_LIST_', Extras::GetExtrasList(unserialize($result[0]['extras']), $result[0]['currency']), $content);
				$content = str_replace('_YOUR_COMPANY_NAME_', $objSiteDescription->GetParameter('header_text'), $content);
				$content = str_replace('_ADMIN_EMAIL_', $objSettings->GetParameter('admin_email'), $content);
			}
			$output .= '<div id="divInvoiceContent">'.$content.'</div>';
		}
		
		if(!$text_only){
			$output .= '<table width="100%" border="0">';
			$output .= '<tr><td colspan="2">&nbsp;</tr>';
			$output .= '<tr>';
			$output .= '  <td colspan="2" align="left"><input type="button" class="mgrid_button" name="btnBack" value="'._BUTTON_BACK.'" onclick="javascript:appGoTo(\''.$this->page.'\');"></td>';
			$output .= '</tr>';			
			$output .= '</table>';
		}
		
		if($draw){
			echo $output;
		}else{
			return ($type == 'pdf') ? $output_pdf : $output;
		}
	}
	
	/**
	 * Send invoice to customer
	 * 		@param $rid
	 */
	public function SendInvoice($rid)
	{
		global $objSettings;
		
		if(strtolower(SITE_MODE) == "demo"){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}
		
		$sql = 'SELECT
					IF(is_admin_reservation = 1, a.email, c.email) as email,
					IF(is_admin_reservation = 1, a.preferred_language, c.preferred_language) as preferred_language
				FROM '.TABLE_BOOKINGS.' b
					LEFT OUTER JOIN '.TABLE_CUSTOMERS.' c ON b.customer_id = c.id
					LEFT OUTER JOIN '.TABLE_ACCOUNTS.' a ON b.customer_id = a.id
				WHERE b.id = '.(int)$rid;		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			
			$recipient = $result[0]['email'];
			$sender    = $objSettings->GetParameter('admin_email');
			$subject   = _INVOICE.' #'.$rid;
			$body      = $this->DrawBookingInvoice($rid, true, 'html', false);
			$preferred_language = $result[0]['preferred_language'];
			//$body      = str_replace('<br />', '', $body);
			
			send_email_wo_template(
				$recipient,
				$sender,
				$subject,
				$body,
				$preferred_language
			);
			
			return true;
		}
		
		$this->error = _EMAILS_SENT_ERROR;
		return false;		
	}
	
	/**
	 * Draws Booking Description
	 * 		@param $rid
	 * 		@param $mode
	 */
	public function DrawBookingDescription($rid, $mode = '')
	{
		global $objLogin;
		
		$output = '';
		$content = '';
		$oid = isset($rid) ? (int)$rid : '0';
		$language_id = Application::Get('lang');

		$sql = 'SELECT
				'.$this->tableName.'.'.$this->primaryKey.',
				'.$this->tableName.'.booking_number,
				'.$this->tableName.'.hotel_reservation_id,
				'.$this->tableName.'.booking_description,
				'.$this->tableName.'.additional_info,
				'.$this->tableName.'.discount_fee,
				'.$this->tableName.'.discount_percent,
				'.$this->tableName.'.order_price,
				'.$this->tableName.'.vat_fee,
				'.$this->tableName.'.vat_percent,
				'.$this->tableName.'.initial_fee,
				'.$this->tableName.'.payment_sum,
				'.$this->tableName.'.pre_payment_type,
				'.$this->tableName.'.pre_payment_value,
				'.$this->tableName.'.additional_payment,
				'.$this->tableName.'.extras,
				'.$this->tableName.'.extras_fee,
				'.$this->tableName.'.coupon_code,
				'.$this->tableName.'.cc_type,
				'.$this->tableName.'.cc_holder_name,
				CASE
					WHEN LENGTH(AES_DECRYPT('.$this->tableName.'.cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\')) = 4
						THEN CONCAT(\'...\', AES_DECRYPT('.$this->tableName.'.cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\'))
					ELSE AES_DECRYPT('.$this->tableName.'.cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\')
				END as cc_number,
				CONCAT(\'...\', SUBSTRING(AES_DECRYPT(cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\'), -4)) as cc_number_for_customer,
				CASE
					WHEN LENGTH(AES_DECRYPT('.$this->tableName.'.cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\')) = 4
						THEN \' ('._CLEANED.')\'
					ELSE \'\'
				END as cc_number_cleaned,								
				'.$this->tableName.'.cc_expires_month,
				'.$this->tableName.'.cc_expires_year,
				'.$this->tableName.'.cc_cvv_code, 
				'.$this->tableName.'.currency,
				'.$this->tableName.'.customer_id,
				'.$this->tableName.'.transaction_number,
				'.$this->tableName.'.payment_date, 
				DATE_FORMAT('.$this->tableName.'.created_date, \''.(($this->fieldDateFormat == 'M d, Y') ? '%b %d, %Y %h:%i %p' : '%d %b %Y %h:%i %p').'\') as created_date_formated,
				DATE_FORMAT('.$this->tableName.'.payment_date, \''.(($this->fieldDateFormat == 'M d, Y') ? '%b %d, %Y %h:%i %p' : '%d %b %Y %h:%i %p').'\') as payment_date_formated,
				'.$this->tableName.'.payment_type,
				'.$this->tableName.'.payment_method,
				IF('.$this->tableName.'.status > 5, -1, '.$this->tableName.'.status) as status,
				CASE
					WHEN '.$this->tableName.'.is_admin_reservation = 0 THEN
						CASE
							WHEN '.TABLE_CUSTOMERS.'.user_name != \'\' THEN '.TABLE_CUSTOMERS.'.user_name
							ELSE \'without_account\'
						END
					ELSE \'admin\'
				END as customer_name,
				'.TABLE_CURRENCIES.'.symbol,
				'.TABLE_CURRENCIES.'.symbol_placement,
				CONCAT("<a href=\"index.php?'.$this->page.'&mg_action=description&oid=", '.$this->tableName.'.'.$this->primaryKey.', "\">", "'._DESCRIPTION.'", "</a>") as link_order_description,
				'.TABLE_CAMPAIGNS.'.campaign_name
			FROM '.$this->tableName.'
				INNER JOIN '.TABLE_CURRENCIES.' ON '.$this->tableName.'.currency = '.TABLE_CURRENCIES.'.code
				LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.$this->tableName.'.customer_id = '.TABLE_CUSTOMERS.'.id
				LEFT OUTER JOIN '.TABLE_CAMPAIGNS.' ON '.$this->tableName.'.discount_campaign_id = '.TABLE_CAMPAIGNS.'.id
			WHERE
				'.$this->tableName.'.'.$this->primaryKey.' = '.(int)$oid;
				
			if($this->user_id != ''){
				$sql .= ' AND '.$this->tableName.'.is_admin_reservation = 0 AND '.$this->tableName.'.customer_id = '.(int)$this->user_id;
			}
					
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);		
		if($result[1] > 0){
			$content .= '<table '.((Application::Get('lang_dir') == 'rtl') ? 'dir="rtl"' : '').' width="100%" border="0">';
			$content .= '<tr><td width="210px">'._BOOKING_NUMBER.': </td><td>'.$result[0]['booking_number'].'</td></tr>';
			if($objLogin->IsLoggedInAsAdmin()) $content .= '<tr><td>'._HOTEL_RESERVATION_ID.': </td><td>'.$result[0]['hotel_reservation_id'].'</td></tr>';
			$content .= '<tr><td>'._DESCRIPTION.': </td><td>'.$result[0]['booking_description'].'</td></tr>';
			$content .= '<tr><td>'._TRANSACTION.': </td><td>'.$result[0]['transaction_number'].'</td></tr>';
			$content .= '<tr><td>'._DATE_CREATED.': </td><td>'.$result[0]['created_date_formated'].'</td></tr>';
			$content .= '<tr><td>'._DATE_PAYMENT.': </td><td>'.$result[0]['payment_date_formated'].'</td></tr>';
			if($this->user_id == ''){
				$content .= '<tr><td>'._CUSTOMER.': </td><td>';
				if($result[0]['customer_name'] == 'without_account'){
					$content .= '[ '._WITHOUT_ACCOUNT.' ]';
				}else if($result[0]['customer_name'] == 'admin'){
					$content .= _ADMIN;
				}else{
					$content .= $result[0]['customer_name'];
				}
				$content .= '</td></tr>';
			}
			$content .= '<tr><td>'._PAYMENT_TYPE.': </td><td>'.$this->arr_payment_types[$result[0]['payment_type']].'</td></tr>';
			$content .= '<tr><td>'._PAYMENT_METHOD.': </td><td>'.$this->arr_payment_methods[$result[0]['payment_method']].'</td></tr>';
			
			if($result[0]['payment_type'] == '1' && empty($mode)){
				// always show cc info, even if collecting is not requieed
				// $this->collect_credit_card == 'yes'
				$content .= '<tr><td>'._CREDIT_CARD_TYPE.': </td><td>'.$result[0]['cc_type'].'</td></tr>';
				$content .= '<tr><td>'._CREDIT_CARD_HOLDER_NAME.': </td><td>'.$result[0]['cc_holder_name'].'</td></tr>';
				if($this->user_id == ''){
					$content .= '<tr><td>'._CREDIT_CARD_NUMBER.': </td><td>'.$result[0]['cc_number'].$result[0]['cc_number_cleaned'].'</td></tr>';
					$content .= '<tr><td>'._CREDIT_CARD_EXPIRES.': </td><td>'.(($result[0]['cc_expires_month'] != '') ? $result[0]['cc_expires_month'].'/'.$result[0]['cc_expires_year'] : '').'</td></tr>';
					$content .= '<tr><td>'._CVV_CODE.': </td><td>'.$result[0]['cc_cvv_code'].'</td></tr>';				
				}else{
					$content .= '<tr><td>'._CREDIT_CARD_NUMBER.': </td><td>'.$result[0]['cc_number_for_customer'].'</td></tr>';
				}
			}

			$content .= '<tr><td>'._BOOKING_PRICE.': </td><td>'.Currencies::PriceFormat($result[0]['order_price'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
			
			if($result[0]['campaign_name'] != '') $content .= '<tr><td>'._DISCOUNT.': </td><td>- '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '.$result[0]['campaign_name'].')</td></tr>';
			else if($result[0]['coupon_code'] != '') $content .= '<tr><td>'._DISCOUNT.': </td><td>- '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '._COUPON_CODE.': '.$result[0]['coupon_code'].')</td></tr>';
			
			$content .= '<tr><td>'._BOOKING_SUBTOTAL.(($result[0]['campaign_name'] != '') ? ' ('._AFTER_DISCOUNT.')' : '').': </td><td>'.Currencies::PriceFormat($result[0]['order_price']-$result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';	

			if(!empty($result[0]['extras'])) $content .= '<tr><td>'._EXTRAS_SUBTOTAL.': </td><td>'.Currencies::PriceFormat($result[0]['extras_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';			
			if(!empty($result[0]['initial_fee'])) $content .= '<tr><td>'._INITIAL_FEE.': </td><td>'.Currencies::PriceFormat($result[0]['initial_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'</td></tr>';
			if($this->vat_included_in_price == 'no') $content .= '<tr><td>'._VAT.': </td><td>'.Currencies::PriceFormat($result[0]['vat_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['vat_percent'], '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($result[0]['vat_percent'])).')</td></tr>';

			$order_price_plus_vat = Currencies::PriceFormat($result[0]['order_price'] - $result[0]['discount_fee'] + $result[0]['extras_fee'] + $result[0]['initial_fee'] + $result[0]['vat_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
			$payment_sum = Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
			$payment_sum_plus_additional = Currencies::PriceFormat($result[0]['payment_sum'] + $result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
			$have_to_pay = Currencies::PriceFormat($result[0]['order_price'] - $result[0]['discount_fee'] + $result[0]['extras_fee'] + $result[0]['initial_fee'] + $result[0]['vat_fee'] - ($result[0]['payment_sum'] + $result[0]['additional_payment']), $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);
			$additional_payment = Currencies::PriceFormat($result[0]['additional_payment'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat);

			if($result[0]['pre_payment_type'] == 'first night'){
				$content .= '<tr><td>'._PAYMENT_SUM.': </td><td>'.$order_price_plus_vat.'</td></tr>';
				$content .= '<tr><td>'._PRE_PAYMENT.': </td><td>'.$payment_sum.' ('._PARTIAL_PRICE.' - '._FIRST_NIGHT.')</td></tr>';
				if($result[0]['additional_payment'] != 0) $content .= '<tr><td>'._ADDITIONAL_PAYMENT.': </td><td>'.$additional_payment.'</td></tr>';
				if($have_to_pay > 0) $content .= '<tr><td style="color:#a60000">'._PAYMENT_REQUIRED.': </td><td style="color:#a60000">'.$have_to_pay.'</td></tr>';						
			}else if($result[0]['pre_payment_type'] == 'percentage' && $result[0]['pre_payment_value'] > 0 && $result[0]['pre_payment_value'] < 100){
				$content .= '<tr><td>'._PAYMENT_SUM.': </td><td>'.$order_price_plus_vat.'</td></tr>';
				$content .= '<tr><td>'._PRE_PAYMENT.': </td><td>'.$payment_sum.' ('._PARTIAL_PRICE.' - '.$result[0]['pre_payment_value'].'%)</td></tr>';
				if($result[0]['additional_payment'] != 0) $content .= '<tr><td>'._ADDITIONAL_PAYMENT.': </td><td>'.$additional_payment.'</td></tr>';
				if($have_to_pay > 0) $content .= '<tr><td style="color:#a60000">'._PAYMENT_REQUIRED.': </td><td style="color:#a60000">'.$have_to_pay.'</td></tr>';
				$content .= '<tr><td>'._TOTAL.': </td><td>'.$payment_sum_plus_additional.'</td></tr>';
			}else if($result[0]['pre_payment_type'] == 'fixed sum' && $result[0]['pre_payment_value'] > 0){
				$content .= '<tr><td>'._PAYMENT_SUM.': </td><td>'.$order_price_plus_vat.'</td></tr>';
				$content .= '<tr><td>'._PRE_PAYMENT.': </td><td>'.$payment_sum.' ('._PARTIAL_PRICE.' - '.Currencies::PriceFormat($result[0]['pre_payment_value'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).')</td></tr>';
				if($result[0]['additional_payment'] != 0) $content .= '<tr><td>'._ADDITIONAL_PAYMENT.': </td><td>'.$additional_payment.'</td></tr>';
				if($have_to_pay > 0) $content .= '<tr><td style="color:#a60000">'._PAYMENT_REQUIRED.': </td><td style="color:#a60000">'.$have_to_pay.'</td></tr>';
				$content .= '<tr><td>'._TOTAL.': </td><td>'.$payment_sum_plus_additional.'</td></tr>';
			}else{
				$content .= '<tr><td>'._PAYMENT_SUM.': </td><td>'.$payment_sum.'</td></tr>';
				$content .= '<tr><td>'._PRE_PAYMENT.': </td><td>'._FULL_PRICE.'</td></tr>';				
				if($result[0]['additional_payment'] != 0) $content .= '<tr><td>'._ADDITIONAL_PAYMENT.': </td><td>'.$additional_payment.'</td></tr>';
				$content .= '<tr><td>'._TOTAL.': </td><td>'.$payment_sum_plus_additional.'</td></tr>';
			}			
			$content .= '<tr><td>'._STATUS.': </td><td>'.$this->statuses_vm[$result[0]['status']].'</td></tr>';
			if($result[0]['additional_info'] != '') $content .= '<tr><td>'._ADDITIONAL_INFO.': </td><td>'.$result[0]['additional_info'].'</td></tr>';
			$content .= '<tr><td colspan="2">&nbsp;</tr>';
			$content .= '</table>';
			
			$content .= Extras::GetExtrasList(unserialize($result[0]['extras']), $result[0]['currency'], '', (($objLogin->IsLoggedInAsAdmin()) ? 'edit' : 'details'), $oid);
		}else{
			///echo mysql_error();
			$content .= draw_important_message(_WRONG_PARAMETER_PASSED, false);
		}

		$content .= $this->GetBookingRoomsList($oid, $language_id, (($objLogin->IsLoggedInAsAdmin()) ? 'edit' : 'details'));

		$output .= '<div id="divDescriptionContent">'.$content.'</div>';
		if(empty($mode)){
			$output .= '<div>';
			$output .= '<br /><input type="button" class="mgrid_button" name="btnBack" value="'._BUTTON_BACK.'" onclick="javascript:appGoTo(\''.$this->page.'\');">';
			$output .= '</div>';			
		}
		
		echo $output;
	}

	/**
	 * Before-Delete record
	 */
    public function BeforeDeleteRecord()
	{
		$oid = MicroGrid::GetParameter('rid');
		$sql = 'SELECT booking_number, rooms_amount, customer_id, is_admin_reservation, status FROM '.TABLE_BOOKINGS.' WHERE id = '.(int)$oid;		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$this->booking_number = $result[0]['booking_number'];
			$this->rooms_amount = $result[0]['rooms_amount'];
			$this->booking_status = $result[0]['status'];
			$this->booking_customer_id = $result[0]['customer_id'];
			$this->booking_is_admin_reserv = (int)$result[0]['is_admin_reservation'];
			return true;
		}
		return false;
	}
	
	/**
	 *	After-Delete record
	 */	
	public function AfterDeleteRecord()
	{
		global $objLogin;

		$sql = 'DELETE FROM '.TABLE_BOOKINGS_ROOMS.' WHERE booking_number = \''.encode_text($this->booking_number).'\'';
		if($this->user_id != ''){
			$sql .= ' AND '.$this->tableName.'.is_admin_reservation = 0 AND '.$this->tableName.'.customer_id = '.(int)$this->user_id;
		}		
		if(!database_void_query($sql)){ /* echo 'error!'; */ }	 

		// update customer orders/rooms amount
		if($objLogin->IsLoggedIn() && ($this->booking_status > 0) && ($this->booking_is_admin_reserv == '0')){
			$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET
						orders_count = IF(orders_count > 0, orders_count - 1, orders_count),
						rooms_count = IF(rooms_count > 0, rooms_count - '.(int)$this->rooms_amount.', rooms_count)
					WHERE id = '.(int)$this->booking_customer_id;
			database_void_query($sql);
		}
	}

	/**
	 * Trigger method - allows to work with View Mode items
	 */
	protected function OnItemCreated_ViewMode($field_name, &$field_value)
	{
		if($field_name == 'customer_name' && $field_value == '{administrator}'){
			$field_value = _ADMIN;			
		}
    }
	
	/**
	 *	Update Payment Date
	 * 		@param $rid
	 */
	public function UpdatePaymentDate($rid)
	{
		$sql = 'UPDATE '.$this->tableName.'
				SET payment_date = \''.date('Y-m-d H:i:s').'\'
				WHERE
					'.$this->primaryKey.' = '.(int)$rid.' AND 
					status = 2 AND
					(payment_date = \'\' OR payment_date = \'0000-00-00\')';
		database_void_query($sql);		
	}
	
	/**
	 *	Cleans pending reservations
	 */
	public function CleanUpBookings()
	{
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		// delete 'tail' records in booking_rooms table
		$sql = 'DELETE
				FROM '.TABLE_BOOKINGS_ROOMS.'					
				WHERE booking_number NOT IN (SELECT booking_number FROM '.TABLE_BOOKINGS.')';
		database_void_query($sql);

		if($this->RemoveExpired()){
			return true;
		}else{
			$this->error = _NO_RECORDS_PROCESSED;
		}
	}
	
		
	/**
	 *	Cleans credit card info
	 * 		@param $rid
	 */
	public function CleanUpCreditCardInfo($rid)
	{
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'UPDATE '.$this->tableName.'
				SET
					cc_number = AES_ENCRYPT(SUBSTRING(AES_DECRYPT(cc_number, \''.PASSWORDS_ENCRYPT_KEY.'\'), -4), \''.PASSWORDS_ENCRYPT_KEY.'\'),
					cc_cvv_code = \'\',
					cc_expires_month = \'\',
					cc_expires_year = \'\'
				WHERE '.$this->primaryKey.' = '.(int)$rid;
		if(database_void_query($sql)){
			return true;
		}else{
			$this->error = _TRY_LATER;
		}		
	}
	
	/**
	 *	Update room numbers for booking
	 * 		@param $rid
	 * 		@param $room_numbers
	 */
	public function UpdateRoomNumbers($rid, $room_numbers)
	{
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}
		
		$sql = 'UPDATE '.TABLE_BOOKINGS_ROOMS.'
				SET room_numbers = \''.encode_text($room_numbers).'\'
				WHERE '.$this->primaryKey.' = '.(int)$rid;
		return database_void_query($sql);		
	}
	
	/**
	 *	Add extras for booking
	 * 		@param $rid
	 * 		@param $sel_extras
	 * 		@param $extras_amount
	 * 		@param $act
	 */
	public function RecalculateExtras($rid, $sel_extras, $extras_amount, $act = 'add')
	{
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'SELECT booking_number, extras, order_price,
		               vat_percent, vat_fee, pre_payment_type, pre_payment_value,
					   payment_sum, discount_campaign_id, discount_percent, discount_fee,
					   extras_fee, initial_fee, currency
		        FROM '.TABLE_BOOKINGS.' WHERE id = '.(int)$rid;
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$booking_number = $result[0]['booking_number'];			
			$pre_payment_type = $result[0]['pre_payment_type'];
			$pre_payment_value = $result[0]['pre_payment_value'];			
			$order_price = $result[0]['order_price'];
			$vat_percent = $result[0]['vat_percent'];
			$payment_sum = $result[0]['payment_sum'];
			$discount_fee = $result[0]['discount_fee'];
			$extras_fee = $result[0]['extras_fee'];
			$initial_fee = $result[0]['initial_fee'];
			$vat_fee = $result[0]['vat_fee'];
			$currency = $result[0]['currency'];
			$order_sub_total = 0;
			
			//calculate discount
			$discount_percent = $result[0]['discount_percent'];

			//calculate total rooms price
			$order_price = 0;
			$sql = 'SELECT SUM(price) as order_price FROM '.TABLE_BOOKINGS_ROOMS.' WHERE booking_number = \''.$booking_number.'\'';
			$result1 = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result1[1] > 0) $order_price = $result1[0]['order_price'];
			
			//calculate extras ammount
			$temp_array = unserialize($result[0]['extras']);			
			if($act == 'add'){
				if(isset($temp_array[$sel_extras])){
					if(($temp_array[$sel_extras] + $extras_amount) > 100) $temp_array[$sel_extras] = 100;
					else $temp_array[$sel_extras] += $extras_amount;
				}else{
					$temp_array[$sel_extras] = $extras_amount;
				}
			}else{
				unset($temp_array[$sel_extras]);
			}
			$sql = 'SELECT (price * '.$extras_amount.') as extras_price FROM '.TABLE_EXTRAS.' WHERE id = '.(int)$sel_extras;
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] > 0){
				$extras_fee = Extras::GetExtrasSum($temp_array, $currency);
			}
			
			// formula: ((order_price - discount) + initial fee + extras) * VAT
			$order_sub_total = (($order_price - $discount_fee) + $initial_fee + $extras_fee);
			$vat_fee = $order_sub_total * ($vat_percent / 100);
			
			if($pre_payment_type == 'full price'){								
				$payment_sum = $order_sub_total + $vat_fee;			
			}else if($pre_payment_type == 'first night'){
				$payment_sum = $this->CalculateFirstNightPrice($booking_number, $vat_percent);
			}else if($pre_payment_type == 'fixed sum'){
				$payment_sum = $pre_payment_value;
			}else if($pre_payment_type == 'percentage'){				
				$payment_sum = ($order_sub_total + $vat_fee) * ($pre_payment_value / 100);
			}

			// update bookings table
			$sql = 'UPDATE '.TABLE_BOOKINGS.' SET
						extras = \''.serialize($temp_array).'\',
						extras_fee = '.$extras_fee.',
						vat_fee = \''.$vat_fee.'\',						
						payment_sum = \''.$payment_sum.'\',
						pre_payment_value = \''.$pre_payment_value.'\'
					WHERE id = '.(int)$rid;
			database_void_query($sql);
			return true;
		}
		return false;				
	}	

	/**
	 * Returns Extras list for booking
	 * 		@param $oid
	 */
	public function GetBookingExtrasList($oid)
	{
		$output = array();
		$sql = 'SELECT currency, extras FROM '.TABLE_BOOKINGS.' WHERE id = '.(int)$oid;
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$arr_extras = unserialize($result[0]['extras']);
			$currency_info = Currencies::GetCurrencyInfo($result[0]['currency']);
			$symbol = isset($currency_info['symbol']) ? $currency_info['symbol'] : '$';
			foreach($arr_extras as $key => $val){
				$extra = Extras::GetExtrasInfo($key);
				$output[] = array('name'=>$extra['name'], 'unit_price'=>$symbol.$extra['price'], 'units'=>$val, 'price'=>$symbol.($extra['price']*$val), 'price_wo_currency'=>($extra['price']*$val));
			}
		}
		return $output;
	}

	/**
	 * Returns Rooms list for booking
	 * 		@param $oid
	 * 		@param $language_id
	 * 		@param $mode
	 */
	public function GetBookingRoomsList($oid, $language_id, $mode = 'details')
	{
		$output = '';
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');
		$meal_plans_count = MealPlans::MealPlansCount();
		$hotels_count = Hotels::HotelsCount();
		$data = array();

        // display list of rooms in order		
		$sql = 'SELECT
					'.TABLE_BOOKINGS_ROOMS.'.id,
					'.TABLE_BOOKINGS_ROOMS.'.booking_number,
					'.TABLE_BOOKINGS_ROOMS.'.rooms,
					'.TABLE_BOOKINGS_ROOMS.'.room_numbers,
					'.TABLE_BOOKINGS_ROOMS.'.adults,
					'.TABLE_BOOKINGS_ROOMS.'.children,
					DATE_FORMAT('.TABLE_BOOKINGS_ROOMS.'.checkin, \''.$this->sqlFieldDateFormat.'\') as checkin,
					DATE_FORMAT('.TABLE_BOOKINGS_ROOMS.'.checkout, \''.$this->sqlFieldDateFormat.'\') as checkout,
					'.TABLE_BOOKINGS_ROOMS.'.rooms,
					'.TABLE_BOOKINGS_ROOMS.'.price,
					'.TABLE_BOOKINGS_ROOMS.'.guests,
					'.TABLE_BOOKINGS_ROOMS.'.guests_fee,
					'.TABLE_BOOKINGS_ROOMS.'.meal_plan_id,
					'.TABLE_BOOKINGS_ROOMS.'.meal_plan_price,
					'.TABLE_CURRENCIES.'.symbol,
					'.TABLE_CURRENCIES.'.symbol_placement,					
					'.TABLE_ROOMS_DESCRIPTION.'.room_type,
					'.TABLE_MEAL_PLANS_DESCRIPTION.'.name as meal_plan_name,
					'.TABLE_HOTELS_DESCRIPTION.'.name as hotel_name			
				FROM '.TABLE_BOOKINGS_ROOMS.'
					INNER JOIN '.$this->tableName.' ON '.TABLE_BOOKINGS_ROOMS.'.booking_number = '.$this->tableName.'.booking_number
					LEFT OUTER JOIN '.TABLE_ROOMS_DESCRIPTION.' ON '.TABLE_BOOKINGS_ROOMS.'.room_id = '.TABLE_ROOMS_DESCRIPTION.'.room_id AND '.TABLE_ROOMS_DESCRIPTION.'.language_id = \''.encode_text($language_id).'\' 
					LEFT OUTER JOIN '.TABLE_CURRENCIES.' ON '.$this->tableName.'.currency = '.TABLE_CURRENCIES.'.code
					LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.$this->tableName.'.customer_id = '.TABLE_CUSTOMERS.'.id
					LEFT OUTER JOIN '.TABLE_MEAL_PLANS_DESCRIPTION.' ON '.TABLE_BOOKINGS_ROOMS.'.meal_plan_id = '.TABLE_MEAL_PLANS_DESCRIPTION.'.meal_plan_id AND '.TABLE_MEAL_PLANS_DESCRIPTION.'.language_id = \''.encode_text($language_id).'\'
					LEFT OUTER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.TABLE_BOOKINGS_ROOMS.'.hotel_id = '.TABLE_HOTELS_DESCRIPTION.'.hotel_id AND '.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.encode_text($language_id).'\'
				WHERE
					'.$this->tableName.'.'.$this->primaryKey.' = '.(int)$oid.' ';
				if($this->user_id != ''){
					$sql .= ' AND '.$this->tableName.'.is_admin_reservation = 0 AND '.$this->tableName.'.customer_id = '.(int)$this->user_id;
				}

		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		if($result[1] > 0){
			$reservations_total = 0;

			$output .= '<h4>'._RESERVATION_DETAILS.'</h4>';
			$output .= '<table '.((Application::Get('lang_dir') == 'rtl') ? 'dir="rtl"' : '').' width="100%" border="0" cellspacing="0" cellpadding="3" class="tblReservationDetails">';
			$output .= '<thead><tr>';
			$output .= '<th align="center"> # </th>';
			$output .= '<th align="left">'._ROOM_TYPE.'</th>';
			$output .= (($hotels_count > 1) ? '<th align="left">'._HOTEL.'</th>' : '<th></th>');
 			$output .= '<th align="center">'._CHECK_IN.'</th>';
			$output .= '<th align="center">'._CHECK_OUT.'</th>';
			$output .= '<th align="center">'._ROOMS.'</th>';
			$output .= '<th align="center">'._ROOM_NUMBERS.'</th>';
			$output .= '<th align="center">'._ADULT.'</th>';
			$output .= (($allow_children == 'yes') ? '<th align="center">'._CHILD.'</th>' : '<th></th>');
			$output .= (($allow_guests == 'yes') ? '<th align="center">'._GUEST.'</th>' : '<th></th>');
			$output .= (($meal_plans_count) ? '<th align="center">'._MEAL_PLANS.'</th>' : '<th></th>');
			$output .= '<th align="right">'._PRICE.'</th>';
			$output .= '<th width="5px" nowrap="nowrap"></th>';
			$output .= '</tr></thead>';
			
			for($i=0; $i < $result[1]; $i++){			
				if($mode == 'invoice'){
					$data[$i]['room_type'] = $result[0][$i]['room_type'];
					$data[$i]['checkin'] = $result[0][$i]['checkin'];
					$data[$i]['checkout'] = $result[0][$i]['checkout'];
					$data[$i]['rooms'] = $result[0][$i]['rooms'];
					$data[$i]['room_numbers'] = decode_text($result[0][$i]['room_numbers']);
					$data[$i]['adults'] = decode_text($result[0][$i]['adults']);
					$data[$i]['children'] = ($allow_children == 'yes') ? $result[0][$i]['children'] : '';
					$data[$i]['guests'] = ($allow_guests == 'yes') ? $result[0][$i]['guests'] : '';
					$data[$i]['guests_fee'] = ($allow_guests == 'yes') ? $result[0][$i]['guests_fee'] : '';
					$data[$i]['price'] = Currencies::PriceFormat($result[0][$i]['price'], $result[0][$i]['symbol'], $result[0][$i]['symbol_placement'], $this->currencyFormat);
					$data[$i]['price_wo_currency'] = $result[0][$i]['price'];
					$data[$i]['meal_plan_name'] = ($meal_plans_count) ? $result[0][$i]['meal_plan_name'] : '';
					$data[$i]['meal_plan_price'] = ($meal_plans_count) ? $result[0][$i]['meal_plan_price'] : 0;
					$data[$i]['hotel_name'] = ($hotels_count > 1) ? $result[0][$i]['hotel_name'] : '';
				}			

				$output .= '<tr>';
				$output .= '<td align="center" width="40px">'.($i+1).'.</td>';
				$output .= '<td align="left">'.$result[0][$i]['room_type'].'</td>';
				$output .= ($hotels_count > 1) ? '<td align="left">'.$result[0][$i]['hotel_name'].'</td>' : '<td></td>';				
				$output .= '<td align="center">'.$result[0][$i]['checkin'].'</td>';
				$output .= '<td align="center">'.$result[0][$i]['checkout'].'</td>';
				$output .= '<td align="center">'.$result[0][$i]['rooms'].'</td>';
				if($mode == 'edit'){
					$output .= '<td align="center">';
					$output .= '<form name="frmBookingDescription" action="index.php?admin=mod_booking_bookings" method="post">';
					$output .= draw_hidden_field('mg_action', 'update_room_numbers', false);
					$output .= draw_hidden_field('mg_rid', $oid, false);
					$output .= draw_hidden_field('rdid', $result[0][$i]['id'], false);
					$output .= draw_token_field(false);
					$output .= '<input type="textbox" name="room_numbers" size="8" maxlength="12" value="'.decode_text($result[0][$i]['room_numbers']).'" />&nbsp;';
					$output .= '<label style="display:none;">'.decode_text($result[0][$i]['room_numbers']).'</label>';
					$output .= '<input type="submit" class="mgrid_button" name="btnSubmit" value="'._BUTTON_UPDATE.'" />';
					$output .= '</form>';
					$output .= '</td>';	
				}else{
					$output .= '<td align="center">'.$result[0][$i]['room_numbers'].'</td>';	
				}				
				$output .= '<td align="center">'.$result[0][$i]['adults'].'</td>';
				$output .= ($allow_children == 'yes') ? ' <td align="center">'.$result[0][$i]['children'].'</td>' : ' <td></td>';
				$output .= ($allow_guests == 'yes') ? ' <td align="center">'.$result[0][$i]['guests'].(!empty($result[0][$i]['guests']) ? ' ('.Currencies::PriceFormat($result[0][$i]['guests_fee'], $result[0][0]['symbol'], $result[0][0]['symbol_placement'], $this->currencyFormat).')' : '').'</td>' : ' <td></td>';
				$output .= ($meal_plans_count) ? ' <td align="center">'.(!empty($result[0][$i]['meal_plan_name']) ? $result[0][$i]['meal_plan_name'].' ('.Currencies::PriceFormat($result[0][$i]['meal_plan_price'], $result[0][$i]['symbol'], $result[0][$i]['symbol_placement'], $this->currencyFormat).')' : '').'</td>' : '<td></td>';
				$output .= '<td align="right">'.Currencies::PriceFormat($result[0][$i]['price'], $result[0][$i]['symbol'], $result[0][$i]['symbol_placement'], $this->currencyFormat).'</td>';
				$output .= '<td></td>';
				$output .= '</tr>';
				$reservations_total += ($result[0][$i]['price'] + $result[0][$i]['meal_plan_price'] + $result[0][$i]['guests_fee']);
			}
			if($reservations_total > 0){
				$output .= '<tr>';
				$output .= '<td colspan="9"></td>';
				$output .= '<td colspan="3" align="right"><span>&nbsp;<b>'._TOTAL.': &nbsp;&nbsp;&nbsp;'.Currencies::PriceFormat($reservations_total, $result[0][0]['symbol'], $result[0][0]['symbol_placement'], $this->currencyFormat).'</b>&nbsp;</span></td>';
				$output .= '<td></td>';
				$output .= '</tr>';					
			}
			$output .= '</table>';			
		}		
		
		if($mode == 'invoice') return $data;
		else return $output;
	}
	
	//==========================================================================
    // Static Methods
	//==========================================================================
	/**
	 * Remove expired 'Preparing' bookings
	 */
	public static function RemoveExpired()
	{
		global $objSettings;
		
		$preparing_orders_timeout = (int)ModulesSettings::Get('booking', 'preparing_orders_timeout');
		$sender = $objSettings->GetParameter('admin_email');
		// preapre datetime format
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$fieldDateFormat = 'M d, Y';
		}else{
			$fieldDateFormat = 'd M, Y';
		}
		$currencyFormat = get_currency_format();
		$language_id = Languages::GetDefaultLang();
		$hotels_count = Hotels::HotelsCount();

		if($preparing_orders_timeout > 0){
			
			$sql_delete = 'DELETE FROM '.TABLE_BOOKINGS.' WHERE status = 0 AND TIMESTAMPDIFF(HOUR, created_date, \''.date('Y-m-d H:i:s').'\') >= '.(int)$preparing_orders_timeout;
			
			if(ModulesSettings::Get('booking', 'reservation_expired_alert') == 'yes'){
				$sql = 'SELECT
							'.TABLE_BOOKINGS.'.customer_id,
							'.TABLE_CUSTOMERS.'.first_name,
							'.TABLE_CUSTOMERS.'.last_name,
							'.TABLE_CUSTOMERS.'.preferred_language,
							'.TABLE_CUSTOMERS.'.email,
							'.TABLE_BOOKINGS.'.booking_number,
							'.TABLE_BOOKINGS.'.created_date,
							'.TABLE_BOOKINGS.'.booking_description,
							'.TABLE_BOOKINGS.'.rooms_amount,
							'.TABLE_BOOKINGS.'.order_price,
							'.TABLE_BOOKINGS.'.currency
						FROM '.TABLE_BOOKINGS.'
							LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.TABLE_BOOKINGS.'.customer_id = '.TABLE_CUSTOMERS.'.id
						WHERE '.TABLE_BOOKINGS.'.status = 0 AND
							TIMESTAMPDIFF(HOUR, '.TABLE_BOOKINGS.'.created_date, \''.date('Y-m-d H:i:s').'\') >= '.(int)$preparing_orders_timeout;
				
				$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
				if($result[1] > 0){
					$hotel_description = '';
					if($hotels_count == 1){
						$hotel_info = Hotels::GetHotelFullInfo(0, $language_id);
						$hotel_description .= $hotel_info['name'].'<br>';
						$hotel_description .= $hotel_info['address'].'<br>';
						$hotel_description .= _PHONE.':'.$hotel_info['phone'];
						if($hotel_info['fax'] != '') $hotel_description .= ', '._FAX.':'.$hotel_info['fax'];
					}
	
					for($i=0; $i < $result[1]; $i++){	
						$booking_details  = _BOOKING_DESCRIPTION.': '.$result[0][$i]['booking_description'].'<br />';
						$booking_details .= _CREATED_DATE.': '.format_datetime($result[0][$i]['created_date'], $fieldDateFormat.' H:i:s', '', true).'<br />';
						$booking_details .= _ROOMS.': '.$result[0][$i]['rooms_amount'].'<br />';
						$booking_details .= _BOOKING_PRICE.': '.Currencies::PriceFormat($result[0][$i]['order_price'], $result[0][$i]['currency'], 'left', $currencyFormat).'<br />';
						
						$recipient = $result[0][$i]['email'];
						$preferred_language = $result[0][$i]['preferred_language'];
						send_email(
							$recipient,
							$sender,
							'reservation_expired',
							array(
								'{FIRST NAME}' => $result[0][$i]['first_name'],
								'{LAST NAME}'  => $result[0][$i]['last_name'],
								'{BOOKING DETAILS}' => $booking_details,
								'{HOTEL INFO}' => ((!empty($hotel_description)) ? '<br>-----<br>'.$hotel_description : ''),
							),
							$preferred_language
						);
					}	
					return database_void_query($sql_delete);
				}							
			}else{
				return database_void_query($sql_delete);
			}			
		}
		return false;
	}
	
	/**
	 * Draw booking status
	 * 		@param $booking_number
	 */
	public function DrawBookingStatus($booking_number = '')
	{			
		global $objSettings;
		$output = '';
		
		$sql = 'SELECT b.id
				FROM '.TABLE_BOOKINGS.' b
				WHERE
					(b.status = 1 OR b.status = 2) AND
					 b.booking_number = \''.$booking_number.'\'';
						
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			echo '<div style="float:'.Application::Get('defined_right').'"><a style="text-decoration:none;" href="javascript:void(\'booking|preview\')" onclick="javascript:appPreview(\'booking\');"><img src="images/printer.png" alt="" /> '._PRINT.'</a></div>';
			$this->DrawBookingDescription($result[0]['id'], 'check booking');
		}else{
			draw_important_message(_NO_BOOKING_FOUND);
		}
	}	
	
	/**
	 *	Draws booking status block
	 *		@param $draw
	 */
	public static function DrawBookingStatusBlock($draw = true)
	{
		$output = '<form action="index.php?page=check_status" id="check-booking-form" name="check-booking-form" method="post">
			'.draw_hidden_field('task', 'check_status', false, 'task').'
			'.draw_token_field(false).'
			<table cellspacing="2" border="0">
			<tr><td>'._ENTER_BOOKING_NUMBER.':</td></tr>
			<tr><td><input type="text" name="booking_number" maxlength="20" autocomplete="off" value="" /></td></tr>
			<tr><td style="height:3px"></td></tr>
			<tr><td><input class="button" type="submit" value="'._CHECK_STATUS.'" /></td></tr>
			</table>
		</form>';
	
		if($draw) echo $output;
		else return $output;
	}
	
	/**
	 *	Calculate first night price for booking
	 *		@param $booking_number
	 *		@param $vat_percent
	 */
	private function CalculateFirstNightPrice($booking_number, $vat_percent)
	{
		$first_night_price = 0;
		$first_night_calculating_type = ModulesSettings::Get('booking', 'first_night_calculating_type');
		
		$sql = 'SELECT checkin, checkout, price, room_id 
				FROM '.TABLE_BOOKINGS_ROOMS.'
				WHERE booking_number = \''.$booking_number.'\'';
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		if($result[1] > 0){
			for($i=0; $i < $result[1]; $i++){
				if($first_night_calculating_type == 'average'){
					// formula: total_sum / number of nights			
					$first_night_price += $result[0][$i]['price'] / nights_diff($result[0][$i]['checkin'], $result[0][$i]['checkout']);
				}else{
					// formula: real price for first day
					$temp = Rooms::GetPriceForDate($result[0][$i]['room_id'], $result[0][$i]['checkin']);
					$first_night_price += $temp * (1 + $vat_percent / 100);
				}				
			}	
		}		
		
		return $first_night_price;
	}
	
	/**
	 * Get Vat Percent decimal points
	 * 		@param $vat_percent
	 */
	private function GetVatPercentDecimalPoints($vat_percent = '0')
	{
		return (substr($vat_percent, -1) == '0') ? 2 : 3;
	}
	
	
	/**
	 * Prepare Invoice Download
	 * 		@param $rid
	 */
	public function PrepareInvoiceDownload($rid)
	{
		if(strtolower(SITE_MODE) == "demo"){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		global $objSettings;
		
		$data = $this->DrawBookingInvoice($rid, false, 'pdf', false);
		$hotel_info = Hotels::GetHotelFullInfo();
		$hotels_count = Hotels::HotelsCount();
		
		//$pdf = new FPDF('P', 'pt', 'Letter'); /* Create fpdf object */		
        define('FPDF_FONTPATH', 'modules/tfpdf/font/');
        $pdf = new tFPDF();

        // Add a Unicode font (uses UTF-8)
        $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $pdf->SetFont('DejaVu','',9);        
		$pdf->SetTextColor(22,22,22);            /* Set the font color */		
		$pdf->SetFont('DejaVu', '', 24);      /* Set base font to start */		
		$pdf->AddPage();                      /* Add a new page to the document */		
		$pdf->SetXY(5, 5);                  /* Set the x,y coordinates of the cursor */
		
		$pdf->Cell(0,15, _INVOICE.' No: '.$data['invoice_number'], 'B', 0, 'L');
		$pdf->Cell(0,5, '', 0, 1, 'L');
		
		$pdf->SetFont('DejaVu','',9);        /* Reset the font */
		$pdf->SetXY(5, 20);                  /* Reset the cursor, write again. */		
		$pdf->Cell(0, 8, _DATE_CREATED.': '.$data['created_date'], 0, 2, 'L');	

		$pdf->SetXY(5, 28);                  /* Reset the cursor, write again. */		
		$pdf->SetFont('DejaVu','',11);       /* Reset the font */
		$pdf->Cell(0,10, _CUSTOMER_DETAILS.':', 0, 0, 'L');    $pdf->Cell(0,10, (($hotels_count == 1) ? $hotel_info['name'] : ''), 0, 1, 'R');
		
		$pdf->SetFont('DejaVu','',9);        /* Reset the font */
		if($data['is_admin_reservation'] == '1'){
			$pdf->Cell(0,5, _ADMIN_RESERVATION, 0, 0, 'L');     if(!empty($hotel_info['address'])) $pdf->Cell(0,5, (($hotels_count == 1) ? _ADDRESS.': '.str_replace("\r\n", ' ', $hotel_info['address']) : ''), 0, 1, 'R');
																if(!empty($hotel_info['phone'])) $pdf->Cell(0,5, (($hotels_count == 1) ? _PHONE.': '.$hotel_info['phone'] : ''), 0, 1, 'R');
																if(!empty($hotel_info['fax'])) $pdf->Cell(0,5, (($hotels_count == 1) ? _FAX.': '.$hotel_info['fax'] : ''), 0, 1, 'R');
																if(!empty($hotel_info['email'])) $pdf->Cell(0,5, (($hotels_count == 1) ? _EMAIL_ADDRESS.': '.$hotel_info['email'] : ''), 0, 1, 'R');			
		}else{
			$pdf->Cell(0,5, $data['first_name'], 0, 0, 'L');       $pdf->Cell(0,5, (($hotels_count == 1) ? _ADDRESS.': '.$hotel_info['address'] : ''), 0, 1, 'R');
			$pdf->Cell(0,5, $data['last_name'], 0, 0, 'L');        $pdf->Cell(0,5, (($hotels_count == 1) ? _PHONE.': '.$hotel_info['phone'] : ''), 0, 1, 'R');
			$pdf->Cell(0,5, $data['email'], 0, 0, 'L');            $pdf->Cell(0,5, (($hotels_count == 1) ? _FAX.': '.$hotel_info['fax'] : ''), 0, 1, 'R');
			$pdf->Cell(0,5, $data['company'], 0, 0, 'L');          $pdf->Cell(0,5, (($hotels_count == 1) ? _EMAIL_ADDRESS.': '.$hotel_info['email'] : ''), 0, 1, 'R');
			$pdf->Cell(0,5, $data['address'], 0, 2, 'L');          
			$pdf->Cell(0,5, $data['city'], 0, 2, 'L');
			$pdf->Cell(0,5, $data['country'], 0, 2, 'L');			
		}
		$pdf->Cell(0,5, '', 0, 1, 'L');
		
		// here table
		$pdf->SetFillColor(225,226,227); $pdf->SetFont('DejaVu','',9);
		$pdf->Cell(0,5, _BOOKING_DETAILS, 1, 2, 'L', true);
		// ----------------		
		$pdf->SetFont('DejaVu','',9);      /* Reset the font */
		$pdf->Cell(70,5, _BOOKING_NUMBER.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['booking_number'], 'R', 1, 'L');
		$pdf->Cell(70,5, _DESCRIPTION.': ', 'LB', 0, 'L');     $pdf->Cell(0,5, $data['booking_description'], 'RB', 1, 'L');
		$pdf->Cell(0,5, '', 0, 1, 'L');
		
		// here table
		$pdf->SetFillColor(225,226,227); $pdf->SetFont('DejaVu','',9);
		$pdf->Cell(0,5, _PAYMENT_DETAILS, 1, 2, 'L', true);
		// ----------------		
		$pdf->SetFont('DejaVu','',9);      /* Reset the font */
		$pdf->Cell(70,5, _TRANSACTION.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['transaction_number'], 'R', 1, 'L');
		$pdf->Cell(70,5, _DATE_PAYMENT.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['payment_date'], 'R', 1, 'L');
		$pdf->Cell(70,5, _PAYMENT_TYPE.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['payment_type'], 'R', 1, 'L');
		$pdf->Cell(70,5, _PAYMENT_METHOD.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['payment_method'], 'R', 1, 'L');
		$pdf->Cell(70,5, _BOOKING_PRICE.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['booking_price'], 'R', 1, 'L');
		if($data['discount'] != ''){ $pdf->Cell(70,5, _DISCOUNT.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['discount'], 'R', 1, 'L'); }
		$pdf->Cell(70,5, _BOOKING_SUBTOTAL.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['booking_subtotal'], 'R', 1, 'L');
		if($data['extras_subtotal'] != ''){ $pdf->Cell(70,5, _EXTRAS_SUBTOTAL.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['extras_subtotal'], 'R', 1, 'L'); }
		if($data['initial_fee'] != ''){ $pdf->Cell(70,5, _INITIAL_FEE.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['initial_fee'], 'R', 1, 'L'); }
		if($data['vat_fee'] != ''){ $pdf->Cell(70,5, _VAT.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['vat_fee'], 'R', 1, 'L'); }
		$pdf->Cell(70,5, _PRE_PAYMENT.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['pre_payment'], 'R', 1, 'L');
		$pdf->Cell(70,5, _ADDITIONAL_PAYMENT.': ', 'L', 0, 'L');   $pdf->Cell(0,5, $data['additional_payment'], 'R', 1, 'L');			
		$pdf->Cell(70,5, _TOTAL.': ', 'LB', 0, 'L');   $pdf->Cell(0,5, $data['total'], 'RB', 1, 'L');
		$pdf->Cell(0,5, '', 0, 1, 'L');

		// here table (extras details)
		$data_extras = $this->GetBookingExtrasList($rid);
		$total_extras_price = 0;
		if(count($data_extras) > 0){
			$pdf->Cell(0,6, _EXTRAS, 0, 1, 'L');
			$pdf->SetFillColor(225,226,227); $pdf->SetFont('DejaVu','',9);
			$pdf->Cell(5,6, '#', 'LBT', 0, 'L', true);
			$pdf->Cell(107,6, _NAME, 'BT', 0, 'L', true);
			$pdf->Cell(35,6, _UNIT_PRICE, 'BT', 0, 'C', true);
			$pdf->Cell(35,6, _UNITS, 'BT', 0, 'C', true);
			$pdf->Cell(15,6, _PRICE, 'BTR', 1, 'R', true);
			$pdf->SetFont('DejaVu','',7);      /* Reset the font */
			for($i = 0; $i < count($data_extras); $i++){
				$pdf->Cell(5,6, ($i+1).'.', 'LBT', 0, 'L');					
				$pdf->Cell(107,6, $data_extras[$i]['name'], 'BT', 0, 'L');
				$pdf->Cell(35,6, $data_extras[$i]['unit_price'], 'BT', 0, 'C');
				$pdf->Cell(35,6, $data_extras[$i]['units'], 'BT', 0, 'C');					
				$pdf->Cell(15,6, $data_extras[$i]['price'], 'BTR', 1, 'R');
				$total_extras_price += $data_extras[$i]['price_wo_currency'];
			}
			$pdf->SetFont('DejaVu','',9);      /* Reset the font */
			$pdf->Cell(147,6, '', 0, 0, 'L');			
			$pdf->Cell(35,6, _TOTAL.': ', 'LBT', 0, 'L', true);
			$pdf->Cell(15,6, $data['booking_currency'].number_format($total_extras_price, 2), 'BTR', 0, 'R', true);
			$pdf->Cell(0,6, '', 0, 1, 'L');
		}

		// here table (reservation details)
		$data_rooms = $this->GetBookingRoomsList($rid, Languages::GetDefaultLang(), 'invoice');
		$pdf->Cell(0,6, _RESERVATION_DETAILS, 0, 1, 'L');
		$pdf->SetFillColor(225,226,227); $pdf->SetFont('DejaVu','',9);
		$pdf->Cell(4,6, '#', 'LBT', 0, 'L', true);
		$pdf->Cell(27,6, _ROOM_TYPE, 'BT', 0, 'L', true);
		$pdf->Cell(28,6, (($hotels_count > 1) ? _HOTEL : ''), 'BT', 0, 'L', true);
		$pdf->Cell(19,6, _CHECK_IN, 'BT', 0, 'L', true);
		$pdf->Cell(19,6, _CHECK_OUT, 'BT', 0, 'L', true);
		$pdf->Cell(10,6, _ROOMS, 'BT', 0, 'C', true);
		$pdf->Cell(14,6, '##', 'BT', 0, 'C', true);
		$pdf->Cell(10,6, _ADULT, 'BT', 0, 'C', true);
		$pdf->Cell(10,6, (($data_rooms[0]['children'] != '') ? _CHILD : ''), 'BT', 0, 'C', true);
		$pdf->Cell(10,6, (($data_rooms[0]['guests'] != '') ? _GUEST : ''), 'BT', 0, 'C', true);
		$pdf->Cell(31,6, _MEAL_PLANS, 'BT', 0, 'R', true);
		$pdf->Cell(15,6, _PRICE, 'BTR', 1, 'R', true);
		
		// ----------------
		$pdf->SetFont('DejaVu','',9);      /* Reset the font */
		$total_room_price = 0;
		for($i = 0; $i < count($data_rooms); $i++){
			$pdf->SetFont('DejaVu','',7);
			$pdf->Cell(4,6, ($i+1).'.', 'LBT', 0, 'L');
			$pdf->Cell(27,6, $data_rooms[$i]['room_type'], 'BT', 0, 'L');
			$pdf->Cell(28,6, (($hotels_count > 1) ? $data_rooms[$i]['hotel_name'] : ''), 'BT', 0, 'L');
			$pdf->Cell(19,6, $data_rooms[$i]['checkin'], 'BT', 0, 'L');
			$pdf->Cell(19,6, $data_rooms[$i]['checkout'], 'BT', 0, 'L');
			$pdf->Cell(10,6, $data_rooms[$i]['rooms'], 'BT', 0, 'C');
			$pdf->Cell(14,6, $data_rooms[$i]['room_numbers'], 'BT', 0, 'C');
			$pdf->Cell(10,6, $data_rooms[$i]['adults'], 'BT', 0, 'C');
			$pdf->Cell(10,6, (($data_rooms[$i]['children'] != '') ? $data_rooms[$i]['children'] : ''), 'BT', 0, 'C');
			$pdf->Cell(10,6, (($data_rooms[$i]['guests'] != '') ? $data_rooms[$i]['guests'].' ('.$data['booking_currency'].number_format($data_rooms[$i]['guests_fee'], 2).')' : ''), 'BT', 0, 'C');
			$pdf->Cell(31,6, $data_rooms[$i]['meal_plan_name'].' ('.$data['booking_currency'].number_format($data_rooms[$i]['meal_plan_price'], 2).')', 'BT', 0, 'R');
			$pdf->Cell(15,6, $data_rooms[$i]['price'], 'BTR', 1, 'R');
			$total_room_price += ($data_rooms[$i]['price_wo_currency'] + $data_rooms[$i]['meal_plan_price'] + $data_rooms[$i]['guests_fee']);
		}
		$pdf->SetFont('DejaVu','',9);      /* Reset the font */
		$pdf->Cell(153,6, '', 0, 0, 'L');
		$pdf->Cell(29,6, _TOTAL.': ', 'LBT', 0, 'L', true);
		$pdf->Cell(15,6, $data['booking_currency'].number_format($total_room_price, 2), 'BTR', 0, 'R', true);
		
		// close the document and save to the filesystem with the name simple.pdf
		$pdf->Output('tmp/export/invoice.pdf','F');

		$this->message = _DOWNLOAD.': <a href="javascript:void(\'pdf\')" onclick="javascript:appGoToPage(\'index.php?admin=export&file=invoice.pdf\')">'._INVOICE.' No.'.$data['invoice_number'].' (PDF)</a>';
		
		return true;
	}	
 	
}
?>