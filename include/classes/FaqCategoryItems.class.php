<?php

/**
 *	FAQ Category Items Class
 *  --------------
 *	Description : encapsulates methods and properties for FAQ Categories
 *	Written by  : ApPHP
 *	Version     : 1.0.1
 *  Updated	    : 08.06.2012
 *  Usage       : Core Class (ALL)
 *  Differences : no
 *
 *	PUBLIC				  	STATIC				 	PRIVATE
 * 	------------------	  	---------------     	---------------
 *	__construct
 *	__destruct
 *	
 *  1.0.1
 *      - changed SQL IF with 'enum' type
 *      - added maxlength for textareas
 *      -
 *      -
 *      -
 *	
 **/


class FaqCategoryItems extends MicroGrid {
	
	protected $debug = false;
	
	// #001 private $arrTranslations = '';		
	
	//==========================================================================
    // Class Constructor
	// 		@param $fcid
	//==========================================================================
	function __construct($fcid = 0)
	{		
		parent::__construct();

		$this->params = array();
		
		## for standard fields
		if(isset($_POST['faq_question']))   $this->params['faq_question'] = prepare_input($_POST['faq_question']);
		if(isset($_POST['faq_answer']))     $this->params['faq_answer'] = prepare_input($_POST['faq_answer']);
		if(isset($_POST['priority_order'])) $this->params['priority_order'] = prepare_input($_POST['priority_order']);
		if(isset($_POST['category_id']))    $this->params['category_id'] = prepare_input($_POST['category_id']);
		if(isset($_POST['is_active']))      $this->params['is_active'] = prepare_input($_POST['is_active']);
		
		///$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		//$this->uPrefix 		= 'prefix_';
		
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_FAQ_CATEGORY_ITEMS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=mod_faq_questions_management&fcid='.(int)$fcid;
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = false;
		$this->alertOnDelete = ''; // leave empty to use default alerts

		$this->allowLanguages = false;
		$this->languageId  	= ''; // ($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();
		$this->WHERE_CLAUSE = 'WHERE category_id = '.(int)$fcid;				
		$this->ORDER_CLAUSE = 'ORDER BY priority_order ASC, faq_answer ASC';
		
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

		///$date_format = get_date_format('view');
		///$date_format_edit = get_date_format('edit');				
		///$currency_format = get_currency_format();
		
		$arr_activity_types = array('0'=>_NO, '1'=>_YES);
		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');

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
									faq_question,
									faq_answer,
									priority_order,
									is_active
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'faq_question'   => array('title'=>_QUESTION, 'type'=>'label', 'align'=>'left', 'width'=>'', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'80', 'format'=>'', 'format_parameter'=>''),
			'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
			'priority_order' => array('title'=>_ORDER, 'type'=>'label', 'align'=>'center', 'width'=>'90px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>'', 'tooltip'=>'', 'maxlength'=>'', 'format'=>'', 'format_parameter'=>'', 'movable'=>true),
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
			'faq_question'   => array('title'=>_QUESTION,  'type'=>'textarea', 'width'=>'410px', 'required'=>true, 'height'=>'70px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'maxlength'=>'512', 'validation_maxlength'=>'512', 'validation_type'=>'', 'unique'=>true),
			'faq_answer'     => array('title'=>_ANSWER, 'type'=>'textarea', 'width'=>'410px', 'required'=>true, 'height'=>'140px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'maxlength'=>'2048', 'validation_maxlength'=>'2048', 'validation_type'=>'', 'unique'=>false),
			'priority_order' => array('title'=>_ORDER,  'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'4', 'default'=>'0', 'validation_type'=>'numeric'),			
            'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'required'=>true, 'width'=>'90px', 'readonly'=>false, 'default'=>'1', 'source'=>$arr_activity_types, 'unique'=>false, 'javascript_event'=>''),		
			'category_id'    => array('title'=>'',      'type'=>'hidden', 'required'=>true, 'readonly'=>false, 'default'=>$fcid),
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
								'.$this->primaryKey.',
								category_id,
								faq_question,
								faq_answer,
								priority_order,
								is_active								
							FROM '.$this->tableName.'
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
			'faq_question'   => array('title'=>_QUESTION, 'type'=>'textarea', 'width'=>'410px', 'required'=>true, 'height'=>'70px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'maxlength'=>'512', 'validation_maxlength'=>'512', 'validation_type'=>'', 'unique'=>true),
			'faq_answer'     => array('title'=>_ANSWER, 'type'=>'textarea', 'width'=>'410px', 'required'=>true, 'height'=>'140px', 'editor_type'=>'simple', 'readonly'=>false, 'default'=>'', 'maxlength'=>'2048', 'validation_maxlength'=>'2048', 'validation_type'=>'', 'unique'=>false),
			'priority_order' => array('title'=>_ORDER, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'4', 'default'=>'0', 'validation_type'=>'numeric'),			
            'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'required'=>true, 'width'=>'90px', 'readonly'=>false, 'default'=>'1', 'source'=>$arr_activity_types, 'unique'=>false, 'javascript_event'=>''),		
			//'category_id'    => array('title'=>'', 'type'=>'hidden', 'required'=>true, 'readonly'=>false, 'default'=>$fcid),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'faq_question'   => array('title'=>_QUESTION, 'type'=>'label'),
			'faq_answer'     => array('title'=>_ANSWER, 'type'=>'label'),
			'priority_order' => array('title'=>_ORDER, 'type'=>'label'),
            'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
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
	
}
?>