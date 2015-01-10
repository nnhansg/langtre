<?php

/**
 *	Rooms Class (for HotelSite ONLY)
 *  -------------- 
 *	Written by  : ApPHP
 *  Updated	    : 23.09.2012
 *	Written by  : ApPHP
 *
 *	PUBLIC:						STATIC:							PRIVATE:
 *  -----------					-----------						-----------
 *  __construct					GetRoomAvalibilityForWeek		GetRoomPrice
 *  __destruct                  GetRoomAvalibilityForMonth      GetRoomDefaultPrice 
 *  DrawRoomAvailabilitiesForm  GetRoomInfo 					GetRoomWeekDefaultPrice
 *  DrawRoomPricesForm          GetRoomTypes                    GetMonthMaxDay 
 *  DeleteRoomAvailability      GetMonthLastDay                 CheckAvailabilityForPeriod
 *  DeleteRoomPrices 		    DrawSearchAvailabilityBlock     DrawPaginationLinks
 *  AddRoomAvailability         DrawSearchAvailabilityFooter    DrawHotelInfoBlock
 *  AddRoomPrices               DrawRoomsInfo                   DrawGuestsDDL
 *  UpdateRoomAvailability      ConvertToDecimal (private)      GetRoomGuestPrice
 *  UpdateRoomPrices            GetPriceForDate
 *  AfterInsertRecord           GetRoomPricesTable
 *  BeforeUpdateRecord          DrawRoomDescription 
 *	AfterUpdateRecord           DrawRoomsInHotel
 *	AfterDeleteRecord           
 *	SearchFor
 *	DrawSearchResult
 *	
 *	
 **/


class Rooms extends MicroGrid {
	
	protected $debug = false;
	
	//-------------------------
	private $arrAvailableRooms;
	private $arrBeds;
	private $arrBathrooms;
	private $currencyFormat;
	private $roomsCount;
	private $hotelsList;

	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{		
		parent::__construct();

		global $objLogin;

		$this->params = array();
		$this->arrAvailableRooms = array();
		
		## for standard fields
		if(isset($_POST['room_type']))  $this->params['room_type'] = prepare_input($_POST['room_type']);
		if(isset($_POST['room_short_description'])) $this->params['room_short_description'] = prepare_input($_POST['room_short_description']);
		if(isset($_POST['room_long_description'])) $this->params['room_long_description'] = prepare_input($_POST['room_long_description']);
		if(isset($_POST['max_adults'])) $this->params['max_adults'] = prepare_input($_POST['max_adults']);
		if(isset($_POST['max_children'])) $this->params['max_children'] = prepare_input($_POST['max_children']);
		if(isset($_POST['max_guests'])) $this->params['max_guests'] = prepare_input($_POST['max_guests']);
		if(isset($_POST['room_count'])) $this->params['room_count'] = prepare_input($_POST['room_count']);		
		if(isset($_POST['default_price'])) $this->params['default_price'] = prepare_input($_POST['default_price']);
		if(isset($_POST['additional_guest_fee'])) $this->params['additional_guest_fee'] = prepare_input($_POST['additional_guest_fee']);		
		if(isset($_POST['priority_order'])) $this->params['priority_order'] = prepare_input($_POST['priority_order']);
		if(isset($_POST['beds'])) $this->params['beds'] = prepare_input($_POST['beds']);
		if(isset($_POST['bathrooms'])) $this->params['bathrooms'] = prepare_input($_POST['bathrooms']);
		if(isset($_POST['room_area'])) $this->params['room_area'] = prepare_input($_POST['room_area']);		
		if(isset($_POST['facilities'])) $this->params['facilities'] = prepare_input($_POST['facilities']);
		if(isset($_POST['hotel_id'])) $this->params['hotel_id'] = prepare_input($_POST['hotel_id']);
		$image_prefix = (isset($_POST['hotel_id'])) ? prepare_input($_POST['hotel_id']).'_' : '';
		
		## for checkboxes 
		if(isset($_POST['is_active'])) $this->params['is_active'] = (int)$_POST['is_active']; else $this->params['is_active'] = '0';

		## for images
		if(isset($_POST['room_icon'])) { 
			$this->params['room_icon'] = prepare_input($_POST['room_icon']);
		}else if(isset($_FILES['room_icon']['name']) && $_FILES['room_icon']['name'] != ''){
			// nothing 			
		}else if (self::GetParameter('action') == 'create'){
			$this->params['room_icon'] = '';
		}
		
		$this->params['language_id'] = MicroGrid::GetParameter('language_id');
	
		$this->primaryKey 	= 'id';
		$this->tableName 	= TABLE_ROOMS;
		$this->dataSet 		= array();
		$this->error 		= '';
		$this->formActionURL = 'index.php?admin=mod_rooms_management';
		$this->actions      = array('add'=>true, 'edit'=>true, 'details'=>true, 'delete'=>true);
		$this->actionIcons  = true;
		$this->allowRefresh = true;
		$this->allowTopButtons = true;
		
		$this->allowLanguages = false;
		$this->languageId  	= ($this->params['language_id'] != '') ? $this->params['language_id'] : Languages::GetDefaultLang();

		$this->WHERE_CLAUSE = '';
		$this->hotelsList = '';
		if($objLogin->IsLoggedInAs('hotelowner')){
			$this->hotelsList = implode(',', $objLogin->AssignedToHotels());
			if(!empty($this->hotelsList)) $this->WHERE_CLAUSE .= 'WHERE '.$this->tableName.'.hotel_id IN ('.$this->hotelsList.')';
		}
		$this->ORDER_CLAUSE = 'ORDER BY '.$this->tableName.'.hotel_id ASC, '.$this->tableName.'.priority_order ASC';
		
		$this->isAlterColorsAllowed = true;

		$this->isPagingAllowed = true;
		$this->pageSize = 20;	

		$this->isSortingAllowed = true;

		// prepare hotels array		
		$total_hotels = Hotels::GetAllActive((!empty($this->hotelsList) ? TABLE_HOTELS.'.id IN ('.$this->hotelsList.')' : ''));
		$arr_hotels = array();
		foreach($total_hotels[0] as $key => $val){
			$arr_hotels[$val['id']] = $val['name'];
		}		

		// prepare facilities array		
		$total_facilities = RoomFacilities::GetAllActive();
		$arr_facilities = array();
		foreach($total_facilities[0] as $key => $val){
			$arr_facilities[$val['id']] = $val['name'];
		}

		$this->isFilteringAllowed = true;
		// define filtering fields
		$this->arrFilteringFields = array(
			_HOTEL  => array('table'=>$this->tableName, 'field'=>'hotel_id', 'type'=>'dropdownlist', 'source'=>$arr_hotels, 'sign'=>'=', 'width'=>'130px', 'visible'=>true),
		);

		$this->isAggregateAllowed = true;
		// define aggregate fields for View Mode
		$this->arrAggregateFields = array(
			'room_count' => array('function'=>'SUM'),
			///'field2' => array('function'=>'AVG'),
		);

		// prepare languages array		
		/// $total_languages = Languages::GetAllActive();
		/// $arr_languages      = array();
		/// foreach($total_languages[0] as $key => $val){
		/// 	$arr_languages[$val['abbreviation']] = $val['lang_name'];
		/// }

		$this->currencyFormat = get_currency_format();		
	
		$this->arrBeds = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
		$this->arrBathrooms = array(0, 1, 2, 3);
		$arr_is_active = array('0'=>'<span class=no>'._NO.'</span>', '1'=>'<span class=yes>'._YES.'</span>');
		
		$default_currency = Currencies::GetDefaultCurrency();
		
		$random_name = true;
		$booking_active = (Modules::IsModuleInstalled('booking')) ? ModulesSettings::Get('booking', 'is_active') : false;
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');

		//---------------------------------------------------------------------- 
		// VIEW MODE
		//---------------------------------------------------------------------- 
		$this->VIEW_MODE_SQL = 'SELECT
									'.$this->tableName.'.'.$this->primaryKey.',
									'.$this->tableName.'.hotel_id,
									'.$this->tableName.'.max_adults,
									'.$this->tableName.'.max_children,
									'.$this->tableName.'.max_guests,
									'.$this->tableName.'.room_count,
									'.$this->tableName.'.default_price,
									'.$this->tableName.'.default_price_flexible_offer,
									'.$this->tableName.'.additional_guest_fee,
									'.$this->tableName.'.room_icon,
									'.$this->tableName.'.room_icon_thumb,
									'.$this->tableName.'.priority_order,
									'.$this->tableName.'.is_active,
									CONCAT("<a href=\"index.php?admin=mod_room_prices&rid=", '.$this->tableName.'.'.$this->primaryKey.', "\" title=\"'._CLICK_TO_MANAGE.'\">", "[ '._PRICES.' ]", "</a>") as link_prices,
									CONCAT("<a href=\"index.php?admin=mod_room_availability&rid=", '.$this->tableName.'.'.$this->primaryKey.', "\" title=\"'._CLICK_TO_MANAGE.'\">", "[ '._AVAILABILITY.' ]", "</a>") as link_room_availability,
									CONCAT("<a href=\"index.php?admin=mod_booking_rooms_occupancy&sel_room_types=", '.$this->tableName.'.'.$this->primaryKey.', "\" title=\"'._CLICK_TO_MANAGE.'\">", "[ '._OCCUPANCY.' ]", "</a>") as link_room_occupancy,
									CONCAT("<a href=\"index.php?admin=mod_room_description&room_id=", '.$this->tableName.'.'.$this->primaryKey.', "\" title=\"'._CLICK_TO_MANAGE.'\">[ ", "'._DESCRIPTION.'", " ]</a>") as link_room_description,
									rd.room_type,
									rd.room_short_description,
									rd.room_long_description
								FROM '.$this->tableName.'
									INNER JOIN '.TABLE_HOTELS.' ON '.$this->tableName.'.hotel_id = '.TABLE_HOTELS.'.id AND '.TABLE_HOTELS.'.is_active = 1
									LEFT OUTER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON '.$this->tableName.'.'.$this->primaryKey.' = rd.room_id AND rd.language_id = \''.$this->languageId.'\' ';
		// define view mode fields
		$this->arrViewModeFields = array(

			'hotel_id'        => array('title'=>_HOTEL, 'type'=>'enum',  'align'=>'left', 'width'=>'100px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_hotels),
			'room_icon_thumb' => array('title'=>_ICON_IMAGE, 'type'=>'image', 'align'=>'center', 'width'=>'80px', 'image_width'=>'60px', 'image_height'=>'30px', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
			'room_type'  	  => array('title'=>_TYPE, 'type'=>'label', 'align'=>'left', 'width'=>'', 'maxlength'=>'32'),
			'room_count' 	  => array('title'=>_COUNT, 'type'=>'label', 'align'=>'center', 'width'=>'49px', 'maxlength'=>''),
			'max_adults'      => array('title'=>_ADULTS, 'type'=>'label', 'align'=>'center', 'width'=>'49px', 'maxlength'=>''),
			'max_children'    => array('title'=>_CHILD, 'type'=>'label', 'align'=>'center', 'width'=>'49px', 'maxlength'=>'', 'visible'=>(($allow_children == 'yes') ? true : false)),
			'max_guests'      => array('title'=>_GUESTS, 'type'=>'label', 'align'=>'center', 'width'=>'49px', 'maxlength'=>'', 'visible'=>(($allow_guests == 'yes') ? true : false)),
			'is_active' 	  => array('title'=>_ACTIVE, 'type'=>'enum',  'align'=>'center', 'width'=>'49px', 'sortable'=>true, 'nowrap'=>'', 'visible'=>true, 'source'=>$arr_is_active),
			'priority_order'  => array('title'=>_ORDER, 'type'=>'label', 'align'=>'center', 'width'=>'60px', 'maxlength'=>'', 'movable'=>true),
			'link_room_description' => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap'),			
			'link_prices' 	  => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap'),
			'link_room_availability' => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap'),
			'link_room_occupancy'    => array('title'=>'', 'type'=>'label', 'align'=>'center', 'width'=>'', 'maxlength'=>'', 'nowrap'=>'nowrap', 'visible'=>(($booking_active == 'global') ? true : false)),
			'_empty_'  	      => array('title'=>'', 'type'=>'label', 'align'=>'left', 'width'=>'15px'), 
		);

		//---------------------------------------------------------------------- 
		// ADD MODE
		// Validation Type: alpha|numeric|float|alpha_numeric|text|email
		// Validation Sub-Type: positive (for numeric and float)
		// Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		//---------------------------------------------------------------------- 
		// define add mode fields
		$this->arrAddModeFields = array(
			'separator_1'   =>array(
				'separator_info' => array('legend'=>_ROOM_DETAILS),
				'hotel_id'       => array('title'=>_HOTEL, 'type'=>'enum',  'width'=>'',   'required'=>true, 'readonly'=>false, 'default'=>((count($arr_hotels) == 1) ? key($arr_hotels) : ''), 'source'=>$arr_hotels, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'room_type'  	 => array('title'=>_TYPE, 'type'=>'textbox',  'width'=>'270px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'70', 'default'=>'', 'validation_type'=>'text'),
				'room_short_description' => array('title'=>_SHORT_DESCRIPTION, 'type'=>'textarea', 'editor_type'=>'wysiwyg', 'width'=>'410px', 'height'=>'40px', 'required'=>true, 'readonly'=>false, 'default'=>'', 'validation_type'=>'text', 'validation_maxlength'=>'512'),
				'room_long_description' => array('title'=>_LONG_DESCRIPTION, 'type'=>'textarea', 'editor_type'=>'wysiwyg', 'width'=>'410px', 'height'=>'70px', 'required'=>false, 'readonly'=>false, 'default'=>'', 'validation_type'=>'text', 'validation_maxlength'=>'4096'),
				'max_adults'     => array('title'=>_MAX_ADULTS, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'default'=>'1', 'validation_type'=>'numeric|positive'),
				'max_children'   => array('title'=>_MAX_CHILDREN, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'default'=>'0', 'validation_type'=>'numeric|positive', 'visible'=>(($allow_children == 'yes') ? true : false)),			
				'max_guests'     => array('title'=>_MAX_GUESTS, 'type'=>'textbox',  'width'=>'30px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'1', 'default'=>'0', 'validation_type'=>'numeric|positive', 'visible'=>(($allow_guests == 'yes') ? true : false)),			
				'room_count'     => array('title'=>_ROOMS_COUNT, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'default'=>'1', 'validation_type'=>'numeric|positive'),
				'beds'           => array('title'=>_BEDS, 'type'=>'enum', 'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrBeds, 'default_option'=>false, 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'bathrooms'      => array('title'=>_BATHROOMS, 'type'=>'enum', 'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrBathrooms, 'default_option'=>false, 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'room_area'      => array('title'=>_ROOM_AREA, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'5', 'default'=>'0', 'validation_type'=>'float|positive', 'validation_maximum'=>'999', 'post_html'=>' m<sup>2</sup>'),
				'default_price'  => array('title'=>_DEFAULT_PRICE_LIMITED_OFFER, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
                'default_price_flexible_offer'  => array('title'=>_DEFAULT_PRICE_FlEXIBLE_OFFER, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
				'additional_guest_fee' => array('title'=>_ADDITIONAL_GUEST_FEE, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
				'priority_order' => array('title'=>_ORDER, 'type'=>'textbox',  'width'=>'35px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'default'=>'0', 'validation_type'=>'numeric|positive'),
				'is_active'      => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0'),
			),
			'separator_2'   =>array(
				'separator_info' => array('legend'=>_ROOM_FACILITIES),
				'facilities'     => array('title'=>_FACILITIES, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$arr_facilities, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true),
			),
			'separator_3'   =>array(
				'separator_info' => array('legend'=>_IMAGES, 'columns'=>'2'),
				'room_icon'      => array('title'=>_ICON_IMAGE, 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'icon_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_icon_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'500k'),
				'room_picture_1' => array('title'=>_IMAGE.' 1', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view1_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_1_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_2' => array('title'=>_IMAGE.' 2', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view2_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_2_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_3' => array('title'=>_IMAGE.' 3', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view3_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_3_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_4' => array('title'=>_IMAGE.' 4', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view4_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_4_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_5' => array('title'=>_IMAGE.' 5', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view5_', 'unique'=>true, 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_5_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
			)
		);

		//---------------------------------------------------------------------- 
		// EDIT MODE
		// Validation Type: alpha|numeric|float|alpha_numeric|text|email
		// Validation Sub-Type: positive (for numeric and float)
		// Ex.: 'validation_type'=>'numeric', 'validation_type'=>'numeric|positive'
		//---------------------------------------------------------------------- 
		$this->EDIT_MODE_SQL = 'SELECT
								'.$this->tableName.'.'.$this->primaryKey.',
								'.$this->tableName.'.hotel_id,
								'.$this->tableName.'.room_type,
								'.$this->tableName.'.room_short_description,
								'.$this->tableName.'.room_long_description,
								'.$this->tableName.'.max_adults,
								'.$this->tableName.'.max_children,
								'.$this->tableName.'.max_guests,
								'.$this->tableName.'.room_count,
								'.$this->tableName.'.default_price,
								'.$this->tableName.'.default_price_flexible_offer,
								'.$this->tableName.'.additional_guest_fee,
								'.$this->tableName.'.beds,
								'.$this->tableName.'.bathrooms,
								'.$this->tableName.'.room_area,
								'.$this->tableName.'.facilities,
								'.$this->tableName.'.room_icon,
								'.$this->tableName.'.room_icon_thumb,
								'.$this->tableName.'.room_picture_1,
								'.$this->tableName.'.room_picture_1_thumb,
								'.$this->tableName.'.room_picture_2,
								'.$this->tableName.'.room_picture_2_thumb,
								'.$this->tableName.'.room_picture_3,
								'.$this->tableName.'.room_picture_3_thumb,
								'.$this->tableName.'.room_picture_4,
								'.$this->tableName.'.room_picture_4_thumb,
								'.$this->tableName.'.room_picture_5,
								'.$this->tableName.'.room_picture_5_thumb,
								'.$this->tableName.'.priority_order,
								'.$this->tableName.'.is_active,
								rd.room_type as m_room_type
							FROM '.$this->tableName.'
								LEFT OUTER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON '.$this->tableName.'.'.$this->primaryKey.' = rd.room_id
							WHERE '.$this->tableName.'.'.$this->primaryKey.' = _RID_';		
		// define edit mode fields
		$this->arrEditModeFields = array(
			'separator_1'   =>array(
				'separator_info' => array('legend'=>_ROOM_DETAILS),
				'hotel_id'       => array('title'=>_HOTEL, 'type'=>'enum',  'width'=>'',   'required'=>true, 'readonly'=>false, 'default'=>'', 'source'=>$arr_hotels, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'm_room_type'    => array('title'=>_ROOM_TYPE, 'type'=>'label'),
				'max_adults'     => array('title'=>_MAX_ADULTS, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'default'=>'', 'validation_type'=>'numeric|positive'),
				'max_children'   => array('title'=>_MAX_CHILDREN, 'type'=>'textbox',  'width'=>'40px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'2', 'default'=>'', 'validation_type'=>'numeric|positive', 'visible'=>(($allow_children == 'yes') ? true : false)),
				'max_guests'     => array('title'=>_MAX_GUESTS, 'type'=>'textbox',  'width'=>'30px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'1', 'default'=>'0', 'validation_type'=>'numeric|positive', 'visible'=>(($allow_guests == 'yes') ? true : false)),			
				'room_count'     => array('title'=>_ROOMS_COUNT, 'type'=>'textbox',  'width'=>'50px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'default'=>'0', 'validation_type'=>'numeric|positive'),
				'beds'           => array('title'=>_BEDS, 'type'=>'enum', 'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrBeds, 'default_option'=>false, 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'bathrooms'      => array('title'=>_BATHROOMS, 'type'=>'enum', 'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$this->arrBathrooms, 'default_option'=>false, 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'dropdownlist', 'multi_select'=>false),
				'room_area'      => array('title'=>_ROOM_AREA, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'5', 'default'=>'0', 'validation_type'=>'float|positive', 'validation_maximum'=>'999', 'post_html'=>' m<sup>2</sup>'),
				'default_price'  => array('title'=>_DEFAULT_PRICE_LIMITED_OFFER, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
				'default_price_flexible_offer'  => array('title'=>_DEFAULT_PRICE_FlEXIBLE_OFFER, 'type'=>'textbox',  'width'=>'80px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
				'additional_guest_fee' => array('title'=>_ADDITIONAL_GUEST_FEE, 'type'=>'textbox',  'width'=>'60px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'10', 'default'=>'0', 'validation_type'=>'float|positive', 'pre_html'=>$default_currency.' '),
				'priority_order' => array('title'=>_ORDER, 'type'=>'textbox',  'width'=>'35px', 'required'=>true, 'readonly'=>false, 'maxlength'=>'3', 'default'=>'0', 'validation_type'=>'numeric|positive'),
				'is_active'      => array('title'=>_ACTIVE, 'type'=>'checkbox', 'readonly'=>false, 'default'=>'1', 'true_value'=>'1', 'false_value'=>'0'),
			),
			'separator_2'   =>array(
				'separator_info' => array('legend'=>_ROOM_FACILITIES),
				'facilities'     => array('title'=>_FACILITIES, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$arr_facilities, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true),
			),
			'separator_3'   =>array(
				'separator_info' => array('legend'=>_IMAGES, 'columns'=>'2'),
				'room_icon'      => array('title'=>_ICON_IMAGE, 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'icon_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_icon_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'500k'),
				'room_picture_1' => array('title'=>_IMAGE.' 1', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view1_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_1_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_2' => array('title'=>_IMAGE.' 2', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view2_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_2_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_3' => array('title'=>_IMAGE.' 3', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view3_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_3_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_4' => array('title'=>_IMAGE.' 4', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view4_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_4_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
				'room_picture_5' => array('title'=>_IMAGE.' 5', 'type'=>'image', 'width'=>'210px', 'required'=>false, 'target'=>'images/rooms_icons/', 'no_image'=>'', 'random_name'=>$random_name, 'image_name_pefix'=>$image_prefix.'view5_', 'thumbnail_create'=>true, 'thumbnail_field'=>'room_picture_5_thumb', 'thumbnail_width'=>'190px', 'thumbnail_height'=>'', 'file_maxsize'=>'900k'),
			)
		);

		//---------------------------------------------------------------------- 
		// DETAILS MODE
		//----------------------------------------------------------------------
		$this->DETAILS_MODE_SQL = $this->EDIT_MODE_SQL;
		$this->arrDetailsModeFields = array(
			'separator_1'   =>array(
				'separator_info' => array('legend'=>_ROOM_DETAILS),
				'hotel_id'       => array('title'=>_HOTEL, 'type'=>'enum', 'source'=>$arr_hotels),
				'room_type'  	 => array('title'=>_TYPE, 'type'=>'label'),
				'max_adults' 	 => array('title'=>_MAX_ADULTS, 'type'=>'label'),
				'max_children' 	 => array('title'=>_MAX_CHILDREN, 'type'=>'label', 'visible'=>(($allow_children == 'yes') ? true : false)),
				'max_guests' 	 => array('title'=>_MAX_GUESTS, 'type'=>'label', 'visible'=>(($allow_guests == 'yes') ? true : false)),				
				'room_count'     => array('title'=>_ROOMS_COUNT, 'type'=>'label'),
				'beds'           => array('title'=>_BEDS, 'type'=>'label'),
				'bathrooms'      => array('title'=>_BATHROOMS, 'type'=>'label'),
				'room_area'      => array('title'=>_ROOM_AREA, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2', 'post_html'=>' m<sup>2</sup>'),
				'default_price'  => array('title'=>_DEFAULT_PRICE_LIMITED_OFFER, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2', 'pre_html'=>$default_currency),
				'default_price_flexible_offer'  => array('title'=>_DEFAULT_PRICE_FlEXIBLE_OFFER, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2', 'pre_html'=>$default_currency),
				'additional_guest_fee'  => array('title'=>_ADDITIONAL_GUEST_FEE, 'type'=>'label', 'format'=>'currency', 'format_parameter'=>$this->currencyFormat.'|2', 'pre_html'=>$default_currency),
				'priority_order' => array('title'=>_ORDER, 'type'=>'label'),
				'is_active'      => array('title'=>_ACTIVE, 'type'=>'enum', 'source'=>$arr_is_active),
			),
			'separator_2'   =>array(
				'separator_info' => array('legend'=>_ROOM_FACILITIES),
				'facilities'     => array('title'=>_FACILITIES, 'type'=>'enum',  'width'=>'', 'required'=>false, 'readonly'=>false, 'default'=>'', 'source'=>$arr_facilities, 'default_option'=>'', 'unique'=>false, 'javascript_event'=>'', 'view_type'=>'checkboxes', 'multi_select'=>true),
			),
			'separator_3'   =>array(
				'separator_info' => array('legend'=>_IMAGES, 'columns'=>'2'),
				'room_icon'      => array('title'=>_ICON_IMAGE, 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
				'room_picture_1' => array('title'=>_IMAGE.' 1', 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
				'room_picture_2' => array('title'=>_IMAGE.' 2', 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
				'room_picture_3' => array('title'=>_IMAGE.' 3', 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
				'room_picture_4' => array('title'=>_IMAGE.' 4', 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
				'room_picture_5' => array('title'=>_IMAGE.' 5', 'type'=>'image', 'target'=>'images/rooms_icons/', 'no_image'=>'no_image.png'),
			)
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
	 *	Draws room availabilities form
	 *		@param $rid
	 */
	public function DrawRoomAvailabilitiesForm($rid)
	{
		global $objSettings;
		
		$nl = "\n";

		$sql = 'SELECT *
				FROM '.TABLE_ROOMS.'
				WHERE id = '.(int)$rid.'
				'.(!empty($this->hotelsList) ? ' AND '.TABLE_ROOMS.'.hotel_id IN ('.$this->hotelsList.')' : '');
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room[1] == 0){
			draw_important_message(_WRONG_PARAMETER_PASSED);
			return false;
		}

		$lang['weeks'][0] = (defined('_SU')) ? _SU : 'Su';
		$lang['weeks'][1] = (defined('_MO')) ? _MO : 'Mo';
		$lang['weeks'][2] = (defined('_TU')) ? _TU : 'Tu';
		$lang['weeks'][3] = (defined('_WE')) ? _WE : 'We';
		$lang['weeks'][4] = (defined('_TH')) ? _TH : 'Th';
		$lang['weeks'][5] = (defined('_FR')) ? _FR : 'Fr';
		$lang['weeks'][6] = (defined('_SA')) ? _SA : 'Sa';

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

		$room_type 	   = isset($_REQUEST['room_type']) ? prepare_input($_REQUEST['room_type']) : '';
		$from_new 	   = isset($_POST['from_new']) ? prepare_input($_POST['from_new']) : '';
		$to_new 	   = isset($_POST['to_new']) ? prepare_input($_POST['to_new']) : '';
		$year 	       = isset($_REQUEST['year']) ? prepare_input($_REQUEST['year']) : 'current';
		$ids_list 	   = '';
		$max_days 	   = 0;
		$output        = '';
		$output_week_days = '';		
		$current_month = date('m');
		$current_year  = date('Y');		
		$selected_year  = ($year == 'next') ? $current_year+1 : $current_year;

		$room_info = $this->GetInfoByID($rid);
		$room_count = isset($room_info['room_count']) ? $room_info['room_count'] : '0';
		
		$output .= '<script type="text/javascript">
			function submitAvailabilityForm(task){
				if(task == "refresh"){
					document.getElementById("task").value = task;
					document.getElementById("frmRoomAvailability").submit();				
				}else if(task == "delete"){
					if(confirm("'._DELETE_WARNING_COMMON.'")){
						document.getElementById("task").value = task;
						document.getElementById("frmRoomAvailability").submit();
					}				
				}else if((task == "update") || (task == "add_new")){
					document.getElementById("task").value = task;
					document.getElementById("frmRoomAvailability").submit();
				}
			}
			function toggleAvailability(selection_type, rid){				
				var selection_type = (selection_type == 1) ? true : false;
				var room_count = "'.$room_count.'";
				for(i=1; i<=31; i++){
					if(document.getElementById("aval_"+rid+"_"+i))
					   document.getElementById("aval_"+rid+"_"+i).value = (selection_type) ? room_count : "0";
				}
			}
		</script>'.$nl;

		$output .= '<form action="index.php?admin=mod_room_availability" id="frmRoomAvailability" method="post">';
		$output .= draw_hidden_field('task', 'update', false, 'task');
		$output .= draw_hidden_field('rid', $rid, false, 'rid');
		$output .= draw_hidden_field('year', $year, false, 'year');
		$output .= draw_hidden_field('room_type', $room_type, false, 'room_type');
		$output .= draw_token_field(false);
		
		$output .= '<table cellpadding="0" cellspacing="0" border="0" width="100%">';
		$output .= '<tr>';
		$output .= '<td align="left" colspan="27">
						<span class="gray">'.str_replace('_MAX_', $room_count, _AVAILABILITY_ROOMS_NOTE).'</span>						
					</td>
					<td align="right" colspan="5">
						<input type="button" class="form_button" style="width:100px" onclick="javascript:submitAvailabilityForm(\'refresh\')" value="'._REFRESH.'">
					</td>
					<td></td>
					<td align="right" colspan="6">
						<input type="button" class="form_button" style="width:130px" onclick="javascript:submitAvailabilityForm(\'update\')" value="'._BUTTON_SAVE_CHANGES.'">
					</td>';
		$output .= '</tr>';
		$output .= '<tr><td colspan="39">&nbsp;</td></tr>';

		$count = 0;
		$week_day = date('w', mktime('0', '0', '0', '1', '1', $selected_year));
		// fill empty cells from the beginning of month line
		while($count < $week_day){
			$td_class = (($count == 0 || $count == 6) ? 'day_td_w' : '');	// 0 - 'Sun', 6 - 'Sat'
			$output_week_days .= '<td class="'.$td_class.'">'.$lang['weeks'][$count].'</td>';
			$count++;
		}
		// fill cells at the middle
		for($day = 1; $day <= 31; $day ++){
			$week_day = date('w', mktime('0', '0', '0', '1', $day, $selected_year));			
			$td_class = (($week_day == 0 || $week_day == 6) ? 'day_td_w' : '');	// 0 - 'Sun', 6 - 'Sat'
			$output_week_days .= '<td class="'.$td_class.'">'.$lang['weeks'][$week_day].'</td>';
		}
		$max_days = $count + 31;
		// fill empty cells at the end of month line 
		if($max_days < 37){
			$count=0;
			while($count < (37-$max_days)){
				$week_day++;
				$count++;				
				$week_day_mod = $week_day % 7;
				$td_class = (($week_day_mod == 0 || $week_day_mod == 6) ? 'day_td_w' : '');	// 0 - 'Sun', 6 - 'Sat'
				$output_week_days .= '<td class="'.$td_class.'">'.$lang['weeks'][$week_day_mod].'</td>';							
			}
			$max_days += $count;
		}		

		// draw week days
		$output .= '<tr style="text-align:center;background-color:#cccccc;">';
		$output .= '<td style="text-align:left;background-color:#ffffff;">';
		$output .= '<select name="selYear" onchange="javascript:appGoTo(\'admin=mod_room_availability\',\'&rid='.$rid.'&year=\'+this.value)">';
		$output .= '<option value="current" '.(($year == 'current') ? 'selected="selected"' : '').'>'.$current_year.'</option>';
		$output .= '<option value="next" '.(($year == 'next') ? 'selected="selected"' : '').'>'.($current_year+1).'</option>';
		$output .= '</select>';
		$output .= '</td>';		
		$output .= '<td align="center" style="padding:0px 4px;background-color:#ffffff;"><img src="images/check_all.gif" alt="" /></td>';
		$output .= $output_week_days;
		$output .= '</tr>';		

		$sql = 'SELECT * FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE room_id = '.(int)$rid.' AND y = '.(($selected_year == $current_year) ? '0' : '1').' ORDER BY m ASC';
		$room = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		for($i=0; $i < $room[1]; $i++){
			$selected_month = $room[0][$i]['m'];
			if($selected_month == $current_month) $tr_class = 'm_current';
			else $tr_class = (($i%2==0) ? 'm_odd' : 'm_even'); 
			
			$output .= '<tr align="center" class="'.$tr_class.'">';			
			$output .= '<td align="left">&nbsp;<b>'.$lang['months'][$selected_month].'</b></td>';
			$output .= '<td><input type="checkbox" class="form_checkbox" onclick="toggleAvailability(this.checked,\''.$room[0][$i]['id'].'\')" /></td>';
			$max_day = $this->GetMonthMaxDay($selected_year, $selected_month);

			// fill empty cells from the beginning of month line
			$count = date('w', mktime('0', '0', '0', $selected_month, 1, $selected_year));
			$max_days -= $count; /* subtract days that were missed from the beginning of the month */
			while($count--) $output .= '<td></td>';
			// fill cells at the middle
			for($day = 1; $day <= $max_day; $day ++){
				if($room[0][$i]['d'.$day] >= $room_count){
					$day_color = 'dc_all';
				}else if($room[0][$i]['d'.$day] > 0 && $room[0][$i]['d'.$day] < $room_count){
					$day_color = 'dc_part';
				}else{
					$day_color = 'dc_none';
				}
				$week_day = date('w', mktime('0', '0', '0', $selected_month, $day, $selected_year));
				$td_class = (($week_day == 0 || $week_day == 6) ? 'day_td_w' : 'day_td'); // 0 - 'Sun', 6 - 'Sat'				
				$output .= '<td class="'.$td_class.'"><label class="l_day">'.$day.'</label><br><input class="day_a '.$day_color.'" maxlength="3" name="aval_'.$room[0][$i]['id'].'_'.$day.'" id="aval_'.$room[0][$i]['id'].'_'.$day.'" value="'.$room[0][$i]['d'.$day].'" /></td>';
			}
			// fill empty cells at the end of the month line 
			while($day <= $max_days){
				$output .= '<td></td>';
				$day++;
			}
			$output .= '</tr>';
			if($ids_list != '') $ids_list .= ','.$room[0][$i]['id'];
			else $ids_list = $room[0][$i]['id'];
		}
		
		$output .= '<tr><td colspan="39">&nbsp;</td></tr>';
		$output .= '<tr><td align="'.Application::Get('defined_right').'" colspan="39"><input type="button" class="form_button" style="width:130px" onclick="javascript:submitAvailabilityForm(\'update\')" value="'._BUTTON_SAVE_CHANGES.'"></td></tr>';
		$output .= '<tr><td colspan="39"><b>'._LEGEND.':</b> </td></tr>';
		$output .= '<tr><td colspan="39" nowrap="nowrap" height="5px"></td></tr>';
		$output .= '<tr><td colspan="39"><div class="dc_all" style="width:16px;height:15px;float:'.Application::Get('defined_left').';margin:1px;"></div> &nbsp;- '._ALL_AVAILABLE.'</td></tr>';
		$output .= '<tr><td colspan="39"><div class="dc_part" style="width:16px;height:15px;float:'.Application::Get('defined_left').';margin:1px;"></div> &nbsp;- '._PARTIALLY_AVAILABLE.'</td></tr>';
		$output .= '<tr><td colspan="39"><div class="dc_none" style="width:16px;height:15px;float:'.Application::Get('defined_left').';margin:1px;"></div> &nbsp;- '._NO_AVAILABLE.'</td></tr>';
		$output .= '</table>';
		$output .= draw_hidden_field('ids_list', $ids_list, false);
		$output .= '</form>';
	
		echo $output;		
	}

	/**
	 *	Draws room prices form
	 *		@param $rid
	 */
	public function DrawRoomPricesForm($rid)
	{		
		global $objSettings;

        $nl = "\n";
		$default_price = '0';
		$output = '';

		$sql = 'SELECT *
				FROM '.TABLE_ROOMS.'
				WHERE id = '.(int)$rid.'
				'.(!empty($this->hotelsList) ? ' AND '.TABLE_ROOMS.'.hotel_id IN ('.$this->hotelsList.')' : '');
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

		if($room[1] > 0){
			$default_price = $room[0]['default_price'];
			$max_adults = $room[0]['max_adults'];
			$max_children = $room[0]['max_children'];
			$max_guests = $room[0]['max_guests'];
			$guest_fee = $room[0]['additional_guest_fee'];
		}else{
			draw_important_message(_WRONG_PARAMETER_PASSED);
			return false;
		}

		$default_currency_info = Currencies::GetDefaultCurrencyInfo();
		if($default_currency_info['symbol_placement'] == 'left'){
			$currency_l_sign = $default_currency_info['symbol'];
			$currency_r_sign = '';
		}else{
			$currency_l_sign = '';
			$currency_r_sign = $default_currency_info['symbol'];			
		}
		
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$calendar_date_format = '%m-%d-%Y';
			$field_date_format = 'M d, Y';
		}else{
			$calendar_date_format = '%d-%m-%Y';
			$field_date_format = 'd M, Y';
		}

		$room_type 	   = isset($_REQUEST['room_type']) ? prepare_input($_REQUEST['room_type']) : '';
		$from_new 	   = isset($_POST['from_new']) ? prepare_input($_POST['from_new']) : '';
		$to_new 	   = isset($_POST['to_new']) ? prepare_input($_POST['to_new']) : '';		
		$adults_new    = isset($_POST['adults_new']) ? prepare_input($_POST['adults_new']) : $max_adults;
		$children_new  = isset($_POST['children_new']) ? prepare_input($_POST['children_new']) : $max_children;
		$guest_fee_new = isset($_POST['guest_fee_new']) ? prepare_input($_POST['guest_fee_new']) : $guest_fee;
		$price_new_mon = isset($_POST['price_new_mon']) ? prepare_input($_POST['price_new_mon']) : $default_price;
		$price_new_tue = isset($_POST['price_new_tue']) ? prepare_input($_POST['price_new_tue']) : $default_price;
		$price_new_wed = isset($_POST['price_new_wed']) ? prepare_input($_POST['price_new_wed']) : $default_price;
		$price_new_thu = isset($_POST['price_new_thu']) ? prepare_input($_POST['price_new_thu']) : $default_price;
		$price_new_fri = isset($_POST['price_new_fri']) ? prepare_input($_POST['price_new_fri']) : $default_price;
		$price_new_sat = isset($_POST['price_new_sat']) ? prepare_input($_POST['price_new_sat']) : $default_price;
		$price_new_sun = isset($_POST['price_new_sun']) ? prepare_input($_POST['price_new_sun']) : $default_price;

		$adults_new_2    = isset($_POST['adults_new_2']) ? prepare_input($_POST['adults_new_2']) : $max_adults;
		$children_new_2  = isset($_POST['children_new_2']) ? prepare_input($_POST['children_new_2']) : $max_children;
		$guest_fee_new_2 = isset($_POST['guest_fee_new_2']) ? prepare_input($_POST['guest_fee_new_2']) : $guest_fee;
		$price_new_mon_2 = isset($_POST['price_new_mon_2']) ? prepare_input($_POST['price_new_mon_2']) : $default_price;
		$price_new_tue_2 = isset($_POST['price_new_tue_2']) ? prepare_input($_POST['price_new_tue_2']) : $default_price;
		$price_new_wed_2 = isset($_POST['price_new_wed_2']) ? prepare_input($_POST['price_new_wed_2']) : $default_price;
		$price_new_thu_2 = isset($_POST['price_new_thu_2']) ? prepare_input($_POST['price_new_thu_2']) : $default_price;
		$price_new_fri_2 = isset($_POST['price_new_fri_2']) ? prepare_input($_POST['price_new_fri_2']) : $default_price;
		$price_new_sat_2 = isset($_POST['price_new_sat_2']) ? prepare_input($_POST['price_new_sat_2']) : $default_price;
		$price_new_sun_2 = isset($_POST['price_new_sun_2']) ? prepare_input($_POST['price_new_sun_2']) : $default_price;

		$ids_list 	   = '';
		$width         = '53px';
		$text_align    = (Application::Get('defined_alignment') == 'left') ? 'right' : 'left';

		$output .= '<link type="text/css" rel="stylesheet" href="modules/jscalendar/skins/aqua/theme.css" />'.$nl;
		$output .= '<script type="text/javascript">
			function submitPriceForm(task, rpid){
				if(task == "refresh"){
					document.getElementById("task").value = task;
					document.getElementById("frmRoomPrices").submit();				
				}else if(task == "delete"){
					if(confirm("'._DELETE_WARNING_COMMON.'")){
						document.getElementById("task").value = task;
						document.getElementById("rpid").value = rpid;
						document.getElementById("frmRoomPrices").submit();
					}				
				}else if((task == "update") || (task == "add_new")){
					document.getElementById("task").value = task;
					document.getElementById("frmRoomPrices").submit();
				}				
			}
		</script>'.$nl;
		$output .= '<script type="text/javascript" src="modules/jscalendar/calendar.js"></script>'.$nl;
		$output .= '<script type="text/javascript" src="modules/jscalendar/lang/calendar-'.((file_exists('modules/jscalendar/lang/calendar-'.Application::Get('lang').'.js')) ? Application::Get('lang') : 'en').'.js"></script>'.$nl;
		$output .= '<script type="text/javascript" src="modules/jscalendar/calendar-setup.js"></script>'.$nl;
		
		$output .= '<form action="index.php?admin=mod_room_prices" id="frmRoomPrices" method="post">';
		$output .= draw_hidden_field('task', 'update', false, 'task');
		$output .= draw_hidden_field('rid', $rid, false, 'rid');
		$output .= draw_hidden_field('rpid', '', false, 'rpid');
        $output .= draw_hidden_field('room_type', $room_type, false, 'room_type');
		$output .= draw_token_field(false);
		
		$output .= '<table width="98%" border="0" cellpadding="1" cellspacing="0">';
		$output .= '<tr style="text-align:center;font-weight:bold;">';
		$output .= '  <td></td>';
		$output .= '  <td align="left"><input type="button" class="form_button" style="width:100px" onclick="javascript:submitPriceForm(\'refresh\')" value="'._REFRESH.'"></td>';
		$output .= '  <td colspan="12"></td>';
		$output .= '</tr>';
		$output .= '<tr style="text-align:center;font-weight:bold;">';
		$output .= '  <td width="5px"></td>';
		$output .= '  <td colspan="3"></td>';
        $output .= '  <td width="20px">' . _PRICE_TYPE . '</td>';
		$output .= '  <td>'._ADULTS.' | '._CHILDREN.' | '._GUEST_FEE.'</td>';
		$output .= '  <td width="10px"></td>';
		$output .= '  <td>'._MON.'</td>';
		$output .= '  <td>'._TUE.'</td>';
		$output .= '  <td>'._WED.'</td>';
		$output .= '  <td>'._THU.'</td>';
		$output .= '  <td>'._FRI.'</td>';
		$output .= '  <td style="background-color:#ffcc33;">'._SAT.'</td>';
		$output .= '  <td style="background-color:#ffcc33;">'._SUN.'</td>';
		$output .= '  <td></td>';
		$output .= '</tr>';

		$sql = 'SELECT rpr.`id` id,
                          `room_id`,
                          `date_from`,
                          `date_to`,
                          `adults`,
                          `children`,
                          `guest_fee`,
                          `mon`,
                          `tue`,
                          `wed`,
                          `thu`,
                          `fri`,
                          `sat`,
                          `sun`,
                          `is_default`,
                          rprext.`id` rooms_prices_extend_id,
                          `rooms_prices_id`,
                          `price_type`,
                          `terms`
				FROM '.TABLE_ROOMS_PRICES.' rpr LEFT JOIN ' . TABLE_ROOMS_PRICES_EXTEND . ' rprext ON rpr.id = rprext.rooms_prices_id
				WHERE rpr.room_id = '.(int)$rid.'
				ORDER BY rpr.is_default DESC, rpr.date_from ASC';

		$room = database_query($sql, DATA_AND_ROWS, ALL_ROWS);

		for($i=0; $i < $room[1]; $i++){
			$output .= '<tr align="center" style="'.(($i%2==0) ? '' : 'background-color:#f1f2f3;').'">';

			$output .= '  <td></td>';

			if ($room[0][$i]['is_default'] == 1) {//if($i == 0 || $i == 1){
				$output .= '  <td align="left" nowrap="nowrap" colspan="3"><b>'._STANDARD_PRICE.'</b></td>';
                $output .= '  <td align="left"><select name="price_type_' . $room[0][$i]['id'] . '" id="price_type_' . $room[0][$i]['id'] . '" disabled><option value="1" ' . ($room[0][$i]['price_type'] == 1 ? ' selected' : '') . '>' . _LIMITED_OFFER . '</option><option value="2" ' . ($room[0][$i]['price_type'] == 2 ? ' selected' : '') . '>' . _FLEXIBLE_OFFER . '</option></select>' . draw_hidden_field('rooms_prices_extend_id_' . $room[0][$i]['id'], $room[0][$i]['rooms_prices_extend_id'], false, 'rooms_prices_extend_id_' . $room[0][$i]['id']) . '</td>';
				$output .= '  <td>';
				$output .= '  &nbsp;'.draw_numbers_select_field('adults_'.$room[0][$i]['id'], $max_adults, 1, $max_adults, 1, '', 'disabled', false);
				$output .= '  &nbsp;'.draw_numbers_select_field('children_'.$room[0][$i]['id'], $max_children, 0, $max_children, 1, '', 'disabled', false);
				$output .= '  &nbsp;'.$currency_l_sign.' <input type="text" maxlength="7" name="guest_fee_'.$room[0][$i]['id'].'" value="'.(isset($_POST['guest_fee_'.$room[0][$i]['id']]) ? prepare_input($_POST['guest_fee_'.$room[0][$i]['id']]) : $room[0][$i]['guest_fee']).'" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'"> '.$currency_r_sign;
				$output .= '  </td>';
			}else{
				$output .= '  <td align="left" nowrap="nowrap"><input type="text" readonly="readonly" name="date_from_'.$room[0][$i]['id'].'" style="width:85px;border:0px;'.(($i%2==0) ? '' : 'background-color:#f1f2f3;').'" value="'.format_datetime($room[0][$i]['date_from'], $field_date_format).'" /></td>';
				$output .= '  <td align="left" nowrap="nowrap">-</td>';
				$output .= '  <td align="left" nowrap="nowrap"><input type="text" readonly="readonly" name="date_to_'.$room[0][$i]['id'].'" style="width:85px;border:0px;'.(($i%2==0) ? '' : 'background-color:#f1f2f3;').'" value="'.format_datetime($room[0][$i]['date_to'], $field_date_format).'" /></td>';
                $output .= '  <td align="left"><select name="price_type_' . $room[0][$i]['id'] . '" id="price_type_' . $room[0][$i]['id'] . '" disabled><option value="1" ' . ($room[0][$i]['price_type'] == 1 ? ' selected' : '') . '>' . _LIMITED_OFFER . '</option><option value="2" ' . ($room[0][$i]['price_type'] == 2 ? ' selected' : '') . '>' . _FLEXIBLE_OFFER . '</option></select>' . draw_hidden_field('rooms_prices_extend_id_' . $room[0][$i]['id'], $room[0][$i]['rooms_prices_extend_id'], false, 'rooms_prices_extend_id_' . $room[0][$i]['id']) . '</td>';
				$output .= '  <td>';
				$output .= '  &nbsp;'.draw_numbers_select_field('adults_'.$room[0][$i]['id'], (isset($_POST['adults_'.$room[0][$i]['id']]) ? $_POST['adults_'.$room[0][$i]['id']] : $room[0][$i]['adults']), 1, $max_adults, 1, '', 'disabled', false);
				$output .= '  &nbsp;'.draw_numbers_select_field('children_'.$room[0][$i]['id'], (isset($_POST['children_'.$room[0][$i]['id']]) ? $_POST['children_'.$room[0][$i]['id']] : $room[0][$i]['children']), 0, $max_children, 1, '', 'disabled', false);
				$output .= '  &nbsp;'.$currency_l_sign.' <input type="text" maxlength="7" name="guest_fee_'.$room[0][$i]['id'].'" value="'.(isset($_POST['guest_fee_'.$room[0][$i]['id']]) ? prepare_input($_POST['guest_fee_'.$room[0][$i]['id']]) : $room[0][$i]['guest_fee']).'" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'"> '.$currency_r_sign;
				$output .= '  </td>';
			}

			$output .= '  <td></td>';
			$output .= '  <td nowrap="nowrap">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_mon" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_mon']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_mon']) : $room[0][$i]['mon']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td nowrap="nowrap">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_tue" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_tue']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_tue']) : $room[0][$i]['tue']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td nowrap="nowrap">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_wed" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_wed']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_wed']) : $room[0][$i]['wed']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td nowrap="nowrap">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_thu" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_thu']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_thu']) : $room[0][$i]['thu']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td nowrap="nowrap">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_fri" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_fri']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_fri']) : $room[0][$i]['fri']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td style="background-color:#ffcc33;">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_sat" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_sat']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_sat']) : $room[0][$i]['sat']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td style="background-color:#ffcc33;">'.$currency_l_sign.' <input type="text" name="price_'.$room[0][$i]['id'].'_sun" value="'.(isset($_POST['price_'.$room[0][$i]['id'].'_sun']) ? prepare_input($_POST['price_'.$room[0][$i]['id'].'_sun']) : $room[0][$i]['sun']).'" maxlength="7" style="padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
			$output .= '  <td width="30px" align="center">'.(($room[0][$i]['is_default'] != 1) ? '<img src="images/delete.gif" alt="'._DELETE_WORD.'" title="'._DELETE_WORD.'" style="cursor:pointer;" onclick="javascript:submitPriceForm(\'delete\',\''.$room[0][$i]['id'].'\')" />' : '').'</td>';
			$output .= draw_hidden_field('is_default_' . $room[0][$i]['id'], $room[0][$i]['is_default'], false, 'is_default_' . $room[0][$i]['id']);
			$output .= '</tr>';
			
			if ($ids_list != '') 
				$ids_list .= ','.$room[0][$i]['id'];
			else 
				$ids_list = $room[0][$i]['id'];
		}

		$output .= '<tr><td colspan="11"></td><td colspan="2" style="height:5px;background-color:#ffcc33;"></td><td></td></tr>';
		$output .= '<tr><td colspan="14">&nbsp;</td></tr>';
		$output .= '<tr>';
		$output .= '  <td colspan="9"></td>';
		$output .= '  <td align="center" colspan="2"></td>';
		$output .= '  <td align="center" colspan="2"><input type="button" class="form_button" style="width:130px" onclick="javascript:submitPriceForm(\'update\')" value="'._BUTTON_SAVE_CHANGES.'"></td>';
		$output .= '  <td></td>';
		$output .= '</tr>';
		$output .= '<tr><td colspan="14">&nbsp;</td></tr>';
		$output .= '<tr align="center">';
		$output .= '  <td></td>';
		$output .= '  <td colspan="3" align="right">'._FROM.': <input type="text" id="from_new" name="from_new" style="color:#808080;width:80px" readonly="readonly" value="'.$from_new.'" /><img id="from_new_cal" src="images/cal.gif" alt="" title="'._SET_DATE.'" style="margin-left:5px;margin-right:5px;cursor:pointer;" /><br />'._TO.': <input type="text" id="to_new" name="to_new" style="color:#808080;width:80px" readonly="readonly" value="'.$to_new.'" /><img id="to_new_cal" src="images/cal.gif" alt="" title="'._SET_DATE.'" style="margin-left:5px;margin-right:5px;cursor:pointer;" /></td>';
        $output .= '  <td align="left">' . _LIMITED_OFFER . '<br/>' . _FLEXIBLE_OFFER . '</td>';
        $output .= '  <td>';
		$output .= '  &nbsp;'.draw_numbers_select_field('adults_new', $adults_new, 1, $max_adults, 1, '', '', false);
		$output .= '  &nbsp;'.draw_numbers_select_field('children_new', $children_new, 0, $max_children, 1, '', '', false);
		$output .= '  &nbsp;'.$currency_l_sign.' <input type="text" maxlength="7" name="guest_fee_new" value="'.$guest_fee_new.'" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'"> '.$currency_r_sign;
		$output .= '<br/>&nbsp;' . draw_numbers_select_field('adults_new_2', $adults_new_2, 1, $max_adults, 1, '', '', false);
		$output .= '  &nbsp;' . draw_numbers_select_field('children_new_2', $children_new_2, 0, $max_children, 1, '', '', false);
		$output .= '  &nbsp;' . $currency_l_sign . ' <input type="text" maxlength="7" name="guest_fee_new_2" value="' . $guest_fee_new_2 . '" style="color:#808080;padding:0 2px;text-align:' . $text_align . ';width:' . $width . '"> ' . $currency_r_sign;
		$output .= '  </td>';
		$output .= '  <td></td>';
		$output .= '  <td>'.$currency_l_sign.' <input type="text" name="price_new_mon" value="'.$price_new_mon.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>' . $currency_l_sign . ' <input type="text" name="price_new_mon_2" value="'.$price_new_mon_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td>'.$currency_l_sign.' <input type="text" name="price_new_tue" value="'.$price_new_tue.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>' . $currency_l_sign . ' <input type="text" name="price_new_tue_2" value="'.$price_new_tue_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td>'.$currency_l_sign.' <input type="text" name="price_new_wed" value="'.$price_new_wed.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>'.$currency_l_sign.' <input type="text" name="price_new_wed_2" value="'.$price_new_wed_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td>'.$currency_l_sign.' <input type="text" name="price_new_thu" value="'.$price_new_thu.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>'.$currency_l_sign.' <input type="text" name="price_new_thu_2" value="'.$price_new_thu_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td>'.$currency_l_sign.' <input type="text" name="price_new_fri" value="'.$price_new_fri.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>'.$currency_l_sign.' <input type="text" name="price_new_fri_2" value="'.$price_new_fri_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td style="background-color:#ffcc33;">'.$currency_l_sign.' <input type="text" name="price_new_sat" value="'.$price_new_sat.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>'.$currency_l_sign.' <input type="text" name="price_new_sat_2" value="'.$price_new_sat_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td style="background-color:#ffcc33;">'.$currency_l_sign.' <input type="text" name="price_new_sun" value="'.$price_new_sun.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'<br/>'.$currency_l_sign.' <input type="text" name="price_new_sun_2" value="'.$price_new_sun_2.'" maxlength="7" style="color:#808080;padding:0 2px;text-align:'.$text_align.';width:'.$width.'" /> '.$currency_r_sign.'</td>';
		$output .= '  <td></td>';
		$output .= '</tr>';			

		$output .= '<tr><td colspan="14">&nbsp;</td></tr>';
		$output .= '<tr>';
		$output .= '  <td colspan="11"></td>';
		$output .= '  <td align="center" colspan="2"><input type="button" class="form_button" style="width:130px" onclick="javascript:submitPriceForm(\'add_new\')" value="'._ADD_NEW.'"></td>';
		$output .= '  <td></td>';
		$output .= '</tr>';
		$output .= '</table>';
		$output .= draw_hidden_field('ids_list', $ids_list, false);
		$output .= '</form>';
		
		$output .= '<script type="text/javascript"> 
		Calendar.setup({firstDay : '.($objSettings->GetParameter('week_start_day')-1).', inputField : "from_new", ifFormat : "'.$calendar_date_format.'", showsTime : false, button : "from_new_cal"});
		Calendar.setup({firstDay : '.($objSettings->GetParameter('week_start_day')-1).', inputField : "to_new", ifFormat : "'.$calendar_date_format.'", showsTime : false, button : "to_new_cal"});
		</script>';

		echo $output;
	}

	/**
	 *	Returns a table with prices for certain room
	 *		@param $rid
	 */
	public static function GetRoomPricesTable($rid)
	{		
		global $objSettings, $objLogin;
		
		$currency_rate = ($objLogin->IsLoggedInAsAdmin()) ? '1' : Application::Get('currency_rate');
		$currency_format = get_currency_format();
	
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$calendar_date_format = '%m-%d-%Y';
			$field_date_format = 'M d, Y';
		}else{
			$calendar_date_format = '%d-%m-%Y';
			$field_date_format = 'd M, Y';
		}

		$sql = 'SELECT * FROM '.TABLE_ROOMS.' WHERE id = '.(int)$rid;
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room[1] > 0){
			$default_price = $room[0]['default_price'];
		}else{
			$default_price = '0';
		}

		$output = '<table class="room_prices" border="0" cellpadding="0" cellspacing="0">';
		$output .= '<tr class="header">';
		$output .= '  <th width="5px">&nbsp;</td>';
		$output .= '  <th colspan="3">&nbsp;</td>';
		$output .= '  <th width="10px">&nbsp;'._ADULT.'&nbsp;</td>';
		$output .= '  <th width="10px">&nbsp;'._CHILD.'&nbsp;</td>';
		$output .= '  <th width="10px">&nbsp;'._GUEST.'&nbsp;</td>';
		//$output .= '  <th width="10px">&nbsp;</td>';
		$output .= '  <th>'._MON.'</td>';
		$output .= '  <th>'._TUE.'</td>';
		$output .= '  <th>'._WED.'</td>';
		$output .= '  <th>'._THU.'</td>';
		$output .= '  <th>'._FRI.'</td>';
		$output .= '  <th>'._SAT.'</td>';
		$output .= '  <th>'._SUN.'</td>';
		$output .= '</tr>';

		$sql = 'SELECT * FROM '.TABLE_ROOMS_PRICES.'
				WHERE
					room_id = '.(int)$rid.' AND
					(
						is_default = 1 OR
						(is_default = 0 AND date_from >= \''.date('Y').'-01-01\') OR
						(is_default = 0 AND date_to >= \''.date('Y').'-01-01\')
					)
				ORDER BY is_default DESC, date_from ASC';
		$room = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		//$output .= '<tr><td colspan="15" nowrap="nowrap" height="5px"></td></tr>';
		for($i=0; $i < $room[1]; $i++){
			$output .= '<tr align="'.Application::Get('defined_right').'">';
			$output .= '  <td></td>';
			if($i == 0){
				$output .= '  <td align="left" nowrap="nowrap" colspan="3"><b>'._STANDARD_PRICE.'</b></td>';	
			}else{
				$output .= '  <td align="left" nowrap="nowrap">'.format_datetime($room[0][$i]['date_from'], $field_date_format).'</td>';
				$output .= '  <td align="left" nowrap="nowrap" width="20px">-</td>';
				$output .= '  <td align="left" nowrap="nowrap">'.format_datetime($room[0][$i]['date_to'], $field_date_format).'</td>';	
			}
			$curr_rate = !$objLogin->IsLoggedInAsAdmin() ? $currency_rate : 1;
							  
			$output .= '  <td align="center">'.$room[0][$i]['adults'].'</td>';
			$output .= '  <td align="center">'.$room[0][$i]['children'].'</td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['guest_fee'] / $curr_rate, '', '', $currency_format).'</span></td>';
			//$output .= '  <td></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['mon'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['tue'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['wed'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['thu'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['fri'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['sat'] / $curr_rate, '', '', $currency_format).'</span></td>';
			$output .= '  <td><span>'.Currencies::PriceFormat($room[0][$i]['sun'] / $curr_rate, '', '', $currency_format).'</span>&nbsp;</td>';
			$output .= '</tr>';
		}		
		//$output .= '<tr><td colspan="15" nowrap="nowrap" height="5px"></td></tr>';
		$output .= '</table>';

		return $output;
	}
        
        /**
	 *	Returns a table with prices vertical for certain room 
	 *		@param $rid
	 */
	public static function GetRoomPricesTableVertical($rid)
	{		
		global $objSettings, $objLogin;
		
		$currency_rate = ($objLogin->IsLoggedInAsAdmin()) ? '1' : Application::Get('currency_rate');
		$currency_format = get_currency_format();
	
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$calendar_date_format = '%m-%d-%Y';
			$field_date_format = 'M d, Y';
		}else{
			$calendar_date_format = '%d-%m-%Y';
			$field_date_format = 'd M, Y';
		}

		$sql = 'SELECT * FROM '.TABLE_ROOMS.' WHERE id = '.(int)$rid;
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room[1] > 0){
			$default_price = $room[0]['default_price'];
		}else{
			$default_price = '0';
		}

		$sql = 'SELECT * FROM '.TABLE_ROOMS_PRICES.'
				WHERE
					room_id = '.(int)$rid.' AND
					(
						is_default = 1 OR
						(is_default = 0 AND date_from >= \''.date('Y').'-01-01\') OR
						(is_default = 0 AND date_to >= \''.date('Y').'-01-01\')
					)
				ORDER BY is_default DESC, date_from ASC';
		$room = database_query($sql, DATA_AND_ROWS, ALL_ROWS);

		$output = '<div class="room_prices">';
		
		if ($room[1] == 0)
                $output .= '  <div class="left">';
		else
			    $output .= '  <div class="left col-1-3">';
                    $output .= '  <div>&nbsp;</div>';
                    $output .= '  <div>'._ADULT.'&nbsp;</div>';
                    $output .= '  <div>'._CHILD.'&nbsp;</div>';
                    $output .= '  <div>'._GUEST.'&nbsp;</div>';
                    //$output .= '  <th width="10px">&nbsp;</td>';
                    $output .= '  <div>'._MON.'</div>';
                    $output .= '  <div>'._TUE.'</div>';
                    $output .= '  <div>'._WED.'</div>';
                    $output .= '  <div>'._THU.'</div>';
                    $output .= '  <div>'._FRI.'</div>';
                    $output .= '  <div>'._SAT.'</div>';
                    $output .= '  <div>'._SUN.'</div>';
		$output .= '</div>';

		//$output .= '<tr><td colspan="15" nowrap="nowrap" height="5px"></td></tr>';
		for($i=0; $i < $room[1]; $i++){
			$output .= '<div class="right col-1-3">';
			
			if($i == 0){
				$output .= '  <div><b>'._STANDARD_PRICE.'</b></div>';	
			}else{
				$output .= '  <div>'.format_datetime($room[0][$i]['date_from'], $field_date_format);
				$output .= ' - '.format_datetime($room[0][$i]['date_to'], $field_date_format).'</div>';	
			}
			$curr_rate = !$objLogin->IsLoggedInAsAdmin() ? $currency_rate : 1;
							  
			$output .= '  <div>'.$room[0][$i]['adults'].'</div>';
			$output .= '  <div>'.$room[0][$i]['children'].'</div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['guest_fee'] / $curr_rate, '', '', $currency_format).'</span></div>';
			//$output .= '  <td></td>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['mon'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['tue'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['wed'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['thu'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['fri'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['sat'] / $curr_rate, '', '', $currency_format).'</span></div>';
			$output .= '  <div><span>'.Currencies::PriceFormat($room[0][$i]['sun'] / $curr_rate, '', '', $currency_format).'</span>&nbsp;</div>';
			$output .= '</div>';
		}				
                $output .= '</div>';
                $output .= '<div class="clear"></div>';

		return $output;
	}
	
    /**
	 * Deletes room availability
	 * 		@param $rid
	 */
	public function DeleteRoomAvailability($rpid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'DELETE FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE id = '.(int)$rpid;
		if(!database_void_query($sql)){
			$this->error = _TRY_LATER;
			return false;
		}
		return true;
	}

    /**
	 * Deletes room prices
	 * 		@param $rpid
	 */
	public function DeleteRoomPrices($rpid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$sql = 'DELETE FROM '.TABLE_ROOMS_PRICES.' WHERE id = '.(int)$rpid;

		if(!database_void_query($sql)){
			$this->error = _TRY_LATER;
			return false;
		}

		$sql = 'DELETE FROM ' . TABLE_ROOMS_PRICES_EXTEND . ' 
				WHERE rooms_prices_id NOT IN (SELECT id FROM ' . TABLE_ROOMS_PRICES . ')';
		database_void_query($sql);
		
		return true;
	}
	
    /**
	 * Adds room availability
	 * 		@param $rid
	 */
	public function AddRoomAvailability($rid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		global $objSettings;

		$task 	  = isset($_POST['task']) ? prepare_input($_POST['task']) : '';
		$from_new = isset($_POST['from_new']) ? prepare_input($_POST['from_new']) : '';
		$to_new   = isset($_POST['to_new']) ? prepare_input( $_POST['to_new']) : '';		
		$aval_mon = isset($_POST['aval_new_mon']) ? '1' : '0';
		$aval_tue = isset($_POST['aval_new_tue']) ? '1' : '0';
		$aval_wed = isset($_POST['aval_new_wed']) ? '1' : '0';
		$aval_thu = isset($_POST['aval_new_thu']) ? '1' : '0';
		$aval_fri = isset($_POST['aval_new_fri']) ? '1' : '0';
		$aval_sat = isset($_POST['aval_new_sat']) ? '1' : '0';
		$aval_sun = isset($_POST['aval_new_sun']) ? '1' : '0';
	
				
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$from_new = substr($from_new, 6, 4).'-'.substr($from_new, 0, 2).'-'.substr($from_new, 3, 2);
			$to_new = substr($to_new, 6, 4).'-'.substr($to_new, 0, 2).'-'.substr($to_new, 3, 2);
		}else{
			// dd/mm/yyyy
			$from_new = substr($from_new, 6, 4).'-'.substr($from_new, 3, 2).'-'.substr($from_new, 0, 2);
			$to_new = substr($to_new, 6, 4).'-'.substr($to_new, 3, 2).'-'.substr($to_new, 0, 2);
		}

		if($from_new == '--' || $to_new == '--'){
			$this->error = _DATE_EMPTY_ALERT;
			return false;
		}else if($from_new > $to_new){
			$this->error = _FROM_TO_DATE_ALERT;
			return false;			
		}else{
			$sql = 'SELECT * FROM '.TABLE_ROOMS_AVAILABILITIES.'
					WHERE
						room_id = '.(int)$rid.' AND
						is_default = 0 AND 
						(((\''.$from_new.'\' >= date_from) AND (\''.$from_new.'\' <= date_to)) OR
						((\''.$to_new.'\' >= date_from) AND (\''.$to_new.'\' <= date_to))) ';	
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] > 0){
				$this->error = _TIME_PERIOD_OVERLAPPING_ALERT;
				return false;
			}
		}

		if($from_new != '' && $to_new != ''){
			$sql = 'INSERT INTO '.TABLE_ROOMS_AVAILABILITIES.' (id, room_id, date_from, date_to, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, '.(int)$rid.', \''.$from_new.'\', \''.$to_new.'\', '.$aval_mon.', '.$aval_tue.', '.$aval_wed.', '.$aval_thu.', '.$aval_fri.', '.$aval_sat.', '.$aval_sun.', 0)';
			if(database_void_query($sql)){
				unset($_POST);
				return true;
			}else{
				$this->error = _TRY_LATER;
				return false;
			}
		}
	}

    /**
	 * Adds room prices
	 * 		@param $rid
	 */
	public function AddRoomPrices($rid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		global $objSettings;
		
		$task 	       = isset($_POST['task']) ? prepare_input($_POST['task']) : '';
		$from_new 	   = isset($_POST['from_new']) ? prepare_input($_POST['from_new']) : '';
		$to_new 	   = isset($_POST['to_new']) ? prepare_input($_POST['to_new']) : '';		
		$adults_new    = isset($_POST['adults_new']) ? prepare_input($_POST['adults_new']) : '1';
		$children_new  = isset($_POST['children_new']) ? prepare_input($_POST['children_new']) : '0';
		$guest_fee_new = isset($_POST['guest_fee_new']) ? prepare_input($_POST['guest_fee_new']) : '0';
		$price_new_mon = isset($_POST['price_new_mon']) ? prepare_input($_POST['price_new_mon']) : '';
		$price_new_tue = isset($_POST['price_new_tue']) ? prepare_input($_POST['price_new_tue']) : '';
		$price_new_wed = isset($_POST['price_new_wed']) ? prepare_input($_POST['price_new_wed']) : '';
		$price_new_thu = isset($_POST['price_new_thu']) ? prepare_input($_POST['price_new_thu']) : '';
		$price_new_fri = isset($_POST['price_new_fri']) ? prepare_input($_POST['price_new_fri']) : '';
		$price_new_sat = isset($_POST['price_new_sat']) ? prepare_input($_POST['price_new_sat']) : '';
		$price_new_sun = isset($_POST['price_new_sun']) ? prepare_input($_POST['price_new_sun']) : '';

		$adults_new_2    = isset($_POST['adults_new_2']) ? prepare_input($_POST['adults_new_2']) : '1';
		$children_new_2  = isset($_POST['children_new_2']) ? prepare_input($_POST['children_new_2']) : '0';
		$guest_fee_new_2 = isset($_POST['guest_fee_new_2']) ? prepare_input($_POST['guest_fee_new_2']) : '0';
		$price_new_mon_2 = isset($_POST['price_new_mon_2']) ? prepare_input($_POST['price_new_mon_2']) : '';
		$price_new_tue_2 = isset($_POST['price_new_tue_2']) ? prepare_input($_POST['price_new_tue_2']) : '';
		$price_new_wed_2 = isset($_POST['price_new_wed_2']) ? prepare_input($_POST['price_new_wed_2']) : '';
		$price_new_thu_2 = isset($_POST['price_new_thu_2']) ? prepare_input($_POST['price_new_thu_2']) : '';
		$price_new_fri_2 = isset($_POST['price_new_fri_2']) ? prepare_input($_POST['price_new_fri_2']) : '';
		$price_new_sat_2 = isset($_POST['price_new_sat_2']) ? prepare_input($_POST['price_new_sat_2']) : '';
		$price_new_sun_2 = isset($_POST['price_new_sun_2']) ? prepare_input($_POST['price_new_sun_2']) : '';
				
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$from_new = substr($from_new, 6, 4).'-'.substr($from_new, 0, 2).'-'.substr($from_new, 3, 2);
			$to_new = substr($to_new, 6, 4).'-'.substr($to_new, 0, 2).'-'.substr($to_new, 3, 2);
		}else{
			// dd/mm/yyyy
			$from_new = substr($from_new, 6, 4).'-'.substr($from_new, 3, 2).'-'.substr($from_new, 0, 2);
			$to_new = substr($to_new, 6, 4).'-'.substr($to_new, 3, 2).'-'.substr($to_new, 0, 2);
		}

		if($from_new == '--' || $to_new == '--'){
			$this->error = _DATE_EMPTY_ALERT;
			return false;
		}else if($from_new > $to_new){
			$this->error = _FROM_TO_DATE_ALERT;
			return false;			
		}else if(!$this->IsFloat($guest_fee_new) || $guest_fee_new < 0 || !$this->IsFloat($guest_fee_new_2) || $guest_fee_new_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._GUEST_FEE.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if($price_new_mon == '' || $price_new_tue == '' || $price_new_wed == '' || $price_new_thu == '' || $price_new_fri == '' || $price_new_sat == '' || $price_new_sun == ''
					|| $price_new_mon_2 == '' || $price_new_tue_2 == '' || $price_new_wed_2 == '' || $price_new_thu_2 == '' || $price_new_fri_2 == '' || $price_new_sat_2 == '' || $price_new_sun_2 == ''){
			$this->error = _PRICE_EMPTY_ALERT;
			return false;
		}else if(!$this->IsFloat($price_new_mon) || $price_new_mon < 0 || !$this->IsFloat($price_new_mon_2) || $price_new_mon_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._MON.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_tue) || $price_new_tue < 0 || !$this->IsFloat($price_new_tue_2) || $price_new_tue_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._TUE.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_wed) || $price_new_wed < 0 || !$this->IsFloat($price_new_wed_2) || $price_new_wed_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._WED.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_thu) || $price_new_thu < 0 || !$this->IsFloat($price_new_thu_2) || $price_new_thu_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._THU.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_fri) || $price_new_fri < 0 || !$this->IsFloat($price_new_fri_2) || $price_new_fri_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._FRI.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_sat) || $price_new_sat < 0 || !$this->IsFloat($price_new_sat_2) || $price_new_sat_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._SAT.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else if(!$this->IsFloat($price_new_sun) || $price_new_sun < 0 || !$this->IsFloat($price_new_sun_2) || $price_new_sun_2 < 0){
			$this->error = str_replace('_FIELD_', '<b>'._SUN.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
			return false;
		}else{
			$sql = 'SELECT * FROM ' . TABLE_ROOMS_PRICES . '
					WHERE
						room_id = '.(int)$rid.' AND
						adults = '.(int)$adults_new.' AND
						children = '.(int)$children_new.' AND
						is_default = 0 AND 
						(((\''.$from_new.'\' >= date_from) AND (\''.$from_new.'\' <= date_to)) OR
						((\''.$to_new.'\' >= date_from) AND (\''.$to_new.'\' <= date_to))) ';	
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

			if($result[1] > 0){
				$this->error = _TIME_PERIOD_OVERLAPPING_ALERT;
				return false;
			}
		}

		if ($from_new != '' && $to_new != '') {
			// Room price limited offer
			$sql = 'INSERT INTO '.TABLE_ROOMS_PRICES.' (id, room_id, date_from, date_to, adults, children, guest_fee, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, '.(int)$rid.', \''.$from_new.'\', \''.$to_new.'\', \''.$adults_new.'\', \''.$children_new.'\', \''.$guest_fee_new.'\', '.$price_new_mon.', '.$price_new_tue.', '.$price_new_wed.', '.$price_new_thu.', '.$price_new_fri.', '.$price_new_sat.', '.$price_new_sun.', 0)';
			
			if (database_void_query($sql)) {
				$sql = 'SELECT MAX(id) max_id FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = ' . (int)$rid;
				$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

				$sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
						VALUES (NULL, ' . $rooms_prices_new[0]['max_id'] . ', 1, \'\')';
				database_void_query($sql);

				// Room price flexible offer				
				$sql = 'INSERT INTO '.TABLE_ROOMS_PRICES.' (id, room_id, date_from, date_to, adults, children, guest_fee, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, '.(int)$rid.', \''.$from_new.'\', \''.$to_new.'\', \''.$adults_new_2.'\', \''.$children_new_2.'\', \''.$guest_fee_new_2.'\', '.$price_new_mon_2.', '.$price_new_tue_2.', '.$price_new_wed_2.', '.$price_new_thu_2.', '.$price_new_fri_2.', '.$price_new_sat_2.', '.$price_new_sun_2.', 0)';
				
				if (database_void_query($sql)) {
					$sql = 'SELECT MAX(id) max_id FROM ' . TABLE_ROOMS_PRICES . ' WHERE room_id = ' . (int)$rid;
					$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

					$sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
							VALUES (NULL, ' . $rooms_prices_new[0]['max_id'] . ', 2, \'\')';
					database_void_query($sql);
				} else {
					$this->error = _TRY_LATER;
					return false;
				}

				return true;
			} else {
				$this->error = _TRY_LATER;
				return false;
			}
		}
	}
	
    /**
	 * Updates room availability
	 * 		@param $rid
	 */
	public function UpdateRoomAvailability($rid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$ids_list = isset($_POST['ids_list']) ? prepare_input($_POST['ids_list']) : '';
		$ids_list_array = explode(',', $ids_list);

		$room_info = $this->GetInfoByID($rid);
		$room_count = isset($room_info['room_count']) ? $room_info['room_count'] : '0';
		
		// update availability		
		foreach($ids_list_array as $key){
			
			$sql = 'UPDATE '.TABLE_ROOMS_AVAILABILITIES.' SET ';
			for($day = 1; $day <= 31; $day ++){
				// input validation
				$aval_day = isset($_POST['aval_'.$key.'_'.$day]) ? $_POST['aval_'.$key.'_'.$day] : '0';
				if(!$this->IsInteger($aval_day) || $aval_day < 0){
					$this->error = str_replace('_FIELD_', '\'<b>Day '.$day.'</b>\'', _FIELD_MUST_BE_NUMERIC_POSITIVE);
					return false;
				}else if($aval_day > $room_count){
					$this->error = str_replace('_FIELD_', '\'<b>Day '.$day.'</b>\'', _FIELD_VALUE_EXCEEDED);
					$this->error = str_replace('_MAX_', $room_count, $this->error);
					return false;					
				}
				
				if($day > 1) $sql .= ', ';
				$sql .= 'd'.$day.' = '.(int)$aval_day;
			}
			$sql .= ' WHERE id = '.$key.' AND room_id = '.(int)$rid;
			if(!database_void_query($sql)){
				$this->error = _TRY_LATER;				
				return false;
			}
		}
		unset($_POST);
		return true;		
	}

    /**
	 * Updates room prices
	 * 		@param $rid
	 */
	public function UpdateRoomPrices($rid)
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$ids_list = isset($_POST['ids_list']) ? prepare_input($_POST['ids_list']) : '';
		$ids_list_array = explode(',', $ids_list);
		
		// input validation
		$arrPrices = array();			
		$count = 0;

		foreach ($ids_list_array as $key) {
            $price_type = (isset($_POST['price_type_'.$key]) ? prepare_input($_POST['price_type_'.$key]) : '1');
            $rooms_prices_extend_id= (isset($_POST['rooms_prices_extend_id_'.$key]) ? prepare_input($_POST['rooms_prices_extend_id_'.$key]) : 0);
            $adults    = (isset($_POST['adults_'.$key]) ? prepare_input($_POST['adults_'.$key]) : '1');
			$children  = (isset($_POST['children_'.$key]) ? prepare_input($_POST['children_'.$key]) : '0');
			$guest_fee = (isset($_POST['guest_fee_'.$key]) ? prepare_input($_POST['guest_fee_'.$key]) : '0');			
			$price_mon = (isset($_POST['price_'.$key.'_mon']) ? prepare_input($_POST['price_'.$key.'_mon']) : '0');
			$price_tue = (isset($_POST['price_'.$key.'_tue']) ? prepare_input($_POST['price_'.$key.'_tue']) : '0');
			$price_wed = (isset($_POST['price_'.$key.'_wed']) ? prepare_input($_POST['price_'.$key.'_wed']) : '0');
			$price_thu = (isset($_POST['price_'.$key.'_thu']) ? prepare_input($_POST['price_'.$key.'_thu']) : '0');
			$price_fri = (isset($_POST['price_'.$key.'_fri']) ? prepare_input($_POST['price_'.$key.'_fri']) : '0');
			$price_sat = (isset($_POST['price_'.$key.'_sat']) ? prepare_input($_POST['price_'.$key.'_sat']) : '0');
			$price_sun = (isset($_POST['price_'.$key.'_sun']) ? prepare_input($_POST['price_'.$key.'_sun']) : '0');
			$is_default = (isset($_POST['is_default_' . $key]) ? prepare_input($_POST['is_default_' . $key]) : '0');
			
			if(!$this->IsFloat($guest_fee) || $guest_fee < 0){
				$this->error = str_replace('_FIELD_', '<b>'._GUEST_FEE.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_mon) || $price_mon < 0){
				$this->error = str_replace('_FIELD_', '<b>'._MON.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_tue) || $price_tue < 0){
				$this->error = str_replace('_FIELD_', '<b>'._TUE.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_wed) || $price_wed < 0){
				$this->error = str_replace('_FIELD_', '<b>'._WED.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_thu) || $price_thu < 0){
				$this->error = str_replace('_FIELD_', '<b>'._THU.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_fri) || $price_fri < 0){
				$this->error = str_replace('_FIELD_', '<b>'._FRI.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_sat) || $price_sat < 0){
				$this->error = str_replace('_FIELD_', '<b>'._SAT.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}else if(!$this->IsFloat($price_sun) || $price_sun < 0){
				$this->error = str_replace('_FIELD_', '<b>'._SUN.'</b>', _FIELD_MUST_BE_NUMERIC_POSITIVE);
				return false;
			}

			$sql = 'UPDATE '.TABLE_ROOMS_PRICES.'
					SET
						'.(($count == 0) ? 'date_from = \'0000-00-00\',' : '').'
						'.(($count == 0) ? 'date_to = \'0000-00-00\',' : '').'
						'.(isset($_POST['adults_'.$key]) ? 'adults = '.(int)$adults.',' : '').'
						'.(isset($_POST['children_'.$key]) ? 'children = '.(int)$children.',' : '').'
						guest_fee = \''.$guest_fee.'\',
						mon = \''.$price_mon.'\',
						tue = \''.$price_tue.'\',
						wed = \''.$price_wed.'\',
						thu = \''.$price_thu.'\',
						fri = \''.$price_fri.'\',
						sat = \''.$price_sat.'\',
						sun = \''.$price_sun.'\',
						is_default = ' . $is_default . '
					WHERE id = '.$key.' AND room_id = '.(int)$rid;

            if(!database_void_query($sql)){
				$this->error = _TRY_LATER;
				return false;
			}

//            include 'init_activerecord.php';
//            $listRoomsPriceExtend = RoomsPricesExtend::find;
//            var_dump(RoomsPricesExtend::update_all());

            // $sql_update_rooms_prices_extend = 'UPDATE ' . TABLE_ROOMS_PRICES_EXTEND . '
            //                                     SET price_type = ' . $price_type . '
            //                                     WHERE id = ' . $rooms_prices_extend_id;

//            echo $sql_update_rooms_prices_extend;
//            echo '<br/>';
            // if(!database_void_query($sql_update_rooms_prices_extend)){
            //     $this->error = _TRY_LATER;
            //     return false;
            // }

			$count++;
		}
		unset($_POST);
		return true;		
	}

    /**
	 * After-Insert opearation
	 */
	public function AfterInsertRecord()
	{		
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$default_price 			= isset($_POST['default_price']) ? prepare_input($_POST['default_price']) : '0';
        $default_price_flexible_offer = isset($_POST['default_price_flexible_offer']) ? prepare_input($_POST['default_price_flexible_offer']) : '0';
		$room_type 			    = isset($_POST['room_type']) ? prepare_input($_POST['room_type']) : '';
		$room_count 			= isset($_POST['room_count']) ? (int)$_POST['room_count'] : '0';
		$room_short_description = isset($_POST['room_short_description']) ? prepare_input($_POST['room_short_description']) : '';
		$room_long_description  = isset($_POST['room_long_description']) ? prepare_input($_POST['room_long_description']) : '';
		
		// add room prices
		// ---------------------------------------------------------------------
		$sql = 'SELECT * FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = '.$this->lastInsertId;
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

		if($room[1] > 0){
			$sql = 'UPDATE '.TABLE_ROOMS_PRICES.'
					SET
						date_from = NULL,
						date_to   = NULL,
						mon = \''.$default_price.'\',
						tue = \''.$default_price.'\',
						wed = \''.$default_price.'\',
						thu = \''.$default_price.'\',
						fri = \''.$default_price.'\',
						sat = \''.$default_price.'\',
						sun = \''.$default_price.'\',
						is_default = 1
					WHERE room_id = '.$this->lastInsertId;
			$result = database_void_query($sql);			
		}else{
            // // ActiveRecord
            // include 'init_activerecord.php';

            // $roomsPrice = RoomsPrices();
            // $roomsPrice->room_id = $this->lastInsertId;
            // // $roomsPrice->date_from = date('Y-m-d', strtotime('0000-00-00'));
            // // $roomsPrice->date_to = date('Y-m-d', strtotime('0000-00-00'));
            // $roomsPrice->mon = $default_price;
            // $roomsPrice->tue = $default_price;
            // $roomsPrice->wed = $default_price;
            // $roomsPrice->thu = $default_price;
            // $roomsPrice->fri = $default_price;
            // $roomsPrice->sat = $default_price;
            // $roomsPrice->sun = $default_price;
            // $roomsPrice->is_default = 1;
            // $roomsPrice->save();
            // echo $roomsPrice->id;


            // Default price limited offer
			$sql = 'INSERT INTO '.TABLE_ROOMS_PRICES.' (id, room_id, date_from, date_to, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, '.$this->lastInsertId.', \'0000-00-00\', \'0000-00-00\', \''.$default_price.'\', \''.$default_price.'\', \''.$default_price.'\', \''.$default_price.'\', \''.$default_price.'\', \''.$default_price.'\', \''.$default_price.'\', 1)';
			$result = database_void_query($sql);

			$sql = 'SELECT MAX(id) max_id FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = '.$this->lastInsertId;
			$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

			$sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
					VALUES (NULL, ' . $rooms_prices_new[0]['max_id'] . ', 1, \'\')';
			$result = database_void_query($sql);

            // Default price flexible offer
            $sql = 'INSERT INTO '.TABLE_ROOMS_PRICES.' (id, room_id, date_from, date_to, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, '.$this->lastInsertId.', \'0000-00-00\', \'0000-00-00\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', 1)';
            $result = database_void_query($sql);

            $sql = 'SELECT MAX(id) max_id FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = '.$this->lastInsertId;
			$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

			$sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
					VALUES (NULL, ' . $rooms_prices_new[0]['max_id'] . ', 2, \'\')';
			$result = database_void_query($sql);
		}
		
		// add room availability
		// ---------------------------------------------------------------------
		$sql = 'SELECT * FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE room_id = '.$this->lastInsertId;
		$room = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room[1] <= 0){
			for($y = 0; $y <= 1; $y++){ // 0 - current, 1 - next year
				$sql_temp = 'INSERT INTO '.TABLE_ROOMS_AVAILABILITIES.' (id, room_id, y, m ';
				$sql_temp_values = '';
				for($i=1; $i<=31; $i++){
					$sql_temp .= ', d'.$i;
					$sql_temp_values .= ', '.$room_count;
				}
				$sql_temp .= ')';
				$sql_temp .= 'VALUES (NULL, '.$this->lastInsertId.', '.$y.', _MONTH_'.$sql_temp_values.');';
				
				for($i = 1; $i <= 12; $i++){
					$sql = str_replace('_MONTH_', $i, $sql_temp);
					$result = database_void_query($sql);
				}
			}
		}		

		// languages array
		// ---------------------------------------------------------------------
		$total_languages = Languages::GetAllActive();
		foreach($total_languages[0] as $key => $val){			
			$sql = 'INSERT INTO '.TABLE_ROOMS_DESCRIPTION.'(
						id, room_id, language_id, room_type, room_short_description, room_long_description
					)VALUES(
						NULL, '.$this->lastInsertId.', \''.$val['abbreviation'].'\', \''.encode_text($room_type).'\', \''.encode_text($room_short_description).'\', \''.encode_text($room_long_description).'\'
					)';
			if(!database_void_query($sql)){
				///echo mysql_error();
			}		
		}		
	}	
	
	public function BeforeUpdateRecord()
	{
		$record_info = $this->GetInfoByID($this->curRecordId);
		$this->roomsCount = isset($record_info['room_count']) ? $record_info['room_count'] : '';
	   	return true;
	}
	 	
	public function AfterUpdateRecord()
	{
		$room_count = MicroGrid::GetParameter('room_count', false);
		if($room_count != $this->roomsCount){
			$sql = 'UPDATE '.TABLE_ROOMS_AVAILABILITIES.' SET ';
			for($day = 1; $day <= 31; $day ++){
				if($day > 1) $sql .= ', ';
				$sql .= 'd'.$day.' = '.$room_count;
			}			
			$sql .= ' WHERE room_id = '.(int)$this->curRecordId;
			database_void_query($sql);	
		}		

		//

		// Default price limited offer
        $default_price_flexible_offer = isset($_POST['default_price_flexible_offer']) ? prepare_input($_POST['default_price_flexible_offer']) : '0';

		$sql = 'SELECT * FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = ' . (int)$this->curRecordId . ' AND is_default = 1';
		$rooms_prices_update = database_query($sql, DATA_AND_ROWS, ALL_ROWS); //var_dump($rooms_prices_update);

		if ($rooms_prices_update[1] < 2) {
			// Default price flexible offer
	        $sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
					VALUES (NULL, ' . $rooms_prices_update[0][0]['id'] . ', 1, \'\')';
			$result = database_void_query($sql);

			$sql = 'SELECT MAX(id) max_id FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = ' . (int)$this->curRecordId  . ' AND is_default = 1';
			$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

	        $sql = 'INSERT INTO '.TABLE_ROOMS_PRICES.' (id, room_id, date_from, date_to, mon, tue, wed, thu, fri, sat, sun, is_default)
					VALUES (NULL, ' . (int)$this->curRecordId . ', \'0000-00-00\', \'0000-00-00\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', \''.$default_price_flexible_offer.'\', 1)'; echo $sql . '<br/>';
	        $result = database_void_query($sql);

	        $sql = 'SELECT MAX(id) max_id FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = ' . (int)$this->curRecordId  . ' AND is_default = 1';
			$rooms_prices_new = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

			$sql = 'INSERT INTO ' . TABLE_ROOMS_PRICES_EXTEND . ' (id, rooms_prices_id, price_type, terms) 
					VALUES (NULL, ' . $rooms_prices_new[0]['max_id'] . ', 2, \'\')';
			$result = database_void_query($sql);
		}
	}

    /**
	 * After-Delete opearation
	 */
	public function AfterDeleteRecord()
	{
		// Block operation in demo mode
		if(strtolower(SITE_MODE) == 'demo'){
			$this->error = _OPERATION_BLOCKED;
			return false;
		}

		$rid = self::GetParameter('rid');

		$sql = 'DELETE FROM '.TABLE_ROOMS_PRICES.' WHERE room_id = '.(int)$rid;
		database_void_query($sql);	

		$sql = 'DELETE FROM ' . TABLE_ROOMS_PRICES_EXTEND . ' 
				WHERE rooms_prices_id NOT IN (SELECT id FROM ' . TABLE_ROOMS_PRICES . ')';
		database_void_query($sql);

		$sql = 'DELETE FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE room_id = '.(int)$rid;
		database_void_query($sql);	
		
		$sql = 'DELETE FROM '.TABLE_ROOMS_DESCRIPTION.' WHERE room_id = '.(int)$rid;		
		database_void_query($sql);
	}
	
    /**
	 * Search available rooms
	 * 		@param $params
	 */
	public function SearchFor($params = array())
	{
		$checkin_date 	= $params['from_year'].'-'.$params['from_month'].'-'.$params['from_day'];
		$checkout_date 	= $params['to_year'].'-'.$params['to_month'].'-'.$params['to_day'];
		$max_adults 	= isset($params['max_adults']) ? $params['max_adults'] : '';
		$max_children 	= isset($params['max_children']) ? $params['max_children'] : '';
		$room_id 	    = isset($params['room_id']) ? $params['room_id'] : '';
		$hotel_sel_id   = isset($params['hotel_sel_id']) ? $params['hotel_sel_id'] : '';
		$hotel_sel_loc_id  = isset($params['hotel_sel_loc_id']) ? $params['hotel_sel_loc_id'] : '';
		
		$order_by_clause = (isset($params['sort_by'])) ? (($params['sort_by'] == '1-5') ? 'h.stars ASC' : 'h.stars DESC') : 'r.priority_order ASC';
		$hotel_where_clause = (!empty($hotel_sel_id)) ? 'h.id = '.(int)$hotel_sel_id.' AND ' : '';
		$hotel_where_clause .= (!empty($hotel_sel_loc_id)) ? 'h.hotel_location_id = '.(int)$hotel_sel_loc_id.' AND ' : '';

		$rooms_count    = 0;
		$show_fully_booked_rooms = ModulesSettings::Get('booking', 'show_fully_booked_rooms');

    	$sql = 'SELECT
					r.id, r.hotel_id, r.room_count
			    FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_HOTELS.' h ON r.hotel_id = h.id
				WHERE 1=1 AND 
					'.$hotel_where_clause.'
					h.is_active = 1 AND
					r.is_active = 1					
					'.(($room_id != '') ? ' AND r.id='.(int)$room_id : '').'
					'.(($max_adults != '') ? ' AND r.max_adults >= '.(int)$max_adults : '').'
					'.(($max_children != '') ? ' AND r.max_children >= '.(int)$max_children : '').'
				ORDER BY '.$order_by_clause;

		$rooms = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		if($rooms[1] > 0){
			// loop by rooms
			for($i=0; $i < $rooms[1]; $i++){
				//echo '<br />'.$rooms[0][$i]['id'].' '.$rooms[0][$i]['room_count'];

                // maximum available rooms in hotel for one day
				$maximal_rooms = (int)$rooms[0][$i]['room_count'];				
				$max_booked_rooms = '0';
				$sql = 'SELECT
							MAX('.TABLE_BOOKINGS_ROOMS.'.rooms) as max_booked_rooms
						FROM '.TABLE_BOOKINGS.'
							INNER JOIN '.TABLE_BOOKINGS_ROOMS.' ON '.TABLE_BOOKINGS.'.booking_number = '.TABLE_BOOKINGS_ROOMS.'.booking_number
						WHERE
                            ('.TABLE_BOOKINGS.'.status = 1 OR '.TABLE_BOOKINGS.'.status = 2) AND
							'.TABLE_BOOKINGS_ROOMS.'.room_id = '.(int)$rooms[0][$i]['id'].' AND
							(
								(\''.$checkin_date.'\' <= checkin AND \''.$checkout_date.'\' > checkin) 
								OR
								(\''.$checkin_date.'\' < checkout AND \''.$checkout_date.'\' >= checkout)
								OR
								(\''.$checkin_date.'\' >= checkin  AND \''.$checkout_date.'\' < checkout)
							)';

				$rooms_booked = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($rooms_booked[1] > 0){
					$max_booked_rooms = (int)$rooms_booked[0]['max_booked_rooms'];
				}
				
				// this is only a simple check if there is at least one room wirh available num > booked rooms
				$available_rooms = (int)($maximal_rooms - $max_booked_rooms);
				// echo '<br> Room ID: '.$rooms[0][$i]['id'].' Max: '.$maximal_rooms.' Booked: '.$max_booked_rooms.' Av:'.$available_rooms;

				// this is advanced check that takes in account max availability for each spesific day is selected period of time
				$fully_booked_rooms = true;
				if($available_rooms > 0){
					$available_rooms_updated = $this->CheckAvailabilityForPeriod($rooms[0][$i]['id'], $checkin_date, $checkout_date, $available_rooms);
					if($available_rooms_updated){
						$rooms_count++;
						$this->arrAvailableRooms[$rooms[0][$i]['hotel_id']][] = array('id'=>$rooms[0][$i]['id'], 'available_rooms'=>$available_rooms_updated);						
						$fully_booked_rooms = false;
					}
				}

				if($show_fully_booked_rooms == 'yes' && $fully_booked_rooms){
					$rooms_count++;
					$this->arrAvailableRooms[$rooms[0][$i]['hotel_id']][] = array('id'=>$rooms[0][$i]['id'], 'available_rooms'=>'0');
				}
			}
		}
		
		return $rooms_count;		
	}

    /**
     * Count rooms available
     * 		@param $params
     */
    public function CountRoomsAvailable($params = array())
    {
        $checkin_date 	= $params['from_year'].'-'.$params['from_month'].'-'.$params['from_day'];
        $checkout_date 	= $params['to_year'].'-'.$params['to_month'].'-'.$params['to_day'];
        $max_adults 	= isset($params['max_adults']) ? $params['max_adults'] : '';
        $max_children 	= isset($params['max_children']) ? $params['max_children'] : '';
        $room_id 	    = isset($params['room_id']) ? $params['room_id'] : '';
        $hotel_sel_id   = isset($params['hotel_sel_id']) ? $params['hotel_sel_id'] : '';
        $hotel_sel_loc_id  = isset($params['hotel_sel_loc_id']) ? $params['hotel_sel_loc_id'] : '';

        $order_by_clause = (isset($params['sort_by'])) ? (($params['sort_by'] == '1-5') ? 'h.stars ASC' : 'h.stars DESC') : 'r.priority_order ASC';
        $hotel_where_clause = (!empty($hotel_sel_id)) ? 'h.id = '.(int)$hotel_sel_id.' AND ' : '';
        $hotel_where_clause .= (!empty($hotel_sel_loc_id)) ? 'h.hotel_location_id = '.(int)$hotel_sel_loc_id.' AND ' : '';

        $rooms_count    = 0;
        $show_fully_booked_rooms = ModulesSettings::Get('booking', 'show_fully_booked_rooms');

        $sql = 'SELECT
					r.id, r.hotel_id, r.room_count
			    FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_HOTELS.' h ON r.hotel_id = h.id
				WHERE 1=1 AND
					'.$hotel_where_clause.'
					h.is_active = 1 AND
					r.is_active = 1
					'.(($room_id != '') ? ' AND r.id='.(int)$room_id : '').'
					'.(($max_adults != '') ? ' AND r.max_adults >= '.(int)$max_adults : '').'
					'.(($max_children != '') ? ' AND r.max_children >= '.(int)$max_children : '').'
				ORDER BY '.$order_by_clause;

        $rooms = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
        if($rooms[1] > 0){
            // loop by rooms
            for($i=0; $i < $rooms[1]; $i++){
                //echo '<br />'.$rooms[0][$i]['id'].' '.$rooms[0][$i]['room_count'];

                // maximum available rooms in hotel for one day
                $maximal_rooms = (int)$rooms[0][$i]['room_count'];
                $max_booked_rooms = '0';
                $sql = 'SELECT
							MAX('.TABLE_BOOKINGS_ROOMS.'.rooms) as max_booked_rooms
						FROM '.TABLE_BOOKINGS.'
							INNER JOIN '.TABLE_BOOKINGS_ROOMS.' ON '.TABLE_BOOKINGS.'.booking_number = '.TABLE_BOOKINGS_ROOMS.'.booking_number
						WHERE
                            ('.TABLE_BOOKINGS.'.status = 1 OR '.TABLE_BOOKINGS.'.status = 2) AND
							'.TABLE_BOOKINGS_ROOMS.'.room_id = '.(int)$rooms[0][$i]['id'].' AND
							(
								(\''.$checkin_date.'\' <= checkin AND \''.$checkout_date.'\' > checkin)
								OR
								(\''.$checkin_date.'\' < checkout AND \''.$checkout_date.'\' >= checkout)
								OR
								(\''.$checkin_date.'\' >= checkin  AND \''.$checkout_date.'\' < checkout)
							)';

                $rooms_booked = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
                if($rooms_booked[1] > 0){
                    $max_booked_rooms = (int)$rooms_booked[0]['max_booked_rooms'];
                }

                // this is only a simple check if there is at least one room wirh available num > booked rooms
                $available_rooms = (int)($maximal_rooms - $max_booked_rooms);
                // echo '<br> Room ID: '.$rooms[0][$i]['id'].' Max: '.$maximal_rooms.' Booked: '.$max_booked_rooms.' Av:'.$available_rooms;

                // this is advanced check that takes in account max availability for each spesific day is selected period of time
                $fully_booked_rooms = true;
                if($available_rooms > 0){
                    $available_rooms_updated = $this->CheckAvailabilityForPeriod($rooms[0][$i]['id'], $checkin_date, $checkout_date, $available_rooms);
                    if($available_rooms_updated){
                        $rooms_count += $available_rooms;
                        $this->arrAvailableRooms[$rooms[0][$i]['hotel_id']][] = array('id'=>$rooms[0][$i]['id'], 'available_rooms'=>$available_rooms_updated);
                        $fully_booked_rooms = false;
                    }
                }

                if($show_fully_booked_rooms == 'yes' && $fully_booked_rooms){
                    $rooms_count += $maximal_rooms;
                    $this->arrAvailableRooms[$rooms[0][$i]['hotel_id']][] = array('id'=>$rooms[0][$i]['id'], 'available_rooms'=>'0');
                }
            }
        }

        return $rooms_count;
    }

    /**
	 * Draws search result
	 * 		@param $params
	 * 		@param $rooms_total
	 * 		@param $draw
	 */
	public function DrawSearchResult($params, $rooms_total = 0, $draw = true)
	{		
		global $objLogin;
		
		$nl = "\n";
		$output = '';
		$currency_rate = Application::Get('currency_rate');
		$currency_format = get_currency_format();
		$lang 		   = Application::Get('lang');		
		$rooms_count   = 0;
		$hotels_count  = 0;
		$total_hotels  = Hotels::HotelsCount();

		$search_page_size = (int)ModulesSettings::Get('rooms', 'search_availability_page_size');
		$show_room_types_in_search = ModulesSettings::Get('rooms', 'show_room_types_in_search');
		if($search_page_size <= 0) $search_page_size = '1';
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');

		$allow_booking = false;
		if(Modules::IsModuleInstalled('booking')){
			if(ModulesSettings::Get('booking', 'is_active') == 'global' ||
			   ModulesSettings::Get('booking', 'is_active') == 'front-end' ||
			  (ModulesSettings::Get('booking', 'is_active') == 'back-end' && $objLogin->IsLoggedInAsAdmin())	
			){
				$allow_booking = true;
			}
		}
		
		$sql = 'SELECT
					r.id,
					r.room_type,
					r.room_count,
					r.room_icon,
					IF(r.room_icon_thumb != \'\', r.room_icon_thumb, \'no_image.png\') as room_icon_thumb,
					r.room_picture_1,
					r.room_picture_2,
					r.room_picture_3,
					r.room_picture_4,
					r.room_picture_5,
					CASE
						WHEN r.room_picture_1 != \'\' THEN r.room_picture_1
						WHEN r.room_picture_2 != \'\' THEN r.room_picture_2
						WHEN r.room_picture_3 != \'\' THEN r.room_picture_3
						WHEN r.room_picture_4 != \'\' THEN r.room_picture_4
						WHEN r.room_picture_5 != \'\' THEN r.room_picture_5
						ELSE \'\'
					END as first_room_image,
					r.max_adults,
					r.max_children,
					r.max_guests,
					r.default_price as price,
					rd.room_type as loc_room_type,
					rd.room_short_description as loc_room_short_description
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id
				WHERE
					r.id = _KEY_ AND
					rd.language_id = \''.$lang.'\'';

		if(count($this->arrAvailableRooms) == 1){

			// -------- pagination		
			$current_page = isset($_REQUEST['p']) ? (int)$_REQUEST['p'] : '1';
			$total_pages = (int)($rooms_total / $search_page_size);		
			if($current_page > ($total_pages+1)) $current_page = 1;
			if(($rooms_total % $search_page_size) != 0) $total_pages++;
			if(!is_numeric($current_page) || (int)$current_page <= 0) $current_page = 1;
			// --------
			
			if($rooms_total > 0){
				
				// get a first key of the array
				reset($this->arrAvailableRooms);
				$first_key = key($this->arrAvailableRooms);
				
				if($total_hotels > 1){
					$output .= '<div style="margin:10px 0;"><b>'._FOUND_HOTELS.': 1, '._TOTAL_ROOMS.': '.$rooms_total.'</b></div>';
					$output .= $this->DrawHotelInfoBlock($first_key, $lang, false);
					$output .= '<div class="line-hor-2"></div>';
				}
				
				$meal_plans = MealPlans::GetAllMealPlans($first_key);
				
				foreach($this->arrAvailableRooms[$first_key] as $key){
					
					if($show_room_types_in_search != 'all' && $key['available_rooms'] < 1) continue;					
					$rooms_count++;
					
					if($rooms_count <= ($search_page_size * ($current_page - 1))){
						continue;
					}else if($rooms_count > ($search_page_size * ($current_page - 1)) + $search_page_size){
						break;
					}
					
					$room = database_query(str_replace('_KEY_', $key['id'], $sql), DATA_AND_ROWS, FIRST_ROW_ONLY);

                    if($room[1] > 0){
						//$output .= '<br />';
						$output .= '<form action="index.php?page=booking" method="post">'.$nl;
						$output .= draw_hidden_field('hotel_id', $first_key, false).$nl;
						$output .= draw_hidden_field('room_id', $room[0]['id'], false).$nl;
						$output .= draw_hidden_field('from_date', $params['from_date'], false).$nl;
						$output .= draw_hidden_field('to_date', $params['to_date'], false).$nl;
						$output .= draw_hidden_field('rooms_quantity', $params['rooms_quantity'], false).$nl;
						$output .= draw_hidden_field('nights', $params['nights'], false).$nl;
						$output .= draw_hidden_field('adults', $params['max_adults'], false).$nl;
						$output .= draw_hidden_field('children', $params['max_children'], false).$nl;
						$output .= draw_hidden_field('hotel_sel_id', $params['hotel_sel_id'], false).$nl;
						$output .= draw_hidden_field('hotel_sel_loc_id', $params['hotel_sel_loc_id'], false).$nl;
						$output .= draw_hidden_field('checkin_year_month', $params['from_year'].'-'.(int)$params['from_month'], false).$nl;
						$output .= draw_hidden_field('checkin_monthday', $params['from_day'], false).$nl;
						$output .= draw_hidden_field('checkout_year_month', $params['to_year'].'-'.(int)$params['to_month'], false).$nl;
						$output .= draw_hidden_field('checkout_monthday', $params['to_day'], false).$nl;
						$output .= '<input class="price_type" type="hidden" value="1" name="price_type">' . $nl; // Default price type is Limited Offer

						$output .= draw_token_field(false).$nl;
						
						$output .= '<div class="line-hor-title"><h3 class="headline">' . prepare_link('rooms', 'room_id', $room[0]['id'], $room[0]['loc_room_type'], $room[0]['loc_room_type'], '', _CLICK_TO_VIEW) . '</h3></div>';
						$output .= '<div class="room-item-bldr">'.$nl;
							$output .= '<div class="left">';
								if($room[0]['first_room_image'] != '') $output .= '<a href="images/rooms_icons/'.$room[0]['first_room_image'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 1">';
								//$output .= '<img class="room_icon" src="images/rooms_icons/'.$room[0]['room_icon_thumb'].'" alt="" />';
								$output .= '<img class="room_icon_full" src="images/rooms_icons/'.$room[0]['first_room_image'].'" alt="" />';
								if($room[0]['first_room_image'] != '') $output .= '</a>';							
								if($room[0]['room_picture_1'] != '') $output .= '  <a href="images/rooms_icons/'.$room[0]['room_picture_1'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 1"></a>';					
								if($room[0]['room_picture_2'] != '') $output .= '  <a href="images/rooms_icons/'.$room[0]['room_picture_2'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 2"></a>';					
								if($room[0]['room_picture_3'] != '') $output .= '  <a href="images/rooms_icons/'.$room[0]['room_picture_3'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 3"></a>';
								if($room[0]['room_picture_4'] != '') $output .= '  <a href="images/rooms_icons/'.$room[0]['room_picture_4'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 4"></a>';
								if($room[0]['room_picture_5'] != '') $output .= '  <a href="images/rooms_icons/'.$room[0]['room_picture_5'].'" rel="lyteshow_'.$room[0]['id'].'" title="'._IMAGE.' 5"></a>';								
							$output .= '</div>';

							$output .= '<div class="left">' . $room[0]['loc_room_short_description'] . '</div>';

							$output .= '<div class="left">';
								$output .= '<table border="0" width="100%">';					
								$room_price = $this->GetRoomPriceExtend($room[0]['id'], $params, 1); // Limited Offer
								$room_price_2 = $this->GetRoomPriceExtend($room[0]['id'], $params, 2); // Flexible Offer

								if(empty($key['available_rooms'])) $rooms_descr = '<span class="gray">('._FULLY_BOOKED.')</span>';
								else if($room[0]['room_count'] > '1' && $key['available_rooms'] == '1') $rooms_descr = '<span class="red">('._ROOMS_LAST.')</span>';
								else if($room[0]['room_count'] > '1' && $key['available_rooms'] <= '5') $rooms_descr = '<span class="red">('.$key['available_rooms'].' '._ROOMS_LEFT.')</span>';
								else $rooms_descr = '<span class="green">('._AVAILABLE.')</span>';

								// $output .= '<tr><td colspan="2"><h3 class="headline">'.prepare_link('rooms', 'room_id', $room[0]['id'], $room[0]['loc_room_type'], $room[0]['loc_room_type'], '', _CLICK_TO_VIEW).' '.$rooms_descr.'</h3></td></tr>';
								
								// $output .= '<tr><td colspan="2" nowrap="nowrap" height="5px"></td></tr>';
								$output .= '<tr><td colspan="2">'._MAX_ADULTS.': '.$room[0]['max_adults'].(($allow_children == 'yes') ? ', '._MAX_CHILDREN.': '.$room[0]['max_children'] : '').'</td></tr>';

								if($key['available_rooms']){ 
									$output .= '<tr style="display: none;"><td colspan="2">' . _RATE /*_ROOMS*/ . '<br/><select name="available_rooms" class="available_rooms_ddl" '.($allow_booking ? '' : 'disabled="disabled"').'>';
										$options = '';
										for($i = 1; $i <= $key['available_rooms']; $i++){
											$room_price_i = $room_price * $i;
											$room_price_i_formatted = Currencies::PriceFormat(($room_price * $i) / $currency_rate, '', '', $currency_format);
											$options .= '<option value="'.$i.'-'.$room_price_i.'" '; 
											$options .= ($i == '0') ? 'selected="selected" ' : '';
											$options .= '>'.$i.(($i != 0) ? ' ('.$room_price_i_formatted.')' : '').'</option>';
										}
										$output .= $options.'</select>';									
										if($params['nights'] > 1){
											$output .= '<span class="rooms_description"> <span class="red">*</span> '._RATE_PER_NIGHT;
											$output .= ': '.Currencies::PriceFormat(($room_price / $currency_rate) / $params['nights'], '', '', $currency_format).'</span>';
										}									
									$output .= '</td>';
									$output .= '</tr>';

									if($meal_plans[1] > 0){
										$output .= '<tr>';
											$output .= '<td colspan="2">'._MEAL_PLANS.'<br/>' . MealPlans::DrawMealPlansDDL($meal_plans, $currency_rate, $currency_format, $allow_booking, false);
											// $output .= '<br/><span class="meal_plans_description"> <span class="red">*</span> '._PERSON_PER_NIGHT.'</span>';
											$output .= '</td>';
										$output .= '</tr>';									
									}
									if($allow_guests == 'yes' && $room[0]['max_guests'] > 0){
										$output .= '<tr>';
											$output .= '<td>'._GUESTS.'<br/>' . $this->DrawGuestsDDL($room[0]['id'], $room[0]['max_guests'], $params, $currency_rate, $currency_format, $allow_booking, false);
											// $output .= '<br/><span class="guests_description"> <span class="red">*</span> '._PER_NIGHT.'</span>';
											$output .= '</td>';
										$output .= '</tr>';
									}
								}
								//$output .= '<tr><td colspan="2"><a class="price_link" href="javascript:void(0);" onclick="javascript:appToggleElement(\'row_prices_'.$room[0]['id'].'\')" title="'._CLICK_TO_SEE_PRICES.'">'._PRICES.' (+)</a></td></tr>';
								$output .= '</table>';
							$output .= '</div><div class="clear"><!-- --></div>';

						$output .= '<div style="margin:10px 0 0 0; display: none;"><span id="row_prices_'.$room[0]['id'].'">'.self::GetRoomPricesTableVertical($room[0]['id']).'</span></div>';
						$output .= '<input class="room_price" type="hidden" value="' . $room_price . '" name="room_price">' . $nl; // Price of room seleted

						if($allow_booking && $key['available_rooms']) {
							// $output .= '<div class="book-button"><input type="submit" class="form_button_middle" value="'._BOOK_NOW.' >" /></div><div class="clear"><!-- --></div>';
							$service_charge = $room_price * 0.05;
							$vat = $room_price * 0.1;
							$total = $room_price + $service_charge + $vat;

							$service_charge_2 = $room_price_2 * 0.05;
							$vat_2 = $room_price_2 * 0.1;
							$total_2 = $room_price_2 + $service_charge_2 + $vat_2;

							$output .= '<div class="line-hor-title price_type">
											<div class="left">
												<div class="title col-1-check-available">' . _LIMITED_OFFER . '</div>
											</div>
											<div class="left">
												<div class="col-2-check-available">
													<span class="terms-detail">' . _CANCEL_OR_CHANGE_FEE . '<br/><a href="javascript:void(0);" onclick="return hs.htmlExpand(this, { contentId: \'highslide-html-' . $room[0]['id'] . '-1\', headingText: \'Terms & Details - ' . _LIMITED_OFFER . '\' } )" class="highslide">' . _TERMS_DETAIL . '</a></span>
													<div class="highslide-html-content" id="highslide-html-' . $room[0]['id'] . '-1">
														<div class="highslide-header">
															<ul>
																<li class="highslide-move">
																	<a href="#" onclick="return false"></a>
																</li>
																<li class="highslide-close">
																	<a href="#" onclick="return hs.close(this)"></a>
																</li>
															</ul>
														</div>
														<div class="highslide-body terms-detail">
															<h4>Bamboo Village Beach Resort & Spa</h4>
															<p class="item">
																38 Nguyen Dinh Chieu Street, Ham Tien Ward, Phan Thiet City, Binh Thuan Province, Vietnam<br>
																Head Office: +84 62 3847 007<br/>
																Sales Office: +84 8 38389358<br/>
																Email Us: <a href="mailto:info@bamboovillageresortvn.com">info@bamboovillageresortvn.com</a>
															</p>
															<div class="price-detail">
																<h4>Price detail</h4>
																<div class="col-1-2">
																	Room Price:
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($room_price / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="col-1-2">
																	Service charge (5%/room/night):
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($service_charge  / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="col-1-2">
																	VAT (10%):
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($vat / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="line"></div>
																<div class="col-1-2">
																	Total:
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($total / $currency_rate), '', '', $currency_format) . '
																</div>
															</div>
														</div>
													    <div class="highslide-footer">
													        <div>
													            <span class="highslide-resize" title="Resize">
													                <span></span>
													            </span>
													        </div>
													    </div>
													</div>
												</div>
											</div>
											<div class="left">
												<div class="col-3-check-available">
													<span class="price">
														' . Currencies::PriceFormat(($room_price / $currency_rate), '', '', $currency_format) . '<br/>
													</span>
													<span class="note">
														' . _ROOM_PER_NIGHT . '<br/><br/>
													</span>
													<input name="book_price_type_1" type="button" class="price_type_button book_price_type_1" value="' . _BOOK_NOW . ' >"  data-room-price="' . $room_price . '" />
												</div>
											</div>
											<div class="clear"><!-- --></div>
										</div>
										<div class="clear"><!-- --></div>';

							$output .= '<div class="line-hor-title price_type">
											<div class="left">
												<div class="title col-1-check-available">' . _FLEXIBLE_OFFER . '</div>
											</div>
											<div class="left">
												<div class="col-2-check-available">
													<span class="terms-detail">' . _CANCEL_OR_CHANGE_NO_FEE . '<br/><a href="javascript:void(0);" onclick="return hs.htmlExpand(this, { contentId: \'highslide-html-' . $room[0]['id'] . '-2\', headingText: \'Terms & Details - ' . _FLEXIBLE_OFFER . '\' } )"
													class="highslide">' . _TERMS_DETAIL . '</a></span>
													<div class="highslide-html-content" id="highslide-html-' . $room[0]['id'] . '-2">
														<div class="highslide-header">
															<ul>
																<li class="highslide-move">
																	<a href="#" onclick="return false"></a>
																</li>
																<li class="highslide-close">
																	<a href="#" onclick="return hs.close(this)"></a>
																</li>
															</ul>
														</div>
														<div class="highslide-body terms-detail">
															<h4>Bamboo Village Beach Resort & Spa</h4>
															<p class="item">
																38 Nguyen Dinh Chieu Street, Ham Tien Ward, Phan Thiet City, Binh Thuan Province, Vietnam<br>
																Head Office: +84 62 3847 007<br/>
																Sales Office: +84 8 38389358<br/>
																Email Us: <a href="mailto:info@bamboovillageresortvn.com">info@bamboovillageresortvn.com</a>
															</p>
															<div class="price-detail">
																<h4>Price detail</h4>
																<div class="col-1-2">
																	Room Price:
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($room_price_2 / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="col-1-2">
																	Service charge (5%/room/night):
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($service_charge_2  / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="col-1-2">
																	VAT (10%):
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($vat_2 / $currency_rate), '', '', $currency_format) . '
																</div>
																<div class="clear"></div>
																<div class="line"></div>
																<div class="col-1-2">
																	Total:
																</div>
																<div class="col-1-2 align-right">
																	' . Currencies::PriceFormat(($total_2 / $currency_rate), '', '', $currency_format) . '
																</div>
															</div>
														</div>
													    <div class="highslide-footer">
													        <div>
													            <span class="highslide-resize" title="Resize">
													                <span></span>
													            </span>
													        </div>
													    </div>
													</div>
												</div>
											</div>
											<div class="left">
												<div class="col-3-check-available">
													<span class="price">
														' . Currencies::PriceFormat(($room_price_2 / $currency_rate), '', '', $currency_format) . '<br/>
													</span>
													<span class="note">
														' . _ROOM_PER_NIGHT . '<br/><br/>
													</span>
													<input name="book_price_type_2" type="button" class="price_type_button book_price_type_2" value="' . _BOOK_NOW . ' >" data-room-price="' . $room_price_2 . '" />
												</div>
											</div>
											<div class="clear"><!-- --></div>
										</div>
										<div class="clear"><!-- --></div>';
						}

						if($rooms_count <= ($rooms_total - 1)) {
							$output .= '<div class="line-hor-2"><!-- --></div>';
						}

						//else $output .= '<tr><td colspan="2"><br /><td></tr>';
						$output .= '</div>'.$nl;
						$output .= '</form>'.$nl;
					}
				}
			}
	
			$output .= $this->DrawPaginationLinks($total_pages, $current_page, $params, false);	
			
		}else{
			// multi hotels found
			
			// -------- pagination
			$hotels_total = count($this->arrAvailableRooms);
			$current_page = isset($_REQUEST['p']) ? (int)$_REQUEST['p'] : '1';
			$total_pages = (int)($hotels_total / $search_page_size);		
			if($current_page > ($total_pages+1)) $current_page = 1;
			if(($hotels_total % $search_page_size) != 0) $total_pages++;
			if(!is_numeric($current_page) || (int)$current_page <= 0) $current_page = 1;
			// --------

			if($rooms_total > 0){				
				$output .= '<div style="margin:10px 0;"><b>'._FOUND_HOTELS.': '.count($this->arrAvailableRooms).', '._TOTAL_ROOMS.': '.$rooms_total.'</b><div class="line-hor"></div></div>';
				
				foreach($this->arrAvailableRooms as $key => $val){

					$meal_plans = MealPlans::GetAllMealPlans($key);				
					$hotels_count++;					
					
					if($hotels_count <= ($search_page_size * ($current_page - 1))){
						continue;
					}else if($hotels_count > ($search_page_size * ($current_page - 1)) + $search_page_size){
						break;
					}

					if($hotels_count > 1) $output .= '<br><div class="line-hor"></div>';
					
					$output .= $this->DrawHotelInfoBlock($key, $lang, false);
					$output .= '<br>';
					
					$output .= '<table class="room_prices" border="0" cellpadding="0" cellspacing="0">';
					$output .= '<tr class="header">';
					$output .= '  <th align="left">&nbsp;'._ROOM_TYPE.'</th>';
					$output .= '  <th align="center" colspan="3" width="80px">'._MAX_OCCUPANCY.'</th>';
					$output .= '  <th align="center">'._ROOMS.'</th>';
					$output .= '  <th align="center" width="80px">'._RATE.'</th>';
					if($meal_plans[1] > 0) $output .= '<th align="center">'._MEAL_PLANS.'</th>'; 
					$output .= '  <th align="center">&nbsp;</th>';
					$output .= '</tr>';

					$output .= '<tr class="header" style="font-size:10px;background-color:transparent;">';
					$output .= '  <th align="left">&nbsp;</th>';
					$output .= '  <th align="center">'._ADULT.'</th>';
					$output .= '  '.(($allow_children == 'yes') ? '<th align="center">'._CHILD.'</th>' : '<th></th>');
					$output .= '  '.(($allow_guests == 'yes') ? '<th align="center">'._GUEST.' <span class="help" title="'._PER_NIGHT.'">[?]</span></th>' : '<th></th>');
					$output .= '  <th align="center">&nbsp;</th>';
					$output .= '  <th align="center">'.(($params['nights'] > 1) ? _RATE_PER_NIGHT_AVG : _RATE_PER_NIGHT).'</th>';
					if($meal_plans[1] > 0) $output .= '  <th align="center">'._PERSON_PER_NIGHT.'</th>';
					$output .= '  <th align="center">&nbsp;</th>';
					$output .= '</tr>';

					foreach($val as $k_key => $v_val){
						
						if($show_room_types_in_search != 'all' && $v_val['available_rooms'] < 1) continue;					

						$room = database_query(str_replace('_KEY_', $v_val['id'], $sql), DATA_AND_ROWS, FIRST_ROW_ONLY);
						if($room[1] > 0){					
						
							$room_price = $this->GetRoomPrice($room[0]['id'], $params);							
							if(empty($v_val['available_rooms'])) $rooms_descr = '<span class="gray">('._FULLY_BOOKED.')</span>';
							else if($room[0]['room_count'] > '1' && $v_val['available_rooms'] == '1') $rooms_descr = '<span class="red">('._ROOMS_LAST.')</span>';
							else if($room[0]['room_count'] > '1' && $v_val['available_rooms'] <= '5') $rooms_descr = '<span class="red">('.$v_val['available_rooms'].' '._ROOMS_LEFT.')</span>';
							else $rooms_descr = '<span class="green">('._AVAILABLE.')</span>';

							$output .= '<form action="index.php?page=booking" method="post">'.$nl;
							$output .= draw_hidden_field('hotel_id', $key, false).$nl;
							$output .= draw_hidden_field('room_id', $room[0]['id'], false).$nl;
							$output .= draw_hidden_field('from_date', $params['from_date'], false).$nl;
							$output .= draw_hidden_field('to_date', $params['to_date'], false).$nl;
							$output .= draw_hidden_field('nights', $params['nights'], false).$nl;
							$output .= draw_hidden_field('adults', $params['max_adults'], false).$nl;
							$output .= draw_hidden_field('children', $params['max_children'], false).$nl;
							$output .= draw_hidden_field('hotel_sel_id', $params['hotel_sel_id'], false).$nl;
							$output .= draw_hidden_field('hotel_sel_loc_id', $params['hotel_sel_loc_id'], false).$nl;
							$output .= draw_hidden_field('sort_by', $params['sort_by'], false).$nl;
							$output .= draw_hidden_field('checkin_year_month', $params['from_year'].'-'.(int)$params['from_month'], false).$nl;
							$output .= draw_hidden_field('checkin_monthday', $params['from_day'], false).$nl;
							$output .= draw_hidden_field('checkout_year_month', $params['to_year'].'-'.(int)$params['to_month'], false).$nl;
							$output .= draw_hidden_field('checkout_monthday', $params['to_day'], false).$nl;
							$output .= draw_token_field(false).$nl;							

							$output .= '<tr>';
							$output .= '  <td align="left">&nbsp;'.prepare_link('rooms', 'room_id', $room[0]['id'], $room[0]['loc_room_type'], $room[0]['loc_room_type'], '', _CLICK_TO_VIEW).' '.$rooms_descr.'</td>';
							$output .= '  <td align="center">'.$room[0]['max_adults'].'</td>';
							$output .= '  <td align="center">'.(($allow_children == 'yes') ? $room[0]['max_children'] : '').'</td>';
							$output .= '  <td align="center">';
									if($allow_guests == 'yes' && $room[0]['max_guests'] > 0){
										$output .= $this->DrawGuestsDDL($room[0]['id'], $room[0]['max_guests'], $params, $currency_rate, $currency_format, $allow_booking, false);
									}else{
										$output .= '--';
									}
							$output .= '  </td>';
							$output .= '  <td align="center">';
								if(!empty($v_val['available_rooms'])){
									$output .= '<select name="available_rooms" class="available_rooms_ddl" style="width:110px" '.($allow_booking ? '' : 'disabled="disabled"').'>';
 									$options = '';
									for($i = 1; $i <= $v_val['available_rooms']; $i++){
										$room_price_i = $room_price * $i;
										$room_price_i_formatted = Currencies::PriceFormat(($room_price * $i) / $currency_rate, '', '', $currency_format);
										$options .= '<option value="'.$i.'-'.$room_price_i.'" '; 
										$options .= ($i == '0') ? 'selected="selected" ' : '';
										$options .= '>'.$i.(($i != 0) ? ' ('.$room_price_i_formatted.')' : '').'</option>';
									}
									$output .= $options.'</select>';
								}
							$output .= '  </td>';
							if($params['nights'] > 1){
								$output .= '<td align="center">'.Currencies::PriceFormat(($room_price / $currency_rate) / $params['nights'], '', '', $currency_format).'</td>';
							}else{
								$output .= '<td align="center">'.Currencies::PriceFormat($room_price, '', '', $currency_format).'</td>';
							}
							if($meal_plans[1] > 0){
								$output .= '<td align="center">';
								if(!empty($v_val['available_rooms'])){
									$output .= MealPlans::DrawMealPlansDDL($meal_plans, $currency_rate, $currency_format, $allow_booking, false);
								}
								$output .= '</td>';
							}
							$output .= '<td align="right">';
							$output .= (($allow_booking && $v_val['available_rooms']) ? '<input type="submit" class="form_button_middle" style="margin:3px;" value="'._BOOK_NOW.'!" />' : '');
							$output .= '</td>';
							$output .= '</tr>';
							$output .= '</form>'.$nl;
						}
					}
					$output .= '</div>';					
				}				
			}
			
			$output .= $this->DrawPaginationLinks($total_pages, $current_page, $params, false);			
		}
		
		//$output .= '<br>';

		if($draw) echo $output;
		else return $output;
	}

    /**
	 * Draws room description
	 * 		@param $room_id
	 * 		@param $back_button
	 */
	public static function DrawRoomDescription($room_id, $back_button = true)
	{		
		global $objLogin;

		$lang = Application::Get('lang');
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$hotels_count = Hotels::HotelsCount();
		$output = '';
		
		$sql = 'SELECT
					r.id,
					r.room_type,
					r.hotel_id,
					r.room_count,
					r.max_adults,
					r.max_children,
					r.beds,
					r.bathrooms,
					r.default_price,
					r.facilities,
					r.room_icon,
					r.room_icon_thumb,
					r.room_picture_1,
					r.room_picture_1_thumb,
					r.room_picture_2,
					r.room_picture_2_thumb,
					r.room_picture_3,
					r.room_picture_3_thumb,
					r.room_picture_4,
					r.room_picture_4_thumb,
					r.room_picture_5,
					r.room_picture_5_thumb,
					r.is_active,
					rd.room_type as loc_room_type,
					rd.room_long_description as loc_room_long_description,
					hd.name as hotel_name
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id
					INNER JOIN '.TABLE_HOTELS.' h ON r.hotel_id = h.id
					INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON r.hotel_id = hd.hotel_id
				WHERE
					h.is_active = 1 AND 
					r.id = '.(int)$room_id.' AND
					hd.language_id = \''.$lang.'\' AND
					rd.language_id = \''.$lang.'\'';
					
		$room_info = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);

		$room_type 		  = isset($room_info['loc_room_type']) ? $room_info['loc_room_type'] : '';
		$room_long_description = isset($room_info['loc_room_long_description']) ? $room_info['loc_room_long_description'] : '';
		$facilities       = isset($room_info['facilities']) ? unserialize($room_info['facilities']) : array();
		$room_count       = isset($room_info['room_count']) ? $room_info['room_count'] : '';
		$max_adults       = isset($room_info['max_adults']) ? $room_info['max_adults'] : '';
		$max_children  	  = isset($room_info['max_children']) ? $room_info['max_children'] : '';
		$beds             = isset($room_info['beds']) ? $room_info['beds'] : '';
		$bathrooms        = isset($room_info['bathrooms']) ? $room_info['bathrooms'] : '';
		$default_price    = isset($room_info['default_price']) ? $room_info['default_price'] : '';
		$room_icon        = isset($room_info['room_icon']) ? $room_info['room_icon'] : '';
		$room_picture_1	  = isset($room_info['room_picture_1']) ? $room_info['room_picture_1'] : '';
		$room_picture_2	  = isset($room_info['room_picture_2']) ? $room_info['room_picture_2'] : '';
		$room_picture_3	  = isset($room_info['room_picture_3']) ? $room_info['room_picture_3'] : '';
		$room_picture_4	  = isset($room_info['room_picture_4']) ? $room_info['room_picture_4'] : '';
		$room_picture_5	  = isset($room_info['room_picture_5']) ? $room_info['room_picture_5'] : '';
		$room_picture_1_thumb = isset($room_info['room_picture_1_thumb']) ? $room_info['room_picture_1_thumb'] : '';
		$room_picture_2_thumb = isset($room_info['room_picture_2_thumb']) ? $room_info['room_picture_2_thumb'] : '';
		$room_picture_3_thumb = isset($room_info['room_picture_3_thumb']) ? $room_info['room_picture_3_thumb'] : '';
		$room_picture_4_thumb = isset($room_info['room_picture_4_thumb']) ? $room_info['room_picture_4_thumb'] : '';
		$room_picture_5_thumb = isset($room_info['room_picture_5_thumb']) ? $room_info['room_picture_5_thumb'] : '';
		$hotel_name       = isset($room_info['hotel_name']) ? $room_info['hotel_name'] : '';
		$is_active		  = (isset($room_info['is_active']) && $room_info['is_active'] == 1) ? _AVAILABLE : _NOT_AVAILABLE;		

		if(count($room_info) > 0){

			// prepare facilities array		
			$total_facilities = RoomFacilities::GetAllActive();
			$arr_facilities = array();
			foreach($total_facilities[0] as $key => $val){
				$arr_facilities[$val['id']] = $val['name'];
			}

			$output .= '<div class="room_description">';
                            $output .= '<div>';
                                    $output .= '<h4>'.$room_type.'&nbsp;';				
                                    if($hotels_count > 1) $output .= ' ('.prepare_link('hotels', 'hid', $room_info['hotel_id'], $hotel_name, $hotel_name, '', _CLICK_TO_VIEW).')';
                                    $output .= '</h4>';
                            $output .= '</div>';
                            $output .= '<div style="padding: 20px 0;">';
			///$output .= '  <img class='room_icon' src='images/rooms_icons/'.$room_icon.'' width='165px' alt='' />';
			if($room_picture_1 == '' && $room_picture_2 == '' && $room_picture_3 == '' && $room_picture_4 == '' && $room_picture_5 == ''){
				$output .= '<img class="room_icon_full" src="images/rooms_icons/no_image.png" alt="" />';
			}
			if($room_picture_1 != '') $output .= ' <a href="images/rooms_icons/'.$room_picture_1.'" rel="lyteshow" title="'._IMAGE.' 1"><img class="room_icon icon_thumb" src="images/rooms_icons/'.$room_picture_1.'" alt="" width="100%" /></a>';
                                $output .= '<div style="padding: 10px 0;">';
			if($room_picture_2 != '') $output .= ' <a href="images/rooms_icons/'.$room_picture_2.'" rel="lyteshow" title="'._IMAGE.' 2"><img class="room_icon icon_thumb" src="images/rooms_icons/'.$room_picture_2.'" height="60px" alt="" /></a>';
			if($room_picture_3 != '') $output .= ' <a href="images/rooms_icons/'.$room_picture_3.'" rel="lyteshow" title="'._IMAGE.' 3"><img class="room_icon icon_thumb" src="images/rooms_icons/'.$room_picture_3.'" height="60px" alt="" /></a>';
			if($room_picture_4 != '') $output .= ' <a href="images/rooms_icons/'.$room_picture_4.'" rel="lyteshow" title="'._IMAGE.' 4"><img class="room_icon icon_thumb" src="images/rooms_icons/'.$room_picture_4.'" height="60px" alt="" /></a>';
			if($room_picture_5 != '') $output .= ' <a href="images/rooms_icons/'.$room_picture_5.'" rel="lyteshow" title="'._IMAGE.' 5"><img class="room_icon icon_thumb" src="images/rooms_icons/'.$room_picture_5.'" height="60px" alt="" /></a>';
                                $output .= '</div>'
                                    . '</div>';
                                // draw prices table
                            $output .= '<div><h4>'._PRICES.'</h4></div>';
                            $output .= '<div style="margin: 0 0 20px 0; display: none;">'.self::GetRoomPricesTableVertical($room_id).'</div>';
                            $output .= '<div class="left">';
                                
                                if($back_button){ 
                                        if(!$objLogin->IsLoggedInAsAdmin()){ 
                                                if(Modules::IsModuleInstalled('booking')){
                                                        if(ModulesSettings::Get('booking', 'show_reservation_form') == 'yes'){
                                                                $output .= '<div><h4>'._RESERVATION.'</h4></div>';
                                                                $output .= '<div>'.self::DrawSearchAvailabilityBlock3(false, $room_id, $max_adults, $max_children, true, '', '', false).'</div>';
                                                        }
                                                }
                                        }
                                }
                            $output .= '</div>';
                            $output .= '<div class="right">';
                                $output .= '<div>'.$room_long_description.'</div>';
                                $output .= '<h4>'._FACILITIES.':</h4>';
                                $output .= '<ul class="bullet-circle">';
                                if(is_array($facilities)){
                                        foreach($facilities as $key => $val){
                                                if(isset($arr_facilities[$val])) $output .= '<li>'.$arr_facilities[$val].'</li>';
                                        }					
                                }
                                $output .= '</ul>';
                                $output .= '<div><b>'._COUNT.':</b> '.$room_count.'</div>';
                                $output .= '<div><b>'._MAX_ADULTS.':</b> '.$max_adults.'</div>';
                                if(!empty($beds)) $output .= '<div><b>'._BEDS.':</b> '.$beds.'</div>';
                                if(!empty($bathrooms)) $output .= '<div><b>'._BATHROOMS.':</b> '.$bathrooms.'</div>';
                                //$output .= '<tr><td><b>'._DEFAULT_PRICE.':</b> '.Currencies::PriceFormat($default_price).'</td></tr>';
                                $output .= '<div><b>'._AVAILABILITY.':</b> '.$is_active.'</div>';
                            $output .= '</div>';
                            $output .= '<div class="clear"></div>';
			$output .= '</div>';
			
		}else{
			$output .= draw_important_message(_WRONG_PARAMETER_PASSED, false);		
		}
		
		echo $output;	
	}
	
	/**
	 *	Get room price for a certain period of time
	 *		@param $room_id
	 *		@param $params
	 */
	private function GetRoomPrice($room_id, $params)
	{		
		// improve: how to make it takes default price if not found another ?
		// make check periods for 2, 3 days?
		$debug = false;
		
		$date_from = $params['from_year'].'-'.self::ConvertToDecimal($params['from_month']).'-'.self::ConvertToDecimal($params['from_day']);
		$date_to = $params['to_year'].'-'.self::ConvertToDecimal($params['to_month']).'-'.self::ConvertToDecimal($params['to_day']);
		$room_default_price = $this->GetRoomDefaultPrice($room_id);
		$arr_week_default_price = $this->GetRoomWeekDefaultPrice($room_id);
        
		// calculate available discounts for specific period of time
		$arr_standard_discounts = Campaigns::GetCampaignInfo('', $date_from, $date_to, 'standard');
	
		$total_price = '0';
		$offset = 0;
		while($date_from < $date_to){
			$curr_date_from = $date_from;

			$offset++;			
			$current = getdate(mktime(0,0,0,$params['from_month'],$params['from_day']+$offset,$params['from_year']));
			$date_from = $current['year'].'-'.self::ConvertToDecimal($current['mon']).'-'.self::ConvertToDecimal($current['mday']);
			
			$curr_date_to = $date_from;
			if($debug) echo '<br> ('.$curr_date_from.' == '.$curr_date_to.') ';
			
			$sql = 'SELECT
						r.id,
						r.default_price,
						rp.adults,
						rp.children,
						rp.mon,
						rp.tue,
						rp.wed,
						rp.thu,
						rp.fri,
						rp.sat,
						rp.sun,
						rp.sun,
						rp.is_default
					FROM '.TABLE_ROOMS.' r
						INNER JOIN '.TABLE_ROOMS_PRICES.' rp ON r.id = rp.room_id
					WHERE
						r.id = '.(int)$room_id.' AND
						rp.adults >= '.(int)$params['max_adults'].' AND
						rp.children >= '.(int)$params['max_children'].' AND 
						(
							(rp.date_from <= \''.$curr_date_from.'\' AND rp.date_to = \''.$curr_date_from.'\') OR
							(rp.date_from <= \''.$curr_date_from.'\' AND rp.date_to >= \''.$curr_date_to.'\')
						) AND
						rp.is_default = 0
					ORDER BY rp.adults ASC, rp.children ASC';
						
			$room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($room_info[1] > 0){
				$arr_week_price = $room_info[0];
				
				// calculate total sum, according to week day prices
				$start = $current_date = strtotime($curr_date_from); 
				$end = strtotime($curr_date_to); 
				while($current_date < $end) {
					// take default weekday price if weekday price is empty
					if(empty($arr_week_price[strtolower(date('D', $current_date))])){
						if($debug) echo '-'.$arr_week_default_price[strtolower(date('D', $current_date))];	
						$room_price = $arr_week_default_price[strtolower(date('D', $current_date))];	
					}else{
						if($debug) echo '='.$arr_week_price[strtolower(date('D', $current_date))];
						$room_price = $arr_week_price[strtolower(date('D', $current_date))];
					}

					if(isset($arr_standard_discounts[$curr_date_from])){
						$room_price = $room_price * (1 - ($arr_standard_discounts[$curr_date_from] / 100));
						if($debug) echo ' after '.$arr_standard_discounts[$curr_date_from].'%= '.$room_price;
					}
					$total_price += $room_price;
					$current_date = strtotime('+1 day', $current_date); 
				}
				
			}else{
				// add default (standard) price
				if($debug) echo '>'.$arr_week_default_price[strtolower(date('D', strtotime($curr_date_from)))];
				$t_price = $arr_week_default_price[strtolower(date('D', strtotime($curr_date_from)))];
				if(!empty($t_price)) $room_price = $t_price;
				else $room_price = $room_default_price;

				if(isset($arr_standard_discounts[$curr_date_from])){
					$room_price = $room_price * (1 - ($arr_standard_discounts[$curr_date_from] / 100));
					if($debug) echo ' after '.$arr_standard_discounts[$curr_date_from].'%= '.$room_price;
				}			
				$total_price += $room_price;
			}
		}
        return $total_price;
	}

    /**
     *	Get room price for a certain period of time
     *		@param $room_id
     *		@param $params
     */
    private function GetRoomPriceExtend($room_id, $params, $price_type = 1)
    {
        // improve: how to make it takes default price if not found another ?
        // make check periods for 2, 3 days?
        $debug = false;

        $date_from = $params['from_year'].'-'.self::ConvertToDecimal($params['from_month']).'-'.self::ConvertToDecimal($params['from_day']);
        $date_to = $params['to_year'].'-'.self::ConvertToDecimal($params['to_month']).'-'.self::ConvertToDecimal($params['to_day']);
        $room_default_price = $this->GetRoomDefaultPriceExtend($room_id, $price_type);
        $arr_week_default_price = $this->GetRoomWeekDefaultPriceExtend($room_id, $price_type);

        // calculate available discounts for specific period of time
        $arr_standard_discounts = Campaigns::GetCampaignInfo('', $date_from, $date_to, 'standard');

        $total_price = '0';
        $offset = 0;

        while ($date_from < $date_to) {
            $curr_date_from = $date_from;

            $offset++;
            $current = getdate(mktime(0, 0, 0, $params['from_month'], $params['from_day'] + $offset, $params['from_year']));
            $date_from = $current['year'].'-'.self::ConvertToDecimal($current['mon']).'-'.self::ConvertToDecimal($current['mday']);

            $curr_date_to = $date_from;
            if ($debug) echo '<br> ('.$curr_date_from.' == '.$curr_date_to.') ';

            $sql = 'SELECT rpr.`id` id,
                          `room_id`,
                          `date_from`,
                          `date_to`,
                          `adults`,
                          `children`,
                          `guest_fee`,
                          `mon`,
                          `tue`,
                          `wed`,
                          `thu`,
                          `fri`,
                          `sat`,
                          `sun`,
                          `is_default`,
                          rprext.`id` rooms_prices_extend_id,
                          `rooms_prices_id`,
                          `price_type`,
                          `terms`
				FROM ' . TABLE_ROOMS_PRICES . ' rpr LEFT JOIN ' . TABLE_ROOMS_PRICES_EXTEND . ' rprext ON rpr.id = rprext.rooms_prices_id
				WHERE rpr.room_id = ' . (int)$room_id . ' AND
						rpr.adults >= '.(int)$params['max_adults'].' AND
						rpr.children >= '.(int)$params['max_children'].' AND
						(
							(rpr.date_from <= \''.$curr_date_from.'\' AND rpr.date_to = \''.$curr_date_from.'\') OR
							(rpr.date_from <= \''.$curr_date_from.'\' AND rpr.date_to >= \''.$curr_date_to.'\')
						) AND
						rpr.is_default = 0 AND
						rprext.price_type = ' . $price_type . '
				ORDER BY rpr.adults ASC, rpr.children ASC';

            $room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

            if ($room_info[1] > 0) {
                $arr_week_price = $room_info[0];

                // calculate total sum, according to week day prices
                $start = $current_date = strtotime($curr_date_from);
                $end = strtotime($curr_date_to);

                while ($current_date < $end) {
                    // take default weekday price if weekday price is empty
                    if (empty($arr_week_price[strtolower(date('D', $current_date))])){
                        if ($debug) 
                        	echo '-'.$arr_week_default_price[strtolower(date('D', $current_date))];

                        $room_price = $arr_week_default_price[strtolower(date('D', $current_date))];
                    } else {
                        if($debug) 
                        	echo '='.$arr_week_price[strtolower(date('D', $current_date))];

                        $room_price = $arr_week_price[strtolower(date('D', $current_date))];
                    }

                    if (isset($arr_standard_discounts[$curr_date_from])){
                        $room_price = $room_price * (1 - ($arr_standard_discounts[$curr_date_from] / 100));
                        
                        if ($debug) 
                        	echo ' after '.$arr_standard_discounts[$curr_date_from].'%= '.$room_price;
                    }

                    $total_price += $room_price;
                    $current_date = strtotime('+1 day', $current_date);
                }

            } else {
                // add default (standard) price
                if($debug) 
                	echo '>'.$arr_week_default_price[strtolower(date('D', strtotime($curr_date_from)))];

                $t_price = $arr_week_default_price[strtolower(date('D', strtotime($curr_date_from)))];
                
                if (!empty($t_price)) 
                	$room_price = $t_price;
                else 
                	$room_price = $room_default_price;

                if(isset($arr_standard_discounts[$curr_date_from])){
                    $room_price = $room_price * (1 - ($arr_standard_discounts[$curr_date_from] / 100));
                    
                    if($debug) 
                    	echo ' after '.$arr_standard_discounts[$curr_date_from].'%= '.$room_price;
                }

                $total_price += $room_price;
            }
        }
        return $total_price;
    }

	/**
	 *	Get room guest price for a certain period of time
	 *		@param $room_id
	 *		@param $params
	 */
	private function GetRoomGuestPrice($room_id, $params)
	{
		$guest_price = '0';
		
		$sql = 'SELECT
					r.id,
					r.id,
					rp.guest_fee
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_PRICES.' rp ON r.id = rp.room_id
				WHERE
					r.id = '.(int)$room_id.' AND
					(
						(
							rp.is_default = 0 AND 
							rp.adults >= '.(int)$params['max_adults'].' AND
							rp.children >= '.(int)$params['max_children'].' AND 
							( (rp.date_from <= \''.$params['from_date'].'\' AND rp.date_to = \''.$params['from_date'].'\') OR
							  (rp.date_from <= \''.$params['from_date'].'\' AND rp.date_to >= \''.$params['to_date'].'\')
							) 						
						)
						OR
						(
							rp.is_default = 1
						)
					)
				ORDER BY rp.adults ASC, rp.children ASC, rp.is_default ASC';
		$room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room_info[1] > 0){
			$guest_price = $room_info[0]['guest_fee'];			
		}
		
		return $guest_price;		
	}

	/**
	 *	Returns room default price
	 *		@param $room_id
	 */
	private function GetRoomDefaultPrice($room_id)
	{
		$sql = 'SELECT
					r.id,
					r.default_price,
					rp.mon,
					rp.tue,
					rp.wed,
					rp.thu,
					rp.fri,
					rp.sat,
					rp.sun,
					rp.sun,
					rp.is_default
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_PRICES.' rp ON r.id = rp.room_id
				WHERE
					r.id = '.(int)$room_id.' AND
					rp.is_default = 1';
					
		$room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room_info[1] > 0){
			return $room_info[0]['mon'];
		}else{
			return $room_info[0]['default_price'];
		}
	}

	/**
	 *	Returns room default price
	 *		@param $room_id
	 */
	private function GetRoomDefaultPriceExtend($room_id, $price_type = 1)
	{	
		$sql = 'SELECT rpr.`id` id,
                          `room_id`,
                          `date_from`,
                          `date_to`,
                          `adults`,
                          `children`,
                          `guest_fee`,
                          `mon`,
                          `tue`,
                          `wed`,
                          `thu`,
                          `fri`,
                          `sat`,
                          `sun`,
                          `is_default`,
                          rprext.`id` rooms_prices_extend_id,
                          `rooms_prices_id`,
                          `price_type`,
                          `terms`
				FROM ' . TABLE_ROOMS_PRICES . ' rpr LEFT JOIN ' . TABLE_ROOMS_PRICES_EXTEND . ' rprext ON rpr.id = rprext.rooms_prices_id
				WHERE rpr.room_id = ' . (int)$room_id . ' 
						AND rpr.is_default = 1
						AND rprext.price_type = ' . $price_type . ' 
				ORDER BY rprext.price_type ASC';
					
		$room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

		if($room_info[1] > 0) {
			return $room_info[0][strtolower(date('D', time()))];
		} else {
			return $room_info[0]['default_price'];
		}
	}

	/**
	 *	Returns room week default price
	 *		@param $room_id
	 */
	private function GetRoomWeekDefaultPrice($room_id, $price_type = 1)
	{		
		$sql = 'SELECT
					r.id,
					r.default_price,
					rp.mon,
					rp.tue,
					rp.wed,
					rp.thu,
					rp.fri,
					rp.sat,
					rp.sun,
					rp.sun,
					rp.is_default
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_PRICES.' rp ON r.id = rp.room_id
				WHERE
					r.id = '.(int)$room_id.' AND
					rp.is_default = 1';					

		$room_default_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

		if($room_default_info[1] > 0){
			return $room_default_info[0];
		}

		return array();
	}

	/**
	 *	Returns room week default price
	 *		@param $room_id
	 */
	private function GetRoomWeekDefaultPriceExtend($room_id, $price_type = 1)
	{
		$sql = 'SELECT rpr.`id` id,
                          `room_id`,
                          `date_from`,
                          `date_to`,
                          `adults`,
                          `children`,
                          `guest_fee`,
                          `mon`,
                          `tue`,
                          `wed`,
                          `thu`,
                          `fri`,
                          `sat`,
                          `sun`,
                          `is_default`,
                          rprext.`id` rooms_prices_extend_id,
                          `rooms_prices_id`,
                          `price_type`,
                          `terms`
				FROM ' . TABLE_ROOMS_PRICES . ' rpr LEFT JOIN ' . TABLE_ROOMS_PRICES_EXTEND . ' rprext ON rpr.id = rprext.rooms_prices_id
				WHERE rpr.room_id = ' . (int)$room_id . ' 
						AND rpr.is_default = 1
						AND rprext.price_type = ' . $price_type . ' 
				ORDER BY rprext.price_type ASC';

		$room_default_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);

		if ($room_default_info[1] > 0) {
			return $room_default_info[0];
		}

		return array();
	}

	/**
	 *	Returns room availability for month
	 *		@param $arr_rooms
	 *		@param $year
	 *		@param $month
	 *		@param $day
	 */
	public static function GetRoomAvalibilityForWeek($arr_rooms, $year, $month, $day)
	{
		//echo '$year, $month, $day';
		$end_date = date('Y-m-d', strtotime('+7 day', strtotime($year.'-'.$month.'-'.$day)));
		$end_date = explode('-', $end_date);
		$year_end = $end_date['0'];
		$month_end = $end_date['1'];
		$day_end = $end_date['2'];
		
		$today = date('Ymd');
		$today_month = date('Ym');
				
		for($i=0; $i<count($arr_rooms); $i++){
			$arr_rooms[$i]['availability'] = array('01'=>0, '02'=>0, '03'=>0, '04'=>0, '05'=>0, '06'=>0, '07'=>0, '08'=>0, '09'=>0, '10'=>0, '11'=>0, '12'=>0, '13'=>0, '14'=>0, '15'=>0,
										           '16'=>0, '17'=>0, '18'=>0, '19'=>0, '20'=>0, '21'=>0, '22'=>0, '23'=>0, '24'=>0, '25'=>0, '26'=>0, '27'=>0, '28'=>0, '29'=>0, '30'=>0, '31'=>0);
			// exit if we in the past
			if($today_month > $year.$month) continue;

			// fill array with rooms availability
			// ------------------------------------
			$sql = 'SELECT * FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE room_id = '.(int)$arr_rooms[$i]['id'].' AND m = '.(int)$month;
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);			
			if($result[1] > 0){
				for($d = (int)$day; (($d <= (int)$day+7) && ($d <= 31)); $d ++){
					$arr_rooms[$i]['availability'][self::ConvertToDecimal($d)] = (int)$result[0]['d'.$d];
				}				
			}
			
			// fill array with rooms availability
			// ------------------------------------
			if($month_end != $month){
				$sql = 'SELECT * FROM '.TABLE_ROOMS_AVAILABILITIES.' WHERE room_id = '.(int)$arr_rooms[$i]['id'].' AND m = '.(int)$month_end;
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);			
				if($result[1] > 0){
					for($d = 1; ($d <= (int)$day_end); $d ++){
						$arr_rooms[$i]['availability'][self::ConvertToDecimal($d)] = (int)$result[0]['d'.$d];
					}				
				}				
			}
		}

		///echo '<pre>';
		///print_r($arr_rooms[0]);
		///echo '</pre>';
				
		return $arr_rooms;
	}

	/**
	 *	Returns room availability for month
	 *		@param $arr_rooms
	 *		@param $year
	 *		@param $month
	 */
	public static function GetRoomAvalibilityForMonth($arr_rooms, $year, $month)
	{
		$today = date('Ymd');
		$today_year_month = date('Ym');
		$today_year = date('Y');
				
		for($i=0; $i<count($arr_rooms); $i++){
			$arr_rooms[$i]['availability'] = array('01'=>0, '02'=>0, '03'=>0, '04'=>0, '05'=>0, '06'=>0, '07'=>0, '08'=>0, '09'=>0, '10'=>0, '11'=>0, '12'=>0, '13'=>0, '14'=>0, '15'=>0,
										           '16'=>0, '17'=>0, '18'=>0, '19'=>0, '20'=>0, '21'=>0, '22'=>0, '23'=>0, '24'=>0, '25'=>0, '26'=>0, '27'=>0, '28'=>0, '29'=>0, '30'=>0, '31'=>0);
			// exit if we in the past
			if($today_year_month > $year.$month) continue;

			// fill array with rooms availability
			// ------------------------------------
			if(isset($arr_rooms[$i]['id'])){
				$sql = 'SELECT *
						FROM '.TABLE_ROOMS_AVAILABILITIES.'
				        WHERE room_id = '.(int)$arr_rooms[$i]['id'].' AND
							  y = '.(($today_year == $year) ? '0' : '1').' AND	
						      m = '.(int)$month;
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){
					for($day = 1; $day <= 31; $day ++){
						$arr_rooms[$i]['availability'][self::ConvertToDecimal($day)] = (int)$result[0]['d'.$day];
					}				
				}				
			}
		}

		//echo '<pre>';
		//print_r($arr_rooms);
		//echo '</pre>';
				
		return $arr_rooms;
	}
	
	/**
	 *	Returns room week default availability 
	 *		@param $room_id
	 *		@param $checkin_date
	 *		@param $checkout_date
	 *		@param $avail_rooms
	 */
	private function CheckAvailabilityForPeriod($room_id, $checkin_date, $checkout_date, $avail_rooms = 0)	
	{
		$available_rooms = $avail_rooms;
		$available_until_approval = ModulesSettings::Get('booking', 'available_until_approval');
		
		// calculate total sum, according to week day prices
		$current_date = strtotime($checkin_date);
		$current_year = date('Y');
		$end = strtotime($checkout_date);
		$m_old = '';		
		
		while($current_date < $end) {
			$y = date('Y', $current_date);
			$m = date('m', $current_date);
			$d = date('d', $current_date);
			
            if($m_old != $m){
				$sql = 'SELECT * 
						FROM '.TABLE_ROOMS_AVAILABILITIES.' ra
						WHERE ra.room_id = '.(int)$room_id.' AND
							  ra.y = '.(($y == $current_year) ? '0' : '1').' AND
							  ra.m = '.(int)$m;
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			}

			if($result[1] > 0){
				///echo '<br />'.$result[1].' Room ID: '.$room_id.' Day: '.$d.' Avail: '.$result[0]['d'.(int)$d];
				if($result[0]['d'.(int)$d] <= 0){
					return 0;
				}else{
					$current_date_formated = date('Y-m-d', $current_date);
					// check maximal booked rooms for this day!!!
					$sql = 'SELECT
								SUM('.TABLE_BOOKINGS_ROOMS.'.rooms) as total_booked_rooms
							FROM '.TABLE_BOOKINGS.'
								INNER JOIN '.TABLE_BOOKINGS_ROOMS.' ON '.TABLE_BOOKINGS.'.booking_number = '.TABLE_BOOKINGS_ROOMS.'.booking_number
							WHERE
								('.(($available_until_approval == 'yes') ? '' : TABLE_BOOKINGS.'.status = 1 OR ').' '.TABLE_BOOKINGS.'.status = 2) AND
								'.TABLE_BOOKINGS_ROOMS.'.room_id = '.(int)$room_id.' AND
								(
									(\''.$current_date_formated.'\' >= checkin AND \''.$current_date_formated.'\' < checkout) 
									OR
									(\''.$current_date_formated.'\' = checkin AND \''.$current_date_formated.'\' = checkout) 
								)';
					$result1 = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
					if($result1[1] > 0){
						///echo '<br>T: '.$result[0]['d'.(int)$d].' Reserved/B: '.$result1[0]['total_booked_rooms'];
						if($result1[0]['total_booked_rooms'] >= $result[0]['d'.(int)$d]){
							return 0;
						}else{
							$available_diff = $result[0]['d'.(int)$d] - $result1[0]['total_booked_rooms'];
							if($available_diff < $available_rooms){
								$available_rooms = $available_diff;
							}
						}
					}
				}
			}else{
				return 0;
			}
			$m_old = $m;
			$current_date = strtotime('+1 day', $current_date); 
		}		
		return $available_rooms;		
	}

	/**
	 *	Convert to decimal number with leading zero
	 *  	@param $number
	 */	
	private static function ConvertToDecimal($number)
	{
		return (($number < 0) ? '-' : '').((abs($number) < 10) ? '0' : '').abs($number);
	}

	/**
	 *	Get price for specific date (1 night)
	 *		@param $day
	 */
	public static function GetPriceForDate($rid, $day)
	{
		// get a week day of $day
		$week_day = strtolower(date('D', strtotime($day))); 

		$sql = 'SELECT '.$week_day.' as price
				FROM '.TABLE_ROOMS_PRICES.'
				WHERE
					(
						is_default = 1 OR
						(is_default = 0 AND date_from <= \''.$day.'\' AND \''.$day.'\' <= date_to)
					) AND 
					room_id = '.(int)$rid.'
				ORDER BY is_default ASC
				LIMIT 0, 1';
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			return $result[0]['price'];
		}else{
			return '0';
		}
	}

	/**
	 *	Get room info
	 *	  	@param $room_id
	 *	  	@param $param
	 */
	public static function GetRoomInfo($room_id, $param)
	{
		$lang = Application::Get('lang');
		$output = '';
		
		$sql = 'SELECT
					r.id,
					r.room_count,
					r.max_adults,
					r.max_children,
					r.beds,
					r.bathrooms,
					r.default_price,
					r.room_icon,					
					r.room_picture_1,
					r.room_picture_2,
					r.room_picture_3,
					r.room_picture_4,
					r.room_picture_5,
					r.is_active,
					rd.room_type,
					rd.room_short_description,
					rd.room_long_description
				FROM '.TABLE_ROOMS.' r
					INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id
				WHERE
					r.id = '.(int)$room_id.' AND
					rd.language_id = \''.$lang.'\'';

		$room_info = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($room_info[1] > 0){
			$output = isset($room_info[0][$param]) ? $room_info[0][$param] : '';
		}
		return $output;
	}

	/**
	 *	Returns room types default price
	 *		@param 4where
	 */
	public static function GetRoomTypes($where = '')
	{
		global $objLogin;
		
		$lang = Application::Get('lang');
		$output = '';
		$where_clause = '';

		if($objLogin->IsLoggedInAs('hotelowner')){
			$hotels_list = implode(',', $objLogin->AssignedToHotels());
			if(!empty($hotels_list)) $where_clause .= ' AND r.hotel_id IN ('.$hotels_list.')';
		}
		
		if(!empty($where)) $where_clause .= ' AND r.hotel_id = '.(int)$where;
		
		$sql = 'SELECT
					r.id,
					r.hotel_id,
					r.room_count,
					rd.room_type,
					\'\' as availability,
					hd.name as hotel_name					
				FROM '.TABLE_ROOMS.' r 
					INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id AND rd.language_id = \''.$lang.'\'
					INNER JOIN '.TABLE_HOTELS.' h ON r.hotel_id = h.id AND h.is_active = 1
					INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON r.hotel_id = hd.hotel_id AND hd.language_id = \''.$lang.'\'
				WHERE 1 = 1
				    '.$where_clause.'
				ORDER BY r.hotel_id ASC, r.priority_order ASC';

		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);

		if($result[1] > 0){
			return $result[0];
		}else{
			return array();
		}
	}

	/**
	 *	Returns last day of month
	 *		@param $month
	 *		@param $year
	 */
	public static function GetMonthLastDay($month, $year)
	{
		if(empty($month)) {
		   $month = date('m');
		}
		if(empty($year)) {
		   $year = date('Y');
		}
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('d', $result);
	}
	
	/**
	 *	Draws search availability block
	 *	    @param $show_calendar
	 *	    @param $room_id
	 *	    @param $m_adults
	 *	    @param $m_children
	 *	    @param $inline
	 *	    @param $action_url
	 *	    @param $target
	 *	    @param $draw
	 */
	public static function DrawSearchAvailabilityBlock($show_calendar = true, $room_id = '', $m_adults = 8, $m_children = 3, $inline = false, $action_url = '', $target = '', $draw = true)
	{	
		$current_day = date('d');
		$maximum_adults = ($inline) ? $m_adults : 8;
		$maximum_children = ($inline) ? $m_children : 3;
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$action_url = ($action_url != '') ? $action_url : APPHP_BASE;
		$target = (!empty($target)) ? $target : '';
		
		$output = '<link rel="stylesheet" type="text/css" href="'.$action_url.'templates/'.Application::Get('template').'/css/calendar.css" />
		<form target="'.$target.'" action="'.$action_url.'index.php?page=check_availability" id="reservation-form" name="reservation-form" method="post">
		'.draw_hidden_field('room_id', $room_id, false).'
		'.draw_hidden_field('p', '1', false, 'page_number').'
		'.draw_token_field(false);
		
		$output_hotels = '';
		$output_locations = '';
		$output_sort_by = '';
		$total_hotels = Hotels::GetAllActive();

		if($total_hotels[1] > 1){
			$selected_hotel_id = isset($_POST['hotel_sel_id']) ? prepare_input($_POST['hotel_sel_id']) : '';
			$output_hotels .= '<select class="" style="width:191px" name="hotel_sel_id">';
			$output_hotels .= '<option value="">-- '._ALL.' --</option>';

			foreach ($total_hotels[0] as $key => $val){
				$output_hotels .= '<option'.(($selected_hotel_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
			}

			$output_hotels .= '</select>';			

			$total_hotels_locations = HotelsLocations::GetHotelsLocations();
			$hotel_sel_loc_id = isset($_POST['hotel_sel_loc_id']) ? prepare_input($_POST['hotel_sel_loc_id']) : '';

			if ($total_hotels_locations[1] > 1){
				$output_locations .= '<select class="" style="width:191px" name="hotel_sel_loc_id">';
				$output_locations .= '<option value="">-- '._ALL.' --</option>';

				foreach($total_hotels_locations[0] as $key => $val){
					$output_locations .= '<option'.(($hotel_sel_loc_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
				}

				$output_locations .= '</select>';			
			}			

			$selected_sort_by = isset($_POST['sort_by']) ? prepare_input($_POST['sort_by']) : '';
			$output_sort_by = '<label class="label-inline">'._SORT_BY.': </label><select class="star_rating" name="sort_by">
					<option'.(($selected_sort_by == '5-1') ? ' selected="selected"' : '').' value="5-1">'._STARS_5_1.'</option>
					<option'.(($selected_sort_by == '1-5') ? ' selected="selected"' : '').' value="1-5">'._STARS_1_5.'</option>
				</select>&nbsp;';
		}

		$output1 = '<select id="checkin_day" name="checkin_monthday" class="checkin_day" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$selected_day = isset($_POST['checkin_monthday']) ? prepare_input($_POST['checkin_monthday']) : date('d');

						for($i=1; $i<=31; $i++){													
							$output1  .= '<option value="'.$i.'" '.(($selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}

					$output1 .= '</select>
					<select id="checkin_year_month" name="checkin_year_month" class="checkin_year_month" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$selected_year_month = isset($_POST['checkin_year_month']) ? prepare_input($_POST['checkin_year_month']) : date('Y-n');

						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output1 .= '<option value="'.$val.'" '.(($selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}

					$output1 .= '</select>';

					if($show_calendar) $output1 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkin\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22" /></a>';
		
		$output2 = '<select id="checkout_monthday" name="checkout_monthday" class="checkout_day" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$checkout_selected_day = isset($_POST['checkout_monthday']) ? prepare_input($_POST['checkout_monthday']) : date('d');
						for($i=1; $i<=31; $i++){
							$output2 .= '<option value="'.$i.'" '.(($checkout_selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
					$output2 .= '</select>
					<select id="checkout_year_month" name="checkout_year_month" class="checkout_year_month" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$checkout_selected_year_month = isset($_POST['checkout_year_month']) ? prepare_input($_POST['checkout_year_month']) : date('Y-n');
						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output2 .= '<option value="'.$val.'" '.(($checkout_selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}
					$output2 .= '</select>';
					if($show_calendar) $output2 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkout\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22 /></a>';
					
		$output3 = '<label class="label-inline">'._ROOMS.': </label>
					<select class="max_occupation" name="rooms_quantity" id="rooms_quantity">';
        $rooms_quantity = isset($_POST['rooms_quantity']) ? (int)$_POST['rooms_quantity'] : '1';
        $maximum_rooms = 100;

        for($i=1; $i<=$maximum_rooms; $i++){
            $output3 .= '<option value="'.$i.'" '.(($rooms_quantity == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
        }

        $output3 .= '</select>&nbsp;<div style="width:100%; clear:both; height:4px;"></div>';

        $output3 .= '<label class="label-inline">'._ADULTS.': </label>
					<select class="max_occupation" name="max_adults" id="max_adults">';
						$max_adults = isset($_POST['max_adults']) ? (int)$_POST['max_adults'] : '1';
						for($i=1; $i<=$maximum_adults; $i++){
							$output3 .= '<option value="'.$i.'" '.(($max_adults == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
						}
        $output3 .= '</select>&nbsp;<div style="width:100%; clear:both; height:4px;"></div>';
					
					if($allow_children == 'yes'){
						$output3 .= '<label class="label-inline">'._CHILDREN.': </label>';
						$output3 .= '<select class="max_occupation" name="max_children" id="max_children">';
							$max_children = isset($_POST['max_children']) ? (int)$_POST['max_children'] : '0';
							for($i=0; $i<=$maximum_children; $i++){
								$output3 .= '<option value="'.$i.'" '.(($max_children == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
							}
						$output3 .= '</select>';
					}
					
		if($inline){
			$output .= '<table cellspacing="2" border="0">
				<tr>
					<td><label>'._CHECK_IN.':</label></td>
					<td><label>'._CHECK_OUT.':</label></td>
					<td></td>
				</tr>
				<tr>
					<td nowrap="nowrap">'.$output1.'</td>
					<td nowrap="nowrap">'.$output2.'</td>
					<td nowrap="nowrap">'.$output3.'</td>
				</tr>				
				<tr><td colspan="3" style="height:7px"></td></tr>
				<tr><td colspan="3"><input class="button" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._CHECK_AVAILABILITY.'" /></td></tr>	
				</table>';			
		}else{
			$output .= '<table cellspacing="2" border="0">';
			if(!empty($output_hotels)){
				$output .= '<tr><td><label>'._SELECT_HOTEL.':</label></td></tr>
						<tr><td nowrap="nowrap">'.$output_hotels.'</td></tr>';
				
				if($total_hotels_locations[1] > 1) {
					$output .= '<tr><td><label>'._SELECT_LOCATION.':</label></td></tr>
							<tr><td nowrap="nowrap">'.$output_locations.'</td></tr>';
				}
			}			
			$output .= '<tr><td><label>'._CHECK_IN.':</label></td></tr>
						<tr><td nowrap="nowrap">'.$output1.'</td></tr>
						<tr><td><label>'._CHECK_OUT.':</label></td></tr>
						<tr><td nowrap="nowrap">'.$output2.'</td></tr>
						<tr><td style="height:5px"></td></tr>
						<tr><td nowrap="nowrap">'.$output3.'</td></tr>';
			if(!empty($output_hotels)){
				$output .= '<tr><td nowrap="nowrap">'.$output_sort_by.'</td></tr>';
			}
			$output .= '<tr><td style="height:7px"></td></tr>
						<tr><td><input class="button" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._CHECK_AVAILABILITY.'" /></td></tr>	
			</table>';
		}

		
		$output .= '</form>
		<div id="calendar"></div>';
		
		if($draw) echo $output;
		else return $output;
	}
	
	/**
	 *	Draws search availability block 2 - ChoNoi Group
	 *	    @param $show_calendar
	 *	    @param $room_id
	 *	    @param $m_adults
	 *	    @param $m_children
	 *	    @param $inline
	 *	    @param $action_url
	 *	    @param $target
	 *	    @param $draw
	 */
	public static function DrawSearchAvailabilityBlock2($show_calendar = true, $room_id = '', $m_adults = 8, $m_children = 3, $inline = false, $action_url = '', $target = '', $draw = true)
	{	
		$current_day = date('d');
		$maximum_adults = ($inline) ? $m_adults : 8;
		$maximum_children = ($inline) ? $m_children : 3;
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$action_url = ($action_url != '') ? $action_url : APPHP_BASE;
		$target = (!empty($target)) ? $target : '';
		
		$output = '<link rel="stylesheet" type="text/css" href="'.$action_url.'templates/'.Application::Get('template').'/css/calendar.css" />
		<form target="'.$target.'" action="'.$action_url.'index.php?page=check_availability" id="reservation-form" name="reservation-form" method="post">
		'.draw_hidden_field('room_id', $room_id, false).'
		'.draw_hidden_field('p', '1', false, 'page_number').'
		'.draw_token_field(false);
		
		$output_hotels = '';
		$output_locations = '';
		$output_sort_by = '';
		$total_hotels = Hotels::GetAllActive();
		if($total_hotels[1] > 1){
			$selected_hotel_id = isset($_POST['hotel_sel_id']) ? prepare_input($_POST['hotel_sel_id']) : '';
			$output_hotels .= '<select class="" style="width:191px" name="hotel_sel_id">';
			$output_hotels .= '<option value="">-- '._ALL.' --</option>';
			foreach($total_hotels[0] as $key => $val){
				$output_hotels .= '<option'.(($selected_hotel_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
			}
			$output_hotels .= '</select>';			

			$total_hotels_locations = HotelsLocations::GetHotelsLocations();
			$hotel_sel_loc_id = isset($_POST['hotel_sel_loc_id']) ? prepare_input($_POST['hotel_sel_loc_id']) : '';
			if($total_hotels_locations[1] > 1){
				$output_locations .= '<select class="" style="width:191px" name="hotel_sel_loc_id">';
				$output_locations .= '<option value="">-- '._ALL.' --</option>';
				foreach($total_hotels_locations[0] as $key => $val){
					$output_locations .= '<option'.(($hotel_sel_loc_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
				}
				$output_locations .= '</select>';			
			}			

			$selected_sort_by = isset($_POST['sort_by']) ? prepare_input($_POST['sort_by']) : '';
			$output_sort_by = _SORT_BY.': <select class="star_rating" name="sort_by">
					<option'.(($selected_sort_by == '5-1') ? ' selected="selected"' : '').' value="5-1">'._STARS_5_1.'</option>
					<option'.(($selected_sort_by == '1-5') ? ' selected="selected"' : '').' value="1-5">'._STARS_1_5.'</option>
				</select>&nbsp;';
		}

		$output1 = '<select id="checkin_day" name="checkin_monthday" class="checkin_day" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$selected_day = isset($_POST['checkin_monthday']) ? prepare_input($_POST['checkin_monthday']) : date('d');
						for($i=1; $i<=31; $i++){													
							$output1  .= '<option value="'.$i.'" '.(($selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
					$output1 .= '</select>
					<select id="checkin_year_month" name="checkin_year_month" class="checkin_year_month" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$selected_year_month = isset($_POST['checkin_year_month']) ? prepare_input($_POST['checkin_year_month']) : date('Y-n');
						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output1 .= '<option value="'.$val.'" '.(($selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}
					$output1 .= '</select>';
					if($show_calendar) $output1 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkin\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22" /></a>';
		
		$output2 = '<select id="checkout_monthday" name="checkout_monthday" class="checkout_day" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$checkout_selected_day = isset($_POST['checkout_monthday']) ? prepare_input($_POST['checkout_monthday']) : date('d');
						for($i=1; $i<=31; $i++){
							$output2 .= '<option value="'.$i.'" '.(($checkout_selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
					$output2 .= '</select>
					<select id="checkout_year_month" name="checkout_year_month" class="checkout_year_month" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$checkout_selected_year_month = isset($_POST['checkout_year_month']) ? prepare_input($_POST['checkout_year_month']) : date('Y-n');
						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output2 .= '<option value="'.$val.'" '.(($checkout_selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}
					$output2 .= '</select>';
					if($show_calendar) $output2 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkout\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22" /></a>';
					
		$output3 = _ADULTS.':
					<select class="max_occupation" name="max_adults" id="max_adults">';
						$max_adults = isset($_POST['max_adults']) ? (int)$_POST['max_adults'] : '1';
						for($i=1; $i<=$maximum_adults; $i++){
							$output3 .= '<option value="'.$i.'" '.(($max_adults == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
						}
					$output3 .= '</select>&nbsp;';
					
					if($allow_children == 'yes'){
						$output3 .= _CHILDREN.': ';
						$output3 .= '<select class="max_occupation" name="max_children" id="max_children">';
							$max_children = isset($_POST['max_children']) ? (int)$_POST['max_children'] : '0';
							for($i=0; $i<=$maximum_children; $i++){
								$output3 .= '<option value="'.$i.'" '.(($max_children == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
							}
						$output3 .= '</select>';
					}
					
		if($inline){
			$output .= '<table cellspacing="2" border="0">
				<tr>
					<td><label>'._CHECK_IN.':</label></td>
					<td><label>'._CHECK_OUT.':</label></td>
					<td></td>
				</tr>
				<tr>
					<td nowrap="nowrap">'.$output1.'</td>
					<td nowrap="nowrap">'.$output2.'</td>
					<td nowrap="nowrap">'.$output3.'</td>
				</tr>				
				<tr><td colspan="3" style="height:7px"></td></tr>
				<tr><td colspan="3"><input class="button" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._CHECK_AVAILABILITY.'" /></td></tr>	
				</table>';			
		}else{
			$output .= '<table cellspacing="4" border="0" class="info">';
			if(!empty($output_hotels)){
				if($total_hotels_locations[1] > 1) {
					$output .= '<tr><td><label>'._SELECT_HOTEL.':</label></td><td><label>'._SELECT_LOCATION.':</label></td></tr>
							<tr><td nowrap="nowrap" class="inte-col-1 row">'.$output_hotels.'</td><td nowrap="nowrap" class="row">'.$output_locations.'</td></tr>';
				} else {
					$output .= '<tr><td><label>'._SELECT_HOTEL.':</label></td><td><label></label></td></tr>
							<tr><td nowrap="nowrap" class="inte-col-1 row">'.$output_hotels.'</td><td nowrap="nowrap" class="row"></td></tr>';
				}
				
				//$output .= '<tr><td><label>'._SELECT_LOCATION.':</label></td></tr>
				//		<tr><td nowrap="nowrap">'.$output_locations.'</td></tr>';
			}			
			$output .= '<tr><td><label>'._CHECK_IN.':</label></td><td><label>'._CHECK_OUT.':</label></td></tr>
						<tr><td nowrap="nowrap" class="row">'.$output1.'</td><td nowrap="nowrap" class="row">'.$output2.'</td></tr>						
						<tr><td style="height:5px"></td></tr>
						<tr><td nowrap="nowrap" colspan="2">'.$output3.$output_sort_by.'</td></tr>';
			//if(!empty($output_hotels)){
			//	$output .= '<tr><td style="height:5px" cols	pan="2"></td></tr>
			//			<tr><td nowrap="nowrap">'.$output_sort_by.'</td></tr>';
			//}
			$output .= '</table>
						<div class="button-reserve"><input class="button headline" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._RESERVE.' >" /></div>';
		}

		
		$output .= '</form>
		<div id="calendar"></div>';
		
		if($draw) echo $output;
		else return $output;
	}
        
        /**
	 *	Draws search availability block 3 - ChoNoi Group
	 *	    @param $show_calendar
	 *	    @param $room_id
	 *	    @param $m_adults
	 *	    @param $m_children
	 *	    @param $inline
	 *	    @param $action_url
	 *	    @param $target
	 *	    @param $draw
	 */
	public static function DrawSearchAvailabilityBlock3($show_calendar = true, $room_id = '', $m_adults = 8, $m_children = 3, $inline = false, $action_url = '', $target = '', $draw = true)
	{	
		$current_day = date('d');
		$maximum_adults = ($inline) ? $m_adults : 8;
		$maximum_children = ($inline) ? $m_children : 3;
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$action_url = ($action_url != '') ? $action_url : APPHP_BASE;
		$target = (!empty($target)) ? $target : '';
		
		$output = '<link rel="stylesheet" type="text/css" href="'.$action_url.'templates/'.Application::Get('template').'/css/calendar.css" />
		<form target="'.$target.'" action="'.$action_url.'index.php?page=check_availability" id="reservation-form" name="reservation-form" method="post">
		'.draw_hidden_field('room_id', $room_id, false).'
		'.draw_hidden_field('p', '1', false, 'page_number').'
		'.draw_token_field(false);
		
		$output_hotels = '';
		$output_locations = '';
		$output_sort_by = '';
		$total_hotels = Hotels::GetAllActive();
		if($total_hotels[1] > 1){
			$selected_hotel_id = isset($_POST['hotel_sel_id']) ? prepare_input($_POST['hotel_sel_id']) : '';
			$output_hotels .= '<select class="" style="width:191px" name="hotel_sel_id">';
			$output_hotels .= '<option value="">-- '._ALL.' --</option>';
			foreach($total_hotels[0] as $key => $val){
				$output_hotels .= '<option'.(($selected_hotel_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
			}
			$output_hotels .= '</select>';			

			$total_hotels_locations = HotelsLocations::GetHotelsLocations();
			$hotel_sel_loc_id = isset($_POST['hotel_sel_loc_id']) ? prepare_input($_POST['hotel_sel_loc_id']) : '';
			if($total_hotels_locations[1] > 1){
				$output_locations .= '<select class="" style="width:191px" name="hotel_sel_loc_id">';
				$output_locations .= '<option value="">-- '._ALL.' --</option>';
				foreach($total_hotels_locations[0] as $key => $val){
					$output_locations .= '<option'.(($hotel_sel_loc_id == $val['id']) ? ' selected="selected"' : '').' value="'.$val['id'].'">'.$val['name'].'</option>';
				}
				$output_locations .= '</select>';			
			}			

			$selected_sort_by = isset($_POST['sort_by']) ? prepare_input($_POST['sort_by']) : '';
			$output_sort_by = _SORT_BY.': <select class="star_rating" name="sort_by">
					<option'.(($selected_sort_by == '5-1') ? ' selected="selected"' : '').' value="5-1">'._STARS_5_1.'</option>
					<option'.(($selected_sort_by == '1-5') ? ' selected="selected"' : '').' value="1-5">'._STARS_1_5.'</option>
				</select>&nbsp;';
		}

		$output1 = '<select id="checkin_day" name="checkin_monthday" class="checkin_day" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$selected_day = isset($_POST['checkin_monthday']) ? prepare_input($_POST['checkin_monthday']) : date('d');
						for($i=1; $i<=31; $i++){													
							$output1  .= '<option value="'.$i.'" '.(($selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
					$output1 .= '</select>
					<select id="checkin_year_month" name="checkin_year_month" class="checkin_year_month" onchange="cCheckDateOrder(this,\'checkin_monthday\',\'checkin_year_month\',\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$selected_year_month = isset($_POST['checkin_year_month']) ? prepare_input($_POST['checkin_year_month']) : date('Y-n');
						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output1 .= '<option value="'.$val.'" '.(($selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}
					$output1 .= '</select>';
					if($show_calendar) $output1 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkin\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22" /></a>';
		
		$output2 = '<select id="checkout_monthday" name="checkout_monthday" class="checkout_day" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="day prompt" value="0">'._DAY.'</option>';
						$checkout_selected_day = isset($_POST['checkout_monthday']) ? prepare_input($_POST['checkout_monthday']) : date('d');
						for($i=1; $i<=31; $i++){
							$output2 .= '<option value="'.$i.'" '.(($checkout_selected_day == $i) ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
					$output2 .= '</select>
					<select id="checkout_year_month" name="checkout_year_month" class="checkout_year_month" onchange="cCheckDateOrder(this,\'checkout_monthday\',\'checkout_year_month\');cUpdateDaySelect(this);">
						<option class="month prompt" value="0">'._MONTH.'</option>';
						$checkout_selected_year_month = isset($_POST['checkout_year_month']) ? prepare_input($_POST['checkout_year_month']) : date('Y-n');
						for($i=0; $i<12; $i++){
							$cur_time = mktime(0, 0, 0, date('m')+$i, '1', date('Y'));
							$val = date('Y', $cur_time).'-'.(int)date('m', $cur_time);
							$output2 .= '<option value="'.$val.'" '.(($checkout_selected_year_month == $val) ? 'selected="selected"' : '').'>'.get_month_local(date('n', $cur_time)).' \''.date('y', $cur_time).'</option>';
						}
					$output2 .= '</select>';
					if($show_calendar) $output2 .= '<a class="calendar" onclick="cShowCalendar(this,\'calendar\',\'checkout\');" href="javascript:void(0);"><img title="'._PICK_DATE.'" alt="calendar" src="templates/'.Application::Get('template').'/images/button-calendar.png" width="22" /></a>';
					
		$output3 = '<div><label class="label-inline">'._ADULTS.':</label>
					<select class="max_occupation" name="max_adults" id="max_adults">';
						$max_adults = isset($_POST['max_adults']) ? (int)$_POST['max_adults'] : '1';
						for($i=1; $i<=$maximum_adults; $i++){
							$output3 .= '<option value="'.$i.'" '.(($max_adults == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
						}
					$output3 .= '</select></div>';
					
					if($allow_children == 'yes'){
						$output3 .= '<div><label class="label-inline">'._CHILDREN.':</label>';
						$output3 .= '<select class="max_occupation" name="max_children" id="max_children">';
							$max_children = isset($_POST['max_children']) ? (int)$_POST['max_children'] : '0';
							for($i=0; $i<=$maximum_children; $i++){
								$output3 .= '<option value="'.$i.'" '.(($max_children == $i) ? 'selected="selected"' : '').'>'.$i.'&nbsp;</option>';
							}
						$output3 .= '</select></div>';
					}
					
		if($inline){
			$output .= '<div>
					<div><label>'._CHECK_IN.':</label></div>
                                        <div>'.$output1.'</div>
					<div><label>'._CHECK_OUT.':</label></div>
					<div>'.$output2.'</div>'
					.$output3.
                                        '<div><input class="button" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._CHECK_AVAILABILITY.'" /></div>	
                                    </div>';			
		}else{
			$output .= '<div class="info">';
                            if(!empty($output_hotels)){
                                    if($total_hotels_locations[1] > 1) {
                                            $output .= '<div><label>'._SELECT_HOTEL.':</label></div><div><label>'._SELECT_LOCATION.':</label></div>
                                                            <div class="inte-col-1 row">'.$output_hotels.'</div><div class="row">'.$output_locations.'</div>';
                                    } else {
                                            $output .= '<div><label>'._SELECT_HOTEL.':</label></div><div><label></label></div>
                                                            <div class="inte-col-1 row">'.$output_hotels.'</div><div class="row"></div>';
                                    }
                            }			
                            $output .= '<div><label>'._CHECK_IN.':</label></div>'
                                    . '<div class="row">'.$output1.'</div>'
                                    . '<div><label>'._CHECK_OUT.':</label></div>'                                
                                    . '<div class="row">'.$output2.'</div>'
                                    . '<div>'.$output3.$output_sort_by.'</div>';
			$output .= '</div>'
                                . '<div class="button-reserve"><input class="button headline" type="button" onclick="document.getElementById(\'reservation-form\').submit()" value="'._RESERVE.' >" /></div>';
		}

		
		$output .= '</form>
		<div id="calendar"></div>';
		
		if($draw) echo $output;
		else return $output;
	}
	
	/**
	 *	Draws search availability footer scripts
	 *		@param $dir
	 *		@param $action_url
	 */	
	public static function DrawSearchAvailabilityFooter($dir = '', $action_url = '')
	{
		global $objSettings;

		$nl = "\n";		
		$output = '';		
		if(Modules::IsModuleInstalled('booking')){
			$min_nights = ModulesSettings::Get('booking', 'minimum_nights');
			$min_nights_packages = Packages::GetMinimumNights(date('Y-m-01'), date('Y-m-28'));
			if(isset($min_nights_packages['minimum_nights']) && !empty($min_nights_packages['minimum_nights'])) $min_nights = $min_nights_packages['minimum_nights'];
			$action_url = ($action_url != '') ? $action_url : APPHP_BASE;
	
			$output  = '<script type="text/javascript" src="'.$action_url.'templates/'.Application::Get('template').'/js/calendar'.$dir.'.js"></script>'.$nl;
			$output .= '<script type="text/javascript">'.$nl;
			$output .= 'var calendar = new Object();';
			$output .= 'var trCal = new Object();';
			$output .= 'trCal.nextMonth = "'._NEXT.'";';
			$output .= 'trCal.prevMonth = "'._PREVIOUS.'";';
			$output .= 'trCal.closeCalendar = "'._CLOSE.'";';
			$output .= 'trCal.icons = "templates/'.Application::Get('template').'/images/";';
			$output .= 'trCal.iconPrevMonth2 = "'.((Application::Get('defined_alignment') == 'left') ? 'butPrevMonth2.gif' : 'butNextMonth2.gif').'";';
			$output .= 'trCal.iconPrevMonth = "'.((Application::Get('defined_alignment') == 'left') ? 'butPrevMonth.gif' : 'butNextMonth.gif').'";';
			$output .= 'trCal.iconNextMonth2 = "'.((Application::Get('defined_alignment') == 'left') ? 'butNextMonth2.gif' : 'butPrevMonth2.gif').'";';
			$output .= 'trCal.iconNextMonth = "'.((Application::Get('defined_alignment') == 'left') ? 'butNextMonth.gif' : 'butPrevMonth.gif').'";';
			$output .= 'trCal.currentDay = "'.date('d').'";';
			$output .= 'trCal.currentYearMonth = "'.date('Y-n').'";';
			$output .= 'var minimum_nights = "'.(int)$min_nights.'";';
			$output .= 'var months = ["'._JANUARY.'","'._FEBRUARY.'","'._MARCH.'","'._APRIL.'","'._MAY.'","'._JUNE.'","'._JULY.'","'._AUGUST.'","'._SEPTEMBER.'","'._OCTOBER.'","'._NOVEMBER.'","'._DECEMBER.'"];';
			$output .= 'var days = ["'._MON.'","'._TUE.'","'._WED.'","'._THU.'","'._FRI.'","'._SAT.'","'._SUN.'"];'.$nl;
			if(!isset($_POST['checkin_monthday']) && !isset($_POST['checkin_year_month'])){ 
				$output .= 'cCheckDateOrder(document.getElementById("checkin_day"),"checkin_monthday","checkin_year_month","checkout_monthday","checkout_year_month");';
			}			
			$output .= '</script>';
		}		
		echo $output;
	}
	
	/**
	 *	Draw information about rooms and services
	 *		@param $draw
	 */	
	public static function DrawRoomsInfo($draw = true)
	{
		$lang = Application::Get('lang');
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');
		$hotel_id = isset($_POST['hotel_id']) ? (int)$_POST['hotel_id'] : '';
		$total_hotels = Hotels::GetAllActive();
		$output = '';

		if($total_hotels[1] > 1){
			$output .= '<form action="'.prepare_link('pages', 'system_page', 'rooms', 'index', '', '', '', true).'" method="post">';
			$output .= '<div class="hotel_selector"> '._HOTEL.': <select name="hotel_id">';
			$output .= '<option value="0">'._ALL.'</option>';
			$total_hotels = Hotels::GetAllActive();
			foreach($total_hotels[0] as $key => $val){
				$output .= '<option value="'.$val['id'].'" '.(($hotel_id == $val['id']) ? ' selected="selected"' : '').'>'.$val['name'].'</option>';
			}				
			$output .= '</select> ';
			$output .= '<input type="submit" class="form_button" value="'._SHOW.'" />';
			$output .= '</div>';
			$output .= '</form>';
			$output .= '<div class="line-hor-2"></div>';			
		}

		$sql = 'SELECT
				r.id,
				r.max_adults,
				r.max_children,
				r.max_guests,
				r.room_count,
				r.default_price,
				r.room_icon,
				IF(r.room_icon_thumb != "", r.room_icon_thumb, "no_image.png") as room_icon_thumb,
                                IF(r.room_picture_1 != "", r.room_picture_1, "no_image.png") as room_picture_1,
				r.priority_order,
				r.is_active,
				CONCAT("<a href=\"index.php?admin=mod_room_prices&rid=", r.id, "\" title=\"'._CLICK_TO_MANAGE.'\">", "[ '._PRICES.' ]", "</a>") as link_prices,
				CONCAT("<a href=\"index.php?admin=mod_room_availability&rid=", r.id, "\" title=\"'._CLICK_TO_MANAGE.'\">", "[ '._AVAILABILITY.' ]", "</a>") as link_room_availability,
				IF(r.is_active = 1, "<span class=yes>'._YES.'</span>", "<span class=no>'._NO.'</span>") as my_is_active,
				CONCAT("<a href=\"index.php?admin=mod_room_description&room_id=", r.id, "\" title=\"'._CLICK_TO_MANAGE.'\">[ ", "'._DESCRIPTION.'", " ]</a>") as link_room_description,
				rd.room_type,
				rd.room_short_description,
				rd.room_long_description,
				h.id as hotel_id,
				hd.name as hotel_name
			FROM '.TABLE_ROOMS.' r
				INNER JOIN '.TABLE_HOTELS.' h ON r.hotel_id = h.id
				INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' hd ON r.hotel_id = hd.hotel_id
				INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id
			WHERE
				'.(!empty($hotel_id) ? ' h.id = '.(int)$hotel_id.' AND ' : '').'
				h.is_active = 1 AND 
				r.is_active = 1 AND
				hd.language_id = \''.$lang.'\' AND
				rd.language_id = \''.$lang.'\'
			ORDER BY
				r.hotel_id ASC, 
				r.priority_order ASC';
		
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		for($i=0; $i<$result[1]; $i++){
		    $is_active = (isset($result[0][$i]['is_active']) && $result[0][$i]['is_active'] == 1) ? _AVAILABLE : _NOT_AVAILABLE;		
			$href = prepare_link('rooms', 'room_id', $result[0][$i]['id'], $result[0][$i]['hotel_name'].'/'.$result[0][$i]['room_type'], $result[0][$i]['room_type'], '', '', true);
	
			if($i > 0) $output .= '<div class="line-hor-2"></div>';					
			$output .= '<div class="room-item-bldr">';
                        $output .= '<div class="left">
                                        <a href="'.$href.'" title="'._CLICK_FOR_MORE_INFO.'"><img class="room_icon_full" src="images/rooms_icons/'.$result[0][$i]['room_picture_1'].'" alt="" /></a>';                                
                        $output .= '</div>';
			$output .= '<div class="right">
                                        <div>
                                            <h3 class="headline"><a href="'.$href.'" title="'._CLICK_TO_VIEW.'">'.$result[0][$i]['room_type'].'</a></h3>
                                        </div>';			
                        $output .= '<p>'.(($total_hotels[1] > 1 && empty($hotel_id)) ? _HOTEL.': '.prepare_link('hotels', 'hid', $result[0][$i]['hotel_id'], $result[0][$i]['hotel_name'], $result[0][$i]['hotel_name'], '', _CLICK_TO_VIEW) : '').'</p>';
			$output .= '<div>'.$result[0][$i]['room_short_description'].'</div>';
			$output .= '<div><b>'._COUNT.':</b> '.$result[0][$i]['room_count'].'</div>';
			$output .= '<div><b>'._MAX_ADULTS.':</b> '.$result[0][$i]['max_adults'].'</div>';
			if($allow_children == 'yes') $output .= '<div><b>'._MAX_CHILDREN.':</b> '.$result[0][$i]['max_children'].'</div>';
			if($allow_guests == 'yes' && !empty($result[0][$i]['max_guests'])) $output .= '<div><b>'._MAX_GUESTS.':</b> '.$result[0][$i]['max_guests'].'</div>';
			//$output .= '<tr><td><b>'._DEFAULT_PRICE.':</b> '.Currencies::PriceFormat($default_price).'</td></tr>';
			$output .= '<div><b>'._AVAILABILITY.':</b> '.$is_active.'</div>';
			$output .= '</div>';			
                        $output .= '<div class="clear"></div></div>';
		}		

		if($draw) echo $output;
		else return $output;
	}	

	/**
	 *	Get max day for month
	 *	  	@param $year
	 *	  	@param $month	 
	 */
	private function GetMonthMaxDay($year, $month)
	{
		if(empty($month)) $month = date('m');
		if(empty($year)) $year = date('Y');
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('d', $result);
	}
	
	/**
	 * Draws system suggestion form
	 * 		@param $room_id
	 * 		@param $checkin_day
	 * 		@param $checkin_year_month
	 * 		@param $checkout_day
	 * 		@param $checkout_year_month
	 * 		@param $max_adults
	 * 		@param $max_children
	 * 		@param $draw
	 */
	public static function DrawTrySystemSuggestionForm($room_id, $checkin_day, $checkin_year_month, $checkout_day, $checkout_year_month, $max_adults, $max_children, $draw = true)
	{
		$output = '';
		if($max_adults > 1){
			$output .= '<br>';
			$output .= '<form target="_parent" action="index.php?page=check_availability" method="post">';
			$output .= draw_hidden_field('room_id', $room_id, false);
			$output .= draw_hidden_field('p', '1', false, 'page_number');
			$output .= draw_token_field(false);
			$output .= draw_hidden_field('checkin_monthday', $checkin_day, false);
			$output .= draw_hidden_field('checkin_year_month', $checkin_year_month, false);
			$output .= draw_hidden_field('checkout_monthday', $checkout_day, false);
			$output .= draw_hidden_field('checkout_year_month', $checkout_year_month, false);
			$output .= draw_hidden_field('max_adults', (int)($max_adults / 2), false);
			$output .= draw_hidden_field('max_children', (int)($max_children / 2), false);
			
			$output .= _TRY_SYSTEM_SUGGESTION.':<br>';
			$output .= '<input class="button" type="submit" value="'._CHECK_NOW.'" />';
			$output .= '</form>';				
		}
		
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 * Draws rooms in specific hotel
	 * 		@param $hotel_id
	 * 		@param $draw
	 */
	public static function DrawRoomsInHotel($hotel_id, $draw = true)
	{
		$output = '';
		
		$sql = 'SELECT
					r.id,
					r.room_count,
					rd.room_type 
				FROM '.TABLE_ROOMS.' r 
					LEFT OUTER JOIN '.TABLE_ROOMS_DESCRIPTION.' rd ON r.id = rd.room_id AND rd.language_id = \''.Application::Get('lang').'\'
				WHERE r.is_active = 1 AND hotel_id = '.(int)$hotel_id.'
				ORDER BY r.priority_order ASC ';
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		if($result[1] > 0){
			$output .= '<b>'._ROOMS.'</b>:<br>';
			$output .= '<ul>';
			for($i=0; $i<$result[1]; $i++){				
				$output .= '<li> '.prepare_link('rooms', 'room_id', $result[0][$i]['id'], $result[0][$i]['room_type'], $result[0][$i]['room_type'], '', _CLICK_TO_VIEW).' - '.$result[0][$i]['room_count'].' </li>';
			}
			$output .= '</ul>';
		}
	
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 * Draws pagination links
	 * 		@param $total_pages
	 * 		@param $current_page
	 * 		@param $params
	 * 		@param $draw
	 */
	private function DrawPaginationLinks($total_pages, $current_page, $params, $draw = true)
	{
		global $objLogin;
		
		$output = '';
		
		// draw pagination links
		if($total_pages > 1){	
			if($objLogin->IsLoggedInAsAdmin()){				
				$output .= '<form action="index.php?page=check_availability" id="reservation-form" name="reservation-form" method="post">
				'.draw_hidden_field('p', '1', false, 'page_number').'
				'.draw_token_field(false).'
				'.draw_hidden_field('checkin_monthday', $params['from_day'], false, 'checkin_monthday').'
				'.draw_hidden_field('checkin_year_month', $params['from_year'].'-'.(int)$params['from_month'], false, 'checkin_year_month').'
				'.draw_hidden_field('checkout_monthday', $params['to_day'], false, 'checkout_monthday').'
				'.draw_hidden_field('checkout_year_month', $params['to_year'].'-'.(int)$params['to_month'], false, 'checkout_year_month');
			}
			
			$output .= '<div class="paging">';
			for($page_ind = 1; $page_ind <= $total_pages; $page_ind++){
				$output .= '<a class="paging_link" href="javascript:void(\'page|'.$page_ind.'\');" onclick="javascript:appFormSubmit(\'reservation-form\',\'page_number='.$page_ind.'\')">'.(($page_ind == $current_page) ? '<b>['.$page_ind.']</b>' : $page_ind).'</a> ';
			}
			$output .= '</div>'; 
			if($objLogin->IsLoggedInAsAdmin()) $output .= '<form>';
		}

		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 * Draw Hotel Info block
	 * 		@param $hotel_id
	 * 		@param $lang
	 * 		@param $draw
	 */
	private function DrawHotelInfoBlock($hotel_id, $lang, $draw = true)
	{
		$output = '';
		$hotel_info = Hotels::GetHotelFullInfo($hotel_id, $lang);
		$arr_stars_vm = array('0'=>_NONE,
							  '1'=>'<img src="images/stars1.gif" alt="1" />',
							  '2'=>'<img src="images/stars2.gif" alt="2" />',
							  '3'=>'<img src="images/stars3.gif" alt="3" />',
							  '4'=>'<img src="images/stars4.gif" alt="4" />',
							  '5'=>'<img src="images/stars5.gif" alt="5" />');
		
		$output .= '<div class="tbl_hotel_description">';
		$output .= '<div class="left"><img class="hotel_icon" src="images/hotels/'.$hotel_info['hotel_image'].'" alt="" /></div>';
		$output .= '<div class="right">
						<div class="hotel_name headline">'.prepare_link('hotels', 'hid', $hotel_info['id'], $hotel_info['name'], $hotel_info['name'], '', _CLICK_TO_SEE_DESCR).'</div>
						<div class="hotel_star">'.$arr_stars_vm[$hotel_info['stars']].'</div>
						<div class="hotel_location">'.$hotel_info['location_name'].'</div>
						<div class="hotel_description">'.substr_by_word($hotel_info['description'], 350, true).'</div>
					</div>';
		$output .= '</div><div class="clear"><!-- --></div>';

		if($draw) echo $output;
		else return $output;
	}
	
	/**
	 * Draw guests dropdownlist
	 * 		@param $room_id
	 * 		@param $max_guests
	 * 		@param $params
	 * 		@param $currency_rate
	 * 		@param $currency_format
	 * 		@param $enabled
	 * 		@param $draw
	 */
	private function DrawGuestsDDL($room_id, $max_guests, $params, $currency_rate, $currency_format, $enabled = true, $draw = true)
	{
		$guest_price = $this->GetRoomGuestPrice($room_id, $params);		
		$output = '<select class="available_guests_ddl" name="available_guests" '.($enabled ? '' : 'disabled="disabled"').'>';
		$output .= '<option value="0">0</option>';	
		for($i=0; $i<$max_guests; $i++){
			$guests_count = ($i+1);
			$guest_fee_per_night = (($guests_count * $guest_price) / $currency_rate);
			$guest_fee_per_night_format = Currencies::PriceFormat($guest_fee_per_night, '', '', $currency_format);
			$output .= '<option value="'.$guests_count.'-'.$guest_fee_per_night.'">'.$guests_count.' ('.$guest_fee_per_night_format.')</option>';	
		}
		$output .= '</select>';
		
		if($draw) echo $output;
		else return $output;
	}
	
}
?>