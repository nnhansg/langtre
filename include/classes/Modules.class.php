<?php

/**
 *	Class Modules
 *  -------------- 
 *  Description : encapsulates modules properties
 *	Written by  : ApPHP
 *	Version     : 1.0.6
 *  Updated	    : 05.11.2012
 *	Usage       : Core Class (ALL)
 *	Differences : no
 *	
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *	__construct				IsModuleInstalled		CleanModuleTables
 *	__destruct              Init
 *	DrawModules
 *	GetAllModules
 *	InstallModule
 *	UninstallModule
 *	AfterUpdateRecord
 *	BeforeEditRecord
 *	
 *
 *  1.0.6
 *	    - ucfirst() replaced with ucwords()
 *      - replaced SQL CASEs with 'enum' types
 *      - replaced <img> for installed/uninstalled
 *      - fixed issue with floating img
 *      -
 *  1.0.5
 *      - added Init() method to prevent unneded checks for modules
 *      - added draw_token_field()
 *      - fixed HTML error in DrawModules()
 *      - added description for each module in title attribute
 *      - fixed bug on drawinf installed/uninstalled images      
 *  1.0.4
 *  	- added drawing of modules only if module acces is allowed in DrawModules()
 *  	- added split to system and additional modules
 *  	- blocking for operations with system modules
 *  	- added check for empty dependent tables
 *  	- added alert on un-installation operation
 *  1.0.3
 *      - re-done using of 'module_tables' field
 *      - added private method CleanModuleTables() 
 *      - added recursive un-installing modules 
 *      - added check on installation of dependent module
 *      - added possibility to truncate or not related tables
 *	
 **/

class Modules extends MicroGrid {

	protected $debug = false;
	
	// ------------------
	public $modulesCount;

	protected $modules;

	private $id;
	private $is_installed = '';
	private $is_system = '';
	private $module_name = '';
	private static $arr_modules = array();
	
	//==========================================================================
    // Class Constructor
	// 		@param $id
	//==========================================================================
	function __construct($id = '')
	{
		parent::__construct();

		//////////////////////////////////////////////////////////////////
		$this->id = $id;
		if($this->id != ''){
			$sql = 'SELECT
						id, name, name_const, description_const, icon_file, module_tables, dependent_modules, is_installed, is_system, priority_order, settings_access_by
					FROM '.TABLE_MODULES.'
					WHERE id = \''.intval($this->id).'\'';
			$this->modules = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		}else{
			$this->modules = $this->GetAllModules();
		}
		$this->modulesCount = $this->modules[1];
		//////////////////////////////////////////////////////////////////

		$this->params = array();
		
		## for standard fields
		if(isset($_POST['is_installed'])) $this->params['is_installed'] = prepare_input($_POST['is_installed']);
		
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

		$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		//$this->uPrefix 		= 'prefix_';
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_MODULES;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=modules';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;

		$this->allowLanguages = false;
		$this->languageId  	= ''; //
		$this->WHERE_CLAUSE = ''; // WHERE .... / 'WHERE language_id = \''.$this->languageId.'\'';				
		$this->ORDER_CLAUSE = 'ORDER BY is_system DESC, priority_order DESC'; 
		
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

		$arr_installed = array('0'=>_NO, '1'=>_YES);
		$arr_system = array('0'=>_NO, '1'=>_YES);
		// prepare languages array		
		/// $total_languages = Languages::GetAllActive();
		/// $arr_languages      = array();
		/// foreach($total_languages[0] as $key => $val){
		/// 	$arr_languages[$val['abbreviation']] = $val['lang_name'];
		/// }

		//---------------------------------------------------------------------- 
		// VIEW MODE
		// format: strip_tags
		// format: nl2br
		// format: 'format'=>'date', 'format_parameter'=>'M d, Y, g:i A' + IF(date_created = '0000-00-00 00:00:00', '', date_created) as date_created,
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									CONCAT(UCASE(SUBSTRING(name, 1, 1)),LCASE(SUBSTRING(name, 2))) as mod_name,
									icon_file,
									name_const,
									description_const, 
									module_tables,
									dependent_modules,
									CASE
										WHEN is_installed = 1 THEN \'success_sign.gif\'
										ELSE \'error_sign.gif\'								
									END as mod_is_installed,
									CASE
										WHEN is_system = 1 THEN \'success_sign.gif\'
										ELSE \'error_sign.gif\'								
									END as mod_is_system
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'icon_file' 		=> array('title'=>_IMAGE, 'type'=>'image', 'align'=>'left', 'width'=>'60px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'image_width'=>'42px', 'image_height'=>'42px', 'target'=>'images/modules_icons/', 'no_image'=>'no_image.png'),
			'mod_name'      	=> array('title'=>_NAME, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>''),
			'mod_is_installed'  => array('title'=>_STATUS, 'type'=>'image', 'align'=>'center', 'width'=>'120px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'image_width'=>'16px', 'image_height'=>'16px', 'target'=>'images/', 'no_image'=>'error_sign.gif'),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password|date
		// 	 Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255... Ex.: 'validation_maxlength'=>'255'
		// - Validation Max Value: 12, 255... Ex.: 'validation_maximum'=>'99.99'
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(		    

		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// - Validation Type: alpha|numeric|float|alpha_numeric|text|email|ip_address|password|date
		//   Validation Sub-Type: positive (for numeric and float)
		//   Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		// - Validation Max Length: 12, 255... Ex.: 'validation_maxlength'=>'255'
		// - Validation Max Value: 12, 255... Ex.: 'validation_maximum'=>'99.99'
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								CONCAT(UCASE(REPLACE('.$this->tableName.'.name,"_"," "))) as mod_name,
								'.$this->tableName.'.name,								        
								'.$this->tableName.'.name_const,
								'.$this->tableName.'.description_const, 								
								'.$this->tableName.'.icon_file,
								'.$this->tableName.'.module_tables,
								'.$this->tableName.'.dependent_modules,
								'.$this->tableName.'.is_installed,
								'.$this->tableName.'.is_system,
								"1" as truncate_tables,
								IF('.TABLE_VOCABULARY.'.key_text IS NOT NULL, '.TABLE_VOCABULARY.'.key_text, "") as mod_description
							FROM '.$this->tableName.'
								LEFT OUTER JOIN '.TABLE_VOCABULARY.' ON ('.$this->tableName.'.description_const = '.TABLE_VOCABULARY.'.key_value AND '.TABLE_VOCABULARY.'.language_id = \''.Application::Get('lang').'\')
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(		
			'mod_name'          => array('title'=>_NAME, 'type'=>'label'),
			'mod_description'   => array('title'=>_DESCRIPTION, 'type'=>'label'),
			'icon_file'         => array('title'=>_ICON_IMAGE, 'type'=>'image', 'width'=>'', 'readonly'=>true, 'required'=>false, 'target'=>'images/modules_icons/', 'no_image'=>'', 'random_name'=>true, 'overwrite_image'=>false, 'unique'=>false, 'image_width'=>'96px', 'image_height'=>'96px', 'thumbnail_create'=>false, 'thumbnail_field'=>'', 'thumbnail_width'=>'', 'thumbnail_height'=>''),
			'is_system'         => array('title'=>_SYSTEM_MODULE, 'type'=>'enum', 'width'=>'', 'required'=>false, 'readonly'=>true, 'source'=>$arr_system, 'unique'=>false),
			'is_installed'      => array('title'=>_INSTALLED, 'type'=>'enum', 'width'=>'', 'required'=>true, 'readonly'=>false, 'source'=>$arr_installed, 'unique'=>false, 'javascript_event'=>'onchange="appToggleElementReadonly(this.value,0,\'truncate_tables\',false,true,false)"'),
			'truncate_tables'   => array('title'=>_TRUNCATE_RELATED_TABLES, 'type'=>'checkbox', 'readonly'=>false, 'true_value'=>'1', 'false_value'=>'0', 'unique'=>false),
		);
		
		if($action = MicroGrid::GetParameter('action') == 'edit'){
			echo '<script type="text/javascript">
				function __mgDoModeAlert(){
					if(jQuery(\'#is_installed\').val() == \'0\' && confirm(\''._MODULE_UNINSTALL_ALERT.'\')){
						// do nothing
						return true;
					}else if(jQuery(\'#is_installed\').val() == \'1\'){
						return true;
					}
					return false;
				}
				</script>';			
		}

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(

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
	 *	Initialize class
	 */
	public static function Init()
	{
		$sql = 'SELECT name, is_installed FROM '.TABLE_MODULES;		
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		for($i=0; $i < $result[1]; $i++){			
			self::$arr_modules[$result[0][$i]['name']] = ($result[0][$i]['is_installed'] == '1') ? true : false;
		}
	}	

	/**
	 *	Returns all modules array
	 *		@param $params - array of arguments
	 */
	public function GetAllModules($params = array())
	{		
		$sql = 'SELECT id, name, name_const, description_const, icon_file, module_tables, dependent_modules, is_installed, is_system, priority_order, settings_access_by
				FROM '.TABLE_MODULES.'
				ORDER BY priority_order ASC';		
		return database_query($sql, DATA_AND_ROWS, ALL_ROWS);
	}

	/**
	 *	Draws all modules
	 *		return: html output
	 */
	public function DrawModules()
	{
		global $objLogin;
		$margin = 'margin:-97px 0px 0px -44px;';
		$nl = "\n";
		
		if($this->modulesCount > 0){			
			$this->IncludeJSFunctions();
			echo '<form name="frmMicroGrid_'.$this->tableName.'" id="frmMicroGrid_'.$this->tableName.'" action="'.$this->formActionURL.'" method="post">'.$nl;
			draw_hidden_field($this->uPrefix.'mg_action', 'view'); echo $nl;
			draw_hidden_field('mg_rid', ''); echo $nl;
			draw_hidden_field('mg_sorting_fields', 'id'); echo $nl;
			draw_hidden_field('mg_sorting_types', ''); echo $nl;
			draw_hidden_field('mg_page', ''); echo $nl;
			draw_hidden_field('mg_operation', ''); echo $nl;
			draw_hidden_field('mg_operation_type', ''); echo $nl;
			draw_hidden_field('mg_operation_field', ''); echo $nl;
			draw_hidden_field('mg_search_status', ''); echo $nl;
			draw_hidden_field('mg_language_id', ''); echo $nl;
			draw_hidden_field('mg_operation_code', self::GetRandomString(20)); echo $nl;
			draw_token_field(); echo $nl;
			
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">';			
			echo '<tr><td>';
			
			$modules_output = '';
			for($i=0; $i < $this->modules[1]; $i++){
				if($this->modules[0][$i]['is_system'] == '1'){					
					if($objLogin->IsLoggedInAs($this->modules[0][$i]['settings_access_by'])){
						$modules_output .= '<div style="width:120px;float:'.Application::Get('defined_left').';text-align:center;margin:5px;">
							<div><b>'.decode_text(constant($this->modules[0][$i]['name_const'])).'</b></div>
							<div><img src="images/modules_icons/'.$this->modules[0][$i]['icon_file'].'" title="'.@decode_text(constant($this->modules[0][$i]['description_const'])).'" alt="" style="cursor:help;margin:2px;border:1px solid #dedede"></div>
							<div>'.(($this->modules[0][$i]['is_installed'] == 1) ? '<img src="images/success_sign.gif" style="position:absolute;'.$margin.'" alt="">' : '<img src="images/error_sign.gif" style="position:absolute;'.$margin.'" alt="">').'</div>
							<div><a href="javascript:void(0);" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'edit\', \''.$this->modules[0][$i]['id'].'\');">[ '._EDIT_WORD.' ]</a></div>
						</div>';
					}					
				}
			}
			
			if($modules_output != ''){
				echo draw_sub_title_bar(_SYSTEM_MODULES, false);
				echo $modules_output;
			}
			
			echo '</td></tr><tr><td>';
			
			$modules_output = '';
			for($i=0; $i < $this->modules[1]; $i++){
				if($this->modules[0][$i]['is_system'] == '0'){					
					if($objLogin->IsLoggedInAs($this->modules[0][$i]['settings_access_by'])){
						$modules_output .= '<div style="width:120px;float:'.Application::Get('defined_left').';text-align:center;margin:5px;">
							<div><b>'.decode_text(constant($this->modules[0][$i]['name_const'])).'</b></div>
							<div><img src="images/modules_icons/'.$this->modules[0][$i]['icon_file'].'" title="'.@decode_text(constant($this->modules[0][$i]['description_const'])).'" alt="" style="cursor:help;margin:2px;border:1px solid #dedede"></div>			
							<div>'.(($this->modules[0][$i]['is_installed'] == 1) ? '<img src="images/success_sign.gif" style="position:absolute;'.$margin.'" alt="">' : '<img src="images/error_sign.gif" style="position:absolute;'.$margin.'" alt="">').'</div>
							<div><a href="javascript:void(0);" onclick="javascript:__mgDoPostBack(\''.$this->tableName.'\', \'edit\', \''.$this->modules[0][$i]['id'].'\');">[ '._EDIT_WORD.' ]</a></div>
						</div>';
					}					
				}
			}

			if($modules_output != ''){
				echo draw_sub_title_bar(_ADDITIONAL_MODULES, false);
				echo $modules_output;
			}

			echo '</td></tr>';
			echo '</table>';
			echo '</form>'.$nl;
		}
	}

	/**
	 *	Installs a Module
	 *		return: boolean
	 */
	public function InstallModule()
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$mid = $this->module_name;

		$sql = 'SELECT name FROM '.TABLE_MODULES.' WHERE dependent_modules LIKE \'%'.$mid.'%\' AND is_installed = 0';
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$first_module = ucwords(str_replace('_', ' ', $mid));
			$second_module = ucwords(str_replace('_', ' ', $result[0]['name']));
			$this->error = str_replace(array('_FIRST_MODULE_', '_SECOND_MODULE_'), array($first_module, $second_module), _CANNOT_INSTALL_DEPENDENT_MODULE);
			return false;							
		}else{			
			$sql = 'UPDATE '.TABLE_MODULES.' SET is_installed = 1 WHERE name = \''.$mid.'\'';		
			if(database_void_query($sql)){
				$this->modules = $this->GetAllModules();
				$this->modulesCount = $this->modules[1];
				return true;
			}else{
				$this->error = _WRONG_PARAMETER_PASSED;
				return false;			
			}			
		}		
	}

	/**
	 *	Un-Installs Module
	 *		return: boolean
	 */
	public function UninstallModule()
	{
		// block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$mid = $this->module_name;
		$truncate_tables = isset($_POST['truncate_tables']) ? true : false;
		
		$sql = 'UPDATE '.TABLE_MODULES.' SET is_installed = 0 WHERE name = \''.$mid.'\' AND is_system = 0';
		if(database_void_query($sql, false, true))
		{
			$sql = 'SELECT name, name_const, description_const, module_tables, dependent_modules FROM '.TABLE_MODULES.' WHERE name = \''.$mid.'\'';
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] > 0){
				// clear module tables
				if($truncate_tables) $this->CleanModuleTables($result[0]['module_tables']);

				// check dependent modules
				if(isset($result[0]['dependent_modules'])){
					$modules_arr = explode(',', $result[0]['dependent_modules']);
					foreach($modules_arr as $module){
						if($module != '') $this->UninstallModule(array('mid'=>$module));
					}				
				}				
			}

			$this->modules = $this->GetAllModules();
			$this->modulesCount = $this->modules[1];
			
			return true;
		}else{
			echo $sql;			
			$this->error = _WRONG_PARAMETER_PASSED;
			return false;			
		}		
	}

	/**
	 *	Checks if a module is installed
	 *		@param $module_name
	 *		return: boolean
	 */
	public static function IsModuleInstalled($module_name)
	{		
		if(isset(self::$arr_modules[$module_name]) && self::$arr_modules[$module_name] == true){
			return true;
		}else{
			return false;			
		}
	}
	
	/**
	 *	Clean module tables
	 *		@param $module_name
	 */
	private function CleanModuleTables($module_tables = '')
	{
		$module_tables_arr = explode(',', $module_tables);
		foreach($module_tables_arr as $table){
			if($table != ''){
				$sql = 'TRUNCATE '.constant('TABLE_'.strtoupper(trim($table)));
				database_void_query($sql);				
			}
		}
	}

	/**
	 * Before-Updating function
	 */
	public function BeforeUpdateRecord()
	{	
		$sql = 'SELECT name, is_installed, is_system FROM '.$this->tableName.' WHERE '.$this->primaryKey.' = '.$this->curRecordId;
		$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
        if(isset($result['is_installed'])){
			$this->is_installed = $result['is_installed'];
			$this->module_name = $result['name'];			
			if($result['is_system'] == '1'){
				$this->error = _SYSTEM_MODULE_ACTIONS_BLOCKED;
				return false;
			}
		}		
		return true;
	}
	
	/**
	 * After-Updating function
	 */
	public function AfterUpdateRecord()
	{
		$is_installed = self::GetParameter('is_installed', false);
		if($this->is_installed == '0' && $is_installed == '1'){
			if($this->InstallModule()){
				$this->error = _MODULE_INSTALLED;
			}
		}else if($this->is_installed == '1' && $is_installed == '0'){
			if($this->UninstallModule()){
				$this->error = _MODULE_UNINSTALLED;
			}		
		}
		return true;
	}

}
?>