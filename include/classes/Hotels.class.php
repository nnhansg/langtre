<?php

/**
 *	Hotels Class 
 *  --------------
 *  Description : encapsulates Hotels class properties
 *  Updated	    : 16.05.2010
 *	Written by  : ApPHP
 *
 *	PUBLIC:					STATIC:					PRIVATE:
 *  -----------				-----------				-----------
 *  __construct				GetAllActive            ValidateTranslationFields
 *  __destruct              DrawAboutUs
 *                          GetHotelInfo
 *                          GetHotelFullInfo
 *                          DrawLocalTime
 *                          DrawPhones
 *                          HotelsCount
 *                          DrawHotelDescription 
 *	                        
 **/


class Hotels extends MicroGrid {
	
	protected $debug = false;
	
	private $arrTranslations = '';
	private $hotelOwner = false;		

	private static $arr_stars_vm = array(
		'0'=>_NONE,
		'1'=>'<img src="images/stars1.gif" alt="1" />',
		'2'=>'<img src="images/stars2.gif" alt="2" />',
		'3'=>'<img src="images/stars3.gif" alt="3" />',
		'4'=>'<img src="images/stars4.gif" alt="4" />',
		'5'=>'<img src="images/stars5.gif" alt="5" />');
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();
		
		global $objLogin;
		$this->hotelOwner = $objLogin->IsLoggedInAs('hotelowner');
		
		$this->params = array();
		
		## for standard fields
		
		if(isset($_POST['hotel_location_id']))   $this->params['hotel_location_id'] = prepare_input($_POST['hotel_location_id']);
		if(isset($_POST['phone']))     $this->params['phone'] = prepare_input($_POST['phone']);
		if(isset($_POST['fax']))   	   $this->params['fax'] = prepare_input($_POST['fax']);
		if(isset($_POST['email']))     $this->params['email'] = prepare_input($_POST['email']);
		if(isset($_POST['map_code']))  $this->params['map_code'] = prepare_input($_POST['map_code'], false, 'low');
		if(isset($_POST['time_zone'])) $this->params['time_zone'] = prepare_input($_POST['time_zone']);
		if(isset($_POST['priority_order'])) $this->params['priority_order'] = prepare_input($_POST['priority_order']);
		if(isset($_POST['is_active']))   $this->params['is_active']  = (int)$_POST['is_active']; else $this->params['is_active'] = '0';
		if(isset($_POST['is_default']))  $this->params['is_default'] = (int)$_POST['is_default'];
		if(isset($_POST['stars']))       $this->params['stars'] = prepare_input($_POST['stars']);
		
		## for checkboxes 
		//$this->params['field4'] = isset($_POST['field4']) ? prepare_input($_POST['field4']) : '0';

		## for images (not necessary)
		//if(isset($_POST['icon'])){
		//	$this->params['icon'] = prepare_input($_POST['icon']);
		//}else if(isset($_FILES['icon']['name']) && $_FILES['icon']['name'] != ''){
		//	// nothing 			
		//}else if (self::GetParameter('action') == 'create'){
		//	$this->params['icon'] = '';
		//}

		## for files:
		// define nothing

		///$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		//$this->uPrefix 		= 'prefix_';
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_HOTELS; // 
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=hotels_info';
		$this->actions      = array(
								'add'=>($this->hotelOwner ? false : true),
								'edit'=>($this->hotelOwner ? $objLogin->HasPrivileges('edit_hotel_info') : true),
								'details'=>true,
								'delete'=>($this->hotelOwner ? false : true));
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = true;
		$this->alertOnDelete = ''; // leave empty to use default alerts

		$this->allowLanguages = false;
		$this->languageId = $objLogin->GetPreferredLang();
		$this->WHERE_CLAUSE = 'WHERE 1 = 1';

		if($this->hotelOwner){
			$hotels = $objLogin->AssignedToHotels();
			$hotels_list = implode(',', $hotels);
			if(!empty($hotels_list)) $this->WHERE_CLAUSE .= ' AND '.$this->tableName.'.'.$this->primaryKey.' IN ('.$hotels_list.')';
		}

		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.priority_order ASC';
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$this->isExportingAllowed = false;
		$this->arrExportingTypes = array('csv'=>false);
		
		///$this->isAggregateAllowed = false;
		///// define aggregate fields for View Mode
		///$this->arrAggregateFields = array(
		///	'field1' => array('function'=>'SUM', 'align'=>'center'),
		///	'field2' => array('function'=>'AVG', 'align'=>'center'),
		///);

		///$date_format = get_date_format('view');
		///$date_format_settings = get_date_format('view', true); /* to get pure settings format */
		///$date_format_edit = get_date_format('edit');
		///$datetime_format = get_datetime_format();
		///$time_format = get_time_format(); /* by default 1st param - shows seconds */
		///$currency_format = get_currency_format();

		// prepare locations array		
		$total_hotels_locations = HotelsLocations::GetHotelsLocations();
		$arr_hotels_locations = array();
		foreach($total_hotels_locations[0] as $key => $val){
			$arr_hotels_locations[$val['id']] = $val['name'].' ('.$val['country_id'].')';
		}			
		
		$arr_time_zones = get_timezones_array();

		$arr_active_vm = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_default_types_vm = array('0'=>'<span class=gray>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_default_types = array('0'=>_NO, '1'=>_YES);
		$arr_stars = array('1'=>'&lowast; (1)</span>', '2'=>'&lowast;&lowast; (2)', '3'=>'&lowast;&lowast;&lowast; (3)', '4'=>'&lowast;&lowast;&lowast;&lowast; (4)', '5'=>'&lowast;&lowast;&lowast;&lowast;&lowast; (5)');

		$this->isFilteringAllowed = true;
		// define filtering fields
		$this->arrFilteringFields = array(
			
			_LOCATIONS  => array('table'=>$this->tableName, 'field'=>'hotel_location_id', 'type'=>'dropdownlist', 'source'=>$arr_hotels_locations, 'sign'=>'=', 'width'=>'130px', 'visible'=>true),
			
			// 'Caption_1'  => array('table'=>'', 'field'=>'', 'type'=>'text', 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'80px', 'visible'=>true),
			// 'Caption_2'  => array('table'=>'', 'field'=>'', 'type'=>'dropdownlist', 'source'=>array(), 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'130px', 'visible'=>true),
			// 'Caption_3'  => array('table'=>'', 'field'=>'', 'type'=>'calendar', 'date_format'=>'dd/mm/yyyy|mm/dd/yyyy|yyyy/mm/dd', 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'80px', 'visible'=>true),
		);


		///////////////////////////////////////////////////////////////////////////////
		// #002. prepare translation fields array
		$this->arrTranslations = $this->PrepareTranslateFields(
			array('name', 'address', 'description')
		);
		///////////////////////////////////////////////////////////////////////////////			

		///////////////////////////////////////////////////////////////////////////////			
		// #003. prepare translations array for add/edit/detail modes
		/// REMEMBER! to add '.$sql_translation_description.' in EDIT_MODE_SQL
		/// $sql_translation_description = $this->PrepareTranslateSql(
		$sql_translation_description = $this->PrepareTranslateSql(
			TABLE_HOTELS_DESCRIPTION,
			'hotel_id',
			array('name', 'address', 'description')
		);
		///////////////////////////////////////////////////////////////////////////////			

		//---------------------------------------------------------------------- 
		// VIEW MODE
		// format: strip_tags
		// format: nl2br
		// format: 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A'
		// format: 'format'=>'currency', 'format_parameter'=>'european|2' or 'format_parameter'=>'american|4'
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT
									'.$this->tableName.'.'.$this->primaryKey.',
									'.$this->tableName.'.hotel_location_id,
									'.$this->tableName.'.phone,
									'.$this->tableName.'.fax,
									'.$this->tableName.'.email,
									'.$this->tableName.'.time_zone,
									'.$this->tableName.'.map_code,
									'.$this->tableName.'.hotel_image_thumb,
									'.$this->tableName.'.stars,
									'.$this->tableName.'.is_default,
									'.$this->tableName.'.is_active,
									'.$this->tableName.'.priority_order,
									'.TABLE_HOTELS_DESCRIPTION.'.name
								FROM ('.$this->tableName.'
									LEFT OUTER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.$this->tableName.'.id = '.TABLE_HOTELS_DESCRIPTION.'.hotel_id AND '.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.$this->languageId.'\')
								';
								
		// define view mode fields
		$this->arrViewModeFields = array(
			
			'hotel_image_thumb' => array('title'=>_IMAGE, 'type'=>'image', 'align'=>'center', 'width'=>'55px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'image_width'=>'50px', 'image_height'=>'30px', 'target'=>'images/hotels/', 'no_image'=>'no_image.png'),
			'name'    => array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'hotel_location_id' => array('title'=>_LOCATION_NAME, 'type'=>'enum',  'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_hotels_locations),
			'phone'   => array('title'=>_PHONE, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'fax'     => array('title'=>_FAX, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'stars'   => array('title'=>_STARS, 'type'=>'enum',  'align'=>'center', 'width'=>'70px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>self::$arr_stars_vm),
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'70px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_active_vm),
			'is_default'     => array('title'=>_DEFAULT, 'type'=>'enum',  'align'=>'center', 'width'=>'70px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_default_types_vm),
			'priority_order' => array('title'=>_ORDER,  'type'=>'label', 'align'=>'center', 'width'=>'65px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>'', 'movable'=>true),			
			'id'             => array('title'=>'ID', 'type'=>'label', 'align'=>'center', 'width'=>'50px'),

			// 'field1'  => array('title'=>'', 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			// 'field2'  => array('title'=>'', 'type'=>'image', 'align'=>'center', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'image_width'=>'50px', 'image_height'=>'30px', 'target'=>'uploaded/', 'no_image'=>''),
			// 'field3'  => array('title'=>'', 'type'=>'enum',  'align'=>'center', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>array()),
			// 'field4'  => array('title'=>'', 'type'=>'link',  'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>'', 'href'=>'http://{field4}|mailto://{field4}', 'target'=>''),

		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password|date
		// 	 Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255... Ex.: 'validation_maxlength'=>'255'
		// - Validation Min Length: 4, 6... Ex.: 'validation_minlength'=>'4'
		// - Validation Max Value: 12, 255... Ex.: 'validation_maximum'=>'99.99'
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(		    

			'separator_1'   =>array(
				'separator_info' => array('legend'=>_HOTEL_INFO, 'columns'=>'0'),
				'phone'  		=> array('title'=>_PHONE, 'type'=>'textbox',  'required'=>false, 'width'=>'170px', 'readonly'=>false, 'maxlength'=>'32', 'default'=>'', 'validation_type'=>'text'),
				'fax'  		   	=> array('title'=>_FAX, 'type'=>'textbox',  'required'=>false, 'width'=>'170px', 'readonly'=>false, 'maxlength'=>'32', 'default'=>'', 'validation_type'=>'text'),
				'email' 		=> array('title'=>_EMAIL_ADDRESS,'type'=>'textbox', 'width'=>'210px', 'required'=>false, 'maxlength'=>'70', 'validation_type'=>'email', 'unique'=>true),
				'hotel_location_id' => array('title'=>_LOCATION_NAME, 'type'=>'enum', 'width'=>'', 'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_hotels_locations, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'stars'         => array('title'=>_STARS, 'type'=>'enum',     'width'=>'',      'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_stars, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'time_zone'     => array('title'=>_TIME_ZONE, 'type'=>'enum',  'required'=>true, 'width'=>'480px', 'readonly'=>false, 'source'=>$arr_time_zones),
				'hotel_image'   => array('title'=>_IMAGE, 'type'=>'image',    'width'=>'210px', 'required'=>true, 'readonly'=>false, 'target'=>'images/hotels/', 'no_image'=>'no_image.png', 'random_name'=>false, 'overwrite_image'=>true, 'unique'=>true, 'image_name_pefix'=>'hotel_'.(int)self::GetParameter('rid').'_', 'thumbnail_create'=>true, 'thumbnail_field'=>'hotel_image_thumb', 'thumbnail_width'=>'120px', 'thumbnail_height'=>'', 'file_maxsize'=>'500k'),
				'map_code'      => array('title'=>_MAP_CODE, 'type'=>'textarea', 'required'=>false, 'width'=>'480px', 'height'=>'100px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'maxlength'=>'1024', 'validation_maxlength'=>'1024', 'unique'=>false),

				'priority_order' => array('title'=>_ORDER, 'type'=>'textbox', 'required'=>true, 'width'=>'40px', 'readonly'=>false, 'maxlength'=>'2', 'default'=>'0', 'validation_type'=>'numeric|positive', 'unique'=>false, 'visible'=>true),
				'is_default'     => array('title'=>_IS_DEFAULT, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'0', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
				'is_active'      => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),		
			)
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password|date
		//   Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255... Ex.: 'validation_maxlength'=>'255'
		// - Validation Min Length: 4, 6... Ex.: 'validation_minlength'=>'4'
		// - Validation Max Value: 12, 255... Ex.: 'validation_maximum'=>'99.99'
		// - for editable passwords they must be defined directly in SQL : '.$this->tableName.'.user_password,
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.stars,
								'.$this->tableName.'.hotel_location_id,
								'.$this->tableName.'.phone,
								'.$this->tableName.'.fax,
								'.$this->tableName.'.email,
								'.$this->tableName.'.time_zone,
								'.$this->tableName.'.hotel_image,
								'.$this->tableName.'.hotel_image_thumb,
								'.$this->tableName.'.map_code,
								'.$this->tableName.'.stars,
								'.$sql_translation_description.'
								'.$this->tableName.'.priority_order,
								'.$this->tableName.'.is_active,
								'.$this->tableName.'.is_default
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		

		// prepare trigger
		$sql = 'SELECT is_default FROM '.$this->tableName.' WHERE id = '.(int)self::GetParameter('rid');
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		$is_default = '0';
		if($result[1] > 0){
			$is_default = (isset($result[0]['is_default'])) ? $result[0]['is_default'] : '0';
		}

		// define edit mode fields
		$this->arrEditModeFields = array(

			'separator_1'   => array(
				'separator_info'=> array('legend'=>_HOTEL_INFO, 'columns'=>'0'),
				'phone'  		=> array('title'=>_PHONE, 'type'=>'textbox',  'required'=>false, 'width'=>'170px', 'readonly'=>false, 'maxlength'=>'32', 'default'=>'', 'validation_type'=>'text'),
				'fax'  		   	=> array('title'=>_FAX, 'type'=>'textbox',  'required'=>false, 'width'=>'170px', 'readonly'=>false, 'maxlength'=>'32', 'default'=>'', 'validation_type'=>'text'),
				'email' 		=> array('title'=>_EMAIL_ADDRESS,'type'=>'textbox', 'width'=>'210px', 'required'=>false, 'maxlength'=>'70', 'validation_type'=>'email', 'unique'=>true),
				'hotel_location_id' => array('title'=>_LOCATION_NAME, 'type'=>'enum', 'width'=>'', 'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_hotels_locations, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'stars'         => array('title'=>_STARS, 'type'=>'enum',     'width'=>'',      'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_stars, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'time_zone'     => array('title'=>_TIME_ZONE, 'type'=>'enum',  'required'=>true, 'width'=>'480px', 'readonly'=>false, 'source'=>$arr_time_zones),
				'hotel_image'   => array('title'=>_IMAGE, 'type'=>'image',    'width'=>'210px', 'required'=>true, 'readonly'=>false, 'target'=>'images/hotels/', 'no_image'=>'no_image.png', 'random_name'=>true, 'overwrite_image'=>false, 'unique'=>true, 'image_name_pefix'=>'hotel_'.(int)self::GetParameter('rid').'_', 'thumbnail_create'=>true, 'thumbnail_field'=>'hotel_image_thumb', 'thumbnail_width'=>'120px', 'thumbnail_height'=>'', 'file_maxsize'=>'500k'),
				'map_code'      => array('title'=>_MAP_CODE, 'type'=>'textarea', 'required'=>false, 'width'=>'480px', 'height'=>'100px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'maxlength'=>'1024', 'validation_maxlength'=>'1024', 'unique'=>false),

				'priority_order'=> array('title'=>_ORDER, 'type'=>'textbox', 'required'=>true, 'width'=>'40px', 'readonly'=>false, 'maxlength'=>'2', 'default'=>'0', 'validation_type'=>'numeric|positive', 'unique'=>false, 'visible'=>true),
				'is_default'    => array('title'=>_IS_DEFAULT, 'type'=>'checkbox', 'readonly'=>(($is_default) ? true : false), 'default'=>'0', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false, 'visible'=>(($this->hotelOwner) ? false: true)),		
				'is_active'     => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>(($is_default) ? true : false), 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),		
			)
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(

			'separator_1'   =>array(
				'separator_info' => array('legend'=>_HOTEL_INFO, 'columns'=>'0'),
				'phone'  		=> array('title'=>_PHONE, 'type'=>'label', 'format'=>'', 'format_parameter'=>'', 'visible'=>true),
				'fax'  		   	=> array('title'=>_FAX, 'type'=>'label', 'format'=>'', 'format_parameter'=>'', 'visible'=>true),
				'email'     	=> array('title'=>_EMAIL_ADDRESS, 	 'type'=>'label'),
				'hotel_location_id' => array('title'=>_LOCATION_NAME, 'type'=>'enum', 'source'=>$arr_hotels_locations),
				'stars'         => array('title'=>_STARS, 'type'=>'enum', 'source'=>self::$arr_stars_vm),
				'time_zone'     => array('title'=>_TIME_ZONE, 'type'=>'enum', 'source'=>$arr_time_zones),
				'hotel_image'   => array('title'=>_IMAGE, 'type'=>'image', 'target'=>'images/hotels/', 'no_image'=>'no_image.png', 'image_width'=>'120px', 'image_height'=>'90px', 'visible'=>true),
				'map_code'      => array('title'=>_MAP_CODE, 'type'=>'html', 'format'=>'', 'format_parameter'=>'', 'visible'=>true),
	
				'priority_order' => array('title'=>_ORDER, 'type'=>'label'),
				'is_default'     => array('title'=>_DEFAULT, 'type'=>'enum', 'source'=>$arr_default_types_vm),
				'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_active_vm),
			)
		);

		///////////////////////////////////////////////////////////////////////////////
		// #004. add translation fields to all modes
		$this->AddTranslateToModes(
			$this->arrTranslations,
				array('name'        => array('title'=>_NAME, 'type'=>'textbox', 'width'=>'410px', 'required'=>true, 'maxlength'=>'125', 'readonly'=>false),
					  'address' 	=> array('title'=>_ADDRESS, 'type'=>'textarea', 'width'=>'410px', 'height'=>'55px', 'required'=>false, 'maxlength'=>'225', 'validation_maxlength'=>'225', 'readonly'=>false),
					  'description' => array('title'=>_DESCRIPTION, 'type'=>'textarea', 'width'=>'410px', 'height'=>'90px', 'required'=>false, 'maxlength'=>'2048', 'validation_maxlength'=>'2048', 'readonly'=>false, 'editor_type'=>'wysiwyg')
			)
		);
		///////////////////////////////////////////////////////////////////////////////			

	}
	

	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }


	/**
	 *	Returns all array of all active hotels
	 */
	public static function GetAllActive($where_clause = '')
	{		
		$sql = 'SELECT
					'.TABLE_HOTELS.'.*,
					'.TABLE_HOTELS_DESCRIPTION.'.name,
					'.TABLE_HOTELS_DESCRIPTION.'.address,
					'.TABLE_HOTELS_DESCRIPTION.'.description
				FROM '.TABLE_HOTELS.'
					INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.TABLE_HOTELS.'.id = '.TABLE_HOTELS_DESCRIPTION.'.hotel_id AND '.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.Application::Get('lang').'\'
				WHERE
					'.TABLE_HOTELS.'.is_active = 1
					'.(!empty($where_clause) ? ' AND '.$where_clause : '').'
				ORDER BY '.TABLE_HOTELS.'.priority_order ASC ';			
		return database_query($sql, DATA_AND_ROWS);
	}

	/**
	 * Draws About Us block
	 * 		@param $draw
	 */
	public static function DrawAboutUs($draw = true)
	{		
		$lang = Application::Get('lang');		
		$output = '';
		
		$sql = 'SELECT
					h.phone,
					h.fax,
					h.stars,
					h.map_code,	
					hd.name,									
					hd.address,
					hd.description 
				FROM '.TABLE_HOTELS.' h
					INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON h.id = hd.hotel_id
				WHERE h.is_default = 1 AND hd.language_id = \''.$lang.'\'';
				
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$output .= '<h3>'.$result[0]['name'].'</h3>';
			$output .= '<p>'._STARS.': '.self::$arr_stars_vm[$result[0]['stars']].'</p>';
			$output .= '<p>'.$result[0]['description'].'</p>';		
			$output .= '<p>'._ADDRESS.': '.$result[0]['address'].'</p>';
			$output .= '<p>'._PHONE.': '.$result[0]['phone'].'<br />'._FAX.': '.$result[0]['fax'].'</p>';
			if($result[0]['map_code']) $output .= '<p>'._OUR_LOCATION.':<br /> '.$result[0]['map_code'].'</p>';
		}
		if($draw) echo $output;
		else return $output;
	}

	/**
	 * Returns Hotel info
	 * 		@param $hotel_id 
	 */
	public static function GetHotelInfo($hotel_id = '')
	{
		$output = array();
		$sql = 'SELECT *
				FROM '.TABLE_HOTELS.'
				WHERE '.(!empty($hotel_id) ? ' id ='.(int)$hotel_id : ' is_default = 1');		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$output = $result[0];
		}
		return $output;
	}

	/**
	 * Returns Hotel full info
	 *      @param $hotel_id
	 * 		@param $lang
	 */
	public static function GetHotelFullInfo($hotel_id = '', $lang = '')
	{
		$output = array();
		$sql = 'SELECT
					h.*,
					hd.name,
					hd.address,
					hd.description,
					hld.name as location_name
				FROM '.TABLE_HOTELS.' as h
					INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON h.id = hd.hotel_id
					LEFT OUTER JOIN '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.' hld ON h.hotel_location_id = hld.hotel_location_id 
				WHERE 1=1
				'.(!empty($hotel_id) ? ' AND h.id = \''.(int)$hotel_id.'\' ' : ' AND h.is_default = 1').'
				'.(($lang != '') ? ' AND hld.language_id = \''.$lang.'\' ' : '').'
				'.(($lang != '') ? ' AND hd.language_id = \''.$lang.'\' ' : '').'
				LIMIT 0, 1';
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$output = $result[0];
		}
		return $output;
	}	

	/**
	 * Draws Local Time block
	 *      @param $hotel_id
	 * 		@param $draw
	 */
	public static function DrawLocalTime($hotel_id = '', $draw = true)
	{
		global $objSettings;
		
		// set timezone
		//----------------------------------------------------------------------
		$hotelInfo = Hotels::GetHotelInfo($hotel_id);
		$time_offset_hotel = (isset($hotelInfo['time_zone'])) ? $hotelInfo['time_zone'] : 0;
		$time_offset_site = $objSettings->GetParameter('time_zone');
		$time_zome_diff = $time_offset_hotel - $time_offset_site;
		$time_with_offset = time() + $time_zome_diff * 3600;
		
		if(Application::Get('lang') != 'en'){
			$dmy_string = ($objSettings->GetParameter('date_format') == 'mm/dd/yyyy') ? '%B %d, %Y' : '%d %B, %Y'; 
			$output1 = strftime(str_replace('%B', get_month_local(@strftime('%m', $time_with_offset)), $dmy_string), $time_with_offset);
			$output2 = strftime(str_replace('%A', get_weekday_local(@strftime('%w', $time_with_offset)+1), '%A %H:%M'), $time_with_offset);			
		}else{
			$dmy_string = ($objSettings->GetParameter('date_format') == 'mm/dd/yyyy') ? 'F dS, Y' : 'dS \of F Y'; 
			$output1 = @date($dmy_string, $time_with_offset);
			$output2 = @date('l g:i A', $time_with_offset);
		}
		$output = $output1.'<br />'.$output2;
		
		if($draw) echo $output;
		else return $output;
	}
	
	/**
	 * Draws hotel phones
	 * 		@param $draw
	 */
	public static function DrawPhones($draw = true)
	{
		$hotels = Hotels::GetAllActive();
		$output = '';
		
		if($hotels[1] == 1){
			$output = $hotels[0][0]['phone'].'<br />'.$hotels[0][0]['fax'];	
		}	
	
		if($draw) echo $output;
		else return $output;
	}

	/**
	 * Returns hotels count
	*/
	public static function HotelsCount()
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_HOTELS.' WHERE is_active = 1'; 
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			return (int)$result[0]['cnt'];
		}
		return 0;
	}
	
	/**
	 * Returns hotels description
	 * 		@param $hotel_id
	 * 		@param $draw
	*/
	public static function DrawHotelDescription($hotel_id, $draw = true)
	{
		$output = '';
		
		$sql = 'SELECT
					h.id,
					h.hotel_location_id,
					h.phone,
					h.fax,
					h.time_zone,
					h.map_code,
					h.hotel_image_thumb,
					h.stars,
					h.is_default,
					h.is_active,
					h.priority_order,
					hd.name as hotel_name,
					hd.address as hotel_address,
					hd.description as hotel_description
				FROM '.TABLE_HOTELS.' h
					LEFT OUTER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON h.id = hd.hotel_id AND hd.language_id = \''.Application::Get('lang').'\'
				WHERE h.is_active = 1 AND h.id = '.(int)$hotel_id;
				
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$output .= draw_title_bar($result[0]['hotel_name'].' &nbsp;'.self::$arr_stars_vm[$result[0]['stars']], false);
			
			$output .= '<table class="tblHotelDescription">';
			$output .= '<tr>';
			$output .= '<td colspan="2"><b>'._ADDRESS.'</b>: '.$result[0]['hotel_address'].'</td>';
			$output .= '<td rowspan="2"><img src="images/hotels/'.$result[0]['hotel_image_thumb'].'" style="float:'.Application::Get('defined_right').';margin:0 5px;" alt="" /></td>';
			$output .= '</tr>';
			$output .= '<tr>';
			$output .= '<td valign="top"><b>'._LOCAL_TIME.'</b>:<br>'.Hotels::DrawLocalTime($result[0]['id'], false).'</td>';
			$output .= '<td valign="top">';
			if($result[0]['phone'] || $result[0]['fax']){
				if($result[0]['phone']) $output .= '<b>'._PHONE.'</b>: '.$result[0]['phone'].'<br />';
				if($result[0]['fax']) $output .= '<b>'._FAX.'</b>: '.$result[0]['fax'];
			}
			$output .= '</td>';			
			$output .= '</tr>';
			$output .= '<tr><td colspan="3">'.$result[0]['hotel_description'].'</td></tr>';
			$output .= '<tr><td colspan="3">'.Rooms::DrawRoomsInHotel($hotel_id, false).'</td></tr>';
			$output .= '</table>';
			
			if($result[0]['map_code']) $output .= '<p><b>'._LOCATION.'</b>:<br /> '.$result[0]['map_code'].'</p>';			
						
		}else{
			$output = draw_important_message(_WRONG_PARAMETER_PASSED, false);					
		}
	
		if($draw) echo $output;
		else return $output;
	}


	//==========================================================================
    // MicroGrid Methods
	//==========================================================================	
	/**
	 * Validate translation fields
	 */
	private function ValidateTranslationFields()	
	{
		foreach($this->arrTranslations as $key => $val){
			if(trim($val['name']) == ''){
				$this->error = str_replace('_FIELD_', '<b>'._NAME.'</b>', _FIELD_CANNOT_BE_EMPTY);
				$this->errorField = 'name_'.$key;
				return false;				
			}			
		}		
		return true;		
	}

	/**
	 * Before-Insertion
	 */
	public function BeforeInsertRecord()
	{
		return $this->ValidateTranslationFields();
	}

	/**
	 * After-Insertion - add banner descriptions to description table
	 */
	public function AfterInsertRecord()
	{
		$sql = 'INSERT INTO '.TABLE_HOTELS_DESCRIPTION.'(id, hotel_id, language_id, name, address, description) VALUES ';
		$count = 0;
		foreach($this->arrTranslations as $key => $val){
			if($count > 0) $sql .= ',';
			$sql .= '(NULL, '.$this->lastInsertId.', \''.$key.'\', \''.encode_text(prepare_input($val['name'])).'\', \''.encode_text(prepare_input($val['address'])).'\', \''.encode_text(prepare_input($val['description'], false, 'medium')).'\')';
			$count++;
		}
		if(database_void_query($sql)){
			
			// set default  = 0 for other languages
			if(self::GetParameter('is_default', false) == '1'){
				$sql = 'UPDATE '.TABLE_HOTELS.'
						SET is_active = IF(id = '.(int)$this->lastInsertId.', 1, is_active),
						    is_default = IF(id = '.(int)$this->lastInsertId.', 1, 0)';
				database_void_query($sql);					
			}			
			
			return true;
		}else{
   		    ///echo $sql.'<br>'.mysql_error();			
			return false;
		}
	}	

	/**
	 * Before-Updating operations
	 */
	public function BeforeUpdateRecord()
	{
		return $this->ValidateTranslationFields();
	}

	/**
	 * After-Updating - update hotels item descriptions to description table
	 */
	public function AfterUpdateRecord()
	{
		// set always default hotel to be active
		$sql = 'SELECT * FROM '.TABLE_HOTELS.' WHERE id = '.(int)$this->curRecordId;                    
		if($language = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){                        
			// set default  = 0 for other languages
			if(self::GetParameter('is_default', false) == '1'){
				$sql = 'UPDATE '.TABLE_HOTELS.'
						SET is_active = IF(id = '.(int)$this->curRecordId.', 1, is_active),
						    is_default = IF(id = '.(int)$this->curRecordId.', 1, 0)';
				database_void_query($sql);					
			}			
		}			

		foreach($this->arrTranslations as $key => $val){
			$sql = 'UPDATE '.TABLE_HOTELS_DESCRIPTION.'
					SET name = \''.encode_text(prepare_input($val['name'])).'\',
						address = \''.encode_text(prepare_input($val['address'])).'\',
						description = \''.encode_text(prepare_input($val['description'], false, 'medium')).'\'
					WHERE hotel_id = '.$this->curRecordId.' AND language_id = \''.$key.'\'';
			database_void_query($sql);
			//echo mysql_error();
		}
	}	


    /**
	 * Before-Deleting Record
	 */
	public function BeforeDeleteRecord()
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_HOTELS.' WHERE is_active = 1';
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			if((int)$result['cnt'] > 1){
				$rid = MicroGrid::GetParameter('rid');
				$sql = 'SELECT is_default FROM '.TABLE_HOTELS.' WHERE id = '.(int)$rid;
				if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
					if($result['is_default'] == '1'){
						$this->error = _DEFAULT_HOTEL_DELETE_ALERT;
						return false;
					}
				}				
				return true;	
			}else{
				$this->error = _LAST_HOTEL_ALERT;
				return false;	
			}
		}
	    return false;	
	}

    /**
	 * After-Deleting Record
	 */
	public function AfterDeleteRecord()
	{
		$sql = 'SELECT id, is_active FROM '.TABLE_HOTELS;
		if($result = database_query($sql, DATA_AND_ROWS, ALL_ROWS)){
			if((int)$result[1] == 1){
				// make last hotel always default and active
				$sql = 'UPDATE '.TABLE_HOTELS.' SET is_default = \'1\', is_active = \'1\' WHERE id= '.(int)$result[0][0]['id'];
				database_void_query($sql);
			}
		}

        // delete info from hotel description table
		$sql = 'DELETE FROM '.TABLE_HOTELS_DESCRIPTION.' WHERE hotel_id = '.$this->curRecordId;
		if(database_void_query($sql)){
			return true;
		}else{
			return false;
		}
	}


}

?>