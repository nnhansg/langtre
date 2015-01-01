<?php

/**
 *	Class Menu (for Hotel Site ONLY)
 *  -------------- 
 *  Description : encapsulates menu properties
 *  Updated	    : 03.05.2012
 *	Written by  : ApPHP
 *	
 *	PUBLIC:					STATIC:					PRIVATE:
 * 	------------------	  	---------------     	---------------
 *  __construct             GetAll       			GetAllFooter
 *  __destruct              DrawMenuSelectBox
 *  GetName                 DrawContentTypeBox
 *  GetParameter            DrawMenuPlacementBox
 *  GetId                   DrawMenuAccessSelectBox 
 *  GetOrder                DrawMenu 
 *  MenuUpdate        		DrawTopMenu
 *  MenuCreate              DrawFooterMenu
 *  MenuDelete              GetTopMenus
 *  MenuMove                GetMenuPages
 *                          GetMenuLinks (private)
 *            				GetMenus
 *                          GetAllSystemPages 
 *                          DrawHeaderMenu
 *                          GetAllTop
 *                          
 **/

class Menu {

	private $id;
	
	protected $menu;
	protected $languageId;
	protected $whereClause;
	
	public $langIdByUrl;
	public $error;    
	
	//==========================================================================
    // Class Constructor
	//		@param $id
	//==========================================================================
	function __construct($id = '')
	{
		$this->id = $id;
		$this->languageId  = (isset($_REQUEST['language_id']) && $_REQUEST['language_id'] != '') ? prepare_input($_REQUEST['language_id']) : Languages::GetDefaultLang();
		$this->whereClause  = '';
		$this->whereClause .= ($this->languageId != '') ? ' AND language_id = \''.$this->languageId.'\'' : '';		
		$this->langIdByUrl = ($this->languageId != '') ? '&amp;language_id='.$this->languageId : '';
		
		if($this->id != ''){
			$sql = 'SELECT
						'.TABLE_MENUS.'.*,
						'.TABLE_LANGUAGES.'.lang_name as language_name
					FROM '.TABLE_MENUS.'
						LEFT OUTER JOIN '.TABLE_LANGUAGES.' ON '.TABLE_MENUS.'.language_id = '.TABLE_LANGUAGES.'.abbreviation
					WHERE '.TABLE_MENUS.'.id = \''.(int)$this->id.'\'';
			$this->menu = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
		}else{
			$this->menu['menu_name'] = '';
			$this->menu['menu_placement'] = '';
			$this->menu['menu_order'] = '';
			$this->menu['language_id'] = '';
			$this->menu['language_name'] = '';
			$this->menu['access_level'] = '';
		}
	}
	
	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	//==========================================================================
    // PUBLIC METHODS
	//==========================================================================
	/**
	 *	Return a name of menu 
	 */
	public function GetName()
	{		
		if(isset($this->menu['menu_name'])) return decode_text($this->menu['menu_name']);
		else return '';
	}

	/**
	 *	Return a value of parameter
	 *		@param $param
	 */
	public function GetParameter($param = '')
	{
		if(isset($this->menu[$param])){
			return $this->menu[$param];
		}else{
			return '';
		}
	}
	
	/**
	 *	Returns menu ID
	 */
	public function GetId()
	{
		return $this->id;
	}
	
	/**
	 *	Returns menu order
	 */
	public function GetOrder()
	{
		if(isset($this->menu['menu_order'])) return $this->menu['menu_order'];
		else return '';
	}
	
	/**
	 *	Updates menu 
	 *		@param $param - array of parameters
	 */
	public function MenuUpdate($params = array())
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		if(isset($this->id)){
			// Get input parameters
			if(isset($params['name']) && $params['name'] != ''){
				$this->menu['menu_name'] = $params['name'];
			}else{
				$this->error = _MENU_NAME_EMPTY;
				return false;
			}
			if(isset($params['order'])) 		 $this->menu['menu_order'] = $params['order'];
		    if(isset($params['language_id'])) 	 $this->menu['language_id'] = $params['language_id'];
			if(isset($params['menu_placement'])) $this->menu['menu_placement'] = $params['menu_placement'];
			if(isset($params['access_level'])) 	 $this->menu['access_level'] = $params['access_level'];
			
			$sql = 'SELECT MIN(menu_order) as min_order, MAX(menu_order) as max_order FROM '.TABLE_MENUS;
			if($menu = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
				$min_order = $menu['min_order'];
				$max_order = $menu['max_order'];
				
				// insert menu with new priority order in menus list
				$sql = 'SELECT menu_order FROM '.TABLE_MENUS.' WHERE id = '.(int)$this->id;
				if($menu = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
					$sql_down = 'UPDATE '.TABLE_MENUS.' SET menu_order = menu_order - 1 WHERE language_id = \''.$this->menu['language_id'].'\' AND id <> '.(int)$this->id.' AND menu_order <= '.$this->menu['menu_order'].' AND menu_order > '.$menu['menu_order'];
					$sql_up = 'UPDATE '.TABLE_MENUS.' SET menu_order = menu_order + 1 WHERE language_id = \''.$this->menu['language_id'].'\' AND id <> '.(int)$this->id.' AND menu_order >= '.$this->menu['menu_order'].' AND menu_order < '.$menu['menu_order'];
					
					if($menu['menu_order'] != $this->menu['menu_order']){							
						$sql = 'UPDATE '.TABLE_MENUS.'
						        SET
								    language_id = \''.$this->menu['language_id'].'\',
									menu_name = \''.encode_text($this->menu['menu_name']).'\',
									menu_placement = \''.$this->menu['menu_placement'].'\',
								    menu_order = '.$this->menu['menu_order'].',
									access_level = \''.$this->menu['access_level'].'\'
								WHERE id = '.(int)$this->id.' AND menu_order <> '.$this->menu['menu_order'];
						if($result = database_void_query($sql)){
							if($this->menu['menu_order'] == $min_order){
								$sql = $sql_up;
							}else if($this->menu['menu_order'] == $max_order){
								$sql = $sql_down;
							}else{
								if($menu['menu_order'] < $this->menu['menu_order']) $sql = $sql_down;
								else $sql = $sql_up;
							}
							$result = database_void_query($sql);
						}
					}else{
						$sql = 'UPDATE '.TABLE_MENUS.'
						        SET
									language_id = \''.$this->menu['language_id'].'\',
								    menu_name = \''.encode_text($this->menu['menu_name']).'\',
									menu_placement = \''.$this->menu['menu_placement'].'\',
									access_level = \''.$this->menu['access_level'].'\'
								WHERE id = '.(int)$this->id;
						$result = database_void_query($sql);
					}
				}
			}

			if($result >= 0){
				return true;
			}else{
				$this->error = _TRY_LATER;
				return false;
			}				
		}else{
			$this->error = _MENU_MISSED;
			return false;
		}
	}
	
	/**
	 *	Creates new menu 
	 *		@param $param - array of parameters
	 */
	public function MenuCreate($params = array())
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		// Get input parameters
		if(isset($params['name'])) 			 $this->menu['menu_name'] = $params['name'];
		if(isset($params['menu_placement'])) $this->menu['menu_placement'] = $params['menu_placement'];
		if(isset($params['order'])) 		 $this->menu['menu_order'] = $params['order'];
		if(isset($params['language_id'])) 	 $this->menu['language_id'] = $params['language_id'];
		if(isset($params['access_level']))   $this->menu['access_level'] = $params['access_level'];

		// Prevent creating of empty records in our 'menus' table
		if($this->menu['menu_name'] != ''){
			$menu_code = strtoupper(get_random_string(10));

			$total_languages = Languages::GetAllActive();
			for($i = 0; $i < $total_languages[1]; $i++){				

				$m = self::GetAll(' menu_order ASC', TABLE_MENUS, '', $total_languages[0][$i]['abbreviation']);
				$max_order = (int)($m[1]+1);			

				$sql = 'INSERT INTO '.TABLE_MENUS.' (language_id, menu_code, menu_name, menu_placement, menu_order, access_level)
						VALUES(\''.$total_languages[0][$i]['abbreviation'].'\', \''.$menu_code.'\', \''.encode_text($this->menu['menu_name']).'\', \''.$this->menu['menu_placement'].'\', '.$max_order.', \''.$this->menu['access_level'].'\')';
				if(!database_void_query($sql)){
					$this->error = _TRY_LATER;
					return false;
				}
			}
			return true;			
		}else{
			$this->error = _MENU_NAME_EMPTY;
			return false;
		}
	}

	/**
	 *	Delete menu 
	 *		@param $menu_id - menu ID
	 *		@param $menu_order
	 */
	public function MenuDelete($menu_id = '0', $menu_order = '0')
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'SELECT language_id FROM '.TABLE_MENUS.' WHERE id = '.(int)$menu_id;
		if($menu = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			$sql = 'DELETE FROM '.TABLE_MENUS.' WHERE id = '.(int)$menu_id;
			if(database_void_query($sql)){
				$sql = 'UPDATE '.TABLE_MENUS.' SET menu_order = menu_order - 1 WHERE language_id = \''.$menu['language_id'].'\' AND menu_order > '.(int)$menu_order;
				if(database_void_query($sql)){
					return true;    
				}                				   
			}
		}		
		return false;
	}

	/**
	 *	Moves menu (change priority order)
	 *		@param $menu_id
	 *		@param $dir - direction
	 *		@param $menu_order  - menu order
	 */
	public function MenuMove($menu_id, $dir = '', $menu_order = '')
	{		
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){ 
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		if(($dir == '') || ($menu_order == '')){
			$this->error = _WRONG_PARAMETER_PASSED;
			return false;
		}

		$sql = 'SELECT * FROM '.TABLE_MENUS.'
				WHERE
					id <> \''.(int)$menu_id.'\' AND
					menu_order '.(($dir == 'up') ? '<' : '>').' '.(int)$menu_order.' AND
					language_id = \''.$this->languageId.'\'
				ORDER BY menu_order '.(($dir == 'up') ? 'DESC' : 'ASC');
        if($menu = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY)){
			$sql = 'UPDATE '.TABLE_MENUS.' SET menu_order = \''.$menu_order.'\' WHERE id = '.(int)$menu['id'];
			if(database_void_query($sql)){
				$sql = 'UPDATE '.TABLE_MENUS.' SET menu_order = \''.$menu['menu_order'].'\' WHERE id = '.(int)$menu_id;				
				if(!database_void_query($sql)){
					$this->error = _TRY_LATER;
					return false;					
				}
			}else{
				$this->error = _TRY_LATER;
				return false;
			}
		}
		return true;		
	}

	//==========================================================================
    // STATIC METHODS
	//==========================================================================
	/**
	 *	Return array of all menus 
	 *		@param $order - order clause
	 *		@param $join_table - join tables
	 *		@param $menu_placement
	 *		@param $lang_id
	 */
	public static function GetAll($order = ' menu_order ASC', $join_table = '', $menu_placement = '', $lang_id = '')
	{
		$where_clause = '';
		if($menu_placement != ''){
			$where_clause .= 'AND '.TABLE_MENUS.'.menu_placement = \''.$menu_placement.'\' ';
		}
		if($lang_id != '') $where_clause .= 'AND '.$join_table.'.language_id = \''.$lang_id.'\' ';
		
		// Build ORDER BY CLAUSE
		if($order == '') $order_clause = '';
		else $order_clause = 'ORDER BY '.$order;		

		// Build JOIN clause
		if($join_table == '') {
			$join_clause = '';
			$join_select_fields = '';
		}else if($join_table != TABLE_MENUS){
			$join_clause = 'LEFT OUTER JOIN '.$join_table.' ON '.$join_table.'.menu_id='.TABLE_MENUS.'.id ';
			$join_select_fields = ', '.$join_table.'.* ';
		} else {
			$join_clause = '';
			$join_select_fields = '';
        }		
		
		$sql = 'SELECT
					'.TABLE_MENUS.'.*,
					'.TABLE_LANGUAGES.'.lang_name as language_name
					'.$join_select_fields.' 
				FROM '.TABLE_MENUS.' 
				    INNER JOIN '.TABLE_LANGUAGES.' ON '.TABLE_MENUS.'.language_id = '.TABLE_LANGUAGES.'.abbreviation
					'.$join_clause.'
				WHERE 1=1
				'.$where_clause.'
				'.$order_clause;			
		
		return database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
	}	

	/**
	 *	Draws all menus in dropdowm box
	 *		@param $menu_id
	 *		@param $language_id
	 */
	public static function DrawMenuSelectBox($menu_id = '', $language_id = '')
	{	
		echo '<select name="menu_id" id="menu_id" style="width:170px">';
		echo '<option value="">-- '._SELECT.' --</option>';
		$all_menus = self::GetAll(' menu_order ASC', TABLE_MENUS, '', $language_id);		                 
		for($i = 0; $i < $all_menus[1]; $i++){
			echo '<option value="'.$all_menus[0][$i]['id'].'"';
			echo ($all_menus[0][$i]['id'] == $menu_id) ? ' selected="selected" ' : '';
			echo '>'.$all_menus[0][$i]['menu_name'].'</option>';
		}
		echo '</select>';		
	}

	/**
	 *	Return array of all footer menus 
	 *		@param $where_clause
	 *		@param $lang_id
	 */
	private static function GetAllFooter($where_clause = '', $lang_id = '')
	{
		global $objLogin;

		if($lang_id != '') $where_clause .= 'AND '.TABLE_PAGES.'.language_id = \''.$lang_id.'\' ';
		
		// Get all top menus
		$sql = 'SELECT '.TABLE_PAGES.'.* 
				FROM '.TABLE_PAGES.'
					INNER JOIN '.TABLE_MENUS.' ON '.TABLE_PAGES.'.menu_id = '.TABLE_MENUS.'.id
				WHERE '.TABLE_MENUS.'.menu_placement = \'bottom\' AND 
					is_published = 1 AND 
					('.TABLE_PAGES.'.finish_publishing = \'0000-00-00\' OR '.TABLE_PAGES.'.finish_publishing >= \''.@date('Y-m-d').'\')
					'.((!$objLogin->IsLoggedIn()) ? ' AND ('.TABLE_MENUS.'.access_level = \'public\' AND '.TABLE_PAGES.'.access_level = \'public\')' : '').'					
					'.$where_clause.'
				ORDER BY '.TABLE_MENUS.'.menu_order ASC, '.TABLE_PAGES.'.priority_order ASC';				
		return database_query($sql, DATA_AND_ROWS);
	}

	/**
	 *	Draw content type dropdowm box
	 *		@param $content_type
	 */
	public static function DrawContentTypeBox($content_type = '')
	{
		echo '<select name="content_type" onchange="ContentType_OnChange(this.value);" >';
		echo '<option value="article" '.(($content_type == 'article') ? ' selected="selected"' : '').'>'._ARTICLE.'</option>';
		echo '<option value="link" '.(($content_type == 'link') ? ' selected="selected"' : '').'>'._LINK.'</option>';
		echo '</select>';		
	}

	/**
	 *	Draw menus placement in dropdowm box
	 *		@param $menu_placement
	 */
	public static function DrawMenuPlacementBox($menu_placement = '')
	{
		global $objSettings;

		$template = $objSettings->GetParameter('template');
		$count = 0;
		
		echo '<select name="menu_placement">';
		if(@file_exists('templates/'.$template.'/info.xml')){
			// load XML file
			$xml = simplexml_load_file('templates/'.$template.'/info.xml');		 
			if(isset($xml->menus->menu)){
				foreach($xml->menus->menu as $menu){
					echo '<option value="'.$menu.'"'.((strtolower($menu_placement) == strtolower($menu)) ? ' selected="selected"' : '').'>'.ucfirst($menu).'</option>';
					$count++;
				}				
			}
		}		
		if(!$count){
			echo '<option value="left"   '.(($menu_placement == 'left') ? ' selected="selected" ' : '').'>'._LEFT.'</option>';
			echo '<option value="top"    '.(($menu_placement == 'top') ? ' selected="selected" ' : '').'>'._TOP.'</option>';
			echo '<option value="right"  '.(($menu_placement == 'right') ? ' selected="selected" ' : '').'>'._RIGHT.'</option>';
			echo '<option value="bottom" '.(($menu_placement == 'bottom') ? ' selected="selected" ' : '').'>'._BOTTOM.'</option>';
		}
		echo '<option value="hidden" '.(($menu_placement == 'hidden') ? ' selected="selected" ' : '').'>- '._HIDDEN.' -</option>';
		echo '</select>';
	}

	/**
	 *	Draw menu accessible dropdown menu
	 *		@param $access_level
	 */
	public static function DrawMenuAccessSelectBox($access_level = 'public')
	{
		echo '<select name="access_level" id="access_level">';
			echo '<option value="public" '.(($access_level == 'public') ? ' selected="selected"' : '').'>'._PUBLIC.'</option>';
			echo '<option value="registered" '.(($access_level == 'registered') ? ' selected="selected"' : '').'>'._REGISTERED.'</option>';
		echo '</select>';		
	}	

	/**
	 *	Draws menus 
	 *		@param $menu_position
	 *		@param $draw = true
	 */
	public static function DrawMenu($menu_position = 'left', $draw = true)
	{
		global $objSettings, $objLogin;
		$output = '';
		
		if($menu_position == 'left') $objLogin->DrawLoginLinks();
		
		// Get all menus which have items (links to pages)
		$menus = self::GetMenus($menu_position);
		$menus_count = $menus[1];

		$objNews = News::Instance();
		$show_news_block = ModulesSettings::Get('news', 'show_news_block');
		$show_subscribe_block = ModulesSettings::Get('news', 'show_newsletter_subscribe_block');
		//if(Modules::IsModuleInstalled('news') && ($show_news_block == 'right side' || $show_subscribe_block == 'right side')) $menus_count++;

		//variant 1. if($menus_count > 0) $output .= '<div id="column-'.$menu_position.'-wrapper">';
		//variant 2. if($menus_count > 0) $output = '<div id="column-'.$menu_position.'-wrapper" style="'.(($menus_count > 0) ? 'width:205px;' : '').'">';

		if(Modules::IsModuleInstalled('booking')){
			if(ModulesSettings::Get('booking', 'show_reservation_form') == 'yes'){
				if(Application::Get('page') != 'rooms'){
					$output .= draw_block_top(_RESERVATION, '', 'maximazed', false);				
					$output .= Rooms::DrawSearchAvailabilityBlock(true, '', 8, 3, false, '', '', false);
					$output .= draw_block_bottom(false);
				}

				if(!$objLogin->IsLoggedIn() && (ModulesSettings::Get('booking', 'show_booking_status_form') == 'yes')){			
					$output .= draw_block_top(_BOOKING_STATUS, '', 'maximazed', false);
					$output .= Bookings::DrawBookingStatusBlock(false);
					$output .= draw_block_bottom(false);
				}
			}
		}
		
		// Display all menu titles (names) according to their order
		for($menu_ind = 0; $menu_ind < $menus[1]; $menu_ind++){				
			// Start draw new menu
			$output .= draw_block_top($menus[0][$menu_ind]['menu_name'], '', 'maximazed', false);

			$menu_links = self::GetMenuLinks($menus[0][$menu_ind]['id'], Application::Get('lang'), $menu_position);
			if($menu_links[1] > 0) $output .= '<ul class="'.Application::Get('lang_dir').'">';
			for($menu_link_ind = 0; $menu_link_ind < $menu_links[1]; $menu_link_ind++) {
				if($menu_links[0][$menu_link_ind]['content_type'] == 'link'){
					$output .= '<li>'.prepare_permanent_link($menu_links[0][$menu_link_ind]['link_url'], $menu_links[0][$menu_link_ind]['menu_link'], $menu_links[0][$menu_link_ind]['link_target'], 'main_menu_link').'</li>';
				}else{					
					// draw current menu link
					$class = (Application::Get('page_id') == $menu_links[0][$menu_link_ind]['id']) ? ' active' : '';
					$output .= '<li>'.prepare_link('pages', 'pid', $menu_links[0][$menu_link_ind]['id'], $menu_links[0][$menu_link_ind]['page_key'], $menu_links[0][$menu_link_ind]['menu_link'], 'main_menu_link'.$class).'</li>';
				}
			}
			if($menu_links[1] > 0) $output .= '</ul>';
			$output .= draw_block_bottom(false);
        }
		
		if($menu_position == 'right'){
			if(Modules::IsModuleInstalled('news')){
				if($show_news_block == 'right side') $output .= $objNews->DrawNewsBlock(false);
				if($show_subscribe_block == 'right side') $output .= $objNews->DrawSubscribeBlock(false);	
			}
		}
		
		if($menu_position == 'left'){
			if(!$objLogin->IsLoggedIn() || Application::Get('preview') == 'yes'){
				if(Modules::IsModuleInstalled('customers') && ModulesSettings::Get('customers', 'allow_login') == 'yes'){
					if(Application::Get('customer') != 'login'){
						$output .= Customers::DrawLoginFormBlock(false);		
					}
				}				
			}
			if(Modules::IsModuleInstalled('news')){
				if($show_news_block == 'left side') $output .= $objNews->DrawNewsBlock(false);
				if($show_subscribe_block == 'left side') $output .= $objNews->DrawSubscribeBlock(false);	
			}
			if(Modules::IsModuleInstalled('booking')){
				if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))){					
					if(ModulesSettings::Get('booking', 'payment_type_paypal') == 'yes' || ModulesSettings::Get('booking', 'payment_type_2co') == 'yes' || ModulesSettings::Get('booking', 'payment_type_authorize') == 'yes'){
						$output .= draw_block_top(_PAYMENTS, '', 'maximized', false);
						$output .= '<div class="payment_instruments"><img src="images/ppc_icons/logo_paypal.gif" title="PayPal" alt="PayPal" />
							  <img src="images/ppc_icons/logo_ccVisa.gif" title="Visa" alt="Visa" />
							  <img src="images/ppc_icons/logo_ccMC.gif" title="MasterCard" alt="MasterCard" />
							  <img src="images/ppc_icons/logo_ccAmex.gif" title="Amex" alt="Amex" /></div>';
						$output .= draw_block_bottom(false);
					}
				}
			}

			// Draw local time
			if(Hotels::HotelsCount() == 1){
				$output .= draw_block_top(_LOCAL_TIME, '', 'maximazed', false);
				$output .= Hotels::DrawLocalTime('', false);
				$output .= draw_block_bottom(false);
			}

			$output .= draw_block_footer(false);			
		}
		
		if($draw) echo $output;
		else return $output;		
		
		//if($menus_count > 0) $output .= '</div>';		
	}

	/**
	 *	Draws top menu
	 */
	public static function DrawTopMenu()
	{		
		echo '<li><a href="index.php">'._HOME.'</a></li>';			

		if(Modules::IsModuleInstalled('customers')){			
			echo '<li><a href="index.php?customer=my_account">'._MY_ACCOUNT.'</a></li>';
		}
		if(Modules::IsModuleInstalled('booking')){				
			if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))){
				echo '<li><a href="index.php?page=booking">'._BOOKING.'</a></li>';
				echo '<li><a href="index.php?page=checkout">'._CHECKOUT.'</a></li>';
			}
		}
		
		$menus = self::GetTopMenus($lang);
		for($i = 0; $i < $menus[1]; $i++) {
			$menu_pages = self::GetMenuPages($menus[0][$i]['id'], Application::Get('lang'));
			if($menu_pages[1] > 0){
				echo '<li><a href="javascript:void(0);">'.$menus[0][$i]['menu_name'].'</a>';
				echo '<ul class="dropdown_inner" style="width:200px">';
				// Draw current menu link
				for($j = 0; $j < $menu_pages[1]; $j++) {
					if($menu_pages[0][$j]['content_type'] == 'link'){
					    echo '<li>'.prepare_permanent_link($menu_pages[0][$j]['link_url'], $menu_pages[0][$j]['menu_link'], $menu_pages[0][$j]['link_target']).'</li>';					
					}else{					
						echo '<li>'.prepare_link('pages', 'pid', $menu_pages[0][$j]['id'], $menu_pages[0][$j]['page_key'], $menu_pages[0][$j]['menu_link'], '').'</li>';						
					}					
				}
				echo '</ul>';
				echo '</li>';
			}				
		}
	}

	/**
	 *	Draws all menus for footer
	 */
	public static function DrawFooterMenu()
	{
		$lang = Application::Get('lang');

		$output = '<a href="index.php">'._HOME.'</a>';
		
		$system_pages = self::GetAllSystemPages();
		for($ind = 0; $ind < $system_pages[1]; $ind++) {
			if(($system_pages[0][$ind]['is_published']) &&
			   ($system_pages[0][$ind]['system_page'] == 'terms_and_conditions' ||
				$system_pages[0][$ind]['system_page'] == 'about_us' ||
				$system_pages[0][$ind]['system_page'] == 'contact_us')
				){
				if($system_pages[0][$ind]['content_type'] == 'link'){
					$output .= '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;'.prepare_permanent_link($system_pages[0][$ind]['link_url'], $system_pages[0][$ind]['menu_link'], $system_pages[0][$ind]['link_target']);
				}else{					
					$output .= '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;'.prepare_link('pages', 'system_page', $system_pages[0][$ind]['system_page'], 'index', $system_pages[0][$ind]['menu_link'], '');
				}
			}
		}
		$output .= '<br />';

		for($ind = 0; $ind < $system_pages[1]; $ind++) {
			if(($system_pages[0][$ind]['is_published']) &&
			   ($system_pages[0][$ind]['system_page'] != 'terms_and_conditions' &&
				$system_pages[0][$ind]['system_page'] != 'about_us' &&
				$system_pages[0][$ind]['system_page'] != 'contact_us')
			   ){
				if($ind != 0 && $system_pages[0][$ind]['menu_link']) $output .= '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;'; 
				if($system_pages[0][$ind]['content_type'] == 'link'){
					$output .= prepare_permanent_link($system_pages[0][$ind]['link_url'], $system_pages[0][$ind]['menu_link'], $system_pages[0][$ind]['link_target']);
				}else{					
					$output .= prepare_link('pages', 'system_page', $system_pages[0][$ind]['system_page'], 'index', $system_pages[0][$ind]['menu_link'], '');
				}				
			}
		}
		if(Modules::IsModuleInstalled('booking')){
			if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))){
				$output .= '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;<a href="index.php?page=booking">'._BOOKING.'</a>';
			}
		}
		$output .= '<br />';
			
		$menus = self::GetAllFooter('', $lang);
		if($menus[1] > 0) $output .= '<br />';
		for($menu_ind = 0; $menu_ind < $menus[1]; $menu_ind++) {
			if($menu_ind > 0) $output .= '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;';
			$output .= prepare_link('pages', 'pid', $menus[0][$menu_ind]['id'], $menus[0][$menu_ind]['page_key'], $menus[0][$menu_ind]['menu_link'], '');
		}
		
		echo $output;
	}

	/**
	 *	Return array of all top menus 
	 *		@param $lang_id
	 */
	public static function GetTopMenus($lang_id = '')
	{
		global $objLogin;
		
		$where_clause = ($lang_id != '') ? ' AND '.TABLE_MENUS.'.language_id = \''.$lang_id.'\' ' : '';
		
		// Get all top menus
		$sql = 'SELECT '.TABLE_MENUS.'.* 
				FROM '.TABLE_MENUS.'
				WHERE '.TABLE_MENUS.'.menu_placement = \'top\'
				    '.((!$objLogin->IsLoggedIn()) ? ' AND '.TABLE_MENUS.'.access_level = \'public\'' : '').'
					'.$where_clause.'
				ORDER BY '.TABLE_MENUS.'.menu_order ASC';
		return database_query($sql, DATA_AND_ROWS);
	}	

	/**
	 *	Returns all top pages fot to pmenu
	 *		@param $menu_id
	 *		@param $lang_id
	 */
	public static function GetMenuPages($menu_id = '0', $lang_id = '')
	{
		global $objLogin;

		$where_clause = ($lang_id != '') ? ' AND '.TABLE_PAGES.'.language_id = \''.$lang_id.'\' ' : '';
		
		// Get all top menus
		$sql = 'SELECT '.TABLE_PAGES.'.* 
				FROM '.TABLE_PAGES.'
					INNER JOIN '.TABLE_MENUS.' ON '.TABLE_PAGES.'.menu_id = '.TABLE_MENUS.'.id
				WHERE
					'.TABLE_MENUS.'.id = \''.$menu_id.'\' AND 
					'.TABLE_PAGES.'.is_published = 1 AND
					('.TABLE_PAGES.'.finish_publishing = \'0000-00-00\' OR '.TABLE_PAGES.'.finish_publishing >= \''.@date('Y-m-d').'\')
					'.((!$objLogin->IsLoggedIn()) ? ' AND ('.TABLE_MENUS.'.access_level = \'public\' AND '.TABLE_PAGES.'.access_level = \'public\')' : '').'					
					'.$where_clause.'
				ORDER BY '.TABLE_PAGES.'.priority_order ASC';				
		return database_query($sql, DATA_AND_ROWS);
	}

	/**
	 *	Returns all left menu links array
	 *		@param $menu_id
	 *		@param $lang_id
	 *		@param $position
	 */
	private static function GetMenuLinks($menu_id, $lang_id = '', $position = 'left')
	{
		global $objLogin;
		
		// Get all left menus
		$sql = 'SELECT
					'.TABLE_PAGES.'.*
				FROM '.TABLE_PAGES.'
				    INNER JOIN '.TABLE_LANGUAGES.' ON '.TABLE_PAGES.'.language_id = '.TABLE_LANGUAGES.'.abbreviation
					INNER JOIN '.TABLE_MENUS.' ON '.TABLE_PAGES.'.menu_id = '.TABLE_MENUS.'.id
				WHERE
					'.TABLE_PAGES.'.language_id = \''.$lang_id.'\' AND
					'.TABLE_MENUS.'.menu_placement = \''.$position.'\' AND
					'.TABLE_PAGES.'.menu_id = \''.$menu_id.'\' AND
					'.TABLE_PAGES.'.is_home = 0 AND
					'.TABLE_PAGES.'.is_published = 1 AND
					('.TABLE_PAGES.'.finish_publishing = \'0000-00-00\' OR '.TABLE_PAGES.'.finish_publishing >= \''.@date('Y-m-d').'\')
					'.((!$objLogin->IsLoggedIn()) ? ' AND '.TABLE_PAGES.'.access_level = \'public\'' : '').'
				ORDER BY '.TABLE_PAGES.'.priority_order ASC';
		return database_query($sql, DATA_AND_ROWS);
	}

	/**
	 *	Returns all left menus array
	 *		@param $position
	 */
	public static function GetMenus($position = 'left')
	{
		global $objLogin;

		// Get all left menus
		$sql = 'SELECT
					'.TABLE_MENUS.'.*
				FROM '.TABLE_MENUS.'
				    INNER JOIN '.TABLE_LANGUAGES.' ON '.TABLE_MENUS.'.language_id = '.TABLE_LANGUAGES.'.abbreviation
				WHERE
					'.TABLE_MENUS.'.language_id = \''.Application::Get('lang').'\' AND
					'.TABLE_MENUS.'.menu_placement = \''.$position.'\'
					'.((!$objLogin->IsLoggedIn()) ? ' AND '.TABLE_MENUS.'.access_level = \'public\'' : '').'
				ORDER BY '.TABLE_MENUS.'.menu_order ASC';
		return database_query($sql, DATA_AND_ROWS);
	}
	
	/**
	 *	Returns array of all system pages 
	 */
	public static function GetAllSystemPages()
	{
		$sql = 'SELECT '.TABLE_PAGES.'.* 
				FROM '.TABLE_PAGES.'
				WHERE
					is_system_page = 1 AND					
					language_id = \''.Application::Get('lang').'\' 
				ORDER BY priority_order ASC';				
		return database_query($sql, DATA_AND_ROWS);
	}

	/**
	 *	Draws all menus for header
	 */
	public static function DrawHeaderMenu()
	{
		$system_page = Application::Get('system_page');
		$page = isset($_GET['page']) ? prepare_input($_GET['page']) : '';			
		if($page == 'booking' || $page == 'booking_details' || $page == 'booking_checkout' || $page == 'booking_payment') $system_page = 'booking';
		
		$output = '<ul class="nav nav_bg">';
		$output .= '<li><a href="index.php" '.(($system_page == '') ? 'class="current"' : '').'>'._HOME.'</a></li>';
		
		$system_pages = self::GetAllSystemPages();
		for($ind = 0; $ind < $system_pages[1]; $ind++) {
			if(($system_pages[0][$ind]['is_published']) &&
			    $system_pages[0][$ind]['system_page'] != 'terms_and_conditions' &&
			    $system_pages[0][$ind]['system_page'] != 'about_us' &&
				$system_pages[0][$ind]['system_page'] != 'contact_us'
				){
				if($system_pages[0][$ind]['content_type'] == 'link'){
					$output .= '<li>'.prepare_permanent_link($system_pages[0][$ind]['link_url'], $system_pages[0][$ind]['menu_link'], $system_pages[0][$ind]['link_target'], (($system_page == $system_pages[0][$ind]['system_page']) ? 'current' : '')).'</li>';
				}else{					
					$output .= '<li>'.prepare_link('pages', 'system_page', $system_pages[0][$ind]['system_page'], 'index', $system_pages[0][$ind]['menu_link'], (($system_page == $system_pages[0][$ind]['system_page']) ? 'current' : '')).'</li>';
				}
			}
		}
		if(Modules::IsModuleInstalled('booking')){
			if(in_array(ModulesSettings::Get('booking', 'is_active'), array('global', 'front-end'))){
				$output .= '<li><a href="index.php?page=booking" '.(($system_page == 'booking') ? 'class="current"' : '').'>'._BOOKING.'</a></li>';	
			}
		} 

		$output .= '</ul>';		
		echo $output;
	}

	/**
	 *	Returns array of all top pages 
	 *		@param $where_clause
	 *		@param $lang_id
	 */
	public static function GetAllTop($where_clause = '', $lang_id = '')
	{
		global $objLogin;

		if($lang_id != '') $where_clause .= 'AND '.TABLE_PAGES.'.language_id = \''.$lang_id.'\' ';
		
		// Get all top menus
		$sql = 'SELECT '.TABLE_PAGES.'.* 
				FROM '.TABLE_PAGES.'
					INNER JOIN '.TABLE_MENUS.' ON '.TABLE_PAGES.'.menu_id = '.TABLE_MENUS.'.id
				WHERE '.TABLE_MENUS.'.menu_placement = \'top\' AND
					is_published = 1 					
					'.((!$objLogin->IsLoggedIn()) ? ' AND ('.TABLE_MENUS.'.access_level = \'public\' AND '.TABLE_PAGES.'.access_level = \'public\')' : '').'					
					'.$where_clause.' 
				ORDER BY '.TABLE_MENUS.'.menu_order ASC, '.TABLE_PAGES.'.priority_order ASC';				
		return database_query($sql, DATA_AND_ROWS);
	}

}
?>