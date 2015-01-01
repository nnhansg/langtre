<?php

/**
 *	Coupons Class
 *  --------------
 *	Description : encapsulates methods and properties for Coupons
 *	Written by  : ApPHP
 *	Version     : 1.0.1
 *  Updated	    : 02.07.2012
 *  Usage       : HotelSite, ShoppingCart
 *	Differences : no
 *
 *	PUBLIC				  	STATIC				 	PRIVATE
 * 	------------------	  	---------------     	---------------
 *	__construct             GetCouponInfo           CheckStartFinishDate
 *	__destruct                                      
 *	BeforeInsertRecord
 *	BeforeUpdateRecord
 *
 *  1.0.1
 *      - added 'enum' types instead of SQL CASEs
 *      - replaced " with '
 *      - added SetLocale
 *      - maximum value for discount 100%
 *      -
 *	
 **/


class Coupons extends MicroGrid {
	
	protected $debug = false;
	
	// #001 private $arrTranslations = '';		
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();

		$this->params = array();
		
		## for standard fields
		if(isset($_POST['coupon_code'])) $this->params['coupon_code'] = prepare_input($_POST['coupon_code']);
		if(isset($_POST['date_started'])) $this->params['date_started'] = prepare_input($_POST['date_started']);
		if(isset($_POST['date_finished'])) $this->params['date_finished'] = prepare_input($_POST['date_finished']);
		if(isset($_POST['comments'])) $this->params['comments'] = prepare_input($_POST['comments']);
		if(isset($_POST['discount_percent']))  $this->params['discount_percent'] = prepare_input($_POST['discount_percent']);
		
		## for checkboxes 
		$this->params['is_active'] = isset($_POST['is_active']) ? (int)$_POST['is_active'] : '0';

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

		$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		//$this->uPrefix 		= 'prefix_';
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_COUPONS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=mod_booking_coupons';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = false;
		$this->alertOnDelete = ''; // leave empty to use default alerts

		$this->allowLanguages = false;
		$this->languageId  	= ''; //($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();
		$this->WHERE_CLAUSE = ''; // WHERE .... / 'WHERE language_id = \''.$this->languageId.'\'';				
		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.id DESC';
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$this->isExportingAllowed = false;
		$this->arrExportingTypes = array('csv'=>false);
		
		$this->isFilteringAllowed = false;
		// define filtering fields
		$this->arrFilteringFields = array(
			// 'Caption_1'  => array('table'=>'', 'field'=>'', 'type'=>'text', 'sign'=>'=|like%|%like|%like%', 'width'=>'80px', 'visible'=>true),
			// 'Caption_2'  => array('table'=>'', 'field'=>'', 'type'=>'dropdownlist', 'source'=>array(), 'sign'=>'=|like%|%like|%like%', 'width'=>'130px', 'visible'=>true),
		);
		
		$arr_active = array('0'=>_NO, '1'=>_YES);
		$arr_discount = array();
		for($i=0; $i<=100; $i+=5){
			$arr_discount[$i] = $i;
			if($i == 30) $arr_discount[33] = 33;
			else if($i == 60) $arr_discount[66] = 66;
		}
		$new_coupon_code = strtoupper(get_random_string(4).'-'.get_random_string(4).'-'.get_random_string(4).'-'.get_random_string(4));
		$date_format = get_date_format('view');
		$date_format_edit = get_date_format('edit');				
		$currency_format = get_currency_format();

		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		
		global $objSettings;
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$sqlFieldDateFormat = '%b %d, %Y';
		}else{
			$sqlFieldDateFormat = '%d %b, %Y';
		}

        // set locale time names
		$this->SetLocale(Application::Get('lc_time_name'));

		// prepare languages array		
		/// $total_languages = Languages::GetAllActive();
		/// $arr_languages      = array();
		/// foreach($total_languages[0] as $key => $val){
		/// 	$arr_languages[$val['abbreviation']] = $val['lang_name'];
		/// }

		///////////////////////////////////////////////////////////////////////////////
		// #002. prepare translation fields array
		/// $this->arrTranslations = $this->PrepareTranslateFields(
		///	array('field1', 'field2')
		/// );
		///////////////////////////////////////////////////////////////////////////////			

		///////////////////////////////////////////////////////////////////////////////			
		// #003. prepare translations array for add/edit/detail modes
		/// $sql_translation_description = $this->PrepareTranslateSql(
		///	TABLE_XXX_DESCRIPTION,
		///	'gallery_album_id',
		///	array('field1', 'field2')
		/// );
		///////////////////////////////////////////////////////////////////////////////			

		//---------------------------------------------------------------------- 
		// VIEW MODE
		// format: strip_tags
		// format: nl2br
		// format: 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A'
		// format: 'format'=>'currency', 'format_parameter'=>'european|2' or 'format_parameter'=>'american|4'
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									coupon_code,
									DATE_FORMAT(date_started, "'.$sqlFieldDateFormat.'") as date_started,
									DATE_FORMAT(date_finished, "'.$sqlFieldDateFormat.'") as date_finished,
									discount_percent,
									comments,
									is_active
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'coupon_code'      => array('title'=>_COUPON_CODE, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'date_started'     => array('title'=>_START_DATE, 'type'=>'label', 'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>''),
			'date_finished'    => array('title'=>_FINISH_DATE, 'type'=>'label', 'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>''),
			'discount_percent' => array('title'=>_DISCOUNT, 'type'=>'label', 'align'=>'center', 'width'=>'100px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>'', 'format'=>'currency', 'format_parameter'=>$currency_format.'|2', 'post_html'=>'%'),
			'is_active'        => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
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
			'coupon_code'      => array('title'=>_COUPON_CODE, 'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'19', 'default'=>$new_coupon_code, 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			'date_started'     => array('title'=>_START_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'date_finished'    => array('title'=>_FINISH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'discount_percent' => array('title'=>_DISCOUNT, 'type'=>'enum',     'required'=>true, 'readonly'=>false, 'width'=>'65px', 'source'=>$arr_discount, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1', 'post_html'=>' %'),
			'comments'         => array('title'=>_COMMENTS, 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'height'=>'90px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'validation_maxlength'=>'512', 'unique'=>false),
			'is_active'        => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password|date
		//   Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255... Ex.: 'validation_maxlength'=>'255'
		// - Validation Min Length: 4, 6... Ex.: 'validation_minlength'=>'4'
		// - Validation Max Value: 12, 255... Ex.: 'validation_maximum'=>'99.99'
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								coupon_code,
								date_started,
								date_finished,
								DATE_FORMAT('.$this->tableName.'.date_started, "'.$sqlFieldDateFormat.'") as mod_date_started,
								DATE_FORMAT('.$this->tableName.'.date_finished, "'.$sqlFieldDateFormat.'") as mod_date_finished,
								discount_percent,
								comments,
								is_active
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(	
			'coupon_code'      => array('title'=>_COUPON_CODE, 'type'=>'textbox', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'19', 'default'=>$new_coupon_code, 'validation_type'=>'', 'unique'=>false, 'visible'=>true),
			'date_started'     => array('title'=>_START_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'date_finished'    => array('title'=>_FINISH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'discount_percent' => array('title'=>_DISCOUNT, 'type'=>'enum',     'required'=>true, 'readonly'=>false, 'width'=>'65px', 'source'=>$arr_discount, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1', 'post_html'=>' %'),
			'comments'         => array('title'=>_COMMENTS, 'type'=>'textarea', 'width'=>'310px', 'required'=>false, 'height'=>'90px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'validation_maxlength'=>'512', 'unique'=>false),
			'is_active'        => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'coupon_code'    => array('title'=>_COUPON_CODE, 'type'=>'label'),
			'mod_date_started'  => array('title'=>_START_DATE, 'type'=>'label'),
			'mod_date_finished' => array('title'=>_FINISH_DATE, 'type'=>'label'),
			'discount_percent' => array('title'=>_DISCOUNT, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$currency_format.'|2', 'post_html'=>'%'),
			'comments'         => array('title'=>_COMMENTS, 'type'=>'label'),
			'is_active'        => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
		);

		///////////////////////////////////////////////////////////////////////////////
		// #004. add translation fields to all modes
		/// $this->AddTranslateToModes(
		/// $this->arrTranslations,
		/// array('name'        => array('title'=>_NAME, 'type'=>'textbox', 'width'=>'410px', 'required'=>true, 'maxlength'=>'', 'readonly'=>false),
		/// 	  'description' => array('title'=>_DESCRIPTION, 'type'=>'textarea', 'width'=>'410px', 'height'=>'90px', 'required'=>false, 'readonly'=>false)
		/// )
		/// );
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
	 *	Before-Insertion record
	 */
	public function BeforeInsertRecord()
	{
		if(!$this->CheckStartFinishDate()) return false;
		return true;
	}
	
	/**
	 *	Before-updating record
	 */
	public function BeforeUpdateRecord()
	{
		if(!$this->CheckStartFinishDate()) return false;
		return true;
	}
	
	/**
	 *	Get coupon info
	 */
	public static function GetCouponInfo($coupon_code = '')
	{
		if(empty($coupon_code)) return false;
		
		$output = array();
		
		$current_date = @date('Y-m-d');
		$sql = 'SELECT * FROM '.TABLE_COUPONS.'
				WHERE
					coupon_code = \''.$coupon_code.'\' AND
					is_active = 1 AND 
					(\''.$current_date.'\' >= date_started AND \''.$current_date.'\' <= date_finished)';	
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$output = $result[0];
		}
		return $output;
	}
	
	/**
	 * Check if start date is greater than finish date
	 */
	private function CheckStartFinishDate()
	{
		$date_started = MicroGrid::GetParameter('date_started', false);
		$date_finished = MicroGrid::GetParameter('date_finished', false);
		
		if($date_started > $date_finished){
			$this->error = _START_FINISH_DATE_ERROR;
			return false;
		}	
		return true;		
	}
	
	/**
	 * Updates coupons status
	 */
	public static function UpdateStatus()
	{
		$sql = 'UPDATE '.TABLE_COUPONS.'
				SET is_active = 0
				WHERE date_finished < \''.@date('Y-m-d').'\' AND is_active = 1';    
		database_void_query($sql);
	}

}
?>