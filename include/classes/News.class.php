<?php

/**
 *	Class News
 *  -------------- 
 *  Description : encapsulates mews operations & properties
 *	Written by  : ApPHP
 *	Version     : 1.0.7
 *  Updated	    : 01.11.2012
 *  Usage       : Core Class (excepting MicroBlog)
 *	Differences : no
 *	
 *	PUBLIC:				  	STATIC:				 	PRIVATE:
 * 	------------------	  	---------------     	---------------
 *	__construct             GetNewsId
 *	__destruct              GetNewsInfo
 *	SetSQLs                 CacheAllowed
 *	DrawNewsBlock           GetAllNews
 *	ProcessSubscription
 *	ProcessUnsubscription
 *	DrawSubscribeBlockMain
 *	DrawSubscribeBlock
 *	GetNews	
 *	DrawRegistrationForm
 *	AfterInsertRecord
 *	AfterDetailsMode
 *	
 *  1.0.7
 *      - added sqlFieldDatetimeFormat for langs
 *      - removed align="left" from news event subscription
 *      -
 *      -
 *      -
 *  1.0.6
 *      - aded sending subscription email in a preferred language
 *      - added placeholder for email address field
 *      - fixed bug on wrong lang in email for subscription/unsubscription
 *      - <font> replaced with <span>
 *      - added maxlength for textareas
 *  1.0.5
 *      - GetAllNews changed to static
 *      - added sending email on subscription
 *      - added time delay on repeated subscription
 *      - added maxlength for email fields
 *      - fixed issue with news text in details mode
 *  1.0.4
 *  	- added maxlength for header and text
 *  	- cloning operations encapsulated in AfterInsertRecord()
 *  	- added AfterDeleteRecord()
 *  	- added GetNewsInfo()
 *  	- added $draw parameter for Draw functions
 *  1.0.3
 *  	- CacheAllowed() re-defined as static
 *  	- get_date_format() -> get_datetime_format()
 *  	- changes str_replace with str_ireplace
 *  	- get_random_string(10)
 *  	- changed using of session with Application::Get('lang')
 *  1.0.2
 *  	- removed 0000-00-00 preparing for date fields
 *  	- added GetNewsId()
 *  	- added new field for news table - news_code
 *  	- fixed bug with double registering the same users
 *  	- added token key for submission form
 *	
 **/

class News extends MicroGrid {
	
	protected $debug = false;

	//--------------------------------- 
	private $sqlFieldDatetimeFormat = '';

	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{
		parent::__construct();

		global $objSettings;
		
		$this->params = array();
		if(isset($_POST['news_code']))     $this->params['news_code']    = prepare_input($_POST['news_code']);
		if(isset($_POST['header_text']))   $this->params['header_text']  = prepare_input($_POST['header_text']);
		if(isset($_POST['body_text'])) 	   $this->params['body_text']    = prepare_input($_POST['body_text'], false, 'medium');
		if(isset($_POST['type']))   	   $this->params['type']         = prepare_input($_POST['type']);
		if(isset($_POST['date_created']))  $this->params['date_created'] = prepare_input($_POST['date_created']);
		$this->params['language_id'] 	   = MicroGrid::GetParameter('language_id');
	
		$this->isHtmlEncoding = true;
	
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_NEWS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->languageId  	= ($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();
		$this->formActionURL = 'index.php?admin=mod_news_management';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;		

		$this->allowLanguages = true;
		$this->WHERE_CLAUSE = 'WHERE language_id = \''.$this->languageId.'\'';		
		$this->ORDER_CLAUSE = 'ORDER BY date_created DESC';

		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;

		$this->isSortingAllowed = true;


		// prepare languages array		
		$total_languages = Languages::GetAllActive();
		$arr_languages      = array();
		foreach($total_languages[0] as $key => $val){
			$arr_languages[$val['abbreviation']] = $val['lang_name'];
		}
		
		$arr_types = array('news'=>_NEWS, 'events'=>_EVENTS);
		$datetime_format = get_datetime_format();

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
		$this->VIEW_MODE_SQL = 'SELECT '.$this->primaryKey.',
									type,
									header_text,
									body_text,
									DATE_FORMAT('.$this->tableName.'.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as mod_date_created,
									CASE
										WHEN type = "events" THEN
											CONCAT("<a href=javascript:void(0) onclick=javascript:__mgDoPostBack(\''.$this->tableName.'\',\'details\',\'", '.$this->primaryKey.', "\')>events",
											       " (", (SELECT COUNT(*) as cnt FROM '.TABLE_EVENTS_REGISTERED.' er WHERE er.event_id = '.$this->tableName.'.'.$this->primaryKey.'), ")</a>")
										ELSE type										
									END as type_link
								FROM '.$this->tableName;		
		// define view mode fields
		$this->arrViewModeFields = array(
			'mod_date_created' => array('title'=>_DATE_CREATED, 'type'=>'label', 'align'=>'left', 'width'=>'190px', 'format'=>'date', 'format_parameter'=>$datetime_format),
			'header_text'  => array('title'=>_HEADER,       'type'=>'label', 'align'=>'left', 'width'=>'', 'nowrap'=>'wrap', 'maxlength'=>'90'),
			'type_link'    => array('title'=>_TYPE,         'type'=>'label', 'align'=>'center', 'width'=>'9%'),
		);
		
		//---------------------------------------------------------------------- 
		// ADD MODE
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
			'header_text'  => array('title'=>_HEADER, 	    'type'=>'textbox', 'required'=>true, 'width'=>'410px', 'maxlength'=>'255'),
			'body_text'    => array('title'=>_TEXT,   	    'type'=>'textarea', 'width'=>'490px', 'height'=>'200px', 'editor_type'=>'wysiwyg', 'readonly'=>false, 'default'=>'', 'required'=>true, 'validation_type'=>'', 'unique'=>false, 'maxlength'=>'4096', 'validation_maxlength'=>'4096'),
			'type'  	   => array('title'=>_TYPE,         'type'=>'enum', 'source'=>$arr_types, 'required'=>true, 'default'=>'news'),
			'date_created' => array('title'=>_DATE_CREATED, 'type'=>'datetime', 'required'=>true, 'readonly'=>false, 'default'=>@date('Y-m-d H:i:s'), 'validation_type'=>'', 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$datetime_format, 'min_year'=>'10', 'max_year'=>'5'),
			'language_id'  => array('title'=>_LANGUAGE,     'type'=>'enum', 'source'=>$arr_languages, 'required'=>true),
			'news_code'    => array('title'=>'',            'type'=>'hidden',  'required'=>true, 'readonly'=>false, 'default'=>get_random_string(10)),
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.type,
								'.$this->tableName.'.header_text,
								'.$this->tableName.'.body_text,
								'.$this->tableName.'.language_id,
								'.$this->tableName.'.date_created,
								DATE_FORMAT('.$this->tableName.'.date_created, \''.$this->sqlFieldDatetimeFormat.'\') as mod_date_created,
								'.TABLE_LANGUAGES.'.lang_name as language_name 
							FROM '.$this->tableName.'
								INNER JOIN '.TABLE_LANGUAGES.' ON '.$this->tableName.'.language_id = '.TABLE_LANGUAGES.'.abbreviation
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
			'header_text'  => array('title'=>_HEADER, 	   'type'=>'textbox', 'required'=>true, 'width'=>'410px', 'maxlength'=>'255'),
			'body_text'    => array('title'=>_TEXT,   	   'type'=>'textarea', 'width'=>'490px', 'height'=>'200px', 'editor_type'=>'wysiwyg', 'readonly'=>false, 'default'=>'', 'required'=>true, 'validation_type'=>'', 'unique'=>false, 'maxlength'=>'4096', 'validation_maxlength'=>'4096'),
			'type'  	   => array('title'=>_TYPE,        'type'=>'enum', 'source'=>$arr_types, 'required'=>true),
			'date_created' => array('title'=>_DATE_CREATED,'type'=>'datetime', 'required'=>true, 'readonly'=>false, 'unique'=>false, 'visible'=>true, 'format'=>'date', 'format_parameter'=>$datetime_format, 'min_year'=>'10', 'max_year'=>'5'),
			'language_id'  => array('title'=>_LANGUAGE,    'type'=>'enum', 'source'=>$arr_languages, 'required'=>true, 'readonly'=>true),
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'header_text'   => array('title'=>_HEADER,   'type'=>'label'),
			'body_text'     => array('title'=>_TEXT,     'type'=>'html'),
			'type'          => array('title'=>_TYPE,     'type'=>'label'),
			'mod_date_created'  => array('title'=>_DATE_CREATED, 'type'=>'label'),
			'language_name' => array('title'=>_LANGUAGE, 'type'=>'label'),
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
	 * After-operation Details mode
	 */
	function AfterDetailsMode()
	{
		$sql = 'SELECT
					er.first_name,
					er.last_name,
					er.email,
					er.phone,
					er.date_registered
				FROM '.TABLE_EVENTS_REGISTERED.' er
					INNER JOIN '.$this->tableName.' e ON er.event_id = e.'.$this->primaryKey.'
				WHERE
					e.type = "events" AND 
					er.event_id = '.(int)$this->curRecordId;
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		
		if($result[1] > 0){
			echo '<table class="mgrid_table" border="0" cellspacing="0" cellpadding="2">';
			echo '<tr>';
			echo '<th align="left"><label></label></th>';
			echo '<th align="left"><label>'._FIRST_NAME.'</label></th>';
			echo '<th align="left"><label>'._LAST_NAME.'</label></th>';
			echo '<th align="left"><label>'._EMAIL_ADDRESS.'</label></th>';
			echo '<th align="left"><label>'._PHONE.'</label></th>';
			echo '<th align="left"><label>'._REGISTERED.'</label></th>';
			echo '</tr>';
			echo '<tr><td colspan="6" height="3px" nowrap="nowrap"><div class="no_margin_line"><img src="images/line_spacer.gif" width="100%" height="1px" alt="" /></div></td></tr>';
	
			for($i=0; $i<$result[1]; $i++){
				echo '<tr>';
				echo '<td>'.($i+1).'.</td>';
				echo '<td>'.$result[0][$i]['first_name'].'</td>';
				echo '<td>'.$result[0][$i]['last_name'].'</td>';
				echo '<td>'.$result[0][$i]['email'].'</td>';
				echo '<td>'.$result[0][$i]['phone'].'</td>';
				echo '<td>'.format_datetime($result[0][$i]['date_registered']).'</td>';	
				echo '</tr>';
			}
			echo '</tr>';
			echo '</table>';			
		}		
	}

	/**
	 * After-deleting record
	 */
	public function AfterDeleteRecord()
	{
		$sql = 'DELETE FROM '.TABLE_EVENTS_REGISTERED.' WHERE event_id = '.(int)$this->curRecordId;
		database_void_query($sql);		
	}
	
	/**
	 *	Sets system SQLs
	 *		@param $key
	 *		@param $msg
	 */	
	public function SetSQLs($key, $msg)
	{
		if($this->debug) $this->arrSQLs[$key] = $msg;					
	}
	
	/**
	 *	Draws news block
	 *		@param $draw
	 */	
	public function DrawNewsBlock($draw = true)
	{	
	    $text_align_left = (Application::Get('lang_dir') == 'ltr') ? 'text-align:left;' : 'text-align:right;padding-right:15px;';
		$text_align_right = (Application::Get('lang_dir') == 'ltr') ? 'text-align:right;padding-right:15px;' : 'text-align:left;';

		$news_header_length = ModulesSettings::Get('news', 'news_header_length');
		$news_count = ModulesSettings::Get('news', 'news_count');

		$this->WHERE_CLAUSE = 'WHERE date_created < \''.@date('Y-m-d H:i:s').'\' AND language_id = \''.Application::Get('lang').'\'';		
		$all_news = $this->GetAll($this->ORDER_CLAUSE);
		$output = draw_block_top(_NEWS_AND_EVENTS, '', 'maximized', false);
		$output .= '<ul class="news-block">';		
		for($news_ind = 0; $news_ind < $all_news[1]; $news_ind++)
		{
			if($news_ind+1 > $news_count) break; // Show first X news
			$news_str = $all_news[0][$news_ind]['header_text']; // Display Y first chars
			$news_str = (strlen($news_str) > $news_header_length) ? substr($all_news[0][$news_ind]['header_text'],0,$news_header_length).'...' : $news_str;
			$output .= '<li>'.$news_str.'<br />';
			$output .= prepare_link('news', 'nid', $all_news[0][$news_ind]['id'], $news_str, '<i>'._READ_MORE.' &raquo;</i>', 'category-news');
			$output .= '</li>';
		}
		if($news_ind == 0){
			$output .= '<li>'._NO_NEWS.'</li>';
		}
		$output .= '</ul>';
		$output .= draw_block_bottom(false);
		
		if($draw) echo $output;
		else return $output;
	}	

	/**
	 *	Process subscription
	 *		@param $email
	 */	
	public function ProcessSubscription($email)
	{
		global $objSettings, $objLogin;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}						

		$newsletter_subscription = (bool)Session::Get('newsletter_subscription');
		$newsletter_subscription_time = Session::Get('newsletter_subscription_time');
		$delay_length = 20;

		if($email == ''){
			$this->error = _EMAIL_EMPTY_ALERT;
			return false;
		}else if($email != '' && !check_email_address($email)){
			$this->error = _EMAIL_VALID_ALERT;
			return false;
		}else{			
			$time_elapsed = (time_diff(date('Y-m-d H:i:s'), $newsletter_subscription_time));
			if($newsletter_subscription && $time_elapsed < $delay_length){
				$this->error = str_replace('_WAIT_', $delay_length - $time_elapsed, _SUBSCRIPTION_ALREADY_SENT);
				return false;
			}else{				
				// check if email already exists                    
				$sql = 'SELECT * FROM '.TABLE_NEWS_SUBSCRIBED.' WHERE email = \''.encode_text($email).'\'';
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){
					$this->error = _SUBSCRIBE_EMAIL_EXISTS_ALERT;
					return false;
				}else{
					$sql = 'INSERT INTO '.TABLE_NEWS_SUBSCRIBED.' (id, email, date_subscribed)
							VALUES (NULL, \''.encode_text($email).'\', \''.@date('Y-m-d H:i:s').'\')';
					if(database_void_query($sql)){
						////////////////////////////////////////////////////////////
						send_email(
							$email,
							$objSettings->GetParameter('admin_email'),
							'subscription_to_newsletter',
							array(
								'{WEB SITE}'   => $_SERVER['SERVER_NAME'],
								'{BASE URL}'   => APPHP_BASE,
								'{USER EMAIL}' => $email,
								'{YEAR}' 	   => date('Y')								
							),
							(($objLogin->IsLoggedIn()) ? $objLogin->GetPreferredLang() : '')
						);
						////////////////////////////////////////////////////////////
						Session::Set('newsletter_subscription', true);
						Session::Set('newsletter_subscription_time', date('Y-m-d H:i:s'));
					}else{					
						$this->error = _TRY_LATER;
					}
				}	
			}			
		}
		return true;		
	}
	
	/**
	 *	Process unsubscription
	 *		@param $email
	 */	
	public function ProcessUnsubscription($email)
	{
		global $objSettings, $objLogin;
		
		// deny all operations in demo version
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}						

		if($email == ''){
			$this->error = _EMAIL_EMPTY_ALERT;
			return false;
		}else if($email != '' && !check_email_address($email)){
			$this->error = _EMAIL_VALID_ALERT;
			return false;
		}else{
			// check if email already exists                    
			$sql = 'SELECT * FROM '.TABLE_NEWS_SUBSCRIBED.' WHERE email = \''.encode_text($email).'\'';
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] <= 0){
				$this->error = _EMAIL_NOT_EXISTS;
				return false;
			}else{
				$sql = 'DELETE FROM '.TABLE_NEWS_SUBSCRIBED.' WHERE email = \''.encode_text($email).'\'';
				if(database_void_query($sql)){
 					////////////////////////////////////////////////////////////
					send_email(
						$email,
						$objSettings->GetParameter('admin_email'),
						'unsubscription_from_newsletter',
						array(
							'{WEB SITE}' => $_SERVER['SERVER_NAME'],
							'{BASE URL}' => APPHP_BASE,
						    '{USER EMAIL}' => $email,
							'{YEAR}' 	 => date('Y')
						),
						(($objLogin->IsLoggedIn()) ? $objLogin->GetPreferredLang() : '')
					);
					////////////////////////////////////////////////////////////
				}else{					
					$this->error = _TRY_LATER;
				}
			}	
		}
		return true;		
	}

	/**
	 *	Draws newsletter main subscribe block
	 *	    @param $focus_field
	 *	    @param $email
	 *		@param $draw
	 */	
	public function DrawSubscribeBlockMain($focus_field, $email = '', $draw = true)
	{
		$output  = '<form name="frmNewsletterSubscribeMain" class="newsletter_subscribe" action="index.php?page=newsletter" method="post">';
		$output .= draw_hidden_field('task', 'subscribe', false);
		$output .= draw_token_field(false);
		$output .= '<fieldset>';
		$output .= '<legend><b>'._SUBSCRIBE.'</b></legend>';
		$output .= _NEWSLETTER_SUBSCRIBE_TEXT.'<br />';
		$output .= _EMAIL_ADDRESS.':&nbsp;<input type="text" name="email" id="subscribe_email" value="'.(($focus_field == 'subscribe_email') ? $email : '').'" maxlength="70" autocomplete="off" /><br />';
		$output .= '<input class="form_button" type="submit" name="submit" value="'._SUBSCRIBE.'" />';
		$output .= '</fieldset>';
		$output .= '</form>';
		$output .= '<br/>';

		$output .= '<form name="frmNewsletterUnsubscribeMain" class="newsletter_subscribe" action="index.php?page=newsletter" method="post">';
		$output .= draw_hidden_field('task', 'unsubscribe', false);
		$output .= draw_token_field(false);
		$output .= '<fieldset>';
		$output .= '<legend><b>'._UNSUBSCRIBE.'</b></legend>';
		$output .= _NEWSLETTER_UNSUBSCRIBE_TEXT.'<br />';
		$output .= _EMAIL_ADDRESS.':&nbsp;<input type="text" name="email" id="unsubscribe_email" value="'.(($focus_field == 'unsubscribe_email') ? $email : '').'" maxlength="70" autocomplete="off" /><br />';
		$output .= '<input class="form_button" type="submit" name="submit" value="'._UNSUBSCRIBE.'" />';
		$output .= '</fieldset>';
		$output .= '</form>';
		$output .= '<script type="text/javascript">appSetFocus(\''.$focus_field.'\');</script>';
			
		if($draw) echo $output;
		else return $output;
	}

	/**
	 *	Draws newsletter side subscribe block 
	 *		@param $draw
	 */	
	public function DrawSubscribeBlock($draw = true)
	{
		$output = draw_block_top(_SUBSCRIBE_TO_NEWSLETTER, '', 'maximized', false);
		$output .= '<form name="frmNewsletterSubscribeBlock" class="newsletter_subscribe" action="index.php?page=newsletter" method="post">';
		$output .= draw_hidden_field('task', 'subscribe', false);
		$output .= draw_token_field(false);
		$output .= '<input type="text" name="email" value="" maxlength="70" autocomplete="off" placeholder="'._EMAIL_ADDRESS.'" />';
		$output .= '<input class="form_button" type="submit" name="submit" value="'._SUBSCRIBE.'" />';		
		$output .= '</form>';
		$output .= draw_block_bottom(false);
			
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 *	Returns certain news
	 *		@param $news_id
	 */
	public function GetNews($news_id = '0')
	{
		$sql = $this->VIEW_MODE_SQL.' WHERE '.$this->primaryKey.' = '.(int)$news_id.' '.$this->ORDER_CLAUSE;
		$news = $this->GetRecord($sql);
		return $news;		
	}
	
	/**
	 *	Returns all news
	 *		@param $type
	 *		@param $lang
	 */
	public static function GetAllNews($type = '', $lang = 'en')
	{
		$type_where_clause = ($type == 'previous') ? ' AND date_created <= \''.@date('Y-m-d H:i:s').'\'' : '';
		$sql = 'SELECT * FROM '.TABLE_NEWS.'
				WHERE language_id = \''.$lang.'\' '.$type_where_clause.'
				ORDER BY date_created DESC';
		return database_query($sql, DATA_AND_ROWS);	
	}

	/**
	 *	Draws registration form
	 *		@param $news_id
	 *		@param $event_title
	 *		@param $draw
	 */
	public function DrawRegistrationForm($news_id = '0', $event_title = '', $draw = true)
	{
		if(!$news_id) return '';
		
		global $objSettings, $objLogin;
		
		$lang = Application::Get('lang');		
		$focus_element = 'first_name';

		// post fields
		$task             = isset($_POST['task']) ? prepare_input($_POST['task']) : '';
		$event_id		  = isset($_POST['event_id']) ? (int)$_POST['event_id'] : '0';
		$first_name       = isset($_POST['first_name']) ? prepare_input($_POST['first_name']) : '';
		$last_name        = isset($_POST['last_name']) ? prepare_input($_POST['last_name']) : '';
		$email            = isset($_POST['email']) ? prepare_input($_POST['email']) : '';
		$phone            = isset($_POST['phone']) ? prepare_input($_POST['phone']) : '';
		$message          = isset($_POST['message']) ? substr(prepare_input($_POST['message']), 0, 2048) : '';
		$captcha_code 	  = isset($_POST['captcha_code']) ? prepare_input($_POST['captcha_code']) : '';
		$admin_email	  = $objSettings->GetParameter('admin_email');
		$msg              = '';

		if($task == 'register_to_event')
		{
			include_once('modules/captcha/securimage.php');
			$objImg = new Securimage();			
		
			if($first_name == ''){
				$msg = draw_important_message(_FIRST_NAME_EMPTY_ALERT, false);
				$focus_element = 'first_name';
			}else if($last_name == ''){
				$msg = draw_important_message(_LAST_NAME_EMPTY_ALERT, false);
				$focus_element = 'last_name';
			}else if($email == ''){
				$msg = draw_important_message(_EMAIL_EMPTY_ALERT, false);
				$focus_element = 'email';
			}else if(($email != '') && (!check_email_address($email))){
				$msg = draw_important_message(_EMAIL_VALID_ALERT, false);
				$focus_element = 'email';
			}else if($phone == ''){        
				$msg = draw_important_message(str_replace('_FIELD_', _PHONE, _FIELD_CANNOT_BE_EMPTY), false);
				$focus_element = 'phone';
			}else if(!$objImg->check($captcha_code)){
				$msg = draw_important_message(_WRONG_CODE_ALERT, false);
				$focus_element = 'captcha_code';
			}else{
				$sql = 'SELECT * FROM '.TABLE_EVENTS_REGISTERED.' WHERE event_id = \''.(int)$event_id.'\' AND email = \''.$email.'\'';
				if(database_query($sql, ROWS_ONLY, FIRST_ROW_ONLY) > 0){
					$msg = draw_important_message(_EVENT_USER_ALREADY_REGISTERED, false);
				}				
			}
			
			// deny all operations in demo version
			if(strtolower(SITE_MODE) == 'demo'){
				$msg = draw_important_message(_OPERATION_BLOCKED, false);
			}						

			if($msg == ''){
				if($objLogin->IpAddressBlocked(get_current_ip())){
					$msg = draw_important_message(_IP_ADDRESS_BLOCKED, false);
				}else if($objLogin->EmailBlocked($email)){
					$msg = draw_important_message(_EMAIL_BLOCKED, false);
				}else{
					$sql = 'INSERT INTO '.TABLE_EVENTS_REGISTERED.' (id, event_id, first_name, last_name, email, phone, message, date_registered)
							VALUES (NULL, '.(int)$event_id.', \''.encode_text($first_name).'\', \''.encode_text($last_name).'\', \''.encode_text($email).'\', \''.encode_text($phone).'\', \''.encode_text($message).'\', \''.@date('Y-m-d H:i:s').'\')';
					if(database_void_query($sql)){
						$msg = draw_success_message(_EVENT_REGISTRATION_COMPLETED, false);
	
						////////////////////////////////////////////////////////////
						send_email(
							$email,
							$admin_email,
							'events_new_registration',
							array(
								'{FIRST NAME}' => $first_name,
								'{LAST NAME}'  => $last_name,
								'{EVENT}'      => '<b>'.$event_title.'</b>'
							),
							'',
							$admin_email,
							'Events - new user was registered (admin copy)'
						);
						////////////////////////////////////////////////////////////		
	
						$first_name = $last_name = $email = $phone = $message = '';
					}else{
						///echo mysql_error();
						$msg = draw_important_message(_TRY_LATER, false);
					}					
				}
			}
		}

		$output = '
		'.(($msg != '') ? $msg : '').'<br />
		<fieldset style="border:1px solid #cccccc;padding-left:10px;margin:0px 12px 12px 12px;">
		<legend><b>'._REGISTRATION_FORM.'</b></legend>
		<form method="post" name="frmEventRegistration" id="frmEventRegistration">
			'.draw_hidden_field('task', 'register_to_event', false).'
			'.draw_hidden_field('event_id', $news_id, false).'
			'.draw_token_field(false);
		
		$output .= '
			<table cellspacing="1" cellpadding="2" border="0" width="100%">
			<tbody>
			<tr>
				<td width="25%" align="'.Application::Get('defined_right').'">'._FIRST_NAME.':</td>
				<td><span class="mandatory_star">*</span></td>
				<td nowrap="nowrap" align="'.Application::Get('defined_left').'"><input type="text" id="first_name" name="first_name" size="34" maxlength="32" value="'.decode_text($first_name).'" autocomplete="off" /></td>
			</tr>
			<tr>
				<td align="'.Application::Get('defined_right').'">'._LAST_NAME.':</td>
				<td><span class="mandatory_star">*</span></td>
				<td nowrap="nowrap" align="'.Application::Get('defined_left').'"><input type="text" id="last_name" name="last_name" size="34" maxlength="32" value="'.decode_text($last_name).'" autocomplete="off" /></td>
			</tr>
			<tr>
				<td align="'.Application::Get('defined_right').'">'._EMAIL_ADDRESS.':</td>
				<td><span class="mandatory_star">*</span></td>
				<td nowrap="nowrap" align="'.Application::Get('defined_left').'"><input type="text" id="email" name="email" size="34" maxlength="70" value="'.decode_text($email).'" autocomplete="off" /></td>
			</tr>
			<tr>
				<td align="'.Application::Get('defined_right').'">'._PHONE.':</td>
				<td><span class="mandatory_star">*</span></td>
				<td nowrap="nowrap" align="'.Application::Get('defined_left').'"><input type="text" id="phone" name="phone" size="22" maxlength="32" value="'.decode_text($phone).'" autocomplete="off" /></td>
			</tr>
		    <tr valign="top">
                <td align="'.Application::Get('defined_right').'">'._MESSAGE.':</td>
                <td></td>
                <td nowrap="nowrap" align="'.Application::Get('defined_left').'">
                    <textarea id="message" name="message" style="width:390px;" rows="4" maxlength="2048">'.$message.'</textarea>                
                </td>
		    </tr>
			<tr>
				<td colspan="2"></td>
				<td colspan="2">';				
					
					$output .= '<table border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td>
							<img id="captcha_image" src="modules/captcha/securimage_show.php?sid='.md5(uniqid(time())).'" />
						</td>	
						<td>
							<img style="cursor:pointer; padding:0px; margin:0px;" id="captcha_image_reload" src="modules/captcha/images/refresh.gif" style="cursor:pointer;" onclick="document.getElementById(\'captcha_image\').src = \'modules/captcha/securimage_show.php?sid=\' + Math.random(); appSetFocus(\'captcha_code\'); return false" title="'._REFRESH.'" alt="'._REFRESH.'" /><br />
							<a href="modules/captcha/securimage_play.php"><img border="0" style="padding:0px; margin:0px;" id="captcha_image_play" src="modules/captcha/images/audio_icon.gif" title="'._PLAY.'" alt="'._PLAY.'" /></a>						
						</td>					
						<td>
							'._TYPE_CHARS.'<br />								
							<input type="text" name="captcha_code" id="captcha_code" style="width:175px;margin-top:5px;" value="" maxlength="20" autocomplete="off" />
						</td>
					</tr>
					</table>';

				$output .= '</td>
			</tr>
			<tr><td height="20" colspan="3">&nbsp;</td></tr>            
			<tr>
				<td colspan="3" align="center">
				<input type="submit" class="form_button" name="btnSubmitPD" id="btnSubmitPD" value=" '._SEND.' ">
				</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>		    		    
			</table>
			</form>
			
		</form>
		</fieldset>';
		
		if($focus_element != '') $output .= '<script type="text/javascript">appSetFocus(\''.$focus_element.'\');</script>';
	
		if($draw) echo $output;		
		else return $output;
	}

	/**
	 * After-insertion operation
	 */
	public function AfterInsertRecord()
	{	    
		// --- clone to other languages
		$total_languages = Languages::GetAllActive();
		$language_id 	= self::GetParameter('language_id', false);
		$news_code 	    = self::GetParameter('news_code', false);
		$header_text 	= self::GetParameter('header_text', false);
		$body_text 		= self::GetParameter('body_text', false);
		$date_created 	= self::GetParameter('date_created', false);
		
		for($i = 0; $i < $total_languages[1]; $i++){
			if($language_id != '' && $total_languages[0][$i]['abbreviation'] != $language_id){
				$sql = 'INSERT INTO '.TABLE_NEWS.' (id, news_code, header_text, body_text, date_created, language_id)
						VALUES(NULL, \''.encode_text($news_code).'\', \''.encode_text($header_text).'\', \''.encode_text($body_text).'\', \''.encode_text($date_created).'\', \''.encode_text($total_languages[0][$i]['abbreviation']).'\')';
				database_void_query($sql);
				$this->SetSQLs('insert_lan_'.$total_languages[0][$i]['abbreviation'], $sql);
			}								
		}	
	}

	/**
	 *	Return news id for spesific language
	 *		@param $nid
	 *		@param $lang
	 **/
	public static function GetNewsId($nid = '', $lang = '')
	{
		if($nid != '' && $lang != ''){
			$sql = 'SELECT id
					FROM '.TABLE_NEWS.'
					WHERE language_id = \''.$lang.'\' AND 
						  news_code = (SELECT news_code FROM '.TABLE_NEWS.' WHERE id = '.(int)$nid.')';
			$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
			return isset($result['id']) ? $result['id'] : '';			
		}else{
			return '';	
		}		
	}	
	
	/**
	 *	Return news info for spesific language
	 *		@param $nid
	 *		@param $lang
	 **/
	public static function GetNewsInfo($nid = '', $lang = '')
	{
		if($nid != '' && $lang != ''){
			$sql = 'SELECT *
					FROM '.TABLE_NEWS.'
					WHERE language_id = \''.$lang.'\' AND 
						  news_code = (SELECT news_code FROM '.TABLE_NEWS.' WHERE id = '.(int)$nid.')';
			return database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
		}else{
			return '';	
		}		
	}
	
	/**
	 *	Checks if the page with news may be cached
	 *		@param $news_id
	 */
	public static function CacheAllowed($news_id)
	{
		$sql = 'SELECT id
				FROM '.TABLE_NEWS.'
				WHERE type = \'news\' AND id = '.(int)$news_id;
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){			
			return true;		
		}
		return false;	
	}
	
}
?>