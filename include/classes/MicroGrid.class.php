<?php

/**
 *	Class MicroGrid
 *  -------------- 
 *  Description : encapsulates grid operations & properties
 *	Written by  : ApPHP
 *	Version     : 1.7.7
 *  Updated	    : 11.11.2012
 *  Usage       : Core Class (ALL)
 *
 * 	PUBLIC:					PROTECTED:				    PRIVATE:				STATIC:
 *  -------		            ----------          	    --------                -------
 *	__construct				IsEmail					    GetDataEncodedText   	GetParameter
 *	__destruct				IsNumeric				    GetDataDecodedText		GetRandomString
 *	GetAll					IsFloat					    GetDataEncoded          GetCalledClass
 *	GetInfoByID				IsAlpha					    GetDataDecoded          GetStaticError
 *	GetRecord				IsAlphaNumeric			    FieldsValidation        Instance  
 *	AddRecord				IsText					    ValidateField
 *	UpdateRecord			IsPassword				    CryptValue
 *	DeleteRecord			IsIpAddress				    UncryptValue
 *	BeforeAddRecord		    IsInteger				    FindUniqueFields
 *	BeforeInsertRecord		ResizeImage         	    RemoveFileImage
 *  BeforeEditRecord        IncludeJSFunctions		    ParamEmpty 
 *	BeforeUpdateRecord		DrawErrors				    DrawAddModeButtons
 *	BeforeDeleteRecord		DrawWarnings        	    DrawEditModeButtons
 *	BeforeViewRecords       SetSQLs             	    DrawDetailsModeButtons
 *	BeforeDetailsRecord     DrawSQLs            	    DrawRequiredAsterisk
 *	AfterAddRecord          DrawPostInfo                DrawHeaderTooltip
 *	AfterInsertRecord		GetOSName                   DrawTextareaMaxlength
 *	AfterEditRecord         DeleteImages                DrawImageText
 *	AfterUpdateRecord		GetFormattedMicrotime       FormatFieldValue 
 *	AfterDeleteRecord		SetRunningTime              IsVisible 
 *	AfterViewRecords        DrawRunningTime             PrepareEnumValue
 *	AfterDetailsMode        OnItemCreated_ViewMode      ConvertFileSize
 *	DrawViewMode			OnItemCreated_DetailsMode   DrawVersionInfo
 *	DrawAddMode				CalendarSetupFields         IsSecureField
 *	DrawEditMode			SetLocale 
 *	DrawDetailsMode			 
 *	DrawFieldByType			
 *	DrawOperationLinks		
 *	PrepareTranslateFields  
 *	PrepareTranslateSql
 *	AddTranslateToModes
 *	SetActions
 *	PrepareDateTime
 *	GetMaxOrder
 *
 *  1.7.7 
 *      - changes in DrawDetailsMode()
 *      - added new view_type for "enum" fields in Edit Mode - label
 *      - added possibility to encrypt all other fields
 *      - added possibility to encrypt filtering fields
 *      -
 *  1.7.6
 *      - added automatic lang selction for floating calendar
 *      - changed IsAlphaNumeric
 *      - fixed bug when 'default' attribute is not defined for 'hidden' fields
 *      - fields bug for missing 'week_start_day'
 *      - added "readonly_text" as a format 
 *  1.7.5
 *      - added ID for rows in Details Mode
 *      - fixed issue with detection unique empty field
 *      - added GROUP_BY_CLAUSE
 *      - added new optional params to aggregate functions: 'aggregate_by'=>'tp_wo_currency', 'decimal_place'=>2
 *      - improved debug info
 *  1.7.4
 *      - bug fixed in uploading empty image 
 *      - <font> replaced with <span>
 *      - fixed issue with wrong insertion/updating of unchecked checkboxes in Add/Edit modes
 *      - added editor_type for textarea III type template
 *      - added new triggers AfterAddRecord(), AfterEditRecord() and AfterViewRecords()
 *  1.7.3
 *      - added GetMaxOrder()
 *      - added 'align' attibute for aggregate fields
 *      - added type="password" for password fields
 *      - implemented maxlength for textareas
 *      - added check id uploaded file is a valid image (if defined)
 *  1.7.2
 *      - blocked export for empty recordset
 *      - added @ to unserialize
 *      - fixed error on empty file_maxsize
 *      - $output .= '//-->'.$nl; fix
 *      - added check for mb_strlen()
 *  1.7.1
 *      - fixed align issue for operationLinks
 *      - firstDay for calendar fields depending on global settings
 *      - fixed issue with empty row in Edit mode
 *      - added SetLocale()
 *      - minor changes in DrawTextareaMaxlength()
 *  1.7.0
 *      - added default_option = false for "enum" types
 *      - added 'columns'=>'' for 'separator_info'
 *      - added automatically showed file size in tooltips in Edit Mode
 *      - bug fixed with wrong drawing columns if empty align=''
 *      - minor changes in drawing of 'enum' type in details mode
 *
 * /////////////////////////////////////////////////////////////////////////////
 * IN TEST:
 *      [#001 - 01.03.12] removed $v_val['type'] != 'enum' - doesn't save selected value on reloading
 *	
 **/

class MicroGrid {
	
	public $error;	
	
	protected $debug = false;
		
	protected $tableName;
	protected $primaryKey;
	protected $dataSet;
	protected $lastInsertId;
	
	protected $formActionURL;
	protected $params;
	protected $actions;
	protected $actionIcons;
	protected $errorField;
	protected $arrErrors;
	protected $arrWarnings;
	protected $arrSQLs;
	protected $alertOnDelete;	

	protected $languageId;
	protected $allowLanguages;
	protected $allowRefresh;
	protected $allowTopButtons;
	
	protected $VIEW_MODE_SQL;
	protected $EDIT_MODE_SQL;	
	protected $DETAILS_MODE_SQL;
	protected $WHERE_CLAUSE;
    protected $GROUP_BY_CLAUSE;
	protected $ORDER_CLAUSE;
	protected $LIMIT_CLAUSE;
	
	protected $arrViewModeFields;	
	protected $arrAddModeFields;	
	protected $arrEditModeFields;
	protected $arrDetailsModeFields;
	protected $result;	
	protected $isHtmlEncoding;	
	protected $isAlterColorsAllowed;	
	protected $isPagingAllowed;	
	protected $isSortingAllowed;	
	protected $isExportingAllowed;
	protected $arrExportingTypes;	
	protected $isFilteringAllowed;
	protected $arrFilteringFields;
    protected $isAggregateAllowed;
    protected $arrAggregateFields;
    protected $arrAggregateFieldsTemp;    
	protected $arrImagesFields;
	protected $uPrefix;
	protected static $static_error = '';	
	
	private $startTime;
	private $operationLinks;	
    private $version = '1.6.9';
	private static $instance;
	
	
	//==========================================================================
    // Class Constructor
	//		@param $id
	//==========================================================================
	function __construct($id = '')
	{
		$this->SetRunningTime();
		
		$this->params = array();

		$this->isHtmlEncoding = false;
		
		$this->uPrefix          = '';
		
		$this->primaryKey       = '';
		$this->tableName        = '';
		$this->formActionURL    = '';
		
		$this->languageId  	    = '';
		$this->allowLanguages   = false;
		$this->allowRefresh     = false;
		$this->allowTopButtons  = false;

		$this->VIEW_MODE_SQL    = '';
		$this->EDIT_MODE_SQL    = '';
		$this->DETAILS_MODE_SQL = '';
		$this->WHERE_CLAUSE     = '';
        $this->GROUP_BY_CLAUSE  = '';
		$this->ORDER_CLAUSE     = '';	
		$this->LIMIT_CLAUSE     = '';
		
		$this->arrViewModeFields    = array();
		$this->arrAddModeFields     = array();
		$this->arrEditModeFields    = array();
		$this->arrDetailsModeFields = array();
		$this->arrFilterModeFields  = array();
		
		$this->actions = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons = false;
		
		$this->dataSet = array();
		$this->lastInsertId = '';
		$this->curRecordId = '';
		$this->arrErrors = array();
		$this->arrWarnings = array();
		$this->arrSQLs = array();
		$this->error = '';
		$this->errorField = '';
		$this->alertOnDelete = '';
		
		$this->isAlterColorsAllowed = true;
		
		$this->isPagingAllowed = true;
		$this->pageSize = 20;
		
		$this->isSortingAllowed = true;

		$this->isExportingAllowed = false;
		$this->arrExportingTypes = array('csv'=>false);

		$this->isFilteringAllowed = true;
		$this->arrFilteringFields = array();

		$this->isAggregateAllowed = false;
		$this->arrAggregateFields = array();
        $this->arrAggregateFieldsTemp = array();
		
		$this->arrImagesFields = array();		
	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }


	/**
	 *	Returns DataSet array
	 *		@param $order_clause
	 *		@param $limit_clause
	 */
	public function GetAll($order_clause = '', $limit_clause = '')
	{
		$sql = $this->VIEW_MODE_SQL.' '.$this->WHERE_CLAUSE.' '.$this->GROUP_BY_CLAUSE.' '.$order_clause.' '.$limit_clause;
        if($this->debug) $start_time = $this->GetFormattedMicrotime();
        $result = database_query($sql, DATA_AND_ROWS);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();        
		if($this->debug) $this->arrSQLs['select_get_all'] = '<i>Retrieve Records</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$sql;
		return $result;
	}

	/**
	 *	Returns info by ID
	 *		@param $key
	 */
	public function GetInfoByID($key = '')
	{
		$sql = 'SELECT * FROM '.$this->tableName.' WHERE '.$this->primaryKey.'='.(int)$key.' LIMIT 0, 1';
		return database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
	}
	
	/**
	 *	Returns one record
	 *		@param $sql
	 */
	public function GetRecord($sql = '')
	{
		return database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
	}
	
	/***************************************************************************
	 *
	 *	ADD NEW RECORD
	 *	
	 **************************************************************************/
	public function AddRecord()
	{		
		//----------------------------------------------------------------------
		// block if this is a demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;				
		}

		//----------------------------------------------------------------------
		// F5 validation
		if(!$this->F5Validation()){
			return true;
		}		

		//----------------------------------------------------------------------
		// fields data validation
		if(!$this->FieldsValidation($this->arrAddModeFields)){
			return false;
		}		

		//----------------------------------------------------------------------
		// pre addition check
		if(!$this->BeforeInsertRecord()){
			return false;
		}

		//----------------------------------------------------------------------
		// check for unique fields
		if($this->FindUniqueFields('add')){
			return false;
		}

		//----------------------------------------------------------------------
		// prepare (handle) uploaded files
		$arrUploadedFiles = array();
        if(!$this->UploadFileImage('add', $arrUploadedFiles)){
            return false;
        }
		
		//----------------------------------------------------------------------
		// prepare INSERT SQL
		$sql = 'INSERT INTO `'.$this->tableName.'`(';
			$sql .= $this->primaryKey;
			foreach($this->params as $key => $val){
				if(array_key_exists($key, $this->arrAddModeFields)){
					$sql .= ', `'.$key.'`';
				}else{
					foreach($this->arrAddModeFields as $v_key => $v_val){
						if(array_key_exists($key, $v_val)){
							$sql .= ', `'.$key.'`';
						}							
					}
				}
			}
			foreach($arrUploadedFiles as $key => $val){
				$sql .= ', `'.$key.'`';
			}
		$sql .= ') VALUES (';
			$sql .= 'NULL';
			foreach($this->params as $key => $val){
				if(array_key_exists($key, $this->arrAddModeFields)){
					if($this->arrAddModeFields[$key]['type'] == 'password' || $this->IsSecureField($key, $this->arrAddModeFields[$key])){
						$sql .= ', '.$this->CryptValue($key, $this->arrAddModeFields[$key], $val);
                    }else if($this->arrAddModeFields[$key]['type'] == 'enum'){
                        $sql .= ', '.$this->PrepareEnumValue($key, $this->arrAddModeFields[$key], $val);                        
					}else{
						$sql .= ', \''.mysql_real_escape_string($val).'\'';
					}										
				}else{
					foreach($this->arrAddModeFields as $v_key => $v_val){
						if(array_key_exists($key, $v_val)){
							if($v_val[$key]['type'] == 'password' || $this->IsSecureField($key, $v_val[$key])){
								$sql .= ', '.$this->CryptValue($key, $v_val[$key], $val);
                            }else if($v_val[$key]['type'] == 'enum'){
                                $sql .= ', '.$this->PrepareEnumValue($key, $v_val[$key], $val);
							}else{
								$sql .= ', \''.mysql_real_escape_string($val).'\'';
							}					
						}							
					}
				}
			}
			foreach($arrUploadedFiles as $key => $val){
				$sql .= ', \''.$val.'\'';
			}
		$sql .= ')';
		
        if($this->debug) $start_time = $this->GetFormattedMicrotime();
        $result = database_void_query($sql);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();        
		if($this->debug) $this->arrSQLs['insert_sql'] = '<i>Insert Record</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$sql;
		if(!$result){
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', ''); 
			if($this->debug) $this->arrErrors['insert_sql'] = $sql.'<br>'.mysql_error();			
			$this->error = _TRY_LATER;
			return false;
		}else{
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', self::GetParameter('operation_code'));
			$this->lastInsertId = mysql_insert_id();
			if(!$this->lastInsertId){
				$res = database_query('SELECT MAX('.$this->primaryKey.') as max_id FROM '.$this->tableName, DATA_ONLY);
				$this->lastInsertId = isset($res[0]['max_id']) ? $res[0]['max_id'] : 0;
			}
			$this->AfterInsertRecord();
			return true;
		}		
	}

	/***************************************************************************
	 *
	 *	UPDATE RECORD
	 *	
	 **************************************************************************/
	public function UpdateRecord($rid = '0')
	{		
		$this->curRecordId = $rid;

		//----------------------------------------------------------------------
		// block if this is a demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;				
		}		
			
		//----------------------------------------------------------------------
		// check if we work with valid record
		if($this->curRecordId == '0' || $this->curRecordId == '' || !is_numeric($this->curRecordId)){
			$this->error = _WRONG_PARAMETER_PASSED;
			return false;
		}		

		//----------------------------------------------------------------------
		// F5 validation
		if(!$this->F5Validation()){
			return true;
		}		

		//----------------------------------------------------------------------
		// fields data validation
		if(!$this->FieldsValidation($this->arrEditModeFields)){
			return false;
		}		

		//----------------------------------------------------------------------
		// pre updating check
		if(!$this->BeforeUpdateRecord()){
			return false;
		}

		//----------------------------------------------------------------------
		// check for unique fields
		if($this->FindUniqueFields('edit', $this->curRecordId)){
			return false;
		}

		//----------------------------------------------------------------------
		// prepare (handle) uploaded files
		$arrUploadedFiles = array();
        if(!$this->UploadFileImage('edit', $arrUploadedFiles)){
            return false;
        }
		
		//----------------------------------------------------------------------
		// update
		$sql = 'UPDATE `'.$this->tableName.'` SET ';
			$fields_count = 0;
			foreach($this->params as $key => $val){
				if(array_key_exists($key, $this->arrEditModeFields)){
					if($fields_count++ > 0) $sql .= ',';
					if($this->arrEditModeFields[$key]['type'] == 'password' || $this->IsSecureField($key, $this->arrEditModeFields[$key])){
						$sql .= '`'.$key.'` = '.$this->CryptValue($key, $this->arrEditModeFields[$key], $val);
                    }else if($this->arrEditModeFields[$key]['type'] == 'enum'){
                        $sql .= '`'.$key.'` = '.$this->PrepareEnumValue($key, $this->arrEditModeFields[$key], $val);
					}else{
						$sql .= '`'.$key.'` = \''.mysql_real_escape_string($val).'\'';					
					}
				}else{
					foreach($this->arrEditModeFields as $v_key => $v_val){
						if(array_key_exists($key, $v_val)){
							if($fields_count++ > 0) $sql .= ',';
							if($v_val[$key]['type'] == 'password' || $this->IsSecureField($key, $v_val[$key])){
								$sql .= '`'.$key.'` = '.$this->CryptValue($key, $v_val[$key], $val);
                            }else if($v_val[$key]['type'] == 'enum'){
                                $sql .= '`'.$key.'` = '.$this->PrepareEnumValue($key, $v_val[$key], $val);
							}else{
								$sql .= '`'.$key.'` = \''.mysql_real_escape_string($val).'\'';					
							}					
						}							
					}
				}
			}				
			foreach($arrUploadedFiles as $key => $val){
				if($fields_count > 0) $sql .= ',';
				$sql .= '`'.$key.'` = \''.mysql_real_escape_string($val).'\'';					
			}
		$sql .= ' WHERE `'.$this->primaryKey.'`='.(int)$this->curRecordId;
		

        if($this->debug) $start_time = $this->GetFormattedMicrotime();
        $result = database_void_query($sql);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();        
		if($this->debug) $this->arrSQLs['update_sql'] = '<i>Update Record</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$sql;
		if(!$result){
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', '');
			if($this->debug) $this->arrErrors['update_sql'] = $sql.'<br>'.mysql_error();						
			$this->error = _TRY_LATER;
			return false;
		}else{
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', self::GetParameter('operation_code'));			
			$this->AfterUpdateRecord();
			return true;
		}			
	}

	/***************************************************************************
	 *
	 *	DELETE RECORD
	 *	
	 **************************************************************************/
	public function DeleteRecord($rid = '')
	{
		$this->curRecordId = $rid;

		//----------------------------------------------------------------------
		// check if rid is not empty
		if($this->curRecordId == ''){				
			$this->error = _WRONG_PARAMETER_PASSED;
			return false;
		}
		
		//----------------------------------------------------------------------
		// block if this is a demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;				
		}
		
		//----------------------------------------------------------------------
		// F5 validation
		if(!$this->F5Validation()){
			return false;
		}		

		//----------------------------------------------------------------------
		// pre deleting check
		if(!$this->BeforeDeleteRecord()){
			return false;
		}

		$this->PrepareImagesArray($this->curRecordId);

		//----------------------------------------------------------------------
		// delete
		$sql = 'DELETE FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.(int)$this->curRecordId;
        if($this->debug) $start_time = $this->GetFormattedMicrotime();
        $result = database_void_query($sql);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();        
		if($result > 0){
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', self::GetParameter('operation_code'));
			$this->DeleteImages();
			if($this->debug) $this->arrSQLs['delete_sql'] = '<i>Delete Record</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$sql;
			$this->AfterDeleteRecord();
			return true;
		}else{
			if(isset($_SESSION)) Session::Set($this->uPrefix.'_operation_code', '');			
			if($this->debug) $this->arrErrors['delete_sql'] = $sql.'<br>'.mysql_error();
			$this->error = _TRY_LATER;
			return false;
		}
	}
	
	/**
	 *	'Before'-operation methods
	 */
	public function BeforeAddRecord()
	{
		// your code here...
	}

	public function BeforeInsertRecord()
	{
		return true;
	}

	public function BeforeEditRecord()
	{
		// $this->curRecordId - currently editing record
		// $this->result - current record info
	}
	
	public function BeforeUpdateRecord()
	{
		return true;
	}

	public function BeforeDeleteRecord()
	{
		return true;
	}

	public function BeforeViewRecords()
	{
		// your code here...
	}

	public function BeforeDetailsRecord()
	{
		// your code here...
	}

	/**
	 *	'After'-operation methods
	 */
	public function AfterInsertRecord()
	{
		// $this->lastInsertId - currently inserted record
	}

	public function AfterUpdateRecord()
	{
		// $this->curRecordId - currently updated record
	}

	public function AfterDeleteRecord()
	{
		// $this->curRecordId - currently deleted record
	}

	public function AfterAddRecord()
	{
		// your code here...
	}

	public function AfterEditRecord()
	{
		// $this->curRecordId - currently editing record
		// $this->result - current record info
	}

	public function AfterViewRecords()
	{
		// your code here...
	}

	public function AfterDetailsMode()
	{
		// $this->curRecordId - currently viewed record
	}

	/***********************************************************************
	 *
	 *	Draw View Mode
	 *	
	 ***********************************************************************/
	public function DrawViewMode()
	{        
		$this->IncludeJSFunctions();
        
        $this->BeforeViewRecords();
		
		$sorting_fields  = self::GetParameter('sorting_fields');
		$sorting_types   = self::GetParameter('sorting_types');
		$page 			 = self::GetParameter('page');
		$total_pages	 = $page;

		$rid 		     = self::GetParameter('rid');
        $action          = self::GetParameter('action');
		$operation 		 = self::GetParameter('operation');
		$operation_type  = self::GetParameter('operation_type');
		$operation_field = self::GetParameter('operation_field');
		
		$search_status   = self::GetParameter('search_status');
		
		$concat_sign 	 = (preg_match('/\?/', $this->formActionURL) ? '&' : '?');		
		$colspan 		 = count($this->arrViewModeFields)+1;
		$start_row 		 = 0;
		$total_records 	 = 0;
		$sort_by         = '';
		$export_content  = array();
        $calendar_fields = array();
        $nl = "\n";

		// prepare changing of language
		//----------------------------------------------------------------------
		if($operation == 'change_language' && $operation_type != ''){
			$this->languageId = $operation_type;
			// added to prevent search with entered word on changing language
			$search_status = ''; 
		}
			
		// prepare sorting data
		//----------------------------------------------------------------------
		if($this->isSortingAllowed){
			if($operation == 'sorting'){
				if($sorting_fields != ''){
                    if($action == 'delete'){
                        // $sorting_types
                    }else{
                        if(strtolower($sorting_types) == 'asc') $sorting_types = 'DESC';
                        else $sorting_types = 'ASC';
                    }
					$sort_type = isset($this->arrViewModeFields[$sorting_fields]['sort_type']) ? $this->arrViewModeFields[$sorting_fields]['sort_type'] : 'string';
					$sort_by = isset($this->arrViewModeFields[$sorting_fields]['sort_by']) ? $this->arrViewModeFields[$sorting_fields]['sort_by'] : $sorting_fields;
					if($sort_type == 'numeric'){
						$this->ORDER_CLAUSE = ' ORDER BY ABS('.$sort_by.') '.$sorting_types.' ';	
					}else{
						$this->ORDER_CLAUSE = ' ORDER BY '.$sort_by.' '.$sorting_types.' ';	
					}					
				}else{
					$sorting_types = 'ASC';
				}
			}else{
				if($sorting_fields != '' && $sorting_types != ''){
					$this->ORDER_CLAUSE = ' ORDER BY '.$sorting_fields.' '.$sorting_types.' ';	
				}
			}
		}
		
		// prepare filtering data
		//----------------------------------------------------------------------
		if($this->isFilteringAllowed){
			if($search_status == 'active'){
				if($this->WHERE_CLAUSE == '') $this->WHERE_CLAUSE .= ' WHERE 1=1 ';
				$count = 0;
				foreach($this->arrFilteringFields as $key => $val){					
					if(self::GetParameter('filter_by_'.$val['table'].$val['field'], false) !== ''){
						$sign = '='; $sign_start = ''; $sign_end = '';
						if($val['sign'] == '='){
							$sign = '=';
						}else if($val['sign'] == '>='){
							$sign = '>=';
						}else if($val['sign'] == '<='){
							$sign = '<=';
						}else if($val['sign'] == 'like%'){
							$sign = 'LIKE';
							$sign_end = '%';
						}else if($val['sign'] == '%like'){
							$sign = 'LIKE';
							$sign_start = '%';
						}else if($val['sign'] == '%like%'){
							$sign = 'LIKE';
							$sign_start = '%';
							$sign_end = '%';
						}
						$key_value = self::GetParameter('filter_by_'.$val['table'].$val['field'], false);
						if(isset($val['table']) && $val['table'] != '') $field_name = $val['table'].'.'.$val['field'];
						else $field_name = $val['field'];
                        
                        $date_format = isset($val['date_format']) ? $val['date_format'] : '';
                        $type = isset($val['type']) ? $val['type'] : '';
                        if($type == 'calendar') $key_value = $this->PrepareDateTime($key_value, $date_format);
                        if($this->IsSecureField($key, $val)) $field_name = $this->UncryptValue($field_name, $val, false);
                        
						$this->WHERE_CLAUSE .= ' AND '.$field_name.' '.$sign.' \''.$sign_start.mysql_real_escape_string($key_value).$sign_end.'\' ';                        
					}
				}
			}			
		}		

		// prepare paging data
		//----------------------------------------------------------------------
		if($this->isPagingAllowed){
			if(!is_numeric($page) || (int)$page <= 0) $page = 1;
            // set sql_mode to empty if you have Mixing of GROUP columns SQL issue - in connection.php file
            /// database_void_query('SET sql_mode = ""');            
			$sql = preg_replace('/SELECT\b/i', 'SELECT COUNT(*) as mg_total_records, ', $this->VIEW_MODE_SQL, 1).' '.$this->WHERE_CLAUSE.' LIMIT 0, 1';
            if($this->debug) $start_time = $this->GetFormattedMicrotime();
            $result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
            if($this->debug) $finish_time = $this->GetFormattedMicrotime();
			$total_records = isset($result[0]['mg_total_records']) ? (int)$result[0]['mg_total_records'] : '1';
			if($this->debug){
				if(!mysql_error()){ 
                    $this->arrSQLs['total_records_sql'] = '<i>Total Records</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$sql;
				}else{
					$this->arrErrors['total_records_sql'] = $sql.'<br>'.mysql_error();		
				}
			}
			if($this->pageSize == 0) $this->pageSize = '10';
			$total_pages = (int)($total_records / $this->pageSize);
			// when you back from other languages where more pages than on current
			if($page > ($total_pages+1)) $page = 1; 
			if(($total_records % $this->pageSize) != 0) $total_pages++;
			$start_row = ($page - 1) * $this->pageSize;				
		}
		
		// check if there is move operation and perform it
		//----------------------------------------------------------------------
		if($operation == 'move'){			
			// block if this is a demo mode
			if(strtolower(SITE_MODE) == 'demo'){
				$this->error = _OPERATION_BLOCKED;
			}else{
				$operation_field_p = explode('#', $operation_field);
				$operation_field_p0 = explode('-', $operation_field_p[0]);
				$operation_field_p1 = explode('-', $operation_field_p[2]);
				$of_first 	= isset($operation_field_p0[0]) ? $operation_field_p0[0] : '';
				$of_second 	= isset($operation_field_p0[1]) ? $operation_field_p0[1] : '';
				$of_name 	= $operation_field_p[1];
				$of_first_value  = isset($operation_field_p1[0]) ? $operation_field_p1[0] : '';
				$of_second_value = isset($operation_field_p1[1]) ? $operation_field_p1[1] : '';
				
				if(($of_first_value != '') && ($of_second_value != '')){
					$sql = 'UPDATE '.$this->tableName.' SET '.$of_name.' = \''.$of_second_value.'\' WHERE '.$this->primaryKey.' = \''.$of_first.'\'';
					database_void_query($sql);
					if($this->debug) $this->arrSQLs['select_move_1'] = $sql;
					$sql = 'UPDATE '.$this->tableName.' SET '.$of_name.' = \''.$of_first_value.'\' WHERE '.$this->primaryKey.' = \''.$of_second.'\'';
					database_void_query($sql);
					if($this->debug) $this->arrSQLs['select_move_2'] = $sql;					
				}				
			}
		}		
		
		$arrRecords = $this->GetAll($this->ORDER_CLAUSE, 'LIMIT '.$start_row.', '.(int)$this->pageSize);
		if($this->allowLanguages) $arrLanguages = Languages::GetAllActive();
		if(!$this->isPagingAllowed){
			$total_records = $arrRecords[1];
		}		
	
		echo '<form name="frmMicroGrid_'.$this->tableName.'" id="frmMicroGrid_'.$this->tableName.'" action="'.$this->formActionURL.'" method="post">'.$nl;
		draw_hidden_field('mg_prefix', $this->uPrefix); echo $nl;
		draw_hidden_field('mg_action', 'view'); echo $nl;
		draw_hidden_field('mg_rid', ''); echo $nl;
		draw_hidden_field('mg_sorting_fields', $sorting_fields); echo $nl;
		draw_hidden_field('mg_sorting_types', $sorting_types); echo $nl;
		draw_hidden_field('mg_page', $page); echo $nl;
		draw_hidden_field('mg_operation', $operation); echo $nl;
		draw_hidden_field('mg_operation_type', $operation_type); echo $nl;
		draw_hidden_field('mg_operation_field', $operation_field); echo $nl;
		draw_hidden_field('mg_search_status', $search_status); echo $nl;
		draw_hidden_field('mg_language_id', $this->languageId); echo $nl;
		draw_hidden_field('mg_operation_code', self::GetRandomString(20)); echo $nl;
		draw_token_field(); echo $nl;

		if($this->actions['add'] || $this->allowLanguages || $this->allowRefresh || $this->isExportingAllowed){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">
				<tr>';
					echo '<td align="'.Application::Get('defined_left').'" valign="middle">';
					if($this->actions['add']) echo '<input class="mgrid_button" type="button" name="btnAddNew" value="'._ADD_NEW.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'add\');">&nbsp;&nbsp;&nbsp;';
					if($this->operationLinks != '')  echo $this->operationLinks;
					echo '</td>';
					
					echo '<td align="'.Application::Get('defined_right').'" valign="middle">';
					if($this->isExportingAllowed){
                        if(strtolower(SITE_MODE) == 'demo' || !$arrRecords[1]){
                            echo '<span class="gray">[ '._EXPORT.' ]</span> &nbsp;';
                        }else{
                            if($operation == 'switch_to_export'){
                                echo '[ <a href="javascript:void(\'export|cancel\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', null, null, null, null, \'switch_to_normal\');" title="'._SWITCH_TO_NORMAL.'">'._BUTTON_CANCEL.'</a> | '._DOWNLOAD.' - <a href="javascript:void(\'csv\');" onclick="javascript:appGoToPage(\'index.php?admin=export&file=export.csv\')"><img src="images/microgrid_icons/csv.gif" alt="'._DOWNLOAD.' CSV"></a> ] &nbsp;';
                            }else{
                                echo '<a href="javascript:void(\'export\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', null, null, null, null, \'switch_to_export\');" title="'._SWITCH_TO_EXPORT.'">[ '._EXPORT.' ]</a> &nbsp;';
                            }                            
                        }
					}
					if($this->allowRefresh)	echo '<a href="javascript:void(\'refresh\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\');" title="'._REFRESH.'"><img src="images/microgrid_icons/refresh.gif" alt="'._REFRESH.'"></a>';
					echo '</td>';						
					
					if($this->allowLanguages){
						echo '<td align="'.Application::Get('defined_right').'" width="80px">';
						(($this->allowLanguages) ? draw_languages_box('mg_language_id', $arrLanguages[0], 'abbreviation', 'lang_name', $this->languageId, '', 'onchange="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', null, null, null, null, \'change_language\', this.value, \'language_id\');"') : '');
						echo '</td>';
					}
					echo '
				</tr>
				<tr><td nowrap height="10px"></td></tr>
			</table>';
		}

		if($this->isFilteringAllowed){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">
				<tr>
					<td align="'.Application::Get('defined_left').'">';
						echo '<b>'._FILTER_BY.'</b>: &nbsp;&nbsp;&nbsp;';
						foreach($this->arrFilteringFields as $key => $val){
							if(!$this->IsVisible($val)) continue;
							$filter_field_value = ($search_status == 'active') ? self::GetParameter('filter_by_'.$val['table'].$val['field'], false) : '';
							if($val['type'] == 'text'){
								echo $key.':&nbsp;<input type="text" class="mgrid_text" name="filter_by_'.$val['table'].$val['field'].'" value="'.$this->GetDataDecoded($filter_field_value).'" style="width:'.$val['width'].'" maxlength="125">&nbsp;&nbsp;&nbsp;';
							}else if($val['type'] == 'dropdownlist'){
								if(is_array($val['source'])){
									echo $key.':&nbsp;<select class="mgrid_text" name="filter_by_'.$val['table'].$val['field'].'" style="width:'.$val['width'].'">';
									echo '<option value="">-- '._SELECT.' --</option>';	
									foreach($val['source'] as $key => $val){
										echo '<option '.(($filter_field_value !== '' && $filter_field_value == $key) ? ' selected="selected"' : '').' value="'.$this->GetDataDecoded($key).'">'.$val.'</option>';	
									}
									echo '</select>&nbsp;&nbsp;&nbsp;';
								}								
                            }else if($val['type'] == 'calendar'){
                                $date_format = isset($val['date_format']) ? $val['date_format'] : '';
                                if($date_format == 'mm/dd/yyyy'){
                                    $calendar_date_format = '%m-%d-%Y';
									$placeholder_date_format = 'mm-dd-yyyy';
                                }else if($date_format == 'dd/mm/yyyy'){                                   
                                    $calendar_date_format = '%d-%m-%Y';
									$placeholder_date_format = 'dd-mm-yyyy';
                                }else{
                                    $calendar_date_format = '%Y-%m-%d';
									$placeholder_date_format = 'yyyy-dd-mm';
                                }

								echo $key.':&nbsp;<input type="text" id="filter_cal'.$val['field'].'" class="mgrid_text" name="filter_by_'.$val['table'].$val['field'].'" value="'.$this->GetDataDecoded($filter_field_value).'" style="width:'.$val['width'].'" maxlength="19" placeholder="'.$placeholder_date_format.'">&nbsp;';
                                echo '<img id="filter_cal'.$val['field'].'_img" src="images/microgrid_icons/cal.gif" alt="" title="'._SET_TIME.'" style="cursor:pointer;">';
                                echo '&nbsp;&nbsp;';
                                $calendar_fields[] = array('field'=>'filter_cal'.$val['field'], 'format'=>$calendar_date_format);
							}
						}
						if(count($this->arrFilteringFields) > 0){
							echo '&nbsp;';
							if($search_status == 'active') echo ' <input type="button" class="mgrid_button" name="btnReset" value="'._BUTTON_RESET.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \'\', \'\', \'\', \'\', \'reset_filtering\');">';
							echo ' <input type="button" class="mgrid_button" name="btnSearch" value="'._SEARCH.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \'\', \'\', \'\', \'\', \'filtering\')">';
						}
			echo '	</td>
				</tr>
				<tr><td nowrap height="10px"></td></tr>
			</table>';
		}
		
		// draw rows
		if($arrRecords[1] > 0){            
			echo '<table width="100%" border="'.(($this->debug) ? '1' : '0').'" cellspacing="0" cellpadding="2" class="mgrid_table">';
			// draw column headers
			echo '<tr>';
				foreach($this->arrViewModeFields as $key => $val){
					$width = isset($val['width']) ? ' width="'.$val['width'].'"': '';
					if(isset($val['align']) && $val['align'] == 'left' && Application::Get('defined_left') == 'right'){
						$align = ' align="right"';
					}else if(isset($val['align']) && $val['align'] == 'right' && Application::Get('defined_right') == 'left'){
						$align = ' align="left"';
					}else if(isset($val['align'])){
						$align = ' align="'.$val['align'].'"';
					}else{
						$align = '';	
					}					
					$visible = (isset($val['visible']) && $val['visible']!=='') ? $val['visible'] : true;
					$sortable = (isset($val['sortable']) && $val['sortable']!=='') ? $val['sortable'] : true;
					$th_class = ($key == $sort_by) ? ' class="th_sorted"' : '';
                    $title = isset($val['title']) ? $val['title'] : '';
					if($visible){
						echo '<th'.$width.$align.$th_class.'>';
							if($this->isSortingAllowed && $sortable){
								$field_sorting = 'DESC';
								$sort_icon = '';
								if($key == $sorting_fields){
									if(strtolower($sorting_types) == 'asc'){
										$sort_icon = ' <img src="images/microgrid_icons/up.png" alt="" title="asc">';
									}else if(strtolower($sorting_types) == 'desc'){
										$sort_icon = ' <img src="images/microgrid_icons/down.png" alt="" title="desc">';
									}
									$field_sorting = $sorting_types;
								}
								echo '<a href="javascript:void(\'sort\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \'\', \''.$key.'\', \''.$field_sorting.'\', \''.$page.'\', \'sorting\')"><b>'.$title.'</b></a>'.$sort_icon;
                                $this->DrawHeaderTooltip($val);
							}else{
								echo '<label>'.$title.'</label>';
							}
						echo '</th>';
						if($operation == 'switch_to_export' && strtolower(SITE_MODE) != 'demo') $export_content[0][] = $val['title'];
					}					
				}				
			if($this->actions['details'] || $this->actions['edit'] || $this->actions['delete']){
				echo '<th width="8%">'._ACTIONS.'</th>';
			}
			echo '</tr>';
			echo '<tr><td colspan="'.$colspan.'" height="3px" nowrap="nowrap">'.draw_line('no_margin_line', IMAGE_DIRECTORY, false).'</td></tr>';
			for($i=0; $i<$arrRecords[1]; $i++){
				echo '<tr '.(($this->isAlterColorsAllowed) ? highlight(0) : '').' onmouseover="oldColor=this.style.backgroundColor;this.style.backgroundColor=\'#EDD6C7\';" onmouseout="this.style.backgroundColor=oldColor">';
					foreach($this->arrViewModeFields as $key => $val){
						if(isset($val['align']) && $val['align'] == 'left' && Application::Get('defined_left') == 'right'){
							$align = ' align="right"';
						}else if(isset($val['align']) && $val['align'] == 'right' && Application::Get('defined_right') == 'left'){
							$align = ' align="left"';
						}else if(isset($val['align'])){
							$align = ' align="'.$val['align'].'"';
						}else{
							$align = '';	
						}					
						$wrap    = (isset($val['nowrap']) && $val['nowrap'] == 'nowrap') ? ' nowrap="'.$val['nowrap'].'"': ' wrap';
						$visible = (isset($val['visible']) && $val['visible'] !== '') ? $val['visible'] : true;
						$movable = (isset($val['movable']) && $val['movable'] !== '') ? $val['movable'] : false;
						if(isset($arrRecords[0][$i][$key])){
							$field_value = $this->DrawFieldByType('view', $key, $val, $arrRecords[0][$i], false);
                            if($this->isAggregateAllowed && isset($this->arrAggregateFields[$key])){
                                $key_agreg = (isset($this->arrAggregateFields[$key]['aggregate_by']) && $this->arrAggregateFields[$key]['aggregate_by'] !== '') ? $this->arrAggregateFields[$key]['aggregate_by'] : $key;
                                if(!isset($this->arrAggregateFieldsTemp[$key])){
                                    $this->arrAggregateFieldsTemp[$key] = array('sum'=>$arrRecords[0][$i][$key_agreg], 'count'=>1);
                                }else{
                                    $this->arrAggregateFieldsTemp[$key]['sum'] += $arrRecords[0][$i][$key_agreg];
                                    $this->arrAggregateFieldsTemp[$key]['count']++;
                                }
                            }
						}else{
							if($this->debug) $this->arrWarnings['wrong_'.$key] = 'Field <b>'.$key.'</b>: wrong definition in View mode or at least one field has no value in SQL! Please check currefully your code.';
							$field_value = '';
						}
						if($visible){
							$move_link = '';
							if($movable){
								$move_prev_id  = $arrRecords[0][$i]['id'].'-'.(isset($arrRecords[0][$i-1]['id']) ? $arrRecords[0][$i-1]['id'] : '').'#';
								$move_prev_id .= $key.'#';
								$move_prev_id .= $arrRecords[0][$i][$key].'-'.(isset($arrRecords[0][$i-1][$key]) ? $arrRecords[0][$i-1][$key] : '');							
								$move_next_id  = $arrRecords[0][$i]['id'].'-'.(isset($arrRecords[0][$i+1]['id']) ? $arrRecords[0][$i+1]['id'] : '').'#';
								$move_next_id .= $key.'#';
								$move_next_id .= $arrRecords[0][$i][$key].'-'.(isset($arrRecords[0][$i+1][$key]) ? $arrRecords[0][$i+1][$key] : '');
								if(isset($arrRecords[0][$i-1]['id'])){
									$move_link .= ' <a href="javascript:void(\'move|up\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \''.$arrRecords[0][$i]['id'].'\', \'\', \'\', \'\', \'move\', \'up\', \''.$move_prev_id.'\')">';
									$move_link .= ($this->actionIcons) ? '<img src="images/microgrid_icons/up.png" style="margin-bottom:2px" alt="" title="'._UP.'">' : _UP;
									$move_link .= '</a>';										
								}else{
									$move_link .= ' <span style="width:11px;height:11px;"></span>';
								}
								if(isset($arrRecords[0][$i+1]['id'])){									
									$move_link .= '<a href="javascript:void(\'move|down\');" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \''.$arrRecords[0][$i]['id'].'\', \'\', \'\', \'\', \'move\', \'down\', \''.$move_next_id.'\')">';
									$move_link .= ($this->actionIcons) ? '<img src="images/microgrid_icons/down.png" style="margin-top:2px" alt="" title="'._DOWN.'">' : ((isset($arrRecords[0][$i-1]['id'])) ? '/' : '')._DOWN;
									$move_link .= '</a>';
								}else{
									$move_link .= '<span style="width:11px;height:11px;"></span>';
								}
							}
							echo '<td'.$align.$wrap.'>'.$field_value.$move_link.'</td>';
							if($operation == 'switch_to_export' && strtolower(SITE_MODE) != 'demo') $export_content[$i+1][] = str_replace(',', '', strip_tags($field_value));
						}
					}				
					if($this->actions['details'] || $this->actions['edit'] || $this->actions['delete']){
						echo '<td align="center" nowrap="nowrap">';
						if($this->actions['details']){
							echo '<a href="javascript:void(\'details|'.$arrRecords[0][$i][$this->primaryKey].'\');" title="'._VIEW_WORD.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'details\', \''.$arrRecords[0][$i]['id'].'\')">'.(($this->actionIcons) ? '<img src="images/microgrid_icons/details.gif" title="'._VIEW_WORD.'" alt="" border="0" style="margin:0px; padding:0px;" height="16px">' : _VIEW_WORD).'</a>';
						}				
						if($this->actions['edit']){
							if($this->actions['details']) echo '&nbsp;'.(($this->actionIcons) ? '&nbsp;' : '').draw_divider(false).'&nbsp'; 
							echo '<a href="javascript:void(\'edit|'.$arrRecords[0][$i][$this->primaryKey].'\')" title="'._EDIT_WORD.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'edit\', \''.$arrRecords[0][$i]['id'].'\')">'.(($this->actionIcons) ? '<img src="images/microgrid_icons/edit.gif" title="'._EDIT_WORD.'" alt="" border="0" style="margin:0px;padding:0px;" height="16px">' : _EDIT_WORD).'</a>';
						}
						if($this->actions['delete']){
							if($this->actions['edit'] || $this->actions['details']) echo '&nbsp;'.(($this->actionIcons) ? '&nbsp;' : '').draw_divider(false).'&nbsp'; 
							echo '<a href="javascript:void(\'delete|'.$arrRecords[0][$i][$this->primaryKey].'\')" title="'._DELETE_WORD.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'delete\', \''.$arrRecords[0][$i]['id'].'\')">'.(($this->actionIcons) ? '<img src="images/microgrid_icons/delete.gif" title="'._DELETE_WORD.'" alt="" border="0" style="margin:0px;padding:0px;" height="16px">' : _DELETE_WORD).'</a>';
						}
						echo '&nbsp;</td>';
					}
				echo '</tr>';
			} // for
            
            // draw aggregate fields row
            if($this->isAggregateAllowed){
                echo '<tr><td colspan="'.$colspan.'" height="5px" nowrap="nowrap">'.draw_line('no_margin_line', IMAGE_DIRECTORY, false).'</td></tr>';
                echo '<tr>';
                foreach($this->arrViewModeFields as $key => $val){
					$visible = (isset($val['visible']) && $val['visible'] !== '') ? $val['visible'] : true;
                    if($visible){
                        $ag_field_total = isset($this->arrAggregateFieldsTemp[$key]) ? $this->arrAggregateFieldsTemp[$key]['sum'] : 0;
                        $ag_field_count = isset($this->arrAggregateFieldsTemp[$key]) ? $this->arrAggregateFieldsTemp[$key]['count'] : 0;
                        $ag_field_function = strtoupper(isset($this->arrAggregateFields[$key]['function']) ? $this->arrAggregateFields[$key]['function'] : '');
						$ag_field_align = strtoupper(isset($this->arrAggregateFields[$key]['align']) ? $this->arrAggregateFields[$key]['align'] : 'center');
                        $ag_decimal_place = isset($this->arrAggregateFields[$key]['decimal_place']) ? (int)$this->arrAggregateFields[$key]['decimal_place'] : 2;
                        $ag_field_value = '';
                        if($ag_field_function == 'SUM'){
                            $ag_field_value = ($ag_field_count != 0) ? number_format($ag_field_total, $ag_decimal_place) : '';    
                        }else if($ag_field_function == 'AVG'){
                            $ag_field_value = ($ag_field_count != 0) ? number_format($ag_field_total / $ag_field_count, $ag_decimal_place) : '';    
                        }                        
                        echo '<td align="'.$ag_field_align.'">'.(($ag_field_function != '') ? $ag_field_function.' = ' : '').$ag_field_value.'</td>';
                    }                    
                }
                echo '</tr>';
                echo '<tr><td colspan="'.$colspan.'" height="5px" nowrap="nowrap">'.draw_line('no_margin_line', IMAGE_DIRECTORY, false).'</td></tr>';
            }else{
                echo '<tr><td colspan="'.$colspan.'" height="15px" nowrap="nowrap">'.draw_line('no_margin_line', IMAGE_DIRECTORY, false).'</td></tr>';                
            }

			echo '</table>';
			
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">';
			echo '<tr valign="top">';
			echo '<td>';
				if($this->isPagingAllowed){
					echo '<b>'._PAGES.':</b> ';
					for($i = 1; $i <= $total_pages; $i++){
						echo '<a class="paging_link" href="javascript:void(\'paging\')" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'view\', \'\', \'\', \'\', \''.$i.'\', \'\')">'.(($i == $page) ? '<b>['.$i.']</b>' : $i).'</a> ';
					}				
				}			
			echo '</td>';
			echo '<td align="'.Application::Get('defined_right').'">';
					$row_from = ($start_row + 1);
					$row_to   = ((($start_row + $this->pageSize) < $total_records) ? ($start_row + $this->pageSize) : $total_records);						
					echo '<b>'._TOTAL.'</b>: '.(($row_from < $row_to) ? $row_from.' - '.$row_to : $row_from).' / '.$total_records;
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			
			// prepare export file
			//----------------------------------------------------------------------
			if($operation == 'switch_to_export'){
                if(strtolower(SITE_MODE) == 'demo'){
                    $this->error = _OPERATION_BLOCKED;
                }else{
                    $export_content_count = count($export_content);
                    $fe = @fopen('tmp/export/export.csv', 'w+');
                    @fwrite($fe, "\xEF\xBB\xBF");
                    for($i=0; $i<$export_content_count; $i++){
                        @fputcsv($fe, $export_content[$i]);
                    }
                    @fclose($fe);                                        
                }
			}			
		}else{
			draw_message(_NO_RECORDS_FOUND, true, true, false, 'width:100%');
			//if($this->debug) $this->arrSQLs['select'] = $this->VIEW_MODE_SQL.' '.$this->WHERE_CLAUSE.' '.$this->ORDER_CLAUSE.' LIMIT '.$start_row.', '.(int)$this->pageSize;
		}
		
		echo '</form>';
        
        $this->CalendarSetupFields($calendar_fields);
		
		$this->AfterViewRecords();
		
        $this->DrawVersionInfo();
		$this->DrawRunningTime();
		$this->DrawErrors();
		$this->DrawWarnings();
		$this->DrawSQLs();	
		$this->DrawPostInfo();	
	}

	/***********************************************************************
	 *
	 *	Draw Add Mode
	 *	
	 ***********************************************************************/
	public function DrawAddMode()
	{		
		$this->IncludeJSFunctions('add');		
		
		$sorting_fields  = self::GetParameter('sorting_fields');
		$sorting_types   = self::GetParameter('sorting_types');
		$page 			 = self::GetParameter('page');
		$operation 		 = self::GetParameter('operation');
		$operation_type  = self::GetParameter('operation_type');
		$operation_field = self::GetParameter('operation_field');
		$search_status   = self::GetParameter('search_status');
		// prepare language direction for textboxes, textareas etc..
		$language_dir    = @Languages::GetLanguageDirection($this->languageId);
        $nl              = "\n";
		
		$first_field_focus = '';

		echo '<form name="frmMicroGrid_'.$this->tableName.'" id="frmMicroGrid_'.$this->tableName.'" action="'.$this->formActionURL.'" method="post" enctype="multipart/form-data">'.$nl;
		draw_hidden_field('mg_prefix', $this->uPrefix); echo $nl;
		draw_hidden_field('mg_action', 'create'); echo $nl;
		draw_hidden_field('mg_rid', '-1'); echo $nl;
		draw_hidden_field('mg_sorting_fields', $sorting_fields); echo $nl;
		draw_hidden_field('mg_sorting_types', $sorting_types); echo $nl;
		draw_hidden_field('mg_page', $page); echo $nl;
		draw_hidden_field('mg_operation', $operation); echo $nl;
		draw_hidden_field('mg_operation_type', $operation_type); echo $nl;
		draw_hidden_field('mg_operation_field', $operation_field); echo $nl;
		draw_hidden_field('mg_search_status', $search_status); echo $nl;
		draw_hidden_field('mg_language_id', $this->languageId); echo $nl;
		draw_hidden_field('mg_operation_code', self::GetRandomString(20)); echo $nl;
		draw_token_field(); echo $nl;
		
		// draw hidden fields
		foreach($this->arrAddModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						if($v_val['type'] == 'hidden'){
							draw_hidden_field($v_key, $v_val['default']); echo $nl;
						}				
					}
				}				
			}else{
				if($val['type'] == 'hidden'){
					draw_hidden_field($key, $val['default']); echo $nl;
				}				
			}
		}				
		
		//----------------------------------------------------------------------
		// perform operations before drawing Add Mode
		$this->BeforeAddRecord();

		// draw Add Form
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;
		if($this->allowTopButtons) $this->DrawAddModeButtons();
		echo '<tr><td colspan="2" height="1px" nowrap="nowrap"></td></tr>'.$nl;
		foreach($this->arrAddModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				echo '</table><br>'.$nl;
				echo '<fieldset style="padding:5px;margin-left:5px;margin-right:10px;">'.$nl;
                $columns = isset($val['separator_info']['columns']) ? (int)$val['separator_info']['columns'] : 0;
				if(isset($val['separator_info']['legend'])) echo '<legend>'.$val['separator_info']['legend'].'</legend>'.$nl;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;
                $row_count = 0;
				foreach($val as $v_key => $v_val){
					if(!$this->IsVisible($v_val)) continue;
					if($v_key != 'separator_info' && $v_val['type'] != 'hidden'){
                        if($columns && ($row_count % $columns) == 0){
                            if($row_count) echo '</tr>'.$nl;
                            echo '<tr id="mg_row_'.$v_key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
                        }else if(!$columns){
                            echo '<tr id="mg_row_'.$v_key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
                        }						
						echo '<td width="25%"><label for="'.$v_key.'">'.$v_val['title'].'</label>';
							$this->DrawRequiredAsterisk($v_val);
							$this->DrawHeaderTooltip($v_val);                            
							$this->DrawImageText($v_val);
						echo ':';
                        $this->DrawTextareaMaxlength($v_val);
                        echo '</td>';
						echo '<td style="padding-left:6px">'.$this->DrawFieldByType('add', $v_key, $v_val, $this->params, false, $language_dir).'</td>';
						if(!$columns) echo '</tr>'.$nl;
                        $row_count++;
						if(empty($first_field_focus)) $first_field_focus = $v_key;
					}
				}
				echo '</table>'.$nl;
				echo '</fieldset>'.$nl;				
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;		
			}else{
				if(!$this->IsVisible($val)) continue;
				if($val['type'] != 'hidden'){
					echo '<tr id="mg_row_'.$key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
					echo '<td width="25%"><label for="'.$key.'">'.$val['title'].'</label>';
						$this->DrawRequiredAsterisk($val);
						$this->DrawHeaderTooltip($val);                        
						$this->DrawImageText($val);
					echo ':';
                    $this->DrawTextareaMaxlength($val);
                    echo '</td>';
					echo '<td style="padding-left:6px">'.$this->DrawFieldByType('add', $key, $val, $this->params, false, $language_dir).'</td>';
					echo '</tr>'.$nl;				
					if(empty($first_field_focus)) $first_field_focus = $key;
				}							
			}
		}
		$this->DrawAddModeButtons();
		echo '</table><br>'.$nl;
		echo '</form>'.$nl;

		$focus_field = ($this->errorField != '') ? $this->errorField : $first_field_focus;
		if(!empty($focus_field)) echo '<script type="text/javascript">__mgSetFocus(\''.$focus_field.'\');</script>';
		
		$this->AfterAddRecord();
			
		$this->DrawVersionInfo();
        $this->DrawRunningTime();
		$this->DrawErrors();
		$this->DrawWarnings();
		$this->DrawSQLs();	
		$this->DrawPostInfo();	
	}

	
	/***********************************************************************
	 *
	 *	Draw Edit Mode
	 *	
	 ***********************************************************************/
	public function DrawEditMode($rid = '0', $operation = '', $operation_field = '', $buttons = array('reset'=>false, 'cancel'=>true))
	{		
		$this->IncludeJSFunctions('edit');
		
		$this->curRecordId = $rid;
		
		$sorting_fields  = self::GetParameter('sorting_fields');
		$sorting_types   = self::GetParameter('sorting_types');
		$page 			 = self::GetParameter('page');
		$operation 		 = self::GetParameter('operation');
		$operation_type  = self::GetParameter('operation_type');
		$operation_field = self::GetParameter('operation_field');
		$search_status   = self::GetParameter('search_status');
		// prepare language direction for textboxes, textareas etc..		
		$language_dir    = @Languages::GetLanguageDirection($this->languageId);
        $nl              = "\n";
		
		echo '<form name="frmMicroGrid_'.$this->tableName.'" id="frmMicroGrid_'.$this->tableName.'" action="'.$this->formActionURL.'" method="post" enctype="multipart/form-data">'.$nl;
		draw_hidden_field('mg_prefix', $this->uPrefix); echo $nl;
		draw_hidden_field('mg_action', 'update'); echo $nl;
		draw_hidden_field('mg_rid', $this->curRecordId); echo $nl;
		draw_hidden_field('mg_sorting_fields', $sorting_fields); echo $nl;
		draw_hidden_field('mg_sorting_types', $sorting_types); echo $nl;
		draw_hidden_field('mg_page', $page); echo $nl;
		draw_hidden_field('mg_operation', ''); echo $nl;
		draw_hidden_field('mg_operation_type', ''); echo $nl;
		draw_hidden_field('mg_operation_field', ''); echo $nl;
		draw_hidden_field('mg_search_status', $search_status); echo $nl;
		draw_hidden_field('mg_language_id', $this->languageId); echo $nl;
		draw_hidden_field('mg_operation_code', self::GetRandomString(20)); echo $nl;
		draw_token_field(); echo $nl;
		
		// save filter (search) data for view mode
		if($this->isFilteringAllowed){
			foreach($this->arrFilteringFields as $key => $val){
				//if($val['type'] == 'text'){
					$filter_field_value = ($search_status == 'active') ? self::GetParameter('filter_by_'.$val['table'].$val['field'], false) : '';
					draw_hidden_field('filter_by_'.$val['table'].$val['field'], $filter_field_value); echo $nl;
				//}
			}
		}

		// 1. prepare password fields
		foreach($this->arrEditModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						// prepare password
                        if(isset($v_val['type']) && (($v_val['type'] == 'password') || $this->IsSecureField($key, $v_val))){    
							$password_field = $this->UncryptValue($v_key, $v_val);
							$this->EDIT_MODE_SQL = str_replace($this->tableName.'.'.$v_key, $password_field, $this->EDIT_MODE_SQL);
						}											
					}					
				}				
			}else{
				// prepare password
				if(isset($val['type']) && (($val['type'] == 'password') || $this->IsSecureField($key, $val))){
					$password_field = $this->UncryptValue($key, $val);
					$this->EDIT_MODE_SQL = str_replace($this->tableName.'.'.$key, $password_field, $this->EDIT_MODE_SQL);
				}
			}
		}						

		$this->EDIT_MODE_SQL = str_replace('_RID_', $this->curRecordId, $this->EDIT_MODE_SQL);
        if($this->debug) $start_time = $this->GetFormattedMicrotime();
		$this->result = database_query($this->EDIT_MODE_SQL, DATA_AND_ROWS);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();        
    	if($this->debug) $this->arrSQLs['select_edit_mode'] = '<i>Retrieve Edit Mode Record</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$this->EDIT_MODE_SQL;
        if(!$this->result[1]){
			if($this->debug) echo $this->EDIT_MODE_SQL.'<br>'.mysql_error();
			else echo _WRONG_PARAMETER_PASSED;
			return false;
		}		
		
		//----------------------------------------------------------------------
		// perform operations before drawing Edit Mode
		$this->BeforeEditRecord();

		// 1. draw hidden fields
		// 2. delete files/images
		foreach($this->arrEditModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						// delete file/image
						if($operation == 'remove' && $operation_field != '' && ($v_key == $operation_field)){
							$this->RemoveFileImage($this->curRecordId, $operation_field, $v_val['target'], $this->result[0][0][$v_key]);
							$this->result[0][0][$v_key] = '';
						}
						// draw hidden field
						if($v_val['type'] == 'hidden'){
							draw_hidden_field($v_key, ((isset($v_val['default']) && !empty($v_val['default'])) ? $v_val['default'] : $this->result[0][0][$v_key]));
							echo $nl;
						}
					}					
				}				
			}else{
				// delete file/image
				if($operation == 'remove' && $operation_field != '' && ($key == $operation_field)){
					$this->RemoveFileImage($this->curRecordId, $operation_field, $val['target'], $this->result[0][0][$key]);
					$this->result[0][0][$key] = '';
				}
				// draw hidden field
				if($val['type'] == 'hidden'){
					draw_hidden_field($key, ((isset($val['default']) && !empty($val['default'])) ? $val['default'] : $this->result[0][0][$key]));
					echo $nl;
				}
			}
		}								

		// draw Edit Form
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;
		if($this->allowTopButtons) $this->DrawEditModeButtons($buttons);
		foreach($this->arrEditModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				echo '</table><br>'.$nl;
				echo '<fieldset style="padding:5px;margin-left:5px;margin-right:10px;">'.$nl;
                $columns = isset($val['separator_info']['columns']) ? (int)$val['separator_info']['columns'] : 0;
				if(isset($val['separator_info']['legend'])) echo '<legend>'.$val['separator_info']['legend'].'</legend>'.$nl;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;
                $row_count = 0;
				foreach($val as $v_key => $v_val){
					if(!$this->IsVisible($v_val)) continue;
					if($v_key != 'separator_info' && $v_val['type'] != 'hidden'){
                        if($columns && ($row_count % $columns) == 0){
                            if($row_count) echo '</tr>'.$nl;
                            echo '<tr id="mg_row_'.$v_key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
                        }else if(!$columns){
                            echo '<tr id="mg_row_'.$v_key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
                        }
						echo '<td width="25%"><label for="'.$v_key.'">'.$v_val['title'].'</label>';
							$this->DrawRequiredAsterisk($v_val);
							$this->DrawHeaderTooltip($v_val);                            
							$this->DrawImageText($v_val);
						echo ':';
                        $this->DrawTextareaMaxlength($v_val);
                        echo '</td>';						
						if(!$this->ParamEmpty($v_key) && ($v_val['type'] != 'checkbox')){ /* [#001 - 01.03.12] */
							echo '<td style="padding-left:6px;">'.$this->DrawFieldByType('edit', $v_key, $v_val, $this->params, false, $language_dir).'</td>';
						}else{
							echo '<td style="padding-left:6px;">'.$this->DrawFieldByType('edit', $v_key, $v_val ,$this->result[0][0], false, $language_dir).'</td>';
						}
						if(!$columns) echo '</tr>'.$nl;
                        $row_count++;
					}
				}
				echo '</table>'.$nl;
				echo '</fieldset>'.$nl;				
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;		
			}else{
				if(!$this->IsVisible($val)) continue;
				if($val['type'] != 'hidden'){
					echo '<tr id="mg_row_'.$key.'" onmouseover="__mgTrOnMouseOver(this,\''.Application::Get('defined_right').'\')" onmouseout="__mgTrOnMouseOut(this,\''.Application::Get('defined_right').'\')">';
					echo '<td width="25%"><label for="'.$key.'">'.$val['title'].'</label>';
						$this->DrawRequiredAsterisk($val);
						$this->DrawHeaderTooltip($val);                        
						$this->DrawImageText($val);
					echo ':';
                    $this->DrawTextareaMaxlength($val);
                    echo '</td>';
					if(!$this->ParamEmpty($key) && ($val['type'] != 'checkbox')){ /* [#001 - 01.03.12] */
						echo '<td style="padding-left:6px;">'.$this->DrawFieldByType('edit', $key, $val, $this->params, false, $language_dir).'</td>';													
					}else{
						echo '<td style="padding-left:6px;">'.$this->DrawFieldByType('edit', $key, $val, $this->result[0][0], false, $language_dir).'</td>';						
					}
					echo '</tr>'.$nl;				
				}
			}
		}
		$this->DrawEditModeButtons($buttons);
		echo '</table><br>'.$nl;
		echo '</form>'.$nl;

		if($this->errorField != '') echo '<script type="text/javascript">__mgSetFocus(\''.$this->errorField.'\');</script>';	   
		
		$this->AfterEditRecord();
		
		$this->DrawVersionInfo();
        $this->DrawRunningTime();
		$this->DrawErrors();
		$this->DrawWarnings();
		$this->DrawSQLs();	
		$this->DrawPostInfo();	
	}


	
	/***********************************************************************
	 *
	 *	Draw Details Mode
	 *	
	 ***********************************************************************/
	public function DrawDetailsMode($rid = '0', $buttons = array('back'=>true))
	{		
		$this->IncludeJSFunctions();
        
		$this->curRecordId = $rid;
        $this->BeforeDetailsRecord();		
		
		$sorting_fields  = self::GetParameter('sorting_fields');
		$sorting_types   = self::GetParameter('sorting_types');
		$page 			 = self::GetParameter('page');
		$operation 		 = self::GetParameter('operation');
		$operation_type  = self::GetParameter('operation_type');
		$operation_field = self::GetParameter('operation_field');
		$search_status   = self::GetParameter('search_status');
        $nl              = "\n";

		echo $nl.'<form name="frmMicroGrid_'.$this->tableName.'" id="frmMicroGrid_'.$this->tableName.'" action="'.$this->formActionURL.'" method="post" enctype="multipart/form-data">'.$nl;
		draw_hidden_field('mg_prefix', $this->uPrefix); echo $nl;
		draw_hidden_field('mg_action', 'details'); echo $nl;
		draw_hidden_field('mg_rid', $this->curRecordId); echo $nl;
		draw_hidden_field('mg_sorting_fields', $sorting_fields); echo $nl;
		draw_hidden_field('mg_sorting_types', $sorting_types); echo $nl;
		draw_hidden_field('mg_page', $page); echo $nl;
		// to prevent re-sorting on back to view mode $operation = ''
		draw_hidden_field('mg_operation', ''); echo $nl;
		draw_hidden_field('mg_operation_type', $operation_type); echo $nl;
		draw_hidden_field('mg_operation_field', $operation_field); echo $nl;
		draw_hidden_field('mg_search_status', $search_status); echo $nl;
		draw_hidden_field('mg_language_id', $this->languageId); echo $nl;
		draw_token_field(); echo $nl;
		
		// save filter (search) data for view mode
		if($this->isFilteringAllowed){
			foreach($this->arrFilteringFields as $key => $val){
				//if($val['type'] == 'text'){
					$filter_field_value = ($search_status == 'active') ? self::GetParameter('filter_by_'.$val['table'].$val['field'], false) : '';
					draw_hidden_field('filter_by_'.$val['table'].$val['field'], $filter_field_value); echo $nl;
				//}
			}
		}

		// 1. prepare password fields
		foreach($this->arrDetailsModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){
						// prepare password
                        if(isset($v_val['type']) && (($v_val['type'] == 'password') || $this->IsSecureField($key, $v_val))){
							$password_field = $this->UncryptValue($v_key, $v_val);
							$this->DETAILS_MODE_SQL = str_replace($this->tableName.'.'.$v_key, $password_field, $this->DETAILS_MODE_SQL);
						}
					}
				}
			}else{
				// prepare password
				if(isset($val['type']) && (($val['type'] == 'password') || $this->IsSecureField($key, $val))){
					$password_field = $this->UncryptValue($key, $val);
					$this->DETAILS_MODE_SQL = str_replace($this->tableName.'.'.$key, $password_field, $this->DETAILS_MODE_SQL);
				}
			}
		}
        
		// get result for detailed row		
		$this->DETAILS_MODE_SQL = str_replace('_RID_', $this->curRecordId, $this->DETAILS_MODE_SQL);
        if($this->debug) $start_time = $this->GetFormattedMicrotime();
		$this->result = database_query($this->DETAILS_MODE_SQL, DATA_AND_ROWS);
        if($this->debug) $finish_time = $this->GetFormattedMicrotime();
		if($this->debug) $this->arrSQLs['select_details_mode'] = '<i>Retrieve Detail Mode Record</i> | T: '.round((float)$finish_time - (float)$start_time, 4).' sec. <br>'.$this->DETAILS_MODE_SQL;
        if(!$this->result[1]){
			if($this->debug) echo $this->DETAILS_MODE_SQL.'<br>'.mysql_error();
			else echo _WRONG_PARAMETER_PASSED;
			return false;
		}		
        
	
		// draw Details Form
		echo '<table width="100%" border="0" cellspacing="2" cellpadding="2" class="mgrid_table">'.$nl;
        if($this->allowTopButtons) $this->DrawDetailsModeButtons($buttons);        
		foreach($this->arrDetailsModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){				
				echo '</table><br>'.$nl;
				echo '<fieldset style="padding:5px;margin-left:5px;margin-right:10px;">'.$nl;
				$columns = isset($val['separator_info']['columns']) ? (int)$val['separator_info']['columns'] : 0;
                if(isset($val['separator_info']['legend'])) echo '<legend>'.$val['separator_info']['legend'].'</legend>'.$nl;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;		
				$row_count = 0;
                foreach($val as $v_key => $v_val){
					if(!$this->IsVisible($v_val)) continue;					
					if($v_key != 'separator_info'){						
                        if($columns && ($row_count % $columns) == 0){
                            if($row_count) echo '</tr>'.$nl;
                            echo '<tr id="mg_row_'.$v_key.'">'.$nl;
                        }else if(!$columns){
                            echo '<tr id="mg_row_'.$v_key.'">'.$nl;
                        }						
						echo '  <td width="27%">'.$v_val['title'].':</td>'.$nl;
						echo '  <td style="padding-left:6px;">'.$this->DrawFieldByType('details', $v_key, $v_val, $this->result[0][0], false).'</td>'.$nl;
						if(!$columns) echo '</tr>'.$nl;
                        $row_count++;
					}
				}
				echo '</table>'.$nl;
				echo '</fieldset>'.$nl;				
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="2" class="mgrid_table">'.$nl;		
			}else{
				if(!$this->IsVisible($val)) continue;					
				if($val['type'] != 'hidden'){
					echo '<tr id="mg_row_'.$key.'">'.$nl;
					echo '  <td width="25%">'.ucfirst($val['title']).':</td>'.$nl;
					echo '  <td>'.$this->DrawFieldByType('details', $key, $val, $this->result[0][0], false).'</td>'.$nl;
					echo '</tr>'.$nl;				
				}			
			}
		}
        $this->DrawDetailsModeButtons($buttons);
		echo '</table><br>'.$nl;
		echo '</form>'.$nl;
		
		$this->AfterDetailsMode();

		$this->DrawVersionInfo();
        $this->DrawRunningTime();
		$this->DrawErrors();
		$this->DrawWarnings();
		$this->DrawSQLs();	
		$this->DrawPostInfo();	
	}

	/**
	 * Draw field by type
	 *		@param $link
	 */	
	public function DrawOperationLinks($links)
	{
		$this->operationLinks = $links;
	}

	/**
	 * Draw field by type
	 *		@param $field_name
	 *		@param $field_array - ['field'] => array(''.....)
	 *		@param $params
	 *		@param $draw
	 *		@param $language_dir
	 */	
	public function DrawFieldByType($mode, $field_name, $field_array = array(), $params = array(), $draw = true, $language_dir = 'ltr')
	{
		if($field_name == '') return false;

		$output = '';
        $nl = "\n";
		
		//print_r($field_array);
		$direction    = ($language_dir == 'rtl' || $language_dir == 'ltr') ? ' dir="'.$language_dir.'"' : '';
		$rid 		  = isset($params[$this->primaryKey]) ? $params[$this->primaryKey] : '';
		$field_type   = isset($field_array['type']) ? $field_array['type'] : '';
		$source       = isset($field_array['source']) ? $field_array['source'] : '';
		$default_option = (isset($field_array['default_option']) && $field_array['default_option'] !== '') ? $field_array['default_option'] : '-- '._SELECT.' --';
		$readonly     = (isset($field_array['readonly']) && $field_array['readonly'] === true) ? true : false;
		$default 	  = isset($field_array['default']) ? $field_array['default'] : '';
		$true_value   = isset($field_array['true_value']) ? $field_array['true_value'] : '1';
		$width        = isset($field_array['width']) ? $field_array['width'] : '';
		$height       = isset($field_array['height']) ? $field_array['height'] : '';
		$image_width  = isset($field_array['image_width']) ? $field_array['image_width'] : '120px';
		$image_height = isset($field_array['image_height']) ? $field_array['image_height'] : '90px';
		$show_seconds = isset($field_array['show_seconds']) ? $field_array['show_seconds'] : true;
        $minutes_step = isset($field_array['minutes_step']) ? (int)$field_array['minutes_step'] : 1;
		$maxlength    = isset($field_array['maxlength']) ? $field_array['maxlength'] : '';
		$editor_type  = isset($field_array['editor_type']) ? $field_array['editor_type'] : '';							
		$no_image     = isset($field_array['no_image']) ? $field_array['no_image'] : '';
		$required 	  = isset($field_array['required']) ? $field_array['required'] : false;
		$pre_html 	  = isset($field_array['pre_html']) ? $field_array['pre_html'] : '';
		$post_html 	  = isset($field_array['post_html']) ? $field_array['post_html'] : '';
		$format 	  = isset($field_array['format']) ? $field_array['format'] : '';
		$format_parameter = isset($field_array['format_parameter']) ? $field_array['format_parameter'] : '';
		$tooltip 	  = isset($field_array['tooltip']) ? $field_array['tooltip'] : '';
		$min_year     = isset($field_array['min_year']) ? $field_array['min_year'] : '90';
		$max_year     = isset($field_array['max_year']) ? $field_array['max_year'] : '10';
		$href         = isset($field_array['href']) ? $field_array['href'] : '#';
		$target       = isset($field_array['target']) ? $field_array['target'] : '';
		$javascript_event = isset($field_array['javascript_event']) ? $field_array['javascript_event'] : '';
		$visible      = (isset($field_array['visible']) && $field_array['visible']!=='') ? $field_array['visible'] : true;
        $autocomplete = isset($field_array['autocomplete']) ? $field_array['autocomplete'] : '';
        $cryptography = isset($field_array['cryptography']) ? $field_array['cryptography'] : false;
        $cryptography_type = isset($field_array['cryptography_type']) ? $field_array['cryptography_type'] : '';
        $username_generator = isset($field_array['username_generator']) ? $field_array['username_generator'] : false;
        $password_generator = isset($field_array['password_generator']) ? $field_array['password_generator'] : false;
		$view_type    = isset($field_array['view_type']) ? $field_array['view_type'] : '';
		$multi_select = isset($field_array['multi_select']) ? $field_array['multi_select'] : '';
		
		$atr_readonly = ($readonly) ? ' readonly="readonly"' : '';
		$atr_disabled = ($readonly) ? ' disabled="disabled"' : '';
		$css_disabled = ($readonly) ? ' mgrid_disabled' : '';
		$attr_maxlength = ($maxlength != '') ? ' maxlength="'.intval($maxlength).'"' : '';
        $autocomplete = ($autocomplete == 'off') ? ' autocomplete="off"' : '';

		$field_value  = isset($params[$field_name]) ? $params[$field_name] : '';
		if($mode == 'add' && $field_value == '') $field_value = $default;
		if($this->isHtmlEncoding) $field_value = $this->GetDataDecoded($field_value);

		if($mode == 'view'){            
            $this->OnItemCreated_ViewMode($field_name, $field_value);
            
			// View Mode
			switch($field_type){
				case 'link':
					$target_str = ($target != '') ? ' target="'.$target.'"' : '';
					$href_str = $href;
					$title = '';
					if($maxlength != '' && $this->IsInteger($maxlength)){
						$this->PrepareSubString($field_value, $title, $maxlength);
					}else if($tooltip != ''){
						$title = $tooltip;
					}
					if(preg_match_all('/{.*?}/i', $href, $matches)){
						foreach($matches[0] as $key => $val){
							$val = trim($val, '{}');
							if(isset($params[$val])) $href_str = str_replace('{'.$val.'}', $params[$val], $href_str);
						}
					}
					$output = '<a href="'.$href_str.'"'.$target_str.' title="'.strip_tags($title).'">'.$field_value.'</a>';
					break;

				case 'enum':
					if(is_array($source)){
                        if(isset($source[$field_value])){
                            $output = $source[$field_value];
                            break;
                        }
					}
					break;			

				case 'image':
				    if($field_value == '' && $no_image != '') $field_value = $no_image;
					$output = '<img src="'.$target.$field_value.'" title="'.$field_value.'" alt="" width="'.$image_width.'" height="'.$image_height.'">';
					break;
				
				default:
				case 'label':
					$title = '';
					$field_value  = $this->FormatFieldValue($field_value, $format, $format_parameter);
					if($maxlength != '' && $this->IsInteger($maxlength)){
						$this->PrepareSubString($field_value, $title, $maxlength);
					}else if($tooltip != ''){
						$title = $tooltip;
					}
					$output = $pre_html.'<label class="mgrid_label" title="'.$this->GetDataDecoded(strip_tags($title)).'">'.$this->GetDataDecodedText($field_value).'</label>'.$post_html;
					break;			
			}			
		}else{
            
            if($mode == 'details') $this->OnItemCreated_DetailsMode($field_name, $field_value);
            
			// Add/Edit/Detail Modes 
			switch($field_type){
				case 'checkbox':
					$checked = '';
					$rid = self::GetParameter('rid');
					if($mode == 'add'){
					    if(empty($rid) && $default == $true_value){ // opens page first time 
							$checked = ' checked="checked"';
						}else{
							if($field_value == '1') $checked = ' checked="checked"';
						}
					}else{
						if($field_value == '1') $checked = ' checked="checked"';
					}
					if($readonly){
						$output  = '<input type="checkbox" name="'.$field_name.'" id="'.$field_name.'" class="mgrid_checkbox" value="1"'.$checked.$atr_disabled.'>';
						$output .= draw_hidden_field($field_name, '1', false, $field_name);						
					}else{
						$output = '<input type="checkbox" name="'.$field_name.'" id="'.$field_name.'" class="mgrid_checkbox" value="1"'.$checked.'>';						
					}
					$output .= $post_html;
					break;
				case 'date':
				case 'datetime':
                case 'time':
					if($mode != 'details'){
						$lang = array();
						$lang['months'][1] = (defined('_JANUARY')) ? _JANUARY : 'January';
						$lang['months'][2] = (defined('_FEBRUARY')) ? _FEBRUARY : 'February';
						$lang['months'][3] = (defined('_MARCH')) ? _MARCH : 'March';
						$lang['months'][4] = (defined('_APRIL')) ? _APRIL : 'April';
						$lang['months'][5] = (defined('_MAY')) ? _MAY : 'May';
						$lang['months'][6] = (defined('_JUNE')) ? _JUNE : 'June';
						$lang['months'][7] = (defined('_JULY')) ? _JULY : 'July';
						$lang['months'][8] = (defined('_AUGUST')) ? _AUGUST : 'August';
						$lang['months'][9] = (defined('_SEPTEMBER')) ? _SEPTEMBER : 'September';
						$lang['months'][10] = (defined('_OCTOBER')) ? _OCTOBER : 'October';
						$lang['months'][11] = (defined('_NOVEMBER')) ? _NOVEMBER : 'November';
						$lang['months'][12] = (defined('_DECEMBER')) ? _DECEMBER : 'December';
						$show_link = true;
                        $meridiem = '';
                        
						if($field_type == 'datetime'){
							$datetime_format = 'Y-m-d H:i:s';
							$datetime_empty_value = '0000-00-00 00:00:00';
                            if($minutes_step != '1') $show_link = false;
						}else if($field_type == 'time'){
                            if($format_parameter == 'am/pm'){
                                $datetime_format = ($show_seconds) ? 'g:i:s A' : 'g:i A';
                            }else{
                                $datetime_format = ($show_seconds) ? 'H:i:s' : 'H:i';
                            }
							$datetime_empty_value = '00:00:00';
                            if($minutes_step != '1') $show_link = false;
                        }else{
							$datetime_format = 'Y-m-d';	
							if(!empty($format_parameter)){
								if(strtolower($format_parameter) == 'm-d-y') $datetime_format = 'm-d-Y';
								else if(strtolower($format_parameter) == 'd-m-y') $datetime_format = 'd-m-Y';
							}
							$datetime_empty_value = '0000-00-00';
						}
						$date_datetime_format = @date($datetime_format);
						
						$year = substr($field_value, 0, 4);
						$month = substr($field_value, 5, 2);
						$day = substr($field_value, 8, 2);
						if($field_type == 'datetime'){
							$hour = substr($field_value, 11, 2);
							$minute = substr($field_value, 14, 2);
							$second = substr($field_value, 17, 2);							
						}else if($field_type == 'time'){
                            $hour = substr($field_value, 0, 2);
                            $minute = substr($field_value, 3, 2);
                            $second = ($show_seconds) ? substr($field_value, 6, 2) : '00';                            
                            if($format_parameter == 'am/pm'){
                                $meridiem = '';
                                if($hour == '0'){
                                    $hour = 12;
                                    $meridiem = 'am';
                                }else if($hour < '12'){
                                    $meridiem = 'am';
                                }else if($hour == '12'){
                                    $meridiem = 'pm';     
                                }else{
                                    $hour -= 12;
                                    if($hour > 10) $hour = '0'.(int)$hour;
                                    $meridiem = 'pm';     
                                }
                            }                            
                        }
						
						$arr_ret_date = array();
                        if($field_type == 'datetime' || $field_type == 'date'){
                            $arr_ret_date['y'] = '<select'.$atr_disabled.' name="'.$field_name.'__nc_year" id="'.$field_name.'__nc_year" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="">'._YEAR.'</option>'; for($i=@date('Y')-$min_year; $i<=@date('Y')+$max_year; $i++) { $arr_ret_date['y'] .= '<option value="'.$i.'"'.(($year == $i) ? ' selected="selected"' : '').'>'.$i.'</option>'; }; $arr_ret_date['y'] .= '</select>';                            
                            $arr_ret_date['m'] = '<select'.$atr_disabled.' name="'.$field_name.'__nc_month" id="'.$field_name.'__nc_month" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="">'._MONTH.'</option>'; for($i=1; $i<=12; $i++) { $arr_ret_date['m'] .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($month == $i) ? ' selected="selected"' : '').'>'.$lang['months'][$i].'</option>'; }; $arr_ret_date['m'] .= '</select>';
                            $arr_ret_date['d'] = '<select'.$atr_disabled.' name="'.$field_name.'__nc_day" id="'.$field_name.'__nc_day" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="">'._DAY.'</option>'; for($i=1; $i<=31; $i++) { $arr_ret_date['d'] .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($day == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $arr_ret_date['d'] .= '</select>';
    
                            $output  = $arr_ret_date[strtolower(substr($datetime_format, 0, 1))];
                            $output .= $arr_ret_date[strtolower(substr($datetime_format, 2, 1))];
                            $output .= $arr_ret_date[strtolower(substr($datetime_format, 4, 1))];
                        }

						if($field_type == 'datetime' || $field_type == 'time'){
							if($field_type == 'datetime') $output .= ' : ';
                            if($format_parameter == 'am/pm'){
                                $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_hour" id="'.$field_name.'__nc_hour" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')">'; for($i=1; $i<=12; $i++) { $output .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($hour == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $output .= '</select>';
                                $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_minute" id="'.$field_name.'__nc_minute" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')">'; for($i=0; $i<=59; $i=$i+$minutes_step) { $output .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($minute == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $output .= '</select>';
                                $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_meridiem" id="'.$field_name.'__nc_meridiem" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="am" '.(($meridiem == 'am') ? 'selected="selected"' : '').'>AM</option><option value="pm" '.(($meridiem == 'pm') ? 'selected="selected"' : '').'>PM</option></select>';                    
                            }else{
                                $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_hour" id="'.$field_name.'__nc_hour" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="00">'._HOUR.'</option>'; for($i=0; $i<=23; $i++) { $output .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($hour == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $output .= '</select>';
                                $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_minute" id="'.$field_name.'__nc_minute" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="00">'._MIN.'</option>'; for($i=0; $i<=59; $i=$i+$minutes_step) { $output .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($minute == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $output .= '</select>';                    
                            }
							if($show_seconds){ $output .= '<select'.$atr_disabled.' name="'.$field_name.'__nc_second" id="'.$field_name.'__nc_second" onChange="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\')"><option value="">'._SEC.'</option>'; for($i=0; $i<=59; $i++) { $output .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($second == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $output .= '</select>'; }
						}
						if(!$readonly){
							if($show_link) $output .= ' <a href="javascript:void(\'date|set\');" onclick="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\', \''.@date($datetime_format).'\', \''.(@date('Y')-$min_year).'\', false)">[ '.$date_datetime_format.' ]</a>';
							if(!$required) $output .= ' <a href="javascript:void(\'date|reset\');" onclick="setCalendarDate(\'frmMicroGrid_'.$this->tableName.'\', \''.$field_name.'\', \''.$datetime_format.'\', \''.$datetime_empty_value.'\', \'1\', false)">[ '._RESET.' ]</a>';
						}
						$output .= '<input style="width:0px;border:0px;margin:0px;padding:0px;" type="text" name="'.$field_name.'" id="'.$field_name.'" value="'.$field_value.'">';					
					}else{
						if($field_value != '' && !preg_match('/0000-00-00/', $field_value)){
							if(empty($format_parameter)) $format_parameter = ($format == 'datetime') ? 'Y-m-d H:i:s' : 'Y-m-d';
							$field_value = date($format_parameter, strtotime($field_value));
						}else{
							$field_value = '';
						}
						$output = '<label class="mgrid_label">'.$this->GetDataDecoded($field_value).'</label>';				
					}
					break;
				case 'file':
				case 'image':
					if(strtolower(SITE_MODE) == 'demo') $atr_readonly = ' disabled="disabled"';
				
					if(($mode == 'edit' || $mode == 'details')){
						if($mode == 'edit'){
							if($field_value != ''){
                                $filesize = number_format((@filesize($target.$field_value) / 1024),  1).' Kb';                                
								$output = ($field_type == 'file') ? $field_value : '<img src="'.$target.$field_value.'" title="'.$field_value.' ('.$filesize.')" alt="" width="'.$image_width.'" height="'.$image_height.'">';								
								if($required) $output .= draw_hidden_field($field_name, $field_value, false, $field_name);
								if(strtolower(SITE_MODE) != 'demo' && !$readonly) $output .= '<br><a href="'.$this->formActionURL.'&mg_prefix='.$this->uPrefix.'&mg_action=edit&mg_rid='.$rid.'&mg_operation=remove&mg_operation_field='.$field_name.'">['._DELETE_WORD.']</a>';
							}else{
								$output = '<input type="file" name="'.$field_name.'" id="'.$field_name.'" class="mgrid_file" '.$atr_readonly.'>';		
							}
						}else if($mode == 'details'){
							if($field_value == '' && $no_image != '') $field_value = $no_image;
							$output = ($field_type == 'file') ? $field_value : '<img src="'.$target.$field_value.'" title="'.$field_value.'" alt="" width="'.$image_width.'" height="'.$image_height.'">';								
						}
					}else{
						$output = '<input type="file" name="'.$field_name.'" id="'.$field_name.'" class="mgrid_file" '.$atr_readonly.'>';
					}
					break;				
				case 'enum':
					if(is_array($source)){
						if($mode == 'add' || $mode == 'edit'){
                            if($view_type == 'checkboxes'){
                                $output = '';
                                $params_edit = ($mode == 'edit') ? @unserialize($field_value) : array();
                                $checkboxes_count = 1;
                                foreach($source as $key => $val){
                                    if($mode == 'edit'){
                                        $checked = (is_array($params_edit) && in_array($key, $params_edit)) ? 'checked="checked"' : '';
                                    }else{
                                        $checked = (isset($params[$field_name]) && is_array($params[$field_name]) && in_array($key, $params[$field_name])) ? 'checked="checked"' : '';
                                    }
                                    $output .= '<div style="float:'.Application::Get('defined_left').';width:220px;"><input type="checkbox" name="'.$field_name.'[]" id="'.$field_name.$checkboxes_count.'" value="'.$key.'" '.$checked.'/> <label for="'.$field_name.$checkboxes_count.'">'.$val.'</label></div>';
                                    $checkboxes_count++;
                                }
								$output .= '<input type="hidden" name="'.$field_name.'[]" value="-placeholder-" />'; /* add placeholder for checkboxes */
                            }else if($view_type == 'label'){
                                if(isset($source[$field_value])){
                                    $output = $source[$field_value];
                                    break;
                                }                                
                            }else{
                                $output_start = '<select class="mgrid_select" name="'.$field_name.'" id="'.$field_name.'" '.(($javascript_event!='') ? ' '.$javascript_event : '').' style="'.(($width!='')?'width:'.$width.';':'').'" '.(($readonly) ? 'disabled="disabled"' : '').'>';
                                $output_options = '';
                                if($default_option) $output_options .= '<option value="">'.$default_option.'</option>';
                                foreach($source as $key => $val){
                                    $output_options .= '<option value="'.$key.'" ';
                                    $output_options .= ($field_value == $key) ? 'selected="selected" ' : '';
                                    $output_options .= '>'.$val.'</option>';
                                }
                                $output = $output_start.$output_options.'</select>';												
                            }
						}else{
                            if($view_type == 'checkboxes'){
                                $params_details = @unserialize($field_value);
                                foreach($source as $key => $val){
                                    $checked = (is_array($params_details) && in_array($key, $params_details)) ? '<span class="green">+</span> ' : '';
                                    $output .= '<div style="float:'.Application::Get('defined_left').';width:190px;"><label>'.$checked.(($checked) ? $val : '<span class="lightgray">&#8226; '.$val.'</span>').'</label></div>';
                                }                                
                            }else{
                                if(isset($source[$field_value])){
                                    $output = $source[$field_value];
                                    break;
                                }                                
                            }
						}
					}
					$output .= $post_html;
					break;				
				case 'label':
					$title = '';
					$field_value  = $this->FormatFieldValue($field_value, $format, $format_parameter);
					if($maxlength != '' && $this->IsInteger($maxlength)){
						$this->PrepareSubString($field_value, $title, $maxlength);
					}					
					$output = $pre_html.'<label class="mgrid_label mgrid_wrapword" title="'.strip_tags($title).'">'.$this->GetDataDecoded($field_value).'</label>'.$post_html;			
					break;
                case 'html':
                    if($mode == 'details'){
                        $output = $pre_html.$this->GetDataDecodedText($field_value).$post_html;
                    }
                    break;
				case 'object':
					if(!preg_match('/youtube/i', $field_value)){
						$output = '<object width="'.$width.'" height="'.$height.'">
								   <param name="movie" value="'.$field_value.'">
								   <embed src="'.$field_value.'" width="'.$width.'" height="'.$height.'"></embed>
								   </object>';														
					}else{
						$output = $field_value;
					}
					break;
				case 'password':
					if($mode == 'add' || $mode == 'edit'){
                        if($cryptography && strtolower($cryptography_type) == 'md5') $field_value = '';

                        if($password_generator && $mode == 'add'){
                            $post_html_temp  = ' &nbsp;<a href="javascript:__mgGenerateRandom(\'password\', \'random-password\')" id="link-password">[ '._GENERATE.' ]</a>';
                            $post_html_temp .= ' &nbsp;<span id="random-password-div" style="display:none;"><a href="javascript:void(0);" onclick="__mgUseThisPassword(\''.$field_name.'\')" id="link-confirm-password">[ '._USE_THIS_PASSWORD.' ]</a> <label id="random-password" style="background-color:#f4f4f4;font-size:14px;margin:0 5px;"></label></span>';
                            $post_html .= $post_html_temp.$post_html; 
                        }
						$output = '<input type="password" class="mgrid_text" name="'.$field_name.'" id="'.$field_name.'" style="'.(($width!='')?'width:'.$width.';':'').'" value="'.$this->GetDataDecoded($field_value).'" '.$atr_readonly.$attr_maxlength.'>'.$post_html;
					}else{
						$output = '<label class="mgrid_label">*****</label>';				
					}				
					break;	
				case 'textarea':
					$output = '';
					if($editor_type == 'wysiwyg'){
						$wysiwyg_state = (isset($_COOKIE['wysiwyg_'.$field_name.'_mode'])) ? $_COOKIE['wysiwyg_'.$field_name.'_mode'] : '0';
						$output .= '<script type="text/javascript">';
						$output .= '__mgAddListener(document, \'load\', function() { toggleEditor(\''.$wysiwyg_state.'\',\''.$field_name.'\',\''.$height.'\'); }, false);'.$nl;
						$output .= '__mgAddListener(this, \'load\', function() { toggleEditor(\''.$wysiwyg_state.'\',\''.$field_name.'\',\''.$height.'\'); }, false);'.$nl;					
						$output .= '</script>';						
						$output .= '[ <a id="lnk_0_'.$field_name.'" style="display:none;" href="javascript:toggleEditor(\'0\',\''.$field_name.'\');" title="Switch to Simple Mode">'._SIMPLE.'</a><a id="lnk_1_'.$field_name.'" href="javascript:toggleEditor(\'1\',\''.$field_name.'\');" title="Switch to Advanced Mode">'._ADVANCED.'</a> ]<br>';
					}
					$output .= $pre_html.'<textarea class="mgrid_textarea" name="'.$field_name.'" id="'.$field_name.'" style="'.(($width != '') ? 'width:'.$width.';' : ' rows="7"').(($height != '') ? 'height:'.$height.';' :' cols="60"').'" '.$atr_disabled.$direction.$attr_maxlength.'>'.$this->GetDataDecodedText($field_value).'</textarea>'.$post_html;				
					break;
				default:
				case 'textbox':
                    if($username_generator && $mode == 'add'){
                        $post_html .= ' &nbsp;<a href="javascript:__mgGenerateRandom(\'username\', \''.$field_name.'\')" id="link-username">[ '._GENERATE.' ]</a>'.$post_html;                       
                    }
					$output = $pre_html.'<input class="mgrid_text'.$css_disabled.'" name="'.$field_name.'" id="'.$field_name.'"  style="'.(($width != '') ? 'width:'.$width.';' : '').(($visible == false) ? 'display:none;' : '').'" value="'.$this->GetDataDecoded($field_value).'" '.$atr_readonly.$attr_maxlength.$direction.$autocomplete.' />'.$post_html;
					break;				
			}			
		}		
		
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 * Get data encoded text
	 *		@param $string
	 */
	private function GetDataEncodedText($string = '')
	{
		return str_replace($string);
	}	
	
	/**
	 * Get data decoded text
	 *		@param $string
	 */
	private function GetDataDecodedText($string = '')
	{
		$search  = array("\\\\","\\0","\\n","\\r","\Z","&#034;","&#039");
		$replace = array("\\","\0","\n","\r","\x1a",'"',"'");
		return str_replace($search, $replace, $string);
	}	
	
	/**
	 * Get data encoded
	 *		@param $string
	 */
	private function GetDataEncoded($string = '')
	{
		$search	 = array("\\","\0","\n","\r","\x1a","'",'"',"\'",'\"');
		$replace = array("\\\\","\\0","\\n","\\r","\Z","\'",'\"',"\\'",'\\"');
		return str_replace($search, $replace, $string);
	}	
	
	/**
	 * Get data decoded 
	 *		@param $string
	 */
	private function GetDataDecoded($string = '')
	{
		$search  = array("\\\\","\\0","\\n","\\r","\Z","\'",'\"','"',"'");
		$replace = array("\\","\0","\n","\r","\x1a","\&#039;","\&#034;","&#034;","&#039;");
		return str_replace($search, $replace, $string);
	}

	////////////////////////////////////////////////////////////////////////////
	// Validation methods
	/**
	 * F5 validation procedure
	 */
	private function F5Validation()
	{
		$operation_code = self::GetParameter('operation_code');
        if(
		   $operation_code != '' &&			
		   Session::IsExists($this->uPrefix.'_operation_code') &&
		   Session::Get($this->uPrefix.'_operation_code') == $operation_code
		)
		{		
            $this->error = _OPERATION_WAS_ALREADY_COMPLETED;
			return false;		
		}
		return true;		
	}

	/**
	 * Fields validation procedure
	 * 		@param $array - validation array of fields
	 */
	private function FieldsValidation($array)
	{		
		if(!is_array($array)) return false;
		
		foreach($array as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						if(!$this->ValidateField($v_key, $v_val)){
							$this->errorField = $v_key;
							return false;
						}						
					}
				}
			}else{
				if(!$this->ValidateField($key, $val)){
					$this->errorField = $key;
					return false;
				}										
			}
		}
		return true;
	}
	
	/**
	 * Validate field
	 */
	private function ValidateField($key, $val)
	{
		$validation_type = isset($val['validation_type']) ? strtolower($val['validation_type']) : '';
		$validation_type_parts = explode('|', $validation_type);
		$validation_type = isset($validation_type_parts[0]) ? $validation_type_parts[0] : '';
		$validation_sub_type = isset($validation_type_parts[1]) ? $validation_type_parts[1] : '';

		$validation_maxlength = (isset($val['validation_maxlength']) && $this->IsInteger($val['validation_maxlength'])) ? $val['validation_maxlength'] : '';
		$validation_minlength = (isset($val['validation_minlength']) && $this->IsInteger($val['validation_minlength'])) ? $val['validation_minlength'] : '';
		$validation_maximum = (isset($val['validation_maximum']) && is_numeric($val['validation_maximum'])) ? $val['validation_maximum'] : '';
		$validation_minimum = (isset($val['validation_minimum']) && is_numeric($val['validation_minimum'])) ? $val['validation_minimum'] : '';
		
		$field_type = isset($val['type']) ? strtolower($val['type']) : '';
        $view_type = isset($val['view_type']) ? strtolower($val['view_type']) : '';
		$required = isset($val['required']) ? $val['required'] : false;
		$readonly = isset($val['readonly']) ? $val['readonly'] : false;

		// check image fields
		if($field_type == 'image' || $field_type == 'file'){
			$field_value = isset($_FILES[$key]['name']) ? $_FILES[$key]['name'] : '';
			if($field_value == '') $field_value = self::GetParameter($key, false); 
			if($required && !$field_value){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_CANNOT_BE_EMPTY);
				return false;
			}
			return true;
		}else if($field_type == 'enum' && $view_type == 'checkboxes'){
            if($required && (!isset($this->params[$key]) || count($this->params[$key]) <= 0)){
                $this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_CANNOT_BE_EMPTY);
                return false;
            }            
            return true;
        }

		if($required && isset($this->params[$key]) && $this->params[$key] === '' && !$readonly){ // 
			$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_CANNOT_BE_EMPTY);
			return false;
		}
		if(isset($this->params[$key]) && $this->params[$key] != ''){		
			if($validation_type == 'email' && !$this->IsEmail($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_EMAIL);
				return false;					
			}else if($validation_type == 'alpha' && !$this->IsAlpha($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_ALPHA);
				return false;					
			}else if($validation_type == 'numeric'){
				if(!$this->IsNumeric($this->params[$key])){
					$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_NUMERIC);
					return false;
				}else if($validation_sub_type == 'positive' && $this->params[$key] < 0){
					$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
					return false;					
				}
			}else if($validation_type == 'float'){
				if(!$this->IsFloat($this->params[$key])){
					$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_FLOAT);
					return false;
				}else if($validation_sub_type == 'positive' && $this->params[$key] < 0){
					$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_FLOAT_POSITIVE);
					return false;
				}				
			}else if($validation_type == 'alpha_numeric' && !$this->IsAlphaNumeric($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_ALPHA_NUMERIC);
				return false;					
			}else if($validation_type == 'text' && !$this->IsText($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_TEXT);
				return false;					
			}else if($validation_type == 'password' && !$this->IsPassword($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_PASSWORD);
				return false;					
			}else if($validation_type == 'ip_address' && !$this->IsIpAddress($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_IP_ADDRESS);
				return false;					
			}else if($validation_type == 'date' && !$this->IsDate($this->params[$key])){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MUST_BE_DATE);
				return false;					
			}
			
			// check maxlength
            if(function_exists('mb_strlen')){
                $detected_strlen = mb_strlen($this->params[$key], mb_detect_encoding($this->params[$key]));    
            }else{
                $detected_strlen = strlen($this->params[$key]);    
            }            
            
			if($validation_maxlength > 0 && $detected_strlen > $validation_maxlength){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_LENGTH_EXCEEDED);
				$this->error = str_replace('_LENGTH_', $validation_maxlength, $this->error);
				return false;									
			}
			
			// check minlength
			if($validation_minlength > 0 && $detected_strlen < $validation_minlength){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_MIN_LENGTH_ALERT);
				$this->error = str_replace('_LENGTH_', $validation_minlength, $this->error);
				return false;									
			}
			
			// check min value
			if($this->params[$key] < $validation_minimum){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_VALUE_MINIMUM);
				$this->error = str_replace('_MIN_', $validation_minimum, $this->error);
				return false;									
			}

			// check max value
			if($validation_maximum > 0 && ($this->params[$key] > $validation_maximum)){
				$this->error = str_replace('_FIELD_', '<b>'.$val['title'].'</b>', _FIELD_VALUE_EXCEEDED);
				$this->error = str_replace('_MAX_', number_format((float)$validation_maximum), $this->error);
				return false;									
			}
		}		
		return true;
	}
	
	
	/**
	 * Email Validation
	 */
	protected function IsEmail($field = '')
	{
		$strict = false;
		$regex = $strict ? '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' :  '/^([*+!.&#$�\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
		
		if(preg_match($regex, trim($field))) {
		   return true;
		} else {
		   return false;
		}		
	}

	/**
	 * Numeric Validation
	 */
	protected function IsNumeric($field = '')
	{
		return ($field == strval(intval($field))) ? true : false;
	}

	/**
	 * Float Number Validation
	 */
	protected function IsFloat($field = '', $unsigned = false)
	{
		if($unsigned){
			if(preg_match('/[\+]/',$field) || preg_match('/[\-]/',$field)) return false;
		}
		return ($field == strval(floatval($field))) ? true : false;	
	}

	/**
	 * Alpha Validation
	 */
	protected function IsAlpha($field = '')
	{
		if(function_exists('ctype_alpha') && ctype_alpha($field)){
			return true;
		}else if(preg_match('/[A-Za-z]/',$field)){					
			return true;
		}else{
			return false;
		}		
	}

	/**
	 * Alpha Numeric Validation
	 */
	protected function IsAlphaNumeric($field = '')
	{
		if(function_exists('ctype_alnum') && ctype_alnum($field)){
			return true;
		}else if(preg_match('/[^a-zA-z0-9_\-]/',$field)){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * Text Validation
	 */
	protected function IsText($field = '')
	{
		if($this->IsAlphaNumeric() || $field != ''){
			return true;
		}else{
			return false;
		}		
	}

	/**
	 * Password Validation
	 */
	protected function IsPassword($field = '')
	{
		if(strlen($field) >= 6 && preg_match('/[A-Za-z0-9]/',$field)){
			return true;
		} else {
			return false;
		}		
	}
	
	/**
	 * IP Address Validation
	 */
	protected function IsIpAddress($field = '')
	{
		// format of the ip address is matched
		if(preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/',$field)){
			// all the intger values are separated
			$parts=explode('.',$field);
			// check each part can range from 0-255
			foreach($parts as $ip_parts){
				//if number is not within range of 0-255
				if(intval($ip_parts)>255 || intval($ip_parts)<0) return false; 				
			}
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Date Validation
	 */
	protected function IsDate($field = '')
	{
        if($field == '0000-00-00') return true;
		$year  = (int)substr($field, 0, 4);
		$month = (int)substr($field, 5, 2);
		$day   = (int)substr($field, 8, 2);	
		if(checkdate($month, $day, $year)){		
			return true;
		}else{
			return false;
		}    
	}

	/**
	 * Integer Validation
	 */
	protected function IsInteger($field = '', $unsigned = false)
	{
		if($unsigned){
			return ctype_digit((string)$field);		
		}else{
			if(is_numeric($field) === true){
				if((int)$field == $field){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}			
		}
    }	
	
	/**
	 * Crypt password value
	 */
	private function CryptValue($key, $field_array, $value)
	{
		$cryptography = $field_array['cryptography'];
		$cryptography_type = strtolower($field_array['cryptography_type']);
		$aes_password = $field_array['aes_password'];
        if($cryptography === true || strtolower($cryptography) == 'true'){
            if($cryptography_type == 'md5'){
                return 'MD5(\''.$value.'\')';
            }else if($cryptography_type == 'aes'){
                return 'AES_ENCRYPT(\''.$value.'\', \''.$aes_password.'\')';                
            }
        }
        return '\''.$value.'\'';    
	}
    
	/**
	 * Prepare enum value for SQL
	 */
	private function PrepareEnumValue($key, $field_array, $value)
	{
		$view_type    = isset($field_array['view_type']) ? $field_array['view_type'] : '';
		$multi_select = isset($field_array['multi_select']) ? $field_array['multi_select'] : '';
		if(is_array($value)) foreach($value as $k => $v) if($v == '-placeholder-') unset($value[$k]); /* clear placeholder */
        if($view_type == 'checkboxes' && $multi_select == true){
            return (!empty($value)) ? '\''.serialize($value).'\'' : '\'\'';
        }else{
            return '\''.mysql_real_escape_string($value).'\'';
        }
    }    
	
	/**
	 * Uncrypt password value
	 */
	private function UncryptValue($key, $field_array, $as = true)
	{
		$output = $key;
		$cryptography = $field_array['cryptography'];
		$cryptography_type = strtolower($field_array['cryptography_type']);
		$aes_password = $field_array['aes_password'];
		if($cryptography === true || strtolower($cryptography) == 'true'){
			if($cryptography_type == 'aes'){
				$output = 'AES_DECRYPT('.$key.', \''.$aes_password.'\')'.(($as) ? ' as '.$key : '');    
			}
		}
        return $output;    
	}
	
	/**
	 * Check if there are unique fields
	 */
	private function FindUniqueFields($mode = 'add', $rid = '0')
	{
		foreach($this->params as $key => $val){
			$arrModeFields = ($mode == 'add') ? $this->arrAddModeFields : $this->arrEditModeFields;
			$fp_required = false;
            $fp_unique = false;
            $title = '';
			
			if(array_key_exists($key, $arrModeFields)){
				$fp_unique = isset($arrModeFields[$key]['unique']) ? $arrModeFields[$key]['unique'] : false;
                $fp_required = isset($arrModeFields[$key]['required']) ? $arrModeFields[$key]['required'] : false;
				$title = isset($arrModeFields[$key]['title']) ? $arrModeFields[$key]['title'] : '';
			}else{
				foreach($arrModeFields as $v_key => $v_val){
					if(array_key_exists($key, $v_val)){
						$fp_unique = isset($v_val[$key]['unique']) ? $v_val[$key]['unique'] : false;
                        $fp_required = isset($v_val[$key]['required']) ? $v_val[$key]['required'] : false;
						$title = isset($v_val[$key]['title']) ? $v_val[$key]['title'] : '';
                        break;
					}
				}
			}			
			if($fp_unique === true || strtolower($fp_unique) == 'true'){
                if(!$fp_required && empty($val)) return false; 
				$sql = 'SELECT COUNT(*) as cnt FROM `'.$this->tableName.'` WHERE '.$key.'=\''.mysql_real_escape_string($val).'\'';
				if($mode == 'edit'){
					$sql .= ' AND '.$this->primaryKey.' != \''.$rid.'\'';
				}
				$records = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
				if($records['cnt'] > 0){
					$this->error = str_replace('_FIELD_', '<b>'.$title.'</b>', _FILED_UNIQUE_VALUE_ALERT);
					$this->errorField = $key;
					return true;					
				}
			}
		}
		return false;
	}
	
	/**
	 * Setup calendar fields
    */
	protected function CalendarSetupFields($calendar_fields)
	{
        global $objSettings; 
        $nl = "\n";
        $output = '';
        if(count($calendar_fields) > 0){
            $output = '<script type="text/javascript">'.$nl;
            $output .= '<!--'.$nl;
            $week_start_day = ($objSettings->GetParameter('week_start_day') != '') ? ($objSettings->GetParameter('week_start_day') - 1) : 1;
            foreach($calendar_fields as $key => $val){
                $output .= 'Calendar.setup({firstDay : '.(int)$week_start_day.', inputField : "'.$val['field'].'", ifFormat : "'.$val['format'].'", showsTime : false, button : "'.$val['field'].'_img"});'.$nl;                
            }
            $output .= '//-->'.$nl;
            $output .= '</script>'.$nl;
        }
        echo $output;
    }

    /**
     * Draw vrsion info
     */
    protected function SetLocale($lc_time_name = '')
	{
		if(!empty($lc_time_name) && $lc_time_name != 'en_US'){
			$sql = 'SET lc_time_names = \''.$lc_time_name.'\'';
			database_void_query($sql);
		}        
    }    

	/**
	 * Include JavaScript
	 * 
    */
	protected function IncludeJSFunctions($mode = '')
	{
        $nl = "\n";
        
		echo '<script type="text/javascript" src="include/classes/js/microgrid.js"></script>'.$nl;
		echo '<script type="text/javascript" src="include/classes/js/lang/en.js"></script>'.$nl;
		if($this->alertOnDelete != ''){
			echo '<script type="text/javascript">Vocabulary._MSG[\'alert_delete_record\'] = \''.$this->alertOnDelete.'\';</script>'.$nl;
		}

		// check for WYSIWYG Editor
		$include_wysiwyg_editor = false;
		if($mode == 'add'){
			$arrModeFields = &$this->arrAddModeFields;
		}else if($mode == 'edit'){
			$arrModeFields = &$this->arrEditModeFields;
		}
		if($mode == 'add' || $mode == 'edit'){
			foreach($arrModeFields as $key => $val){
				if($include_wysiwyg_editor == true) break;
				if(preg_match('/separator/i', $key) && is_array($val)){
					foreach($val as $v_key => $v_val){
						if($v_key != 'separator_info'){
							$type = isset($v_val['type']) ? strtolower($v_val['type']) : '';
							$editor_type = isset($v_val['editor_type']) ? $v_val['editor_type'] : '';							
							if($type == 'textarea' && $editor_type == 'wysiwyg') $include_wysiwyg_editor = true;
						}					
					}				
				}else{
					$type = isset($val['type']) ? strtolower($val['type']) : '';
					$editor_type = isset($val['editor_type']) ? $val['editor_type'] : '';							
					if($type == 'textarea' && $editor_type == 'wysiwyg') $include_wysiwyg_editor = true;
				}
			}		
		}
        $include_calendar = false;
        if($mode == '' && is_array($this->arrFilteringFields)){
            foreach($this->arrFilteringFields as $key => $val){
                $type = isset($val['type']) ? strtolower($val['type']) : '';
                if($type == 'calendar') $include_calendar = true;
            }
        }

		if($include_wysiwyg_editor){
			echo '<script type="text/javascript" src="modules/tinymce/tiny_mce.js"></script>';
			echo '<script type="text/javascript" src="include/classes/js/microgrid_tinymce.js"></script>';
		}
        if($include_calendar){ 
            echo '<link type="text/css" rel="stylesheet" href="modules/jscalendar/skins/aqua/theme.css" />'.$nl;
            echo '<script type="text/javascript" src="modules/jscalendar/calendar.js"></script>'.$nl;
            $lang = (file_exists('modules/jscalendar/lang/calendar-'.Application::Get('lang').'.js')) ? Application::Get('lang') : 'en';
            echo '<script type="text/javascript" src="modules/jscalendar/lang/calendar-'.$lang.'.js"></script>'.$nl;            
            echo '<script type="text/javascript" src="modules/jscalendar/calendar-setup.js"></script>'.$nl;            
        }
	}
	
	/**
	 *	Draw system errors
	 *
	*/	
	protected function DrawErrors($draw = true)
	{
		if(!$this->debug) return false;
		$output = '<br><div style="width:100%;text-align:left;color:#860000;">';
		$output .= 'Errors('.count($this->arrErrors).'):<br>------<br>';
		if(count($this->arrErrors) > 0){
			foreach($this->arrErrors as $key){
				$output .= '<span>* '.$key.'</span><br>';
			}
		}
		$output .= '</div>';
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 *	Draw system warnings
	 *
	*/	
	protected function DrawWarnings($draw = true)
	{
		if(!$this->debug) return false;
		$output = '<br><div style="width:100%;text-align:left;color:#cc9900;">';
		$output .= 'Warnings('.count($this->arrWarnings).'):<br>------<br>';
		if(count($this->arrWarnings) > 0){
			foreach($this->arrWarnings as $key){
				$output .= '<span>* '.$key.'</span><br>';
			}
		}
		$output .= '</div>';
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 *	Set system SQLs
	 *
	*/	
	protected function SetSQLs($key, $msg)
	{
		if($this->debug) $this->arrSQLs[$key] = $msg;					
	}

	/**
	 *	Draw system SQLs
	 *
	*/	
	protected function DrawSQLs($draw = true)
	{
		if(!$this->debug) return false;
		$output = '<br><div style="width:100%;text-align:left; color:#444444;">';
		$output .= 'SQL:<br>------<br>';
		if(count($this->arrSQLs) > 0){
			$output .= '<ol>';
			foreach($this->arrSQLs as $key){
				$output .= '<li style="margin-bottom:10px">'.strip_tags($key, '<i><br>').'</li>';
			}
			$output .= '</ol>';
		}
		$output .= '</div>';
		if($draw) echo $output;
		else return $output;		
	}

	/**
	 *	POST data
	*/	
	protected function DrawPostInfo($draw = true)
	{
		if(!$this->debug) return false;
		$output = '<br><div style="width:100%;text-align:left;color:#008600;">';
		$output .= 'POST:<br>------<br><pre style="white-space:pre-wrap;white-space:-moz-pre-wrap;white-space:o-pre-wrap;">';
		$output .= print_r($_POST, true);
		$output .= '</pre>';
		$output .= '</div>';
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 *	Upload image/file 
	*/	
	private function UploadFileImage($mode, &$arrUploadedFiles)
	{
		$system = $this->GetOSName();		

		#if ($uploaded_size > 350000){echo 'Your file is too large.<br>'; $ok=0;} 				
		#if ($uploaded_type =='text/php'){echo 'No PHP files<br>';$ok=0;} 
		#if (!($uploaded_type=='image/gif')) {echo 'You may only upload GIF files.<br>';$ok=0;} 				

		if($mode == 'add'){
			$arrModeFields = &$this->arrAddModeFields;
		}else if($mode == 'edit'){
			$arrModeFields = &$this->arrEditModeFields;
		}
		
		foreach($arrModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						if(isset($v_val['type']) && ($v_val['type'] == 'image' || $v_val['type'] == 'file')){
							if(isset($_FILES[$v_key]['name'])){
								$thumbnail_create = (isset($v_val['thumbnail_create']) && ($v_val['thumbnail_create'] === true || $v_val['thumbnail_create'] == 'true')) ? true : false;
								$thumbnail_field  = (isset($v_val['thumbnail_field'])) ? $v_val['thumbnail_field'] : '';
								$thumbnail_width  = (isset($v_val['thumbnail_width'])) ? $v_val['thumbnail_width'] : '16px';
								$thumbnail_height = (isset($v_val['thumbnail_height'])) ? $v_val['thumbnail_height'] : '16px';
                                $file_maxsize = (isset($v_val['file_maxsize'])) ? $this->ConvertFileSize($v_val['file_maxsize']) : ''; 
        
								if($v_val['type'] == 'image' && !empty($_FILES[$v_key]['tmp_name']) && !getimagesize($_FILES[$v_key]['tmp_name'])){
									$this->error = _INVALID_IMAGE_FILE_TYPE;
									return false;
								}else if(isset($_FILES[$v_key]['size']) && $file_maxsize != '' && ($_FILES[$v_key]['size'] > $file_maxsize)){
                                    $this->error = str_replace('_FILE_SIZE_', number_format(($_FILES[$v_key]['size']/1024), 2, '.', ',').' Kb', _INVALID_FILE_SIZE);
                                    $this->error = str_replace('_MAX_ALLOWED_', number_format(($file_maxsize/1024), 2, '.', ',').' Kb', $this->error);
                                    return false;
                                }

								if($system == 'windows'){
									$target = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).$v_val['target'];
									$target = str_replace('/', '\\', $target);
									$target = str_replace('\\', '\\\\', $target);
								}else{
									$target = $v_val['target'];
								}								
                                $random_name = isset($v_val['random_name']) ? $v_val['random_name'] : false;
								$overwrite_image = isset($v_val['overwrite_image']) ? $v_val['overwrite_image'] : false;
								$image_name_pefix = isset($v_val['image_name_pefix']) ? $v_val['image_name_pefix'] : ''; 
								if($random_name == 'true' || $random_name === true){									
									$target_file_name = basename($_FILES[$v_key]['name']);
									$ext = substr(strrchr($target_file_name, '.'), 1);
									$target_file_name = $image_name_pefix.self::GetRandomString(20).'.'.$ext;
								}else{
									$target_file_name = basename($_FILES[$v_key]['name']);
								}
								$target_full = $target.$target_file_name;
								if(!$overwrite_image && file_exists($target_full)){
									$target_file_ext = substr(strrchr($target_file_name, '.'), 1);
									$target_file_basename = str_replace('.'.$target_file_ext, '', $target_file_name);
									$target_file_name = $target_file_basename.'[1].'.$target_file_ext;
									$target_full = $target.$target_file_name;
								}								
								if(move_uploaded_file($_FILES[$v_key]['tmp_name'], $target_full)){
									$arrUploadedFiles[$v_key] = $target_file_name;
									if($thumbnail_create){
										// create thumbnail
										$thumb_file_ext = substr(strrchr($target_file_name, '.'), 1);
										$thumb_file_name = str_replace('.'.$thumb_file_ext, '', $target_file_name);
										$thumb_file_fullname = $thumb_file_name.'_thumb.'.$thumb_file_ext;								
										@copy($target_full, $target.$thumb_file_fullname);								
										$thumb_file_thumb_fullname = $this->ResizeImage($target, $thumb_file_fullname, $thumbnail_width, $thumbnail_height);
										if($thumbnail_field == $v_key){
											$arrUploadedFiles[$v_key] = $thumb_file_thumb_fullname;
											@unlink($target_full);
										}else if($thumbnail_field != ''){
											$arrUploadedFiles[$thumbnail_field] = $thumb_file_thumb_fullname;
										}
									}
									//echo 'The file '. basename( $_FILES[$v_key]['name']). ' has been uploaded';
								}else{
									//echo 'Sorry, there was a problem uploading your file.';
								}
							}
						}
					}
				}
			}else{
				if(isset($val['type']) && ($val['type'] == 'image' || $val['type'] == 'file')){
					if(isset($_FILES[$key]['name'])){
						$thumbnail_create = (isset($val['thumbnail_create']) && ($val['thumbnail_create'] === true || $val['thumbnail_create'] == 'true')) ? true : false;
						$thumbnail_field = (isset($val['thumbnail_field'])) ? $val['thumbnail_field'] : '';
						$thumbnail_width = (isset($val['thumbnail_width'])) ? $val['thumbnail_width'] : '16px';
						$thumbnail_height = (isset($val['thumbnail_height'])) ? $val['thumbnail_height'] : '16px';
                        $file_maxsize = (isset($val['file_maxsize'])) ? $this->ConvertFileSize($val['file_maxsize']) : ''; 

						if($val['type'] == 'image' && !empty($_FILES[$key]['tmp_name']) && !getimagesize($_FILES[$key]['tmp_name'])){
                            $this->error = _INVALID_IMAGE_FILE_TYPE;
							return false;
						}else if(isset($_FILES[$key]['size']) && $file_maxsize != '' && ($_FILES[$key]['size'] > $file_maxsize)){
                            $this->error = str_replace('_FILE_SIZE_', number_format(($_FILES[$key]['size']/1024), 2, '.', ',').' Kb', _INVALID_FILE_SIZE);
                            $this->error = str_replace('_MAX_ALLOWED_', number_format(($file_maxsize/1024), 2, '.', ',').' Kb', $this->error);
                            return false;
                        }
						
						if($system == 'windows'){
							$target = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).$val['target'];
							$target = str_replace('/', '\\', $target);
							$target = str_replace('\\', '\\\\', $target);
						}else{
							$target = $val['target'];
						}								
						$random_name = isset($val['random_name']) ? $val['random_name'] : false;
						$overwrite_image = isset($v_val['overwrite_image']) ? $v_val['overwrite_image'] : false;
						$image_name_pefix = isset($val['image_name_pefix']) ? $val['image_name_pefix'] : ''; 
						if($random_name == 'true' || $random_name === true){									
							$target_file_name = basename($_FILES[$key]['name']);
							$ext = substr(strrchr($target_file_name, '.'), 1);
							$target_file_name = $image_name_pefix.self::GetRandomString(20).'.'.$ext;
						}else{
							$target_file_name = basename($_FILES[$key]['name']);
						}
						$target_full = $target.$target_file_name;
						if(!$overwrite_image && file_exists($target_full)){
							$target_file_ext = substr(strrchr($target_file_name, '.'), 1);
							$target_file_basename = str_replace('.'.$target_file_ext, '', $target_file_name);
							$target_file_name = $target_file_basename.'[1].'.$target_file_ext;
							$target_full = $target.$target_file_name;
						}						
						if(move_uploaded_file($_FILES[$key]['tmp_name'], $target_full)){
							$arrUploadedFiles[$key] = $target_file_name;
							if($thumbnail_create){
								// create thumbnail
								$thumb_file_ext = substr(strrchr($target_file_name, '.'), 1);
								$thumb_file_name = str_replace('.'.$thumb_file_ext, '', $target_file_name);
								$thumb_file_fullname = $thumb_file_name.'_thumb.'.$thumb_file_ext;								
								@copy($target_full, $target.$thumb_file_fullname);								
								$thumb_file_thumb_fullname = $this->ResizeImage($target, $thumb_file_fullname, $thumbnail_width, $thumbnail_height);
								if($thumbnail_field == $key){
									$arrUploadedFiles[$key] = $thumb_file_thumb_fullname;
									@unlink($target_full);									
								}else if($thumbnail_field != ''){
									$arrUploadedFiles[$thumbnail_field] = $thumb_file_thumb_fullname;
								}
							}
							//echo 'The file '. basename( $_FILES[$key]['name']). ' has been uploaded';
						}else{
							//echo 'Sorry, there was a problem uploading your file.';
						}
					}
				}
			}
		}			
		
		return true;
	}

	/**
	 *	Remove (delete) image/file and update table field
	*/	
	private function RemoveFileImage($rid, $operation_field, $target_path, $target_file)
	{
		//----------------------------------------------------------------------
		// block if this is a demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;				
		}

		@unlink($target_path.$target_file);
		$ext = substr($target_file,strrpos($target_file,'.')+1);
		@unlink($target_path.str_replace('.'.$ext, '_thumb.jpg', $target_file));
		$sql = 'UPDATE '.$this->tableName.' SET '.$operation_field.' = \'\' WHERE '.$this->primaryKey.' = '.$rid;
		database_void_query($sql);
		$sql = 'UPDATE '.$this->tableName.' SET '.$operation_field.'_thumb = \'\' WHERE '.$this->primaryKey.' = '.$rid;
		database_void_query($sql);
		if($this->debug) $this->arrSQLs['delete_image'] = $sql;					
	}
	
	/**
	 * Prepare images/files fields
	 */
	protected function PrepareImagesArray($rid = '0')
	{
		$this->arrImagesFields = array();

		// prepare images/files fields
		foreach($this->arrEditModeFields as $key => $val){
			if(preg_match('/separator/i', $key) && is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key != 'separator_info'){						
						// prepare images
						if($v_val['type'] == 'image' || $v_val['type'] == 'file'){
							$sql = 'SELECT '.$v_key.' FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.(int)$rid;
							$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
							if(isset($result[$v_key])){
								$this->arrImagesFields[$v_key] = $v_val['target'].$result[$v_key];	
							}							
						}											
					}					
				}				
			}else{
				// prepare images
				if($val['type'] == 'image' || $val['type'] == 'file'){
					$sql = 'SELECT '.$key.' FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.(int)$rid;
					$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
					if(isset($result[$key])){
						$this->arrImagesFields[$key] = $val['target'].$result[$key];	
					}							
				}
			}
		}		
	}
	
	/**
	 * Delete images from images array
	 */
	protected function DeleteImages()
	{		
		//----------------------------------------------------------------------
		// block if this is a demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;				
		}

		foreach($this->arrImagesFields as $key => $val){
			@unlink($val);
			$ext = substr($val,strrpos($val,'.')+1);
			@unlink(str_replace('.'.$ext, '_thumb.jpg', $val));
		}			
	}
	
	/**
	 *	Get formatted microtime
	*/	
    protected function GetFormattedMicrotime()
	{
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }    
	
	/**
	 *	Set running time
	 */	
    protected function SetRunningTime()
	{		
        if($this->debug){
            $this->startTime = $this->GetFormattedMicrotime();
        }        
    }    
		
	/**
	 *	Draw script running time
	 */	
    protected function DrawRunningTime()
	{
        // finish calculating running time of a script
        if($this->debug){
            $this->finishTime = $this->GetFormattedMicrotime();
            $output = '<br><div style="width:100%;text-align:left;color:#000047;">';
			$output .= 'Total running time: '.round((float)$this->finishTime - (float)$this->startTime, 6).' sec.';
			$output .= '</div>';
			echo $output;
        }        
    }    

    /**
     * Resize uploaded image
     */
    protected function ResizeImage($image_path, $image_name, $resize_width = '', $resize_height = '')
	{
        $image_path_name = $image_path.$image_name;        
        if(empty($image_path_name)){ // No Image?    
            echo 'uploaded_file_not_image'; //$this->AddWarning('', '', $this->lang['uploaded_file_not_image']);
		}else if(!function_exists('imagecreatefromjpeg')){
			if($this->debug) $this->arrWarnings['wrong_foo'] =  'Function "imagecreatefromjpeg" doesn\'t exists!';
			return $image_name;
        }else{ // An Image?
			if($image_path_name){
                $size   = getimagesize($image_path_name);
                $width  = $size[0];
                $height = $size[1];                
                $case = '';
                $curr_ext = strtolower(substr($image_path_name,strrpos($image_path_name,'.')+1));
				$imagetype = (function_exists('exif_imagetype')) ? exif_imagetype($image_path_name) : '';	
                if($imagetype == '1' && $curr_ext != 'gif') $ext = 'gif';
				else if($imagetype == '2' && $curr_ext != 'jpg' && $curr_ext != 'jpeg') $ext = 'jpg';
                else if($imagetype == '3' && $curr_ext != 'png') $ext = 'png';
				else $ext = $curr_ext;
                switch($ext){
                    case 'png':
                        $iTmp = @imagecreatefrompng($image_path_name);
                        $case = 'png';
                        break;
                    case 'gif':
                        $iTmp = @imagecreatefromgif($image_path_name);
                        $case = 'gif';
                        break;                
                    case 'jpeg':            
                    case 'jpg':
                        $iTmp = @imagecreatefromjpeg($image_path_name);
                        $case = 'jpg';
                        break;                
                }
                $image_path_name_old = $image_path.$image_name;        
				$image_name = str_replace('.'.$curr_ext, '.jpg', strtolower($image_name));
				$image_path_name_new = $image_path.$image_name;        

				if($case != ''){
					if($resize_width != '' && $resize_height == ''){
						$new_width=$resize_width;
						$new_height = ($height/$width)*$new_width;                
					}else if($resize_width == '' && $resize_height != ''){
						$new_height = $resize_height;
						$new_width=($width/$height)*$new_height;
					}else if($resize_width != '' && $resize_height != ''){
						$new_width  = $resize_width;
						$new_height = $resize_height;                    
					}else{
						$new_width  = $width;  
						$new_height = $height;
					}
					$iOut = @imagecreatetruecolor(intval($new_width), intval($new_height));     
					@imagecopyresampled($iOut,$iTmp,0,0,0,0,intval($new_width), intval($new_height), $width, $height);
					@imagejpeg($iOut,$image_path_name_new,100);
					if($curr_ext != 'jpg' && $case != 'jpg') @unlink($image_path_name_old);
				}
            }            
        }
		return $image_name;
    }
	
    /**
     * Returns Operating System name
     */
	protected function GetOSName()
	{
		// some possible outputs
		// Linux: Linux localhost 2.4.21-0.13mdk #1 Fri Mar 14 15:08:06 EST 2003 i686		
		// FreeBSD: FreeBSD localhost 3.2-RELEASE #15: Mon Dec 17 08:46:02 GMT 2001		
		// WINNT: Windows NT XN1 5.1 build 2600		
		// MAC: Darwin Ron-Cyriers-MacBook-Pro.local 10.6.0 Darwin Kernel Version 10.6.0: Wed Nov 10 18:13:17 PST 2010; root:xnu-1504.9.26~3/RELEASE_I386 i386
		$os_name = strtoupper(substr(PHP_OS, 0, 3));
		switch($os_name){
			case 'WIN':
				return 'windows'; break;
			case 'LIN':
				return 'linux'; break;
			case 'FRE':
				return 'freebsd'; break;
			case 'DAR':
				return 'mac'; break;
			default:
				return 'windows'; break;
		}
	}

	/**
	 * Trigger method - allows to work with View Mode items
	 */
	protected function OnItemCreated_ViewMode($field_name, &$field_value)
	{
        // your code here... &$field_value
        // if($field_name == '...'){ $field_value = '...'; }
    }
    
	/**
	 * Trigger method - allows to work with Details Mode items
	 */
	protected function OnItemCreated_DetailsMode($field_name, &$field_value)
	{
        // your code here... &$field_value        
    }
    	
	/**
	 * Check if parameter value is empty
	 */
	private function ParamEmpty($key)
	{
		if(isset($this->params[$key]) && $this->params[$key] !== '' && $this->params[$key] != '0000-00-00'){
			return false;
		}
		return true;	
	}
	
	/**
	 * Draw Add mode buttons
	 */
	private function DrawAddModeButtons()
	{
        $nl = "\n";
		echo '<tr><td colspan="2" height="15px" nowrap="nowrap"></td></tr>'.$nl;
		echo '<tr>
				<td colspan="2">
					<input class="mgrid_button" type="button" name="subAddNewRecord" value="'._BUTTON_CREATE.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\',\'create\');">
					<input class="mgrid_button" type="button" name="btnCancel" value="'._BUTTON_CANCEL.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\',\'view\');">
				</td>
			  <tr>'.$nl;		
	}

	/**
	 * Draw Edit mode buttons
	 */
	private function DrawEditModeButtons($buttons = array('reset'=>false, 'cancel'=>true))
	{
        $nl = "\n";
		echo '<tr><td colspan="2" height="5px" nowrap="nowrap"></td></tr>';
		echo '<tr>
				<td colspan="2">
					<input class="mgrid_button" type="button" name="subUpdateRecord" value="'._BUTTON_UPDATE.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\',\'update\');">&nbsp;
					'.(($buttons['reset']) ? '<input class="mgrid_button" type="reset" name="btnReset" value="'._BUTTON_RESET.'" />&nbsp;' : '').'
					'.(($buttons['cancel']) ? '<input class="mgrid_button" type="button" name="btnCancel" value="'._BUTTON_CANCEL.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\',\'view\');" />' : '').'
				</td>
			  <tr>'.$nl;		
	}
    
	/**
	 * Draw Details mode buttons
	 */
	private function DrawDetailsModeButtons($buttons = array('back'=>true))
	{
        $nl = "\n";
        if($buttons['back']){
            echo '<tr><td colspan="2" height="5px" nowrap="nowrap"></td></tr>';
            echo '<tr>
                    <td colspan="2">
                        <input class="mgrid_button" type="button" name="btnBack" value="'._BUTTON_BACK.'" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\',\'view\');"> 
                    </td>
                  <tr>'.$nl;		
        }
	}
	
	/**
	 * Draw required field asterisk
	 */
	private function DrawRequiredAsterisk($field)
	{
		echo (isset($field['required']) && $field['required']) ? ' <span class="required">*</span>' : '';
	}

	/**
	 * Draw header tooltip
	 */
	private function DrawHeaderTooltip($field)
	{
		echo (isset($field['header_tooltip']) && !empty($field['header_tooltip'])) ? ' <img src="images/microgrid_icons/question.png" class="help" title="'.decode_text($field['header_tooltip']).'" alt="" />' : '';
	}	

	/**
	 * Draw textarea maxlength notice
	 */
	private function DrawTextareaMaxlength($field)
    {        
		echo (isset($field['type']) && $field['type'] == 'textarea' && (isset($field['validation_maxlength']) && !empty($field['validation_maxlength']))) ? '<br />'.str_replace('_MAX_CHARS_', $field['validation_maxlength'], _MAX_CHARS) : '';
	}	

	/**
	 * Draw image dimantions field text
	 */
	private function DrawImageText($field)
	{
		if($field['type'] == 'image'){
			$thumbnail_width = (isset($field['thumbnail_width']) && !empty($field['thumbnail_width'])) ? $field['thumbnail_width'] : '';
			$thumbnail_height = (isset($field['thumbnail_height']) && !empty($field['thumbnail_height'])) ? $field['thumbnail_height'] : '';
			if(!empty($thumbnail_width)) echo ' (w:'.$thumbnail_width.(($thumbnail_height) ? ' x h:'.$thumbnail_height : '').')';
		}
	}
	
	/**
	 * Pre-format field value
	 * 		@param field_value
	 * 		@param format
	 * 		@param format_parameter
	 */
	private function FormatFieldValue($field_value, $format, $format_parameter)
	{
		if($format == 'strip_tags'){
			$field_value = strip_tags($field_value);
		}else if($format == 'readonly_text'){
			$field_value = nl2br(strip_tags($field_value));
		}else if($format == 'date' && $field_value != ''){
			if(empty($format_parameter)) $format_parameter = 'Y-m-d H:i:s';
            $field_value = ((int)$field_value != 0 && $this->IsDate($field_value)) ? date($format_parameter, strtotime($field_value)) : $field_value;
		}else if($format == 'nl2br'){
			$field_value = nl2br($field_value);
		}else if($format == 'currency' && $field_value != ''){
			$fp_parts = explode('|', $format_parameter);
			$fp_type = isset($fp_parts[0]) ? $fp_parts[0] : '';
			$fp_dp = isset($fp_parts[1]) ? $fp_parts[1] : '2';

			$non_digit = preg_replace('/[0-9.,]/','',$field_value);
			$field_value_pre = (!$this->IsInteger(substr($field_value, 0, 1))) ? $non_digit : '';
			$field_value_post = (!$this->IsInteger(substr($field_value, -1))) ? $non_digit : '';
			$field_value = preg_replace('/[^0-9.,]/','',$field_value);
			
			if($fp_type == 'european'){
				$field_value = str_replace('.', '#', $field_value);							
				$field_value = str_replace(',', '.', $field_value);
				$field_value = str_replace('#', '.', $field_value);
				$field_value = $field_value_pre.number_format((float)$field_value, $fp_dp, ',', '.').$field_value_post;
			}else{
				$field_value = $field_value_pre.number_format((float)$field_value, $fp_dp, '.', ',').$field_value_post;	
			}
		}
		
		return $field_value;
	}

    /**
     * Check visibility of field
     */
	private function IsVisible(&$field)
	{
		if(isset($field['visible']) && $field['visible'] !== ''){
			if($field['visible'] !== true) return false;		
		}
		return true;
	}	
	
	////////////////////////////////////////////////////////////////////////////
	// STATIC METHODS
	////////////////////////////////////////////////////////////////////////////
	/**
	 * Update table
	 */
	public function Update($rid = '', $params = array())
	{
		if($rid = '') return false;
		$sql = 'UPDATE `'.$this->tableName.'` SET ';
			$fields_count = 0;
			foreach($params as $key => $val){
				if($fields_count++ > 0) $sql .= ',';
				$sql .= '`'.$key.'` = '.mysql_real_escape_string($val);					
			}				
		$sql .= ' WHERE `'.$this->primaryKey.'`='.(int)$rid;
		
		if(!database_void_query($sql)){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * Prepare fields array for translations 
	 */
    public function PrepareTranslateFields($params = array())
	{
		$output = array();
		
		$total_languages = Languages::GetAllActive();		
		foreach($total_languages[0] as $key => $val){			
			$output[$val['abbreviation']]['lang_name'] = $val['lang_name'];
			$output[$val['abbreviation']]['icon_image'] = $val['icon_image'];
			foreach($params as $p_key){
				$output[$val['abbreviation']][$p_key] = self::GetParameter($p_key.'_'.$val['abbreviation'], false);
			}			
		}		
		return $output;		
	}

	/**
	 * Prepare sql fields array for translations 
	 */
    public function PrepareTranslateSql($table = '', $field = '', $params = array())
	{
		$output = '';
		
		$sql = 'SELECT id, '.$field.', language_id, '.implode(', ', $params).' FROM '.$table.' WHERE '.$field.' = \''.self::GetParameter('rid').'\'';
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);

		for($i=0; $i<$result[1]; $i++){
			foreach($params as $p_key){
				$fd_l = self::GetParameter($p_key.'_'.$result[0][$i]['language_id'], false);
				$fd = (!empty($fd_l)) ? $fd_l : $result[0][$i][$p_key];
				
				$output .= '\''.encode_text($fd).'\' as '.$p_key.'_'.$result[0][$i]['language_id'].',';
			}
		}
		return $output;
	}
	
	/**
	 * Add translation fields to modes
	 */
    public function AddTranslateToModes($translations = array(), $params = array())
	{
		foreach($translations as $key => $val){			
			$this->arrAddModeFields['separator_'.$key]['separator_info'] = array('legend'=>'<img src="images/flags/'.$val['icon_image'].'" alt="" />&nbsp;&nbsp;'.$val['lang_name']);
			foreach($params as $p_key => $p_val){
				$this->arrAddModeFields['separator_'.$key][$p_key.'_'.$key] = array(
					'title'=>$p_val['title'],
					'type'=>$p_val['type'],
					'width'=>$p_val['width'],
					'height'=>(isset($p_val['height']) ? $p_val['height'] : ''),
					'required'=>$p_val['required'],
					'maxlength'=>(isset($p_val['maxlength']) ? $p_val['maxlength'] : ''),
                    'validation_maxlength'=>(isset($p_val['validation_maxlength']) ? $p_val['validation_maxlength'] : ''),
					'readonly'=>false,
					'default'=>$val[$p_key],
					'editor_type'=>(isset($p_val['editor_type']) ? $p_val['editor_type'] : ''),
                    'post_html'=>(isset($p_val['post_html']) ? $p_val['post_html'] : ''));
			}			

			$this->arrEditModeFields['separator_'.$key]['separator_info'] = array('legend'=>'<img src="images/flags/'.$val['icon_image'].'" alt="" />&nbsp;&nbsp;'.$val['lang_name']);
			foreach($params as $p_key => $p_val){
				$this->arrEditModeFields['separator_'.$key][$p_key.'_'.$key] = array(
					'title'=>$p_val['title'],
					'type'=>$p_val['type'],
					'width'=>$p_val['width'],
					'height'=>(isset($p_val['height']) ? $p_val['height'] : ''),
					'required'=>$p_val['required'],
					'maxlength'=>(isset($p_val['maxlength']) ? $p_val['maxlength'] : ''),
                    'validation_maxlength'=>(isset($p_val['validation_maxlength']) ? $p_val['validation_maxlength'] : ''),
					'readonly'=>false,
					'default'=>$val[$p_key],
					'editor_type'=>(isset($p_val['editor_type']) ? $p_val['editor_type'] : ''),
                    'post_html'=>(isset($p_val['post_html']) ? $p_val['post_html'] : ''));
			}			

			$this->arrDetailsModeFields['separator_'.$key]['separator_info'] = array('legend'=>'<img src="images/flags/'.$val['icon_image'].'" alt="" />&nbsp;&nbsp;'. $val['lang_name']);
			foreach($params as $p_key => $p_val){
				$this->arrDetailsModeFields['separator_'.$key][$p_key.'_'.$key] = array(
					'title'=>$p_val['title'],
					'type'=>'label',
                    'post_html'=>(isset($p_val['post_html']) ? $p_val['post_html'] : ''));
			}			
		}		
	}
	
	/**
	 * Set actions
	 */
    public function SetActions($actions = array())
	{
		if(isset($actions['add']))     $this->actions['add'] = (bool)$actions['add'];
		if(isset($actions['edit']))    $this->actions['edit'] = (bool)$actions['edit'];
		if(isset($actions['details'])) $this->actions['details'] = (bool)$actions['details'];
		if(isset($actions['delete']))  $this->actions['delete'] = (bool)$actions['delete'];
	}
    
	/**
	 * Prepare Datetime fields for SQL
	 */
    public function PrepareDateTime($value, $format = '')
	{
        if($format == "mm/dd/yyyy"){
            $month = substr($value, 0, 2);
            $day = substr($value, 3, 2);
            $year = substr($value, 6, 4); 
            $value = $year.'-'.$month.'-'.$day;
        }else if($format == "dd/mm/yyyy"){
            $day = substr($value, 0, 2);
            $month = substr($value, 3, 2);
            $year = substr($value, 6, 4);             
            $value = $year.'-'.$month.'-'.$day;
        }else{
            // do nothing, it's yyyy-mm-dd
        }                        
        return $value;        
    }
    
    /**
     * Get maximum order value
    */
    public function GetMaxOrder($field_name, $max_order = 0)
    {
        $sql = 'SELECT MAX('.$field_name.') as max_order FROM '.$this->tableName;
        $result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
        return (isset($result['max_order']) && $result['max_order'] < $max_order) ? $result['max_order']+1 : $max_order;			        
    }
        
	/**
	 * Cuts word to pre-defined length
	 */
	private function PrepareSubString(&$field_value, &$title, $maxlength)
	{
		if(strlen($field_value) > $maxlength){							
			$title = $field_value;
			if(function_exists('mb_substr')) $field_value = mb_substr($field_value, 0, $maxlength, 'UTF-8').'...';
			else $field_value = substr($field_value, 0, $maxlength).'...';						
		}		
	}

    /**
     * Convert file size
     * 		@param $file_size
     */
    private function ConvertFileSize($file_size)
	{
		$return_size = $file_size;
		if(!is_numeric($file_size)){ 
			if(stripos($file_size, 'm') !== false){ 
				$return_size = intval($file_size)*1024*1024; 
			}else if(stripos($file_size, 'k') !== false){ 
				$return_size = intval($file_size)*1024; 
			}else if(stripos($file_size, 'g') !== false){ 
				$return_size = intval($file_size)*1024*1024*1024;
			}
		}
		return $return_size;
	}
    
    /**
     * Draw vrsion info
     */
    private function DrawVersionInfo()
	{
        $nl = "\n";
        echo $nl.'<!-- This script was generated by microgrid.class.php v'.$this->version.' -->'.$nl;        
    }
    
    /**
     * Check if current field is "secure" field
     */
    private function IsSecureField($field, &$arrModeFields)
	{
        if(!is_array($arrModeFields)) return false;
        if(!in_array($arrModeFields['type'], array('label', 'textbox', 'textarea', 'text'))) return false;
        
		$cryptography = isset($arrModeFields['cryptography']) ? $arrModeFields['cryptography'] : '';
		$cryptography_type = isset($arrModeFields['cryptography_type']) ? strtolower($arrModeFields['cryptography_type']) : '';

        if(($cryptography === true || strtolower($cryptography) == 'true') && $cryptography_type == 'aes'){
            return true;    
        }
        return false;
    }
        
	/**
	 * Returns parameter
	 */
	public static function GetParameter($param, $use_prefix = true, $u_prefix = '')
	{
		$prefix = ($use_prefix) ? 'mg_' : '';
		$output = isset($_REQUEST[$u_prefix.$prefix.$param]) ? $_REQUEST[$u_prefix.$prefix.$param] : '';
		return $output;
	}
		
	/**
	 * Returns random string
	 */
    public static function GetRandomString($length = 20)
	{
        $template_alpha = 'abcdefghijklmnopqrstuvwxyz';
        $template_alphanumeric = '1234567890abcdefghijklmnopqrstuvwxyz';
        settype($template, 'string');
        settype($length, 'integer');
        settype($rndstring, 'string');
        settype($a, 'integer');
        settype($b, 'integer');
        $b = rand(0, strlen($template_alpha) - 1);
        $rndstring .= $template_alpha[$b];        
        for ($a = 0; $a < $length-1; $a++) {
            $b = rand(0, strlen($template_alphanumeric) - 1);
            $rndstring .= $template_alphanumeric[$b];
        }       
        return $rndstring;       
    }	
	
	/**
	 *	Alternative for get_called_class() for PHP < 5.3
	 */
	public static function GetCalledClass()
	{
		if(function_exists('get_called_class')) return get_called_class();
		$bt = debug_backtrace();
		if(!isset($bt[1])){
			return false; // cannot find called class -> stack level too deep
		}else if(!isset($bt[1]['type'])){
			return false; // type not set
		}else switch ($bt[1]['type']) { 
			case '::': 
				$lines = file($bt[1]['file']); 
				$i = 0; 
				$callerLine = ''; 
				do { 
					$i++; 
					$callerLine = $lines[$bt[1]['line']-$i] . $callerLine; 
				} while (stripos($callerLine,$bt[1]['function']) === false); 
				preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/', $callerLine, $matches); 
				if(!isset($matches[1])){ 					
					return false; // could not find caller class: originating method call is obscured
				}
				return $matches[1]; 
				break;
			case '->': switch ($bt[1]['function']) { 
					case '__get': 
						// edge case -> get class of calling object 
						if (!is_object($bt[1]['object'])){							
							return false; // edge case fail. __get called on non object
						}
						return get_class($bt[1]['object']); 
					default: return $bt[1]['class']; 
				}
				break;
			default:
				// unknown backtrace method type
				return false;
				break;
		}
		return false;
	}	

	/**
	 * Returns static error description
	 */
	public static function GetStaticError()
	{
		return self::$static_error;
	}

	/**
	 *	Return instance of the class
	 */
	public static function Instance()
	{
		$className = self::GetCalledClass();
		if(self::$instance == null) self::$instance = new $className();
		return self::$instance;
	}       
	
}
?>