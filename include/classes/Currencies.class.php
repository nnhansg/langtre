<?php

/***
 *	Currencies Class (has differences)
 *  --------------
 *  Description : encapsulates currencies properties
 *	Written by  : ApPHP
 *	Version     : 1.0.3
 *  Updated	    : 30.05.2012
 *	Usage       : HotelSite, ShoppingCart, BusinessDirectory, MedicalAppointments
 *  Differences : $PROJECT
 *
 *	PUBLIC:					STATIC:					PRIVATE:
 * 	------------------	  	---------------     	---------------
 *  __construct				GetDefaultCurrency
 *  __destruct              PriceFormat  
 *  AfterInsertRecord       CurrencyExists 
 *  AfterUpdateRecord       GetDefaultCurrencyInfo
 *  BeforeDeleteRecord      GetCurrencyInfo
 *  AfterDeleteRecord       GetCurrenciesDDL
 *                          
 *                          
 *  1.0.3
 *      - added allow_seo_links to GetCurrenciesDDL
 *      - changes SELECT CASEs with 'enum' type
 *      - added decimal_points to PriceFormat()
 *      - added gray color to not default
 *      -
 *  1.0.2
 *      - improved PriceFormat() method - to display european format
 *      - fixed bug on drawing currency DDL 
 *      - fixed issues with maxlength of some fields
 *      - added AfterInsertRecord()
 *      - added BusinessDirectory
 *  1.0.1
 *      - blocked possibility to make all currencies un-active
 *      - currencies dropdown box now shown only if there is more that 1 active currency 
 *      - removed arguments from GetCurrenciesDDL()
 *      - added (float)$price in PriceFormat() method
 *      - added number format for rate in view mode
 **/


class Currencies extends MicroGrid {
	
	protected $debug = false;
	
	//------------------------------
	// HotelSite, ShoppingCart, BusinessDirectory, MedicalAppointments
	private static $PROJECT = 'HotelSite'; 

	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();
		
		$this->params = array();		
		if(isset($_POST['name']))   $this->params['name'] = prepare_input($_POST['name']);
		if(isset($_POST['symbol'])) $this->params['symbol'] = prepare_input($_POST['symbol']);
		if(isset($_POST['symbol_placement'])) $this->params['symbol_placement'] = prepare_input($_POST['symbol_placement']);
		if(isset($_POST['code']))   $this->params['code'] = prepare_input($_POST['code']);
		if(isset($_POST['rate']))   $this->params['rate'] = prepare_input($_POST['rate']);
		if(isset($_POST['primary_order']))   $this->params['primary_order'] = (int)$_POST['primary_order'];
		// for checkboxes 
		if(isset($_POST['is_default'])) $this->params['is_default'] = (int)$_POST['is_default']; else $this->params['is_default'] = '0';
		if(isset($_POST['is_active']))  $this->params['is_active'] = (int)$_POST['is_active']; else $this->params['is_active'] = '0';
		
		$this->params['language_id'] 	  = MicroGrid::GetParameter('language_id');
	
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_CURRENCIES;
		$this->dataSet 		= array();
		$this->error 		= '';
		if(self::$PROJECT == 'HotelSite'){
			$this->formActionURL = 'index.php?admin=mod_booking_currencies';
		}else if(self::$PROJECT == 'ShoppingCart'){	
			$this->formActionURL = 'index.php?admin=mod_catalog_currencies';			
		}else if(self::$PROJECT == 'BusinessDirectory'){
			$this->formActionURL = 'index.php?admin=mod_payments_currencies';			
		}else if(self::$PROJECT == 'MedicalAppointments'){
			$this->formActionURL = 'index.php?admin=mod_appointments_currencies';			
		}
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;

		$this->allowLanguages = false;
		$this->languageId  	= ''; // ($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();
		$this->WHERE_CLAUSE = ''; // WHERE .... / 'WHERE language_id = \''.$this->languageId.'\'';				
		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.primary_order ASC'; // ORDER BY date_created DESC
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;

		$this->isFilteringAllowed = false;
		// define filtering fields
		///$this->arrFilteringFields = array(
		///	'parameter1' => array('title'=>'',  'type'=>'text', 'sign'=>'=|like%|%like|%like%', 'width'=>'80px'),
		///	'parameter2'  => array('title'=>'',  'type'=>'text', 'sign'=>'=|like%|%like|%like%', 'width'=>'80px'),
		///);

		$currency_format = get_currency_format();
		
		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		$arr_is_default = array('0'=>'<span class=gray>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');

		// prepare languages array		
		/// $total_languages = Languages::GetAllActive();
		/// $arr_languages      = array();
		/// foreach($total_languages[0] as $key => $val){
		/// 	$arr_languages[$val['abbreviation']] = $val['lang_name'];
		/// }

		//---------------------------------------------------------------------- 
		// VIEW MODE
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									name,
									symbol,
									symbol_placement,
									code,
									rate,
									primary_order,
									is_default,
									is_active
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'name'   	=> array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'height'=>'', 'maxlength'=>''),
			'symbol' 	=> array('title'=>_SYMBOL, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
			'code' 		=> array('title'=>_CODE, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>''),
			'rate' 		=> array('title'=>_RATE, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>'', 'format'=>'currency', 'format_parameter'=>$currency_format.'|4'),
			'primary_order' => array('title'=>_ORDER, 'type'=>'label', 'align'=>'center', 'width'=>'', 'height'=>'', 'maxlength'=>'', 'movable'=>true),
			'is_default' => array('title'=>_DEFAULT, 'type'=>'enum',  'align'=>'center', 'width'=>'80px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_default),
			'is_active'  => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'80px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
			'name'   => array('title'=>_NAME, 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'50', 'validation_type'=>'text'),
			'symbol' => array('title'=>_SYMBOL, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'5', 'validation_type'=>'text'),
			'symbol_placement' => array('title'=>_SYMBOL_PLACEMENT, 'type'=>'enum',     'required'=>true, 'readonly'=>false, 'width'=>'100px', 'source'=>array('left'=>_LEFT, 'right'=>_RIGHT)),
			'code'   => array('title'=>_CODE, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'validation_type'=>'alpha'),
			'rate' 	 => array('title'=>_RATE, 'type'=>'textbox',  'width'=>'80px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'validation_type'=>'float', 'validation_maximum'=>'999999'),
			'primary_order'  => array('title'=>_ORDER, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'validation_type'=>'numeric'),
			'is_default' => array('title'=>_DEFAULT, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'0', 'true_value'=>'1', 'false_value'=>'0'),
			'is_active'  => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0'),
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT '.$this->primaryKey.',
									name,
									symbol,
									symbol_placement,
									code,
									rate,
									primary_order,
									is_default,
									is_active
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';
		
		
		$rid = MicroGrid::GetParameter('rid');
		$sql = 'SELECT is_default FROM '.TABLE_CURRENCIES.' WHERE id = '.(int)$rid;
		$readonly = false;
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			$readonly = (isset($result['is_default']) && $result['is_default'] == '1') ? true : false;
		}
		
		// define edit mode fields
		$this->arrEditModeFields = array(		
			'name'   => array('title'=>_NAME, 'type'=>'textbox',  'width'=>'210px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'50', 'validation_type'=>'text'),
			'symbol' => array('title'=>_SYMBOL, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'5', 'validation_type'=>'text'),
			'symbol_placement' => array('title'=>_SYMBOL_PLACEMENT, 'type'=>'enum',     'required'=>true, 'readonly'=>false, 'width'=>'100px', 'source'=>array('left'=>_LEFT, 'right'=>_RIGHT)),
			'code'   => array('title'=>_CODE, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'validation_type'=>'alpha'),
			'rate' 	 => array('title'=>_RATE, 'type'=>'textbox',  'width'=>'80px', 'required'=>true, 'readonly'=>$readonly, 'maxlength'=>'10', 'validation_type'=>'float', 'validation_maximum'=>'999999'),
			'primary_order'  => array('title'=>_ORDER, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'validation_type'=>'numeric'),
			'is_default' => array('title'=>_DEFAULT, 'type'=>'checkbox', 'readonly'=>$readonly, 'default'=>'0', 'true_value'=>'1', 'false_value'=>'0'),
			'is_active'  => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>$readonly, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0'),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'name'   => array('title'=>_NAME, 'type'=>'label'),
			'symbol' => array('title'=>_SYMBOL, 'type'=>'label'),
			'symbol_placement' => array('title'=>_SYMBOL_PLACEMENT, 'type'=>'label'),
			'code'   => array('title'=>_CODE, 'type'=>'label'),
			'rate' 	 => array('title'=>_RATE, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$currency_format.'|4'),
			'primary_order'  => array('title'=>_ORDER, 'type'=>'label'),
			'is_default' => array('title'=>_DEFAULT, 'type'=>'enum', 'source'=>$arr_is_default),
			'is_active'  => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
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
    // Static Methods
	//==========================================================================	
	/**
	 *	Returns default currency
	 */
	public static function GetDefaultCurrency()
	{
		$def_currency = '$';
		$sql = 'SELECT symbol FROM '.TABLE_CURRENCIES.' WHERE is_default = 1';
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			$def_currency = $result['symbol'];					
		}
		return $def_currency;
	}
	
	/**
	 *	Returns formatted price value
	 *		@param $price
	 *		@param $cur_symbol
	 *		@param $cur_symbol_place
	 *		@param $currency_format
	 *		@param $decimal_points
	 */
	public static function PriceFormat($price, $cur_symbol = '', $cur_symbol_place = '', $currency_format = 'american', $decimal_points = 2)
	{
		if(Application::Get('currency_code') == ''){
			$currency_code = Currencies::GetDefaultCurrency();
			$currency_symbol = '$';
			$currency_symbol_place = 'left';
		}else{
			$currency_symbol = ($cur_symbol != '') ? $cur_symbol : Application::Get('currency_symbol');
			$currency_symbol_place = ($cur_symbol_place != '') ? $cur_symbol_place : Application::Get('currency_symbol_place');
		}

		if($currency_symbol_place == 'left'){
			$field_value_pre = $currency_symbol;
			$field_value_post = '';
		}else{
			$field_value_pre = '';
			$field_value_post = $currency_symbol;
		}		

		if($currency_format == 'european'){
			$price = str_replace('.', '#', $price);							
			$price = str_replace(',', '.', $price);
			$price = str_replace('#', '.', $price);
			return $field_value_pre.number_format((float)$price, (int)$decimal_points, ',', '.').$field_value_post;
		}else{
			return $field_value_pre.number_format((float)$price, (int)$decimal_points, '.', ',').$field_value_post;	
		}
	}

	/**
	 *	Check if currency exists
	 *		@param $currency_code
	 */
	public static function CurrencyExists($currency_code = '')
	{
		$sql = 'SELECT code FROM '.TABLE_CURRENCIES.' WHERE code = \''.mysql_real_escape_string($currency_code).'\' AND is_active = 1 ';
		if(database_query($sql, ROWS_ONLY) > 0){
			return true;
		}
		return false;
	}

	/**
	 *	Returns default currency info
	 *		@param $currency_code
	 */
	public static function GetDefaultCurrencyInfo($currency_code = '')
	{
		$sql = 'SELECT symbol, code, rate, symbol_placement FROM '.TABLE_CURRENCIES.' WHERE is_default = 1 AND is_active = 1 ';
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			return $result;
		}
		return array('symbol'=>'$', 'code'=>'USD', 'rate'=>'1', 'symbol_placement'=>'left');
	}

	/**
	 *	Returns currency info
	 *		@param $currency_code
	 */
	public static function GetCurrencyInfo($currency_code = '')
	{
		$sql = 'SELECT symbol, code, rate, symbol_placement FROM '.TABLE_CURRENCIES.' WHERE code = \''.$currency_code.'\' AND is_active = 1 ';
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			return $result;
		}
		return array('symbol'=>'$', 'code'=>'USD', 'rate'=>'1', 'symbol_placement'=>'left');
	}

    /**
	 * Returns currencies dropdown list
	 * 		@param $allow_seo_links
	 */
	public static function GetCurrenciesDDL($allow_seo_links = true)
	{
		global $objSettings;
		
		$sel_currency = Application::Get('currency_code');
		$currency = Application::Get('currency');
		$output = '';
		
		$sql = 'SELECT id, name, symbol, code, rate, primary_order
				FROM '.TABLE_CURRENCIES.'
				WHERE is_active = 1';
		if($result = database_query($sql, DATA_AND_ROWS, ALL_ROWS)){
			if($result[1] > 1){
				$base_url = APPHP_BASE;
				$url = get_page_url();

				// prevent wrong re-loading for some problematic cases
				if(self::$PROJECT == 'HotelSite'){
					$url = str_replace(array('page=booking_payment'), 'page=booking_checkout', $url);
					$url = str_replace(array('page=check_availability'), 'page=index', $url);									
				}else if(self::$PROJECT == 'ShoppingCart'){
					$url = str_replace(array('&act=add', '&act=remove'), '', $url);
					$url = str_replace(array('page=order_proccess'), 'page=checkout', $url);
					$url = str_replace(array('page=search'), 'page=index', $url);									
				}

				if($objSettings->GetParameter('seo_urls') == '1' && $allow_seo_links){					
					// remove lang parameters
					$url = str_replace('/'.Application::Get('lang').'/', '/', $url);						
					
					if(preg_match('/\/'.Application::Get('currency_code').'\//i', $url)){
						$url = str_replace('/'.Application::Get('currency_code').'/', '/__CUR__/', $url);						
					}else{
						$url = str_replace($base_url, $base_url.'__CUR__/', $url); 							
					}						
				}else{
					if(preg_match('/currency='.Application::Get('currency_code').'/i', $url)){
						$url = str_replace('currency='.Application::Get('currency_code'), 'currency=__CUR__', $url);
					}else{
						$url = $url.(preg_match('/\?/', $url) ? '&amp;' : '?').'currency=__CUR__';						
					}
				}

				$output .= '<select onchange="javascript:appSetNewCurrency(\''.$url.'\',this.value)" name="currency" class="currency_select">';
				for($i=0; $i < $result[1]; $i++){
					$output .= '<option value="'.$result[0][$i]['code'].'" '.(($sel_currency == $result[0][$i]['code']) ? ' selected="selected"' : '').'>'.$result[0][$i]['name'].'</option>';
				}
				$output .= '</select>';
			}
		}
	    return $output;
	}	

    /**
	 * After-Insertion Record
	 */
	public function AfterInsertRecord()
	{
		$is_default = MicroGrid::GetParameter('is_default', false);
		if($is_default == '1'){
			$sql = 'UPDATE '.TABLE_CURRENCIES.' SET is_default = \'0\' WHERE id != '.(int)$this->lastInsertId;
			database_void_query($sql);
			return true;
		}
	}
	
	/**
	 * After-Updating Record
	 */
	public function AfterUpdateRecord()
	{
		$sql = 'SELECT id, is_active FROM '.TABLE_CURRENCIES;
		if($result = database_query($sql, DATA_AND_ROWS, ALL_ROWS)){
			if((int)$result[1] == 1){
				// make last currency always be default
				$sql = 'UPDATE '.TABLE_CURRENCIES.' SET rate = \'1\', is_default = \'1\', is_active = \'1\' WHERE id = '.(int)$result[0][0]['id'];
				database_void_query($sql);
				return true;	
			}else{
				// save all other currencies to be not default
				$rid = MicroGrid::GetParameter('rid');
				$is_default = MicroGrid::GetParameter('is_default', false);
				if($is_default == '1'){
					$sql = 'UPDATE '.TABLE_CURRENCIES.' SET rate = \'1\', is_active = \'1\' WHERE id = '.(int)$rid;
					database_void_query($sql);
					
					$sql = 'UPDATE '.TABLE_CURRENCIES.' SET is_default = \'0\' WHERE id != '.(int)$rid;
					database_void_query($sql);
					return true;
				}
			}
		}
	    return true;	
	}

    /**
	 * Before-Deleting Record
	 */
	public function BeforeDeleteRecord()
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_CURRENCIES.' WHERE is_active = 1';
		if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			if((int)$result['cnt'] > 1){
				$rid = MicroGrid::GetParameter('rid');
				$sql = 'SELECT is_default FROM '.TABLE_CURRENCIES.' WHERE id = '.(int)$rid;
				if($result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
					if($result['is_default'] == '1'){
						$this->error = _DEFAULT_CURRENCY_DELETE_ALERT;
						return false;
					}
				}				
				return true;	
			}else{
				$this->error = _LAST_CURRENCY_ALERT;
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
		$sql = 'SELECT id, is_active FROM '.TABLE_CURRENCIES;
		if($result = database_query($sql, DATA_AND_ROWS, ALL_ROWS)){
			if((int)$result[1] == 1){
				// make last currency always 
				$sql = 'UPDATE '.TABLE_CURRENCIES.' SET rate= \'1\', is_default = \'1\', is_active = \'1\' WHERE id= '.(int)$result[0][0]['id'];
				database_void_query($sql);
				return true;	
			}
		}
	    return true;	
	}
	
}
?>