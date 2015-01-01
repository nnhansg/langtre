<?php

/**
 *	Code Template for Packages Class
 *  -------------- 
 *	Written by  : ApPHP
 *	Usage       : HotelSite ONLY
 *  Updated	    : 09.06.2012
 *
 *	PUBLIC				  	STATIC				 	PRIVATE
 * 	------------------	  	---------------     	---------------
 *	__construct             GetPackageInfo          CheckStartFinishDate
 *	__destruct              UpdateStatus            CheckDateOverlapping
 *	BeforeInsertRecord      GetMinimumNights        CheckMinMaxNights 
 *	BeforeUpdateRecord      GetMaximumNights
 *	
 **/


class Packages extends MicroGrid {
	
	protected $debug = false;
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();

		$this->params = array();
		
		## for standard fields
		if(isset($_POST['package_name']))   $this->params['package_name'] = prepare_input($_POST['package_name']);
		if(isset($_POST['start_date']))     $this->params['start_date'] = prepare_input($_POST['start_date']);
		if(isset($_POST['finish_date']))    $this->params['finish_date'] = prepare_input($_POST['finish_date']);
		if(isset($_POST['minimum_nights'])) $this->params['minimum_nights'] = prepare_input($_POST['minimum_nights']);
		if(isset($_POST['maximum_nights'])) $this->params['maximum_nights'] = prepare_input($_POST['maximum_nights']);
		
		## for checkboxes 
		$this->params['is_active'] = isset($_POST['is_active']) ? (int)$_POST['is_active'] : '0';

		## for images
		//if(isset($_POST['icon'])){
		//	$this->params['icon'] = prepare_input($_POST['icon']);
		//}else if(isset($_FILES['icon']['name']) && $_FILES['icon']['name'] != ''){
		//	// nothing 			
		//}else if (self::GetParameter('action') == 'create'){
		//	$this->params['icon'] = '';
		//}

		## for files:
		// define nothing

		//$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		//$this->uPrefix 		= 'prefix_';
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_PACKAGES;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=mod_booking_packages';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;

		$this->allowLanguages = false;
		$this->languageId  	= '';
		$this->WHERE_CLAUSE = ''; // WHERE .... 
		$this->ORDER_CLAUSE = ''; // ORDER BY '.$this->tableName.'.date_created DESC
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$this->isFilteringAllowed = false;
		// define filtering fields
		$this->arrFilteringFields = array(
			// 'Caption_1'  => array('table'=>'', 'field'=>'', 'type'=>'text', 'sign'=>'=|like%|%like|%like%', 'width'=>'80px'),
			// 'Caption_2'  => array('table'=>'', 'field'=>'', 'type'=>'dropdownlist', 'source'=>array(), 'sign'=>'=|like%|%like|%like%', 'width'=>'130px'),
		);

		$default_minimum_nights = ModulesSettings::Get('booking', 'minimum_nights');
		$default_maximum_nights = ModulesSettings::Get('booking', 'maximum_nights');
		
		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_nights = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9',
							'10'=>'10','14'=>'14','21'=>'21','28'=>'28','30'=>'30','45'=>'45','60'=>'60','90'=>'90');
		$arr_max_nights = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9',
							'10'=>'10','14'=>'14','21'=>'21','28'=>'28','30'=>'30','45'=>'45','60'=>'60','90'=>'90',
							'120'=>'120', '150'=>'150', '180'=>'180', '240'=>'240', '360'=>'360');

		//$date_format = get_date_format('view');
		$date_format_edit = get_date_format('edit');
		
		global $objSettings;
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$sqlFieldDateFormat = '%b %d, %Y';
		}else{
			$sqlFieldDateFormat = '%d %b, %Y';
		}

        // set locale time names
		$this->SetLocale(Application::Get('lc_time_name'));

		//---------------------------------------------------------------------- 
		// VIEW MODE
		// format: strip_tags
		// format: nl2br
		// format: 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A' + IF(date_created = '0000-00-00 00:00:00', '', date_created) as date_created,
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									package_name,
									DATE_FORMAT(start_date, \''.$sqlFieldDateFormat.'\') as start_date,
									DATE_FORMAT(finish_date, \''.$sqlFieldDateFormat.'\') as finish_date,
									minimum_nights,
									maximum_nights,
									is_active
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'package_name'    => array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'start_date'  	  => array('title'=>_START_DATE, 'type'=>'label', 'align'=>'center', 'width'=>'140px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>''),
			'finish_date'  	  => array('title'=>_FINISH_DATE, 'type'=>'label', 'align'=>'center', 'width'=>'140px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>''),
			'minimum_nights'  => array('title'=>_MINIMUM_NIGHTS, 'type'=>'label', 'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'maximum_nights'  => array('title'=>_MAXIMUM_NIGHTS, 'type'=>'label', 'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'is_active'       => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'80px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password
		// 	 Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255 ....
		//   Ex.: 'validation_maxlength'=>'255'
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(		    
			'package_name'    => array('title'=>_NAME, 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'50', 'default'=>'Package #_ '.@date('M Y'), 'validation_type'=>'text', 'unique'=>false, 'visible'=>true),
			'start_date'  	  => array('title'=>_START_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'finish_date'  	  => array('title'=>_FINISH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'1', 'max_year'=>'10'),
			'minimum_nights'  => array('title'=>_MINIMUM_NIGHTS, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'90px', 'source'=>$arr_nights, 'default'=>$default_minimum_nights, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1'),
			'maximum_nights'  => array('title'=>_MAXIMUM_NIGHTS, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'90px', 'source'=>$arr_max_nights, 'default'=>$default_maximum_nights, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1'),
			'is_active'       => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password
		//   Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255 ....
		//   Ex.: 'validation_maxlength'=>'255'
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.package_name,
								'.$this->tableName.'.start_date,
								'.$this->tableName.'.finish_date,
								'.$this->tableName.'.minimum_nights,
								'.$this->tableName.'.maximum_nights,
								DATE_FORMAT('.$this->tableName.'.start_date, \''.$sqlFieldDateFormat.'\') as mod_start_date,
								DATE_FORMAT('.$this->tableName.'.finish_date, \''.$sqlFieldDateFormat.'\') as mod_finish_date,								
								'.$this->tableName.'.is_active
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
			'package_name'    => array('title'=>_NAME, 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'50', 'default'=>'Package #_ '.@date('M Y'), 'validation_type'=>'text', 'unique'=>false, 'visible'=>true),
			'start_date'  	  => array('title'=>_START_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'50', 'max_year'=>'10'),
			'finish_date'  	  => array('title'=>_FINISH_DATE, 'type'=>'date', 'width'=>'210px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$date_format_edit, 'min_year'=>'50', 'max_year'=>'10'),
			'minimum_nights'  => array('title'=>_MINIMUM_NIGHTS, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'90px', 'source'=>$arr_nights, 'default'=>$default_minimum_nights, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1'),
			'maximum_nights'  => array('title'=>_MAXIMUM_NIGHTS, 'type'=>'enum', 'required'=>true, 'readonly'=>false, 'width'=>'90px', 'source'=>$arr_max_nights, 'default'=>$default_maximum_nights, 'unique'=>false, 'javascript_event'=>'', 'validation_minimum'=>'1'),
			'is_active'       => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'0', 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'package_name'    => array('title'=>_NAME, 'type'=>'label'),
			'mod_start_date'  => array('title'=>_START_DATE, 'type'=>'label'),
			'mod_finish_date' => array('title'=>_FINISH_DATE, 'type'=>'label'),
			'minimum_nights'  => array('title'=>_MINIMUM_NIGHTS, 'type'=>'label'),
			'maximum_nights'  => array('title'=>_MAXIMUM_NIGHTS, 'type'=>'label'),
			'is_active'       => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
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
	 * Return package info
	 */
	public static function GetPackageInfo()
	{
		$output = array('id'=>'', 'minimum_nights'=>'', 'maximum_nights'=>'');
		$sql = 'SELECT
					id,
					minimum_nights,
					maximum_nights,
					DATE_FORMAT(start_date, \'%M %d\') as start_date,
					DATE_FORMAT(finish_date, \'%M %d, %Y\') as finish_date,
					DATE_FORMAT(finish_date, \'%m/%d/%Y\') as formated_finish_date,
					DATE_FORMAT(finish_date, \'%Y\') as fd_y,
					DATE_FORMAT(finish_date, \'%m\') as fd_m,
					DATE_FORMAT(finish_date, \'%d\') as fd_d
				FROM '.TABLE_PACKAGES.'
				WHERE
                    \''.@date('Y-m-d').'\' >= start_date AND
                    \''.@date('Y-m-d').'\' <= finish_date AND
                    is_active = 1
				ORDER BY start_date DESC';
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$output['id'] = $result[0]['id']; 
			$output['minimum_nights'] = $result[0]['minimum_nights'];
			$output['maximum_nights'] = $result[0]['maximum_nights']; 
		}
		return $output;		
	}
	
	/**
	 *	Before-Insertion record
	 */
	public function BeforeInsertRecord()
	{
		if(!$this->CheckStartFinishDate()) return false;
		if(!$this->CheckDateOverlapping()) return false;
		if(!$this->CheckMinMaxNights()) return false;
		return true;
	}

	/**
	 *	Before-updating record
	 */
	public function BeforeUpdateRecord()
	{
		if(!$this->CheckStartFinishDate()) return false;
		if(!$this->CheckDateOverlapping()) return false;
		if(!$this->CheckMinMaxNights()) return false;
		return true;
	}
	
	/**
	 * Check if start date is greater than finish date
	 */
	private function CheckStartFinishDate()
	{
		$start_date = MicroGrid::GetParameter('start_date', false);
		$finish_date = MicroGrid::GetParameter('finish_date', false);
		
		if($start_date > $finish_date){
			$this->error = _START_FINISH_DATE_ERROR;
			return false;
		}	
		return true;		
	}
	
	/**
	 * Check if there is a date overlapping
	 */
	private function CheckDateOverlapping()
	{
		$rid = MicroGrid::GetParameter('rid');
		$start_date = MicroGrid::GetParameter('start_date', false);
		$finish_date = MicroGrid::GetParameter('finish_date', false);

		$sql = 'SELECT * FROM '.TABLE_PACKAGES.'
				WHERE
					id != '.(int)$rid.' AND 
					is_active = 1 AND 
					(((\''.$start_date.'\' >= start_date) AND (\''.$start_date.'\' <= finish_date)) OR
					((\''.$finish_date.'\' >= start_date) AND (\''.$finish_date.'\' <= finish_date))) ';	
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$this->error = _TIME_PERIOD_OVERLAPPING_ALERT;
			return false;
		}
		return true;
	}
	
	/**
	 * Check if there is a min/max nights overlapping
	 */
	private function CheckMinMaxNights()
	{
		$rid = MicroGrid::GetParameter('rid');
		$min_nights = MicroGrid::GetParameter('minimum_nights', false);
		$max_nights = MicroGrid::GetParameter('maximum_nights', false);

		if($max_nights < $min_nights){
			$this->error = str_replace(array('_FIELD_', '_MIN_'), array('<b>'._MAXIMUM_NIGHTS.'</b>', $min_nights), _FIELD_VALUE_MINIMUM);
			return false;
		}
		return true;
	}

	/**
	 * Update package status
	 */
	public static function UpdateStatus()
	{
		$sql = 'UPDATE '.TABLE_PACKAGES.'
				SET is_active = 0
				WHERE finish_date < \''.@date('Y-m-d').'\' AND is_active = 1';    
		database_void_query($sql);
	}
	
	/**
	 * Get minimum nights for certain period
	 * 		@param $check_in
	 * 		@param $check_out
	 */
	public static function GetMinimumNights($check_in, $check_out)
	{
		$output = array('minimum_nights'=>'', 'start_date'=>'', 'finish_date'=>'');
		$sql = 'SELECT minimum_nights, start_date, finish_date
				FROM '.TABLE_PACKAGES.'
				WHERE
					is_active = 1 AND 
					(((\''.$check_in.'\' >= start_date) AND (\''.$check_in.'\' <= finish_date)) OR
					((\''.$check_out.'\' >= start_date) AND (\''.$check_out.'\' <= finish_date))) ';	
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){			
			$output['minimum_nights'] = $result[0]['minimum_nights'];
			$output['start_date']     = $result[0]['start_date'];
			$output['finish_date']    = $result[0]['finish_date'];
			
		}
	    return $output;
	}

	/**
	 * Get maximum nights for certain period
	 */
	public static function GetMaximumNights($check_in, $check_out)
	{
		$sql = 'SELECT maximum_nights
				FROM '.TABLE_PACKAGES.'
				WHERE
					is_active = 1 AND 
					(((\''.$check_in.'\' >= start_date) AND (\''.$check_in.'\' <= finish_date)) OR
					((\''.$check_out.'\' >= start_date) AND (\''.$check_out.'\' <= finish_date))) ';	
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){			
			return $result[0]['maximum_nights'];
		}
	    return '365';
	}
}

?>