<?php

/**
 *	Class HotelsLocations (for Hotel Site ONLY)
 *  --------------
 *	Description : encapsulates methods and properties
 *	Written by  : ApPHP
 *  Updated	    : 16.09.2012
 *
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *	__construct             GetHotelsLocations      ValidateTranslationFields
 *	__destruct
 *	BeforeInsertRecord
 *	AfterInsertRecord
 *	BeforeUpdateRecord
 *	AfterUpdateRecord
 *	AfterDeleteRecord
 *	
 *  1.0.0
 *      - 
 *      - 
 *      -
 *      -
 *      -
 *      
 *	NOTES:
 *	------
 *	1.	for fiels and images 'target'=>'' must be relative path to the site's directory
 *
 *	NON-DOCUMENTED:
 *	---------------
 *	'pre_html'
 *	'post_html'
 *	'validation_maxlength'=>''		- for add/edit modes - check max length of string
 *	'validation_minlength'=>''		- for add/edit modes - check min length of string
 *	'validation_maximum'=>''		- for add/edit modes - check maximum value of argument
 *	'validation_minimum'=>''		- for add/edit modes - check minimum value of argument
 *	'movable'=>true 				- for priority order in view mode
 *	'sort_type'=>'string|numeric' 	- for fields sorting in view mode
 *	'sort_by'=>'field_name' 		- for fields sorting in view mode
 *	'header_tooltip'=>''            - displays tooltip for header in View/Add/Edit modes
 *	'autocomplete'=>'off'           - block autocomplete by browser
 *	
 *	TEMPLATES:
 *	-------
 *  1. Standard multi-language: 1 table :: 1 page + field lang
 *  2. Advanced multi-language: 2 tables :: 2 pages + link on main grid [description] to another page
 *  3. Professional multi-language: 2 table :: 1 pages + all lang fields on add/edit/detail modes
 *  	  #001. array for language translations
 *		  #002. prepare translation fields array
 *		  #003. prepare translations array for add/edit/detail modes
 *		  #004. add translation fields to all modes
 *        #005. add validation - ValidateTranslationFields()	
 *        #006. add Before/AfterInsert(), Before/AfterUpdate methods and AfterDeleteRecord + prepare_input()!!!
 *	
 *	TRICKS & TIPS:
 *	--------------
 *	1. to make image resize with out creating additional thumbnail - make 'thumbnail_field'=>'image field'
 *	2. function __mgDoModeAlert(){} allows to call customized alerts on update operation
 *	3. to don't show "-- select --" in DDl use 'default_option'=>false
 *	
 **/


class HotelsLocations extends MicroGrid {
	
	protected $debug = false;
	
	// #001 -----------------------
	private $arrTranslations = '';		
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();
		
		global $objLogin;
		
		$this->params = array();
		
		## for standard fields
		if(isset($_POST['country_id'])) $this->params['country_id'] = prepare_input($_POST['country_id']);
		if(isset($_POST['priority_order'])) $this->params['priority_order'] = prepare_input($_POST['priority_order']);
		if(isset($_POST['is_active']))  $this->params['is_active']  = (int)$_POST['is_active']; else $this->params['is_active'] = '0';
		
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
		$this->tableName 	= TABLE_HOTELS_LOCATIONS; // 
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=hotels_locations';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = false;
		$this->alertOnDelete = ''; // leave empty to use default alerts

		$this->allowLanguages = false;
		$this->languageId = $objLogin->GetPreferredLang();
		$this->WHERE_CLAUSE = ''; // WHERE .... / 'WHERE language_id = \''.$this->languageId.'\'';				
		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.priority_order ASC';
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$this->isExportingAllowed = false;
		$this->arrExportingTypes = array('csv'=>false);
		
		$this->isFilteringAllowed = false;
		// define filtering fields
		$this->arrFilteringFields = array(
			// 'Caption_1'  => array('table'=>'', 'field'=>'', 'type'=>'text', 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'80px', 'visible'=>true),
			// 'Caption_2'  => array('table'=>'', 'field'=>'', 'type'=>'dropdownlist', 'source'=>array(), 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'130px', 'visible'=>true),
			// 'Caption_3'  => array('table'=>'', 'field'=>'', 'type'=>'calendar', 'date_format'=>'dd/mm/yyyy|mm/dd/yyyy|yyyy/mm/dd', 'sign'=>'=|>=|<=|like%|%like|%like%', 'width'=>'80px', 'visible'=>true),
		);

		$total_countries = Countries::GetAllCountries('priority_order DESC, name ASC');
		$arr_countries   = array();
		foreach($total_countries[0] as $key => $val){
			$arr_countries[$val['abbrv']] = $val['name'];
		}

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

		$arr_active_vm = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');

		// prepare languages array		
		/// $total_languages = Languages::GetAllActive();
		/// $arr_languages      = array();
		/// foreach($total_languages[0] as $key => $val){
		/// 	$arr_languages[$val['abbreviation']] = $val['lang_name'];
		/// }

		///////////////////////////////////////////////////////////////////////////////
		// #002. prepare translation fields array
		$this->arrTranslations = $this->PrepareTranslateFields(
			array('name')
		);
		///////////////////////////////////////////////////////////////////////////////			

		///////////////////////////////////////////////////////////////////////////////			
		// #003. prepare translations array for add/edit/detail modes
		// REMEMBER! to add '.$sql_translation_description.' in EDIT_MODE_SQL
		$sql_translation_description = $this->PrepareTranslateSql(
			TABLE_HOTELS_LOCATIONS_DESCRIPTION,
			'hotel_location_id',
			array('name')
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
									'.$this->tableName.'.country_id,
									'.$this->tableName.'.priority_order,
									'.$this->tableName.'.is_active,
									'.TABLE_HOTELS_LOCATIONS_DESCRIPTION.'.name as location_name,
									cnt.name as country_name
								FROM (('.$this->tableName.' 
									LEFT OUTER JOIN '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.' ON '.$this->tableName.'.id = '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.'.hotel_location_id AND '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.'.language_id = \''.$this->languageId.'\')
									LEFT OUTER JOIN '.TABLE_COUNTRIES.' cnt ON '.$this->tableName.'.country_id = cnt.abbrv AND cnt.is_active = 1)
								';

		// define view mode fields
		$this->arrViewModeFields = array(
			'location_name'  => array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'country_name'   => array('title'=>_COUNTRY, 'type'=>'label', 'align'=>'center', 'width'=>'200px'),
			'priority_order' => array('title'=>_ORDER,  'type'=>'label', 'align'=>'center', 'width'=>'85px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>'', 'movable'=>true),			
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_active_vm),

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

			'country_id' 	 => array('title'=>_COUNTRY, 'type'=>'enum',  'width'=>'210px', 'source'=>$arr_countries, 'required'=>true),
			'priority_order' => array('title'=>_ORDER, 'type'=>'textbox', 'required'=>true, 'width'=>'40px', 'readonly'=>false, 'maxlength'=>'2', 'default'=>'0', 'validation_type'=>'numeric|positive', 'unique'=>false, 'visible'=>true),
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),		

			// 'field1'  => array('title'=>'', 'type'=>'label'),
			// 'field2'  => array('title'=>'', 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			// 'field3'  => array('title'=>'', 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'height'=>'90px', 'editor_type'=>'simple|wysiwyg', 'validation_type'=>'', 'unique'=>false),
			// 'field4'  => array('title'=>'', 'type'=>'hidden',                     'required'=>true, 'readonly'=>false, 'default'=>date('Y-m-d H:i:s')),
			// 'field5'  => array('title'=>'', 'type'=>'enum',     'width'=>'',      'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_languages, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist|checkboxes', 'multi_select'=>false),
			// 'field6'  => array('title'=>'', 'type'=>'checkbox', 					 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
			// 'field7'  => array('title'=>'', 'type'=>'image',    'width'=>'210px', 'required'=>true, 'readonly'=>false, 'target'=>'uploaded/', 'no_image'=>'', 'random_name'=>true, 'image_name_pefix'=>'', 'overwrite_image'=>false, 'unique'=>false, 'thumbnail_create'=>false, 'thumbnail_field'=>'', 'thumbnail_width'=>'', 'thumbnail_height'=>'', 'file_maxsize'=>'300k'),
			// 'field8'  => array('title'=>'', 'type'=>'file',     'width'=>'210px', 'required'=>true, 'target'=>'uploaded/', 'random_name'=>true, 'overwrite_image'=>false, 'unique'=>false, 'file_maxsize'=>'300k'),
			// 'field9'  => array('title'=>'', 'type'=>'date',     				     'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'date', 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A', 'min_year'=>'90', 'max_year'=>'10'),
			// 'field10' => array('title'=>'', 'type'=>'datetime', 					 'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'', 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A', 'min_year'=>'90', 'max_year'=>'10'),
			// 'field11' => array('title'=>'', 'type'=>'time', 					     'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'', 'format'=>'date', 'format_parameter'=>'H:i:s', 'show_seconds'=>true, 'minutes_step'=>'1'),
			// 'field12' => array('title'=>'', 'type'=>'password', 'width'=>'310px', 'required'=>true, 'validation_type'=>'password', 'cryptography'=>PASSWORDS_ENCRYPTION, 'cryptography_type'=>PASSWORDS_ENCRYPTION_TYPE, 'aes_password'=>PASSWORDS_ENCRYPT_KEY),
			// 'language_id'  => array('title'=>_LANGUAGE, 'type'=>'enum', 'source'=>$arr_languages, 'required'=>true, 'unique'=>false),
			
			//  'separator_X'   =>array(
			//		'separator_info' => array('legend'=>'Legend Text', 'columns'=>'0'),
			//		'field1'  => array('title'=>'', 'type'=>'label'),
			// 		'field2'  => array('title'=>'', 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			// 		'field3'  => array('title'=>'', 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'readonly'=>false, 'maxlength'=>'', 'height'=>'90px', 'editor_type'=>'simple|wysiwyg', 'default'=>'', 'validation_type'=>'', 'unique'=>false),
			//  )
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
								'.$this->tableName.'.country_id,
								'.$sql_translation_description.'
								'.$this->tableName.'.country_id,
								'.$this->tableName.'.priority_order,
								'.$this->tableName.'.is_active,
								cnt.name as country_name
							FROM '.$this->tableName.'							
								LEFT OUTER JOIN '.TABLE_COUNTRIES.' cnt ON '.$this->tableName.'.country_id = cnt.abbrv AND cnt.is_active = 1
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
		
			'country_id' 	 => array('title'=>_COUNTRY, 'type'=>'enum',  'width'=>'210px', 'source'=>$arr_countries, 'required'=>true),
			'priority_order' => array('title'=>_ORDER, 'type'=>'textbox', 'required'=>true, 'width'=>'40px', 'readonly'=>false, 'maxlength'=>'2', 'default'=>'0', 'validation_type'=>'numeric|positive', 'unique'=>false, 'visible'=>true),
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),		

			// 'field1'  => array('title'=>'', 'type'=>'label',    'format'=>'', 'format_parameter'=>'', 'visible'=>true),
			// 'field2'  => array('title'=>'', 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			// 'field3'  => array('title'=>'', 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'height'=>'90px', 'editor_type'=>'simple|wysiwyg', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			// 'field4'  => array('title'=>'', 'type'=>'hidden',   					 'required'=>true, 'default'=>date('Y-m-d H:i:s'), 'visible'=>true),
			// 'field5'  => array('title'=>'', 'type'=>'enum',     'width'=>'',      'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_languages, 'default_option'=>'', 'unique'=>false, 'visible'=>true, 'javascript_event'=>'', 'view_type'=>'dropdownlist|checkboxes', 'multi_select'=>false),
			// 'field6'  => array('title'=>'', 'type'=>'checkbox', 					 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false, 'visible'=>true),
			// 'field7'  => array('title'=>'', 'type'=>'image',    'width'=>'210px', 'required'=>true, 'readonly'=>false, 'target'=>'uploaded/', 'no_image'=>'', 'random_name'=>true, 'image_name_pefix'=>'', 'overwrite_image'=>false, 'unique'=>false, 'visible'=>true, 'image_width'=>'120px', 'image_height'=>'90px', 'thumbnail_create'=>false, 'thumbnail_field'=>'', 'thumbnail_width'=>'', 'thumbnail_height'=>'', 'file_maxsize'=>'300k'),
			// 'field8'  => array('title'=>'', 'type'=>'file',     'width'=>'210px', 'required'=>true, 'readonly'=>false, 'target'=>'uploaded/', 'random_name'=>true, 'overwrite_image'=>false, 'unique'=>false, 'visible'=>true, 'file_maxsize'=>'300k'),
			// 'field9'  => array('title'=>'', 'type'=>'date',     					 'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'date', 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A', 'min_year'=>'90', 'max_year'=>'10'),
			// 'field10' => array('title'=>'', 'type'=>'datetime',                   'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'', 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A', 'min_year'=>'90', 'max_year'=>'10'),
			// 'field11' => array('title'=>'', 'type'=>'time', 					     'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'default'=>'', 'validation_type'=>'', 'format'=>'date', 'format_parameter'=>'H:i:s', 'show_seconds'=>true, 'minutes_step'=>'1'),
			// 'field12' => array('title'=>'', 'type'=>'password', 'width'=>'310px', 'required'=>true, 'validation_type'=>'password', 'cryptography'=>PASSWORDS_ENCRYPTION, 'cryptography_type'=>PASSWORDS_ENCRYPTION_TYPE, 'aes_password'=>PASSWORDS_ENCRYPT_KEY, 'visible'=>true),
		
			//  'separator_X'   =>array(
			//		'separator_info' => array('legend'=>'Legend Text', 'columns'=>'0'),
			//		'field1'  => array('title'=>'', 'type'=>'label'),
			// 		'field2'  => array('title'=>'', 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			// 		'field3'  => array('title'=>'', 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'readonly'=>false, 'maxlength'=>'', 'default'=>'', 'height'=>'90px', 'editor_type'=>'simple|wysiwyg', 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			//  )
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(

			'country_name' 	 => array('title'=>_COUNTRY, 'type'=>'label'),
			'priority_order' => array('title'=>_ORDER, 'type'=>'label'),
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_active_vm),

			// 'field1'  => array('title'=>'', 'type'=>'label', 'format'=>'', 'format_parameter'=>'', 'visible'=>true),
			// 'field2'  => array('title'=>'', 'type'=>'image', 'target'=>'uploaded/', 'no_image'=>'', 'image_width'=>'120px', 'image_height'=>'90px', 'visible'=>true),
			// 'field3'  => array('title'=>'', 'type'=>'date', 'format'=>'date', 'format_parameter'=>'M d, Y', 'visible'=>true),
			// 'field3'  => array('title'=>'', 'type'=>'datetime', 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A', 'visible'=>true),
			// 'field4'  => array('title'=>'', 'type'=>'time', 'format'=>'date', 'format_parameter'=>'g:i A', 'visible'=>true),
			// 'field5'  => array('title'=>'', 'type'=>'enum', 'source'=>array(), 'visible'=>true, 'view_type'=>'label|checkboxes', 'multi_select'=>false),
			// 'field6'  => array('title'=>'', 'type'=>'html', 'visible'=>true),
			// 'field7'  => array('title'=>'', 'type'=>'object', 'width'=>'240px', 'height'=>'200px', 'visible'=>true),

			//  'separator_X'   =>array(
			//		'separator_info' => array('legend'=>'Legend Text', 'columns'=>'0', 'visible'=>true),
            //  )
		);

		///////////////////////////////////////////////////////////////////////////////
		// #004. add translation fields to all modes
		$this->AddTranslateToModes(
		 $this->arrTranslations,
				array('name' => array('title'=>_NAME, 'type'=>'textbox', 'width'=>'410px', 'required'=>true, 'maxlength'=>'125', 'readonly'=>false),				
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
	 * Returns all hotels locations
	*/
	public static function GetHotelsLocations()
	{
		$lang_id = Application::Get('lang');
		$sql = 'SELECT
					hl.id, hl.country_id, hl.priority_order, hl.is_active,
					hld.name
				FROM ('.TABLE_HOTELS_LOCATIONS.' hl
					LEFT OUTER JOIN '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.' hld ON hl.id = hld.hotel_location_id AND hld.language_id = \''.$lang_id.'\')
				WHERE hl.is_active = 1
				ORDER BY hl.priority_order ASC'; 
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		return $result;
	}


	//==========================================================================
    // MicroGrid Methods
	//==========================================================================	
	/***
	 *	Get all DataSet array
	 *
	 *  public function GetAll() { }
	 *	
	 **/
	
	/**
	 * #005 Validate translation fields
	 */
	private function ValidateTranslationFields()	
	{
		// check for required fields		
	 	foreach($this->arrTranslations as $key => $val){			
	 		if($val['name'] == ''){
	 			$this->error = str_replace('_FIELD_', '<b>'._NAME.'</b>', _FIELD_CANNOT_BE_EMPTY);
	 			$this->errorField = 'name_'.$key;
	 			return false;
	 		}else if(strlen($val['name']) > 125){
	 			$this->error = str_replace('_FIELD_', '<b>'._NAME.'</b>', _FIELD_LENGTH_EXCEEDED);
	 			$this->error = str_replace('_LENGTH_', 125, $this->error);
	 			$this->errorField = 'name_'.$key;
	 			return false;
	 		}			
	 	}		
	 	return true;		
	}

	/**
	 *	Before-Insert
	 */
	public function BeforeInsertRecord()
	{
		return $this->ValidateTranslationFields();
	}

	/**
	 *	After-Insert
	 */
	public function AfterInsertRecord()
	{
		// $this->lastInsertId - currently inserted record
	    // $this->params - current record insert info
	 
		$sql = 'INSERT INTO '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.'(id, hotel_location_id, language_id, name) VALUES ';
		$count = 0;
		foreach($this->arrTranslations as $key => $val){
		   if($count > 0) $sql .= ',';
		   $sql .= '(NULL, '.$this->lastInsertId.', \''.$key.'\', \''.encode_text(prepare_input($val['name'])).'\')';
		   $count++;
		}
		if(database_void_query($sql)){
			return true;
		}else{
			//echo mysql_error();			
			return false;
		}
	}
	 
	/**
	 *	Before-Update
	 */
	public function BeforeUpdateRecord()
	{
		// $this->curRecordId - current record		
		return $this->ValidateTranslationFields();
	}

	/**
	 *	Before-Update
	 */
	public function AfterUpdateRecord()
	{
		// $this->curRecordId - currently updated record
	    // $this->params - current record update info
	   
		foreach($this->arrTranslations as $key => $val){
			$sql = 'UPDATE '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.'
					SET name = \''.encode_text(prepare_input($val['name'])).'\'					
				WHERE hotel_location_id = '.$this->curRecordId.' AND language_id = \''.$key.'\'';
			database_void_query($sql);
			//echo mysql_error();
		}
	}

	/**
	 *	Before-Update
	 */
	public function AfterDeleteRecord()
	{
		// $this->curRecordId - currently deleted record
		$sql = 'DELETE FROM '.TABLE_HOTELS_LOCATIONS_DESCRIPTION.' WHERE hotel_location_id = '.$this->curRecordId;
		if(database_void_query($sql)){
			return true;
		}else{
			return false;
		}
	}

	
}
?>