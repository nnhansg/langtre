<?php

/***
 *	Class Reservation
 *  -------------- 
 *  Description : encapsulates Booking properties
 *  Updated	    : 28.08.2012
 *	Written by  : ApPHP
 *	
 *	PUBLIC:					STATIC:					PRIVATE:
 *  -----------				-----------				-----------
 *  __construct										GetVatPercent 
 *  __destruct                                      GenerateBookingNumber 
 *  AddToReservation                                GetVatPercentDecimalPoints
 *  RemoveReservation
 *  ShowReservationInfo
 *  ShowCheckoutInfo
 *  EmptyCart
 *  GetCartItems
 *  IsCartEmpty
 *  PlaceBooking
 *  DoReservation
 *  SendOrderEmail
 *  SendCancelOrderEmail
 *  DrawReservation
 *  LoadDiscountInfo
 *  ApplyDiscountCoupon
 *  RemoveDiscountCoupon
 *  
 **/

class Reservation {

	public $arrReservation;
	public $error;
	public $message;

	private $fieldDateFormat;
	private $cartItems;
	private $roomsCount;
	private $cartTotalSum;
	private $firstNightSum;
	private $currentCustomerID;
	private $selectedUser;
	private $vatPercent;
	private $discountPercent;
	private $discountCampaignID;
	private $discountCoupon;
	private $currencyFormat;
	private $lang;
	private $paypal_form_type;
	private $paypal_form_fields;
	private $paypal_form_fields_count;
	private $first_night_possible;
	private $firstNightCalculationType = 'real';
	private $bookingInitialFee = '0';
	private $vatIncludedInPrice = 'no';
	private $maximumAllowedReservations = '10';


	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{
		global $objSettings;
		global $objLogin;

		if(!$objLogin->IsLoggedIn()){
			$this->currentCustomerID = (int)Session::Get('current_customer_id');
			$this->selectedUser = 'customer';
		}else if($objLogin->IsLoggedInAsCustomer()){
			$this->currentCustomerID = $objLogin->GetLoggedID();
			$this->selectedUser = 'customer';			
		}else{
			if(Session::IsExists('sel_current_customer_id') && (int)Session::Get('sel_current_customer_id') != 0){
				$this->currentCustomerID = (int)Session::Get('sel_current_customer_id');
				$this->selectedUser = 'customer';
			}else{
				$this->currentCustomerID = $objLogin->GetLoggedID();
				$this->selectedUser = 'admin';
			}
		}

		// prepare Booking settings
		$this->firstNightCalculationType = ModulesSettings::Get('booking', 'first_night_calculating_type');
		$this->bookingInitialFee = ModulesSettings::Get('booking', 'booking_initial_fee');
		$this->vatIncludedInPrice = ModulesSettings::Get('booking', 'vat_included_in_price');
		$this->maximumAllowedReservations = ModulesSettings::Get('booking', 'maximum_allowed_reservations');
		
		// prepare currency info
		if(Application::Get('currency_code') == ''){
			$this->currencyCode = Currencies::GetDefaultCurrency();
			$this->currencyRate = '1';
		}else{
			//$default_currency_info = Currencies::GetDefaultCurrencyInfo();
			$this->currencyCode = Application::Get('currency_code');
			$this->currencyRate = Application::Get('currency_rate');
		}		

		// prepare VAT percent
		$this->vatPercent = $this->GetVatPercent();

		// preapre datetime format
		if($objSettings->GetParameter('date_format') == 'mm/dd/yyyy'){
			$this->fieldDateFormat = 'M d, Y';
		}else{
			$this->fieldDateFormat = 'd M, Y';
		}
		
		$this->lang = Application::Get('lang');
		$this->arrReservation = &$_SESSION['reservation'];
		$this->arrReservationInfo = &$_SESSION['reservation_info'];
		$this->cartItems = 0;
		$this->roomsCount = 0;
		$this->cartTotalSum = 0;
		$this->firstNightSum = 0;
		$this->first_night_possible = false;
		$this->paypal_form_type = 'multiple'; // single | multiple
		$this->paypal_form_fields = '';
		$this->currencyFormat = get_currency_format();		  

		// prepare discount info
		$this->LoadDiscountInfo();

		if(count($this->arrReservation) > 0){
			$paypal_form_fields_count = 0;
			foreach($this->arrReservation as $key => $val){
				$room_price_w_meal_guest = ($val['price'] + $val['meal_plan_price'] + $val['guests_fee']);
				$this->cartItems += 1;
				$this->roomsCount += $val['rooms'];
				$this->cartTotalSum += ($room_price_w_meal_guest / $this->currencyRate);
				if($this->firstNightCalculationType == 'average'){
					$this->firstNightSum += ($room_price_w_meal_guest / $val['nights']);
				}else{				
					$this->firstNightSum += Rooms::GetPriceForDate($key, $val['from_date']);	
				}
				if($val['nights'] > 1) $this->first_night_possible = true;
				
				if($this->paypal_form_type == 'multiple'){
					$this->paypal_form_fields_count++;					
					$this->paypal_form_fields .= draw_hidden_field('item_name_'.$this->paypal_form_fields_count, _ROOM_TYPE.': '.$val['room_type'], false);
					$this->paypal_form_fields .= draw_hidden_field('quantity_'.$this->paypal_form_fields_count, $val['rooms'], false);
					$this->paypal_form_fields .= draw_hidden_field('amount_'.$this->paypal_form_fields_count, number_format((($val['price'] / $this->currencyRate) / $val['rooms']), '2', '.', ','), false);
				}
			}
		}
		$this->cartTotalSum = number_format($this->cartTotalSum, 2, '.', '');

		$this->message = '';
		$this->error = '';
		
		//echo $this->firstNightSum;
		//echo '<pre>';
		//print_r($this->arrReservation);
		//echo '</pre>';
	}

	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	/**
	 * Add room to reservation
	 * 		@param $room_id
	 * 		@param $from_date
	 * 		@param $to_date
	 * 		@param $nights
	 * 		@param $rooms
	 * 		@param $price
	 * 		@param $adults
	 * 		@param $children
	 * 		@param $meal_plan_id
	 * 		@param $hotel_id
	 * 		@param $guests
	 * 		@param $guest_fee
	 */	
	public function AddToReservation($room_id, $from_date, $to_date, $nights, $rooms, $price, $adults, $children, $meal_plan_id, $hotel_id, $guests, $guest_fee)
	{		
		if(!empty($room_id)){
			$meal_plan_info = MealPlans::GetPlanInfo($meal_plan_id);
			if(isset($this->arrReservation[$room_id])){
				// add new info for this room
				$this->arrReservation[$room_id]['from_date'] = $from_date;
				$this->arrReservation[$room_id]['to_date'] 	 = $to_date;
				$this->arrReservation[$room_id]['nights'] 	 = $nights;
				$this->arrReservation[$room_id]['rooms'] 	 = $rooms;
				$this->arrReservation[$room_id]['price'] 	 = $price;
				$this->arrReservation[$room_id]['adults'] 	 = $adults;
				$this->arrReservation[$room_id]['children']  = $children;
				$this->arrReservation[$room_id]['hotel_id']  = (int)$hotel_id;
				$this->arrReservation[$room_id]['meal_plan_id'] = (int)$meal_plan_id;
				$this->arrReservation[$room_id]['meal_plan_name'] = isset($meal_plan_info['name']) ? $meal_plan_info['name'] : '';
				//$this->arrReservation[$room_id]['meal_plan_price'] = isset($meal_plan_info['price']) ? number_format($meal_plan_info['price'] * $nights * $adults * $rooms, 2) : 0;
				$this->arrReservation[$room_id]['meal_plan_price'] = isset($meal_plan_info['price']) ? ($meal_plan_info['price'] * $nights * $adults * $rooms) : 0; // NNhanSG
				$this->arrReservation[$room_id]['room_type'] = Rooms::GetRoomInfo($room_id, 'room_type');
				$this->arrReservation[$room_id]['guests']    = $guests;
				//$this->arrReservation[$room_id]['guests_fee'] = number_format($guest_fee * $nights * $adults * $rooms, 2);
				$this->arrReservation[$room_id]['guests_fee'] = ($guest_fee * $nights * $adults * $rooms); // NNhanSG
			}else{
				// just add new room
				$this->arrReservation[$room_id] = array(
					'from_date' => $from_date,
					'to_date'   => $to_date,
					'nights'    => $nights,
					'rooms'     => $rooms,
					'price'     => $price,
					'adults'    => $adults,
					'children'  => $children,
					'hotel_id'  => (int)$hotel_id,
					'meal_plan_id' => (int)$meal_plan_id,
					'meal_plan_name'  => isset($meal_plan_info['name']) ? $meal_plan_info['name'] : '',
					//'meal_plan_price'  => isset($meal_plan_info['price']) ? number_format($meal_plan_info['price'] * $nights * $adults * $rooms, 2) : 0,
					'meal_plan_price'  => isset($meal_plan_info['price']) ? ($meal_plan_info['price'] * $nights * $adults * $rooms) : 0, // NNhanSG
					'room_type' => Rooms::GetRoomInfo($room_id, 'room_type'),
					'guests'    => $guests,
					//'guests_fee' => number_format($guest_fee * $nights * $adults * $rooms, 2)
					'guests_fee' => ($guest_fee * $nights * $adults * $rooms) // NNhanSG
				);
			}
			$this->error = draw_success_message(_ROOM_WAS_ADDED, false);
		}else{
			$this->error = draw_important_message(_WRONG_PARAMETER_PASSED, false);
		}
	}

	/**
	 * Remove room from the reservation cart
	 * 		@param $room_id
	 */
	public function RemoveReservation($room_id)
	{
		if((int)$room_id > 0){
			if(isset($this->arrReservation[$room_id]) && $this->arrReservation[$room_id] > 0){
				unset($this->arrReservation[$room_id]);
				$this->error = draw_message(_ROOM_WAS_REMOVED, false);
			}else{
				$this->error = draw_important_message(_ROOM_NOT_FOUND, false);
			}
		}else{
			$this->error = draw_important_message(_ROOM_NOT_FOUND, false);
		}
	}	

    /** 
	 * Show Reservation Cart on the screen
	 */	
	public function ShowReservationInfo()
	{
		global $objLogin;
		
		$class_left = Application::Get('defined_left');
		$class_right = Application::Get('defined_right');
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');
		$meal_plans_count = MealPlans::MealPlansCount();
	
		if(count($this->arrReservation) > 0)
		{
			echo '<table class="reservation_cart" border="0" width="100%" align="center" cellspacing="0" cellpadding="5"><thead>';
			echo '<tr class="header">				
				<th class="'.$class_left.'" width="25px">&nbsp;</th>
				<th align="'.$class_left.'">'._ROOM_TYPE.'</th>
				<th align="center" width="60px">'._FROM.'</th>
				<th align="center" width="60px">'._TO.'</th>
				<th width="40px" align="center">&nbsp;'._NIGHTS.'&nbsp;</th>
				<th width="40px" align="center">&nbsp;'._ROOMS.'&nbsp;</th>
				<th width="70px" colspan="3" align="center">'._OCCUPANCY.'</th>
				'.(($meal_plans_count) ? '<th width="65px" align="center">'._MEAL_PLANS.'</th>' : '<th style="padding:0px;">&nbsp;</th>').'
				<th width="65px" class="'.$class_right.'">'._PRICE.'</th>
			</tr>';

			echo '<tr style="font-size:10px;background-color:transparent;">				
				<th colspan="6"></th>
				<th align="center">'._ADULT.'</th>
				'.(($allow_children == 'yes') ? '<th align="center">'._CHILD.'</th>' : '<th></th>').'
				'.(($allow_guests == 'yes') ? '<th align="center">'._GUEST.'</th>' : '<th></th>').' 
				<th colspan="2"></th>
			</tr>';
			
			echo '</thead>
			';

			$order_price = 0;
			$objRoom = new Rooms();
			foreach($this->arrReservation as $key => $val)
			{
				$sql = 'SELECT
							'.TABLE_ROOMS.'.id,
							'.TABLE_ROOMS.'.room_type,
							'.TABLE_ROOMS.'.room_icon_thumb,
							CASE
								WHEN '.TABLE_ROOMS.'.room_picture_1 != \'\' THEN '.TABLE_ROOMS.'.room_picture_1
								WHEN '.TABLE_ROOMS.'.room_picture_2 != \'\' THEN '.TABLE_ROOMS.'.room_picture_2
								WHEN '.TABLE_ROOMS.'.room_picture_3 != \'\' THEN '.TABLE_ROOMS.'.room_picture_3
								WHEN '.TABLE_ROOMS.'.room_picture_4 != \'\' THEN '.TABLE_ROOMS.'.room_picture_4
								WHEN '.TABLE_ROOMS.'.room_picture_5 != \'\' THEN '.TABLE_ROOMS.'.room_picture_5
								ELSE \'\'
							END as first_room_image,
							'.TABLE_ROOMS.'.max_adults,
							'.TABLE_ROOMS.'.max_children, 
							'.TABLE_ROOMS.'.default_price as price,
							'.TABLE_ROOMS_DESCRIPTION.'.room_type as loc_room_type,
							'.TABLE_ROOMS_DESCRIPTION.'.room_short_description as loc_room_short_description,
							'.TABLE_HOTELS_DESCRIPTION.'.name as hotel_name
						FROM '.TABLE_ROOMS.' 
							INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' ON '.TABLE_ROOMS.'.id = '.TABLE_ROOMS_DESCRIPTION.'.room_id
							INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.TABLE_ROOMS.'.hotel_id	= '.TABLE_HOTELS_DESCRIPTION.'.hotel_id
						WHERE
							'.TABLE_ROOMS.'.id = '.$key.' AND
							'.TABLE_ROOMS_DESCRIPTION.'.language_id = \''.$this->lang.'\' AND
							'.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.$this->lang.'\' ';
							
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){			
					$room_icon_thumb = ($result[0]['room_icon_thumb'] != '') ? $result[0]['room_icon_thumb'] : 'no_image.png';
					$room_icon_first = ($result[0]['first_room_image'] != '') ? $result[0]['first_room_image'] : 'no_image.png';
					$room_price_w_meal_guest = ($val['price'] + $val['meal_plan_price'] + $val['guests_fee']);
					
					echo '<tr>
							<td align="center"><a href="index.php?page=booking&act=remove&rid='.$key.'"><img src="images/remove.gif" width="16" height="16" border="0" title="'._REMOVE_ROOM_FROM_CART.'" alt="" /></a></td>							
							<td>
								<b>'.prepare_link('rooms', 'room_id', $result[0]['id'], $result[0]['loc_room_type'], $result[0]['loc_room_type'], '', _CLICK_TO_VIEW).'</b><br />
								'.$result[0]['hotel_name'].'
							</td>
							<td align="center">'.format_date($val['from_date'], $this->fieldDateFormat, '', true).'</td>
							<td align="center">'.format_date($val['to_date'], $this->fieldDateFormat, '', true).'</td>
							<td align="center">'.$val['nights'].'</td>
							<td align="center">'.$val['rooms'].'</td>
							<td align="center">'.$val['adults'].'</td>
							'.(($allow_children == 'yes') ? '<td align="center">'.$val['children'].'</td>' : '<td></td>').'
							'.(($allow_guests == 'yes') ? '<td align="center">'.$val['guests'].'</td>' : '<td></td>').'
							'.(($meal_plans_count) ? '<td align="center" style="cursor:help;" title="'.(($val['nights'] > 1) ? _RATE_PER_NIGHT_AVG : _RATE_PER_NIGHT).'">'.$val['meal_plan_name'].'</td>' : '<td></td>').'
							<td align="'.$class_right.'">'.Currencies::PriceFormat($room_price_w_meal_guest / $this->currencyRate, '', '', $this->currencyFormat).'<!--&nbsp;<a class="price_link" href="javascript:void(0);" onclick="javascript:appToggleElement(\'row_prices_'.$key.'\')" title="'._CLICK_TO_SEE_PRICES.'">(+)</a>--></td>
						</tr>
					    <tr><td colspan="11" align="'.$class_left.'">
								<span id="row_prices_'.$key.'" style="margin:5px 10px;">
								<table width="100%">
								<tr>
									<td width="40%"><img src="images/rooms_icons/'.$room_icon_first.'" alt="" width="100%" /></td>
									<td style="vertical-align: top;">
									'._ROOM_PRICE.': '.Currencies::PriceFormat(($val['price'] / $this->currencyRate), '', '', $this->currencyFormat).'<br>
									'._MEAL_PLANS.': '.Currencies::PriceFormat(($val['meal_plan_price'] / $this->currencyRate), '', '', $this->currencyFormat) . '<br>
									'._GUESTS_FEE.': '.Currencies::PriceFormat(($val['guests_fee'] / $this->currencyRate), '', '', $this->currencyFormat).'<br>
									'._RATE_PER_NIGHT.': '.Currencies::PriceFormat(($room_price_w_meal_guest / $this->currencyRate) / $val['nights'], '', '', $this->currencyFormat).'<br>
									</td>
								</tr>
								<tr style="display: none;"><td colspan="2">'.Rooms::GetRoomPricesTableVertical($key).'</td></tr>
								</table>
								</span>
								<div class="line_item_booking"><!-- --></div>
							</td>
						</tr>';
					$order_price += ($room_price_w_meal_guest / $this->currencyRate);					
				}
			}

			// draw sub-total row			
			echo '<tr>
					<td colspan="7"></td>
					<td class="td '.$class_left.'" colspan="2"><b>'._SUBTOTAL.': </b></td>
					<td class="td '.$class_right.'" align="'.$class_right.'" colspan="2"><b>'.Currencies::PriceFormat($order_price, '', '', $this->currencyFormat).'</b></td>
				</tr>';				

			//echo '<tr><td colspan="11" nowrap="nowrap" height="15px"></td></tr>';
			
			// calculate discount			
			$discount_value = ($order_price * ($this->discountPercent / 100));
			$order_price -= $discount_value;
			
			// calculate percent
			$vat_cost = (($order_price + $this->bookingInitialFee) * ($this->vatPercent / 100));
			$cart_total = ($order_price + $this->bookingInitialFee) + $vat_cost;
			
			if($this->discountCampaignID != '' || $this->discountCoupon != ''){
				echo '<tr>
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="2"><b><span style="color:#a60000">'._DISCOUNT.': ('.Currencies::PriceFormat($this->discountPercent, '%', 'right', $this->currencyFormat).')</span></b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'" colspan="2"><b><span style="color:#a60000">- '.Currencies::PriceFormat($discount_value, '', '', $this->currencyFormat).'</span></b></td>
					</tr>';				
			}
			if(!empty($this->bookingInitialFee)){
				echo '<tr>
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="2"><b>'._INITIAL_FEE.': </b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'" colspan="2"><b>'.Currencies::PriceFormat($this->bookingInitialFee, '', '', $this->currencyFormat).'</b></td>
					</tr>';								
			}
			if($this->vatIncludedInPrice == 'no'){
				echo '<tr> 
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="2"><b>'._VAT.': ('.Currencies::PriceFormat($this->vatPercent, '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($this->vatPercent)).')</b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'" colspan="2"><b>'.Currencies::PriceFormat($vat_cost, '', '', $this->currencyFormat).'</b></td>
					</tr>';
			}
			echo '
				<tr class="footer">
					<td colspan="7"></td>
					<td class="td '.$class_left.'" colspan="2"><b>'._TOTAL.':</b></td>
					<td class="td '.$class_right.'" align="'.$class_right.'" colspan="2"><b>'.Currencies::PriceFormat($cart_total, '', '', $this->currencyFormat).'</b></td>
				</tr>
				<tr>
					<td colspan="7"></td>
					<td colspan="3"></td>
					<td align="'.$class_right.'">
						
					</td>
				</tr>
				</table>
				<div style="float: right;">
					<input type="button" class="form_button" onclick="javascript:appGoTo(\'page=booking_details\')" value="'._BOOK.'" />
				</div>
				<div class="clear"></div>';
		}else{
			draw_message(_RESERVATION_CART_IS_EMPTY_ALERT, true, true);
		}
	}

    /** 
	 * Show checkout info
	 */	
	public function ShowCheckoutInfo()
	{
		global $objLogin;
		
		$class_left = Application::Get('defined_left');
		$class_right = Application::Get('defined_right');

		$default_payment_system = ModulesSettings::Get('booking', 'default_payment_system');		
		$pre_payment_type       = ModulesSettings::Get('booking', 'pre_payment_type');
		$pre_payment_value      = ModulesSettings::Get('booking', 'pre_payment_value');
		$payment_type_poa       = ModulesSettings::Get('booking', 'payment_type_poa');
		$payment_type_online    = ModulesSettings::Get('booking', 'payment_type_online');
		$payment_type_bank_transfer = ModulesSettings::Get('booking', 'payment_type_bank_transfer');
		$payment_type_paypal    = ModulesSettings::Get('booking', 'payment_type_paypal');
		$payment_type_2co       = ModulesSettings::Get('booking', 'payment_type_2co');
		$payment_type_authorize = ModulesSettings::Get('booking', 'payment_type_authorize');
		$payment_type           = isset($_POST['payment_type']) ? prepare_input($_POST['payment_type']) : $default_payment_system;
		$payment_type_cnt	    = (($payment_type_poa === 'yes')+
		                          ($payment_type_online === 'yes')+
								  ($payment_type_bank_transfer === 'yes')+
								  ($payment_type_paypal === 'yes')+
								  ($payment_type_2co === 'yes')+
								  ($payment_type_authorize === 'yes'));
		$payment_types_defined  = true;
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');
		$meal_plans_count = MealPlans::MealPlansCount();

		$find_user = isset($_GET['cl']) ? prepare_input($_GET['cl']) : '';
		$cid 	   = isset($_GET['cid']) ? prepare_input($_GET['cid']) : '';
		if($cid != ''){
			if($cid != 'admin'){
				$this->currentCustomerID = $cid;
				Session::Set('sel_current_customer_id', $cid);
				$this->selectedUser = 'customer';			
			}else{
				$this->currentCustomerID = $objLogin->GetLoggedID();
				$this->selectedUser = 'admin';
				Session::Set('sel_current_customer_id', '');
			}
		}
						    
		if($objLogin->IsLoggedInAsAdmin() && $this->selectedUser == 'admin'){
			$table_name = TABLE_ACCOUNTS;
			$sql='SELECT '.$table_name.'.*
				  FROM '.$table_name.'
				  WHERE '.$table_name.'.id = '.(int)$this->currentCustomerID;
		}else{
			$table_name = TABLE_CUSTOMERS;
			$sql='SELECT
					'.$table_name.'.*,
					'.TABLE_COUNTRIES.'.name as country_name,
					'.TABLE_COUNTRIES.'.vat_value
				  FROM '.$table_name.'
					 LEFT OUTER JOIN '.TABLE_COUNTRIES.' ON '.$table_name.'.b_country = '.TABLE_COUNTRIES.'.abbrv AND '.TABLE_COUNTRIES.'.is_active = 1
				  WHERE '.$table_name.'.id = '.(int)$this->currentCustomerID;				  
		}
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] <= 0){
			draw_message(_RESERVATION_CART_IS_EMPTY_ALERT, true, true);
			return false;
		}

		if(count($this->arrReservation) > 0)
		{
			$extras = Extras::GetAllExtras();
			echo "\n".'<script type="text/javascript">'."\n";			
			echo 'var arrExtras = new Array('.$extras[1].');'."\n";
			echo 'var arrExtrasSelected = new Array('.$extras[1].');'."\n";			
			if($extras[1]){
				for($i=0; $i<$extras[1]; $i++){
					echo 'arrExtras['.$i.'] = "'.($extras[0][$i]['price'] / $this->currencyRate).'";'."\n";
					echo 'arrExtrasSelected['.$i.'] = 0;'."\n";
				}
			}						
			echo '</script>'."\n";
			
			echo '<form id="checkout-form" action="index.php?page=booking_payment" method="post">
			'.draw_hidden_field('task', 'do_booking', false).'
			'.draw_hidden_field('selected_user', $this->selectedUser, false).'
			'.draw_token_field(false);
			
			echo '<table class="reservation_cart" border="0" width="99%" align="center" cellspacing="0" cellpadding="5">
			<tr>
				<td colspan="2"><h4>'._BILLING_DETAILS.' &nbsp;';
					if($objLogin->IsLoggedIn()){
						if($objLogin->IsLoggedInAsCustomer()){
							echo '<a style="font-size:13px;" href="javascript:void(0);" onclick="javascript:appGoTo(\'customer=my_account\')">['._EDIT_WORD.']</a>	';
						}else if($objLogin->IsLoggedInAsAdmin()){
						
							echo '<br>'._CHANGE_CUSTOMER.': 
							<input type="text" id="find_user" name="find_user" value="" size="10" maxlength="40" />
							<input type="button" class="button" value="'._SEARCH.'" onclick="javascript:appGoTo(\'page=booking_checkout&cl=\'+jQuery(\'#find_user\').val())" />
							<select name="sel_customer" id="sel_customer">';
								if($find_user == ''){
									if($this->selectedUser == 'admin'){
										echo '<option value="admin">'.$result[0]['first_name'].' '.$result[0]['last_name'].' ('.$result[0]['user_name'].')</option>';										
									}else{
										echo '<option value="'.$result[0]['id'].'">ID:'.$result[0]['id'].' '.$result[0]['first_name'].' '.$result[0]['last_name'].' ('.(($result[0]['user_name'] != '') ? $result[0]['user_name'] : _WITHOUT_ACCOUNT).')'.'</option>';										
									}
								}else{
									$objCustomers = new Customers();
									$result_customers = $objCustomers->GetAllCustomers(' AND (last_name like \''.$find_user.'%\' OR first_name like \''.$find_user.'%\' OR user_name like \''.$find_user.'%\') ');
									if($result_customers[1] > 0){
										for($i = 0; $i < $result_customers[1]; $i++){
											echo '<option value="'.$result_customers[0][$i]['id'].'">ID:'.$result_customers[0][$i]['id'].' '.$result_customers[0][$i]['first_name'].' '.$result_customers[0][$i]['last_name'].' ('.(($result_customers[0][$i]['user_name'] != '') ? $result_customers[0][$i]['user_name'] : _WITHOUT_ACCOUNT).')'.'</option>';
										}								
									}else{
										echo '<option value="admin">'.$result[0]['first_name'].' '.$result[0]['last_name'].' ('.$result[0]['user_name'].')</option>';
									}
								}								
							echo '</select> ';
							if($find_user != '') echo '<input type="button" class="button" value="'._APPLY.'" onclick="javascript:appGoTo(\'page=booking_checkout&cid=\'+jQuery(\'#sel_customer\').val())"/> ';
							echo '<input type="button" class="button" value="'._SET_ADMIN.'" onclick="javascript:appGoTo(\'page=booking_checkout&cid=admin\')"/>';
							if($find_user != '' && $result_customers[1] == 0) echo ' '._NO_CUSTOMER_FOUND;
						}
					}else{
						echo '<a style="font-size:13px;" href="javascript:void(0);" onclick="javascript:appGoTo(\'page=booking_details\',\'&m=edit\')">['._EDIT_WORD.']</a>	';
					}
					echo '</h4>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">
					'._FIRST_NAME.': '.$result[0]['first_name'].'<br />
					'._LAST_NAME.': '.$result[0]['last_name'].'<br />';				
					if(!$objLogin->IsLoggedInAsAdmin()){					
						echo _ADDRESS.': '.$result[0]['b_address'].'<br />';
						echo _ADDRESS_2.': '.$result[0]['b_address_2'].'<br />';
						echo _CITY.': '.$result[0]['b_city'].'<br />';
						echo _ZIP_CODE.': '.$result[0]['b_zipcode'].'<br />';
						echo _COUNTRY.': '.$result[0]['country_name'].'<br />';
						echo _STATE.': '.$result[0]['b_state'].'<br />';
					}				
				echo '</td>
				<td></td>
			</tr>
			</table><br />';

			echo '<table class="reservation_cart" border="0" width="99%" align="center" cellspacing="0" cellpadding="5">
			<tr><td colspan="10"><h4>'._RESERVATION_DETAILS.'</h4></td></tr>
			<tr class="header">
				<th class="'.$class_left.'" width="40px">&nbsp;</th>
				<th align="'.$class_left.'">'._ROOM_TYPE.'</th>
				<th align="center">'._FROM.'</th>
				<th align="center">'._TO.'</th>
				<th width="60px" align="center">'._NIGHTS.'</th>								
				<th width="50px" align="center">'._ROOMS.'</th>
				<th width="70px" colspan="3" align="center">'._OCCUPANCY.'</th>
				'.(($meal_plans_count) ? '<th width="60px" align="center">'._MEAL_PLANS.'</th>' : '<th style="padding:0px;">&nbsp;</th>').'
				<th class="'.$class_right.'" width="80px" align="'.$class_right.'">'._PRICE.'</th>
			</tr>';

			echo '<tr style="font-size:10px;background-color:transparent;">				
				<th colspan="6"></th>
				<th align="center">'._ADULT.'</th>
				'.(($allow_children == 'yes') ? '<th align="center">'._CHILD.'</th>' : '<th></th>').'
				'.(($allow_guests == 'yes') ? '<th align="center">'._GUEST.'</th>' : '<th></th>').' 
				<th colspan="2"></th>
			</tr>';
			
			$order_price=0;
			foreach ($this->arrReservation as $key => $val)
			{
				$sql = 'SELECT
							'.TABLE_ROOMS.'.id,
							'.TABLE_ROOMS.'.room_type,
							'.TABLE_ROOMS.'.room_icon_thumb,
							'.TABLE_ROOMS.'.max_adults,
							'.TABLE_ROOMS.'.max_children, 
							'.TABLE_ROOMS.'.default_price as price,
							'.TABLE_ROOMS_DESCRIPTION.'.room_type as loc_room_type,
							'.TABLE_ROOMS_DESCRIPTION.'.room_short_description as loc_room_short_description,
							'.TABLE_HOTELS_DESCRIPTION.'.name as hotel_name
						FROM '.TABLE_ROOMS.'
							INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' ON '.TABLE_ROOMS.'.id = '.TABLE_ROOMS_DESCRIPTION.'.room_id
							INNER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.TABLE_ROOMS.'.hotel_id	= '.TABLE_HOTELS_DESCRIPTION.'.hotel_id
						WHERE
							'.TABLE_ROOMS.'.id = '.(int)$key.' AND
							'.TABLE_ROOMS_DESCRIPTION.'.language_id = \''.$this->lang.'\' AND
							'.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.$this->lang.'\' ';

				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){
					$room_icon_thumb = ($result[0]['room_icon_thumb'] != '') ? $result[0]['room_icon_thumb'] : 'no_image.png';
					$room_price_w_meal_guest = ($val['price'] + $val['meal_plan_price'] + $val['guests_fee']);
					echo '<tr>
							<td><img src="images/rooms_icons/'.$room_icon_thumb.'" alt="" width="32px" height="32px" /></td>							
							<td>
								<b>'.prepare_link('rooms', 'room_id', $result[0]['id'], $result[0]['loc_room_type'], $result[0]['loc_room_type'], '', _CLICK_TO_VIEW).'</b><br>
								'.$result[0]['hotel_name'].'
							</td>							
							<td align="center">'.format_date($val['from_date'], $this->fieldDateFormat, '', true).'</td>
							<td align="center">'.format_date($val['to_date'], $this->fieldDateFormat, '', true).'</td>							
							<td align="center">'.$val['nights'].'</td>
							<td align="center">'.$val['rooms'].'</td>
							<td align="center">'.$val['adults'].'</td>
							'.(($allow_children == 'yes') ? '<td align="center">'.$val['children'].'</td>' : '<td></td>').'
							'.(($allow_guests == 'yes') ? '<td align="center">'.$val['guests'].'</td>' : '<td></td>').'
							'.(($meal_plans_count) ? '<td align="center">'.$val['meal_plan_name'].'</td>' : '<td></td>').'
							<td align="'.$class_right.'">'.Currencies::PriceFormat($room_price_w_meal_guest / $this->currencyRate, '', '', $this->currencyFormat).'&nbsp;</td>
						</tr>';
					$order_price += ($room_price_w_meal_guest / $this->currencyRate);
				}
			}
			
			// draw sub-total row			
			echo '<tr>
					<td colspan="7"></td>
					<td class="td '.$class_left.'" colspan="3"><b>'._SUBTOTAL.':</b></td>
					<td class="td '.$class_right.'" align="'.$class_right.'">
						<b>'.Currencies::PriceFormat($order_price, '', '', $this->currencyFormat).'</b>
					</td>
				 </tr>';

			//echo '<tr><td colspan="10" nowrap height="5px"></td></tr>';
			//echo '<tr><td colspan="11"><hr size="1" noshade="noshade" /></td></tr>';
			
			// EXTRAS
			// ------------------------------------------------------------
			if($extras[1]){
				echo '<tr><td colspan="11"><hr size="1" noshade="noshade" /></td></tr>';
				echo '<tr><td colspan="11"><h4>'._EXTRAS.'</h4></td></tr>';				
				echo '<tr><td colspan="11"><table width="340px">';				
				for($i=0; $i<$extras[1]; $i++){
					echo '<tr>';
					echo '<td wrap="wrap">'.$extras[0][$i]['name'].' <span class="help" title="'.$extras[0][$i]['description'].'">[?]</span></td>';
					echo '<td>&nbsp;</td>';
					echo '<td align="right">'.Currencies::PriceFormat($extras[0][$i]['price'] / $this->currencyRate, '', '', $this->currencyFormat).'</td>';
					echo '<td>&nbsp;</td>';
					echo '<td>'.draw_numbers_select_field('extras_'.$extras[0][$i]['id'], '', '0', $extras[0][$i]['maximum_count'], 1, 'extras_ddl', 'onchange="appUpdateTotalSum('.$i.',this.value,'.(int)$extras[1].')"', false).'</td>';
					echo '</tr>';
				}
				echo '</table></td></tr>';								
			}
			
			// calculate discount
			$discount_value = ($order_price * ($this->discountPercent / 100));
			$order_price -= $discount_value;
			
			// calculate percent
			$vat_cost = (($order_price + $this->bookingInitialFee) * ($this->vatPercent / 100));
			$cart_total = ($order_price + $this->bookingInitialFee) + $vat_cost;

			if($this->discountCampaignID != '' || $this->discountCoupon != ''){
				echo '<tr>
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="3"><b><span style="color:#a60000">'._DISCOUNT.': ('.Currencies::PriceFormat($this->discountPercent, '%', 'right', $this->currencyFormat).')</span></b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'"><b><span style="color:#a60000">- '.Currencies::PriceFormat($discount_value, '', '', $this->currencyFormat).'</span></b></td>
					</tr>';				
			}
			if(!empty($this->bookingInitialFee)){
				echo '<tr>
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="3"><b>'._INITIAL_FEE.': </b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'"><b>'.Currencies::PriceFormat($this->bookingInitialFee, '', '', $this->currencyFormat).'</b></td>
					</tr>';								
			}
			if($this->vatIncludedInPrice == 'no'){
				echo '<tr>
						<td colspan="7"></td>
						<td class="td '.$class_left.'" colspan="3"><b>'._VAT.': ('.Currencies::PriceFormat($this->vatPercent, '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($this->vatPercent)).')</b></td>
						<td class="td '.$class_right.'" align="'.$class_right.'">
							<b><label id="reservation_vat">'.Currencies::PriceFormat($vat_cost, '', '', $this->currencyFormat).'</label></b>
						</td>
					 </tr>';
			}
			echo '<tr><td colspan="11" nowrap height="5px"></td></tr>
				 <tr class="footer">
					<td colspan="7"></td>
					<td class="td '.$class_left.'" colspan="3"><b>'._TOTAL.':</b></td>
					<td class="td '.$class_right.'" align="'.$class_right.'">
						<b><label id="reservation_total">'.Currencies::PriceFormat($cart_total, '', '', $this->currencyFormat).'</label></b>
					</td>
				 </tr>';

			// PAYMENT DETAILS
			// ------------------------------------------------------------
			echo '<tr><td colspan="11"><hr size="1" noshade="noshade" /></td></tr>';
			echo '<tr><td colspan="11"><h4>'._PAYMENT_DETAILS.'</h4></td></tr>';
			echo '<tr><td colspan="11">';
			echo '<table border="0" width="100%">';
				if($payment_type_cnt > 1){
					echo '<tr><td width="130px" nowrap>'._PAYMENT_TYPE.': &nbsp;</td><td> 
					<select name="payment_type" id="payment_type">';
						if($payment_type_poa == 'yes') echo '<option value="poa" '.(($default_payment_system == 'poa') ? 'selected="selected"' : '').'>'._PAY_ON_ARRIVAL.'</option>';
						if($payment_type_online == 'yes') echo '<option value="online" '.(($default_payment_system == 'online') ? 'selected="selected"' : '').'>'._ONLINE_ORDER.'</option>';	
						if($payment_type_bank_transfer == 'yes') echo '<option value="bank.transfer" '.(($default_payment_system == 'bank.transfer') ? 'selected="selected"' : '').'>'._BANK_TRANSFER.'</option>';
						if($payment_type_paypal == 'yes') echo '<option value="paypal" '.(($default_payment_system == 'paypal') ? 'selected="selected"' : '').'>'._PAYPAL.'</option>';
						if($payment_type_2co == 'yes') echo '<option value="2co" '.(($default_payment_system == '2co') ? 'selected="selected"' : '').'>2CO</option>';	
						if($payment_type_authorize == 'yes') echo '<option value="authorize.net" '.(($default_payment_system == 'authorize.net') ? 'selected="selected"' : '').'>Authorize.Net</option>';	
					echo '</select>';
					echo '</td></tr>';
				}else if($payment_type_cnt == 1){
					if($payment_type_poa == 'yes') $payment_type_hidden = 'poa';
					else if($payment_type_online == 'yes') $payment_type_hidden = 'online';
					else if($payment_type_bank_transfer == 'yes') $payment_type_hidden = 'bank.transfer';
					else if($payment_type_paypal == 'yes') $payment_type_hidden = 'paypal';
					else if($payment_type_2co == 'yes') $payment_type_hidden = '2co';
					else if($payment_type_authorize == 'yes') $payment_type_hidden = 'authorize.net';
					else{
						$payment_type_hidden = '';
						$payment_types_defined = false;
					}
					echo '<tr><td>';
					echo draw_hidden_field('payment_type', $payment_type_hidden, false, 'payment_type');
					echo '</td></tr>';
				}else{
					$payment_types_defined = false;
					echo '<tr><td>';
					echo draw_important_message(_NO_PAYMENT_METHODS_ALERT, false);
					echo '</td></tr>';
				}						
				echo '<tr>';
					if($pre_payment_type == 'first night' && $this->first_night_possible){
						echo '<td>'._PAYMENT_TYPE.': </td>';
						echo '<td>';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_fully" value="full price" checked="checked" /> <label for="pre_payment_fully">'._FULL_PRICE.'</label> &nbsp;&nbsp;';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_partially" value="first night" /> <label for="pre_payment_partially">'._FIRST_NIGHT.'</label>';
						echo draw_hidden_field('pre_payment_value', $pre_payment_value, false, 'pre_payment_full');
					}else if($pre_payment_type == 'percentage' && $pre_payment_value > '0' && $pre_payment_value < '100'){
						echo '<td>'._PAYMENT_TYPE.': </td>';
						echo '<td>';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_fully" value="full price" checked="checked" /> <label for="pre_payment_fully">'._FULL_PRICE.'</label> &nbsp;&nbsp;';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_partially" value="percentage" /> <label for="pre_payment_partially">'._PRE_PAYMENT.' ('.Currencies::PriceFormat($pre_payment_value, '%', 'right', $this->currencyFormat).')</label>';
						echo draw_hidden_field('pre_payment_value', $pre_payment_value, false, 'pre_payment_full');
					}else if($pre_payment_type == 'fixed sum' && $pre_payment_value > '0'){
						echo '<td>'._PAYMENT_TYPE.': </td>';
						echo '<td>';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_fully" value="full price" checked="checked" /> <label for="pre_payment_fully">'._FULL_PRICE.'</label> &nbsp;&nbsp;';
						echo '<input type="radio" name="pre_payment_type" id="pre_payment_partially" value="fixed sum" /> <label for="pre_payment_partially">'._PRE_PAYMENT.' ('.Currencies::PriceFormat($pre_payment_value / $this->currencyRate, '', '', $this->currencyFormat).')</label>';
						echo draw_hidden_field('pre_payment_value', $pre_payment_value, false, 'pre_payment_full');
					}else{
						echo '<td colspan="2">';
						// full price payment
						if($payment_type_cnt <= 1 && $payment_types_defined) echo _FULL_PRICE;
						echo draw_hidden_field('pre_payment_type', 'full price', false, 'pre_payment_fully');
						echo draw_hidden_field('pre_payment_value', '100', false, 'pre_payment_full');
					}
					echo '</td>';
				echo '</tr>';			
			echo '</table></td></tr>';
			
			if($payment_types_defined){			
				// PROMO CODES OR DISCOUNT COUPONS
				// ------------------------------------------------------------
				echo '<tr><td colspan="11"><hr size="1" noshade="noshade" /></td></tr>';
				echo '<tr><td colspan="11"><h4>'._PROMO_CODE_OR_COUPON.'</h4></td></tr>';
				echo '<tr><td colspan="11">'._PROMO_COUPON_NOTICE.'</td></tr>';
				echo '<tr>';
				echo '<td colspan="11">';
				if(!empty($this->discountCoupon)){				
					echo '<input type="text" class="discount_coupon" name="discount_coupon" id="discount_coupon" value="'.$this->discountCoupon.'" readonly="readonly" maxlength="32" />&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" class="button" id="discount_button" value="'._REMOVE.'" onclick="appGoToPage(\'index.php?page=booking_checkout\', \'&submition_type=remove_coupon&token='.Application::Get('token').'&discount_coupon=\'+jQuery(\'#discount_coupon\').val(), \'post\')" />';
				}else{				
					echo '<input type="text" class="discount_coupon" name="discount_coupon" id="discount_coupon" value="'.$this->discountCoupon.'" maxlength="32" />&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" class="button" id="discount_button" value="'._APPLY.'" onclick="appGoToPage(\'index.php?page=booking_checkout\', \'&submition_type=apply_coupon&token='.Application::Get('token').'&discount_coupon=\'+jQuery(\'#discount_coupon\').val(), \'post\')" />';
				}
				echo '</td>';
				echo '</tr>';					
		
				echo '<tr><td colspan="11"><hr size="1" noshade="noshade" /></td></tr>
					  <tr valign="middle">
						<td colspan="11" nowrap height="15px">
							<h4 style="cursor:pointer;" onclick="appToggleElement(\'additional_info\')">'._ADDITIONAL_INFO.' +</h4>
							<textarea name="additional_info" id="additional_info" style="display:none;width:100%;height:75px"></textarea>
						</td>
					  </tr>
					  <tr><td colspan="11" nowrap height="5px"></td></tr>
					  <tr valign="middle">
						<td colspan="8" align="'.$class_right.'"></td>
						<td align="'.$class_right.'" colspan="3">
							'.(($payment_types_defined) ? '<input class="button" type="submit" value="'._SUBMIT_BOOKING.'" />' : '').' 
						</td>
					</tr>';
				echo '</table>';
				echo '<input type="hidden" id="hid_vat_percent" value="'.$this->vatPercent.'" />';
				echo '<input type="hidden" id="hid_booking_initial_fee" value="'.$this->bookingInitialFee.'" />';
				echo '<input type="hidden" id="hid_order_price" value="'.$order_price.'" />';
				echo '<input type="hidden" id="hid_currency_symbol" value="'.Application::Get('currency_symbol').'" />';
				echo '<input type="hidden" id="hid_currency_format" value="'.$this->currencyFormat.'" />';
				echo '</form><br>';
			}else{
				echo '</table>';
				echo '</form>';				
				return '';
			}
		}else{
			draw_message(_RESERVATION_CART_IS_EMPTY_ALERT, true, true);
		}
	}	

	/**
	 * Empty Reservation Cart
	 */
	public function EmptyCart()
	{
		$this->arrReservation = array();
		$this->arrReservationInfo = array();
		Session::Set('current_customer_id', '');
	}
	
	/**
	 * Returns amount of items in Reservation Cart
	 */
	public function GetCartItems()
	{
		return $this->cartItems;
	}	
	
	/**
	 * Checks if cart is empty 
	 */
	public function IsCartEmpty()
	{
		return ($this->cartItems > 0) ? false : true;
	}	

	/**
	 * Draw reservation info
	 * 		@param $payment_type
	 * 		@param $additional_info
	 * 		@param $extras
	 * 		@param $pre_payment_type
	 * 		@param $pre_payment_value
	 * 		@param $draw
	 */
	public function DrawReservation($payment_type, $additional_info, $extras = array(), $pre_payment_type = '', $pre_payment_value = '', $draw = true)
	{
		global $objLogin;

		$class_left = Application::Get('defined_left');
		$class_right = Application::Get('defined_right');
		$output = '';

		$cc_type 		  = isset($_POST['cc_type']) ? prepare_input($_POST['cc_type']) : '';
		$cc_holder_name   = isset($_POST['cc_holder_name']) ? prepare_input($_POST['cc_holder_name']) : '';
		$cc_number 		  = isset($_POST['cc_number']) ? prepare_input($_POST['cc_number']) : '';
		$cc_expires_month = isset($_POST['cc_expires_month']) ? prepare_input($_POST['cc_expires_month']) : '01';
		$cc_expires_year  = isset($_POST['cc_expires_year']) ? prepare_input($_POST['cc_expires_year']) : date('Y');
		$cc_cvv_code 	  = isset($_POST['cc_cvv_code']) ? prepare_input($_POST['cc_cvv_code']) : '';

		$paypal_email        = ModulesSettings::Get('booking', 'paypal_email');
		$credit_card_required = ModulesSettings::Get('booking', 'online_credit_card_required');
		$two_checkout_vendor = ModulesSettings::Get('booking', 'two_checkout_vendor');
		$authorize_login_id  = ModulesSettings::Get('booking', 'authorize_login_id');
		$authorize_transaction_key = ModulesSettings::Get('booking', 'authorize_transaction_key');
		$mode                = ModulesSettings::Get('booking', 'mode');
		
		// prepare customers info 
		$sql='SELECT * FROM '.TABLE_CUSTOMERS.' WHERE id = '.(int)$this->currentCustomerID;
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		$customer_info = array();
		$customer_info['first_name'] = isset($result[0]['first_name']) ? $result[0]['first_name'] : '';
		$customer_info['last_name'] = isset($result[0]['last_name']) ? $result[0]['last_name'] : '';
		$customer_info['address1'] = isset($result[0]['b_address']) ? $result[0]['b_address'] : '';
		$customer_info['address2'] = isset($result[0]['b_address2']) ? $result[0]['b_address2'] : '';
		$customer_info['city'] = isset($result[0]['b_city']) ? $result[0]['b_city'] : '';
		$customer_info['state'] = isset($result[0]['b_state']) ? $result[0]['b_state'] : '';
		$customer_info['zip'] = isset($result[0]['b_zipcode']) ? $result[0]['b_zipcode'] : '';
		$customer_info['country'] = isset($result[0]['b_country']) ? $result[0]['b_country'] : '';
		$customer_info['email'] = isset($result[0]['email']) ? $result[0]['email'] : '';
		$customer_info['company'] = isset($result[0]['company']) ? $result[0]['company'] : '';
		$customer_info['phone'] = isset($result[0]['phone']) ? $result[0]['phone'] : '';
		$customer_info['fax'] = isset($result[0]['fax']) ? $result[0]['fax'] : '';
		
		if($cc_holder_name == ''){
			if($objLogin->IsLoggedIn()){
				$cc_holder_name = $objLogin->GetLoggedFirstName().' '.$objLogin->GetLoggedLastName();
			}else{
				$cc_holder_name = $customer_info['first_name'].' '.$customer_info['last_name'];
			}
		}		
		
		// check if prepared booking exists and replace it		
		$sql='SELECT id, booking_number
			  FROM '.TABLE_BOOKINGS.'
			  WHERE customer_id = '.(int)$this->currentCustomerID.' AND
					status = 0 AND  
					is_admin_reservation = '.(($this->selectedUser == 'admin') ? '1' : '0').'
			  ORDER BY id DESC';	
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$booking_number = $result[0]['booking_number'];
			$order_price = $this->cartTotalSum;
			
			// prepare extras
			$extras_text = '';
			$extras_param = '';
			$extras_sub_total = 0;
			if(count($extras) > 0){
				$extras_text_header = '<tr><td colspan="3" nowrap height="10px"></td></tr>
					  <tr><td colspan="3"><h4>'._EXTRAS.'</h4></td></tr>
					  <tr><td colspan="3">';				
					$extras_text_middle = '';
					foreach($extras as $key => $val){
						$extr = Extras::GetExtrasInfo($key);
						if($val){
							$extras_sub_total += ($extr['price'] / $this->currencyRate) * $val;
							$extras_text_middle .= '<tr><td nowrap="nowrap">'.$extr['name'].'&nbsp;</td>';
							$extras_text_middle .= '<td> : </td>';
							$extras_text_middle .= '<td> '.Currencies::PriceFormat($extr['price'] / $this->currencyRate, '', '', $this->currencyFormat).' x '.$val;
							$extras_text_middle .= draw_hidden_field('extras_'.$key, $val, false)."\n";
							$extras_param .= draw_hidden_field('extras_'.$key, $val, false)."\n";
							$extras_text_middle .= '</td></tr>';
						}
					}
				$extras_text_footer  = '<tr><td>'._EXTRAS_SUBTOTAL.' </td><td> : </td><td> <b>'.Currencies::PriceFormat($extras_sub_total, '', '', $this->currencyFormat).'</b></td></tr>';								  
				$extras_text_footer .= '</td></tr>';			
	
				if($extras_sub_total >= 0){
					$extras_text = $extras_text_header.$extras_text_middle.$extras_text_footer;
				}
			}
			
			// calculate discount
			$discount_value = ($order_price * ($this->discountPercent / 100));
			$order_price_after_discount = $order_price - $discount_value;
	
			// calculate VAT
			$cart_total_wo_vat = round($order_price_after_discount + $extras_sub_total, 2);
			$vat_cost = (($cart_total_wo_vat + $this->bookingInitialFee) * ($this->vatPercent / 100));
			$cart_total = round($cart_total_wo_vat, 2) + $this->bookingInitialFee + $vat_cost;
			
			if($pre_payment_type == 'first night'){
				$is_prepayment = true;			
				$cart_total = ($this->firstNightSum * (1 + $this->vatPercent / 100));
				$prepayment_text = _FIRST_NIGHT;
			}else if(($pre_payment_type == 'percentage') && (int)$pre_payment_value > 0 && (int)$pre_payment_value < 100){
				$is_prepayment = true;			
				$cart_total = ($cart_total * ($pre_payment_value / 100));
				$prepayment_text = $pre_payment_value.'%';
			}else if(($pre_payment_type == 'fixed sum') && (int)$pre_payment_value > 0){
				$is_prepayment = true;			
				$cart_total = round($pre_payment_value / $this->currencyRate, 2);
				$prepayment_text = _FIXED_SUM;  
			}else{
				$prepayment_text = '';
				$is_prepayment = false;
			}
	
			$pp_params = array(
				'api_login'       => '',
				'transaction_key' => '',
				'booking_number'    => $booking_number,			
				
				'address1'      => $customer_info['address1'],
				'address2'      => $customer_info['address2'],
				'city'          => $customer_info['city'],
				'zip'           => $customer_info['zip'],
				'country'       => $customer_info['country'],
				'state'         => $customer_info['state'],
				'first_name'    => $customer_info['first_name'],
				'last_name'     => $customer_info['last_name'],
				'email'         => $customer_info['email'],
				'company'       => $customer_info['company'],
				'phone'         => $customer_info['phone'],
				'fax'           => $customer_info['fax'],
				
				'notify'        => '',
				'return'        => 'index.php?page=booking_return',
				'cancel_return' => 'index.php?page=booking_cancel',
							
				'paypal_form_type'   	   => '',
				'paypal_form_fields' 	   => '',
				'paypal_form_fields_count' => '',
				
				'credit_card_required' => '',
				'cc_type'             => '',
				'cc_holder_name'      => '',
				'cc_number'           => '',
				'cc_cvv_code'         => '',
				'cc_expires_month'    => '',
				'cc_expires_year'     => '',
				
				'currency_code'      => Application::Get('currency_code'),
				'additional_info'    => $additional_info,
				'discount_value'     => $discount_value,
				'extras_param'       => $extras_param,
				'extras_sub_total'   => $extras_sub_total,
				'vat_cost'           => $vat_cost,
				'cart_total'         => $cart_total,
				'is_prepayment'      => $is_prepayment,
				'pre_payment_type'   => $pre_payment_type,
				'pre_payment_value'  => $pre_payment_value,				
			);
	
			$fisrt_part = '<table border="0" width="97%" align="center">
				<tr><td width="20%">'._BOOKING_DATE.' </td><td width="2%"> : </td><td> '.format_date(date('Y-m-d H:i:s'), $this->fieldDateFormat, '', true).'</td></tr>						
				<tr><td>'._ROOMS.' </td><td> : </td><td> '.(int)$this->roomsCount.'</td></tr>
				<tr><td>'._BOOKING_PRICE.' </td><td width="2%"> : </td><td> '.Currencies::PriceFormat($order_price, '', '', $this->currencyFormat).'</td></tr>';
			if($discount_value != ''){
				$fisrt_part .= 	'<tr><td>'._DISCOUNT.' </td><td> : </td><td> - '.Currencies::PriceFormat($discount_value, '', '', $this->currencyFormat).' ('.Currencies::PriceFormat($this->discountPercent, '%', 'right', $this->currencyFormat).')</td></tr>';
				$fisrt_part .= 	'<tr><td>'._BOOKING_SUBTOTAL.' </td><td> : </td><td> <b>'.Currencies::PriceFormat($order_price_after_discount, '', '', $this->currencyFormat).'</b></td></tr>';
			}			
				
			$fisrt_part .= ((count($extras) > 0) ? $extras_text : '').'
				<tr><td colspan="3" nowrap height="10px"></td></tr>
				<tr><td colspan="3"><h4>'._TOTAL.'</h4></td></tr>
				<tr><td>'._SUBTOTAL.' </td><td> : </td><td> '.Currencies::PriceFormat($cart_total_wo_vat, '', '', $this->currencyFormat).'</td></tr>';
				if(!empty($this->bookingInitialFee)){
					$fisrt_part .= '<tr><td>'._INITIAL_FEE.' </td><td> : </td><td> '.Currencies::PriceFormat($this->bookingInitialFee, '', '', $this->currencyFormat).'</td></tr>';
				}
				if($this->vatIncludedInPrice == 'no'){
					$fisrt_part .= '<tr><td>'._VAT.' ('.Currencies::PriceFormat($this->vatPercent, '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($this->vatPercent)).') </td><td> : </td><td> '.Currencies::PriceFormat($vat_cost, '', '', $this->currencyFormat).'</td></tr>';
				}
				if($is_prepayment){
					$fisrt_part .= '<tr><td>'._PAYMENT_SUM.' </td><td> : </td><td> <b>'.Currencies::PriceFormat($order_price_after_discount + $extras_sub_total + $this->bookingInitialFee + $vat_cost, '', '', $this->currencyFormat).'</b></td></tr>';
					$fisrt_part .= '<tr><td>'._PRE_PAYMENT.'</td><td> : </td> <td>'.Currencies::PriceFormat($cart_total, '', '', $this->currencyFormat).' ('.$prepayment_text.')</td></tr>';
				}else{
					$fisrt_part .= '<tr><td>'._PAYMENT_SUM.' </td><td> : </td><td> <b>'.Currencies::PriceFormat($order_price_after_discount + $extras_sub_total + $this->bookingInitialFee + $vat_cost, '', '', $this->currencyFormat).'</b></td></tr>';
					///echo '<tr><td>'._PRE_PAYMENT.'</td><td> : </td> <td>'._FULL_PRICE.'</td></tr>';
				}
				if($additional_info != ''){
					$fisrt_part .= '<tr><td colspan="3" nowrap height="10px"></td></tr>';
					$fisrt_part .= '<tr><td colspan="3"><h4>'._ADDITIONAL_INFO.'</h4>'.$additional_info.'</td></tr>';							
				}
			
			$second_part = '</table><br />';
	
			if($payment_type == 'poa'){	
				
				$output .= $fisrt_part;
				$output .= PaymentIPN::DrawPaymentForm('poa', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;
				
			}else if($payment_type == 'online'){
	
				$output .= $fisrt_part;
					$pp_params['credit_card_required'] = $credit_card_required;
					$pp_params['cc_type']             = $cc_type;
					$pp_params['cc_holder_name']      = $cc_holder_name;
					$pp_params['cc_number']           = $cc_number;
					$pp_params['cc_cvv_code']         = $cc_cvv_code;
					$pp_params['cc_expires_month']    = $cc_expires_month;
					$pp_params['cc_expires_year']     = $cc_expires_year;
				$output .= PaymentIPN::DrawPaymentForm('online', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;			
		
			}else if($payment_type == 'paypal'){							
			
				$output .= $fisrt_part;
					$pp_params['api_login']                = $paypal_email;
					$pp_params['notify']        		   = 'index.php?page=booking_notify_paypal';
					$pp_params['paypal_form_type']   	   = $this->paypal_form_type;
					$pp_params['paypal_form_fields'] 	   = $this->paypal_form_fields;
					$pp_params['paypal_form_fields_count'] = $this->paypal_form_fields_count;						
				$output .= PaymentIPN::DrawPaymentForm('paypal', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;		
			
			}else if($payment_type == '2co'){				
	
				$output .= $fisrt_part;
					$pp_params['api_login'] = $two_checkout_vendor;			
					$pp_params['notify']    = 'index.php?page=booking_notify_2co';
				$output .= PaymentIPN::DrawPaymentForm('2co', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;
	
			}else if($payment_type == 'authorize.net'){
	
				$output .= $fisrt_part;
					$pp_params['api_login'] 	  = $authorize_login_id;
					$pp_params['transaction_key'] = $authorize_transaction_key;
					$pp_params['notify']    	  = 'index.php?page=booking_notify_autorize_net';
					// authorize.net accepts only USD, so we need to convert the sum into USD
					$pp_params['cart_total']      = number_format((($pp_params['cart_total'] * Application::Get('currency_rate'))), '2', '.', ',');												
				$output .= PaymentIPN::DrawPaymentForm('authorize.net', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;
	
			}else if($payment_type == 'bank.transfer'){
				
				$output .= $fisrt_part;
				$output .= PaymentIPN::DrawPaymentForm('bank.transfer', $pp_params, (($mode == 'TEST MODE') ? 'test' : 'real'), false);
				$output .= $second_part;							
			}			
		}else{
			///echo $sql.mysql_error();
			$output .= draw_important_message(_ORDER_ERROR, false);
		}
		
		if($draw) echo $output;
		else return $output;
	}

	/**
	 * Place booking
	 * 		@param $additional_info
	 * 		@param $cc_params
	 */
	public function PlaceBooking($additional_info = '', $cc_params = array())
	{
		global $objLogin;
		$additional_info = substr_by_word($additional_info, 1024);
		
        if(SITE_MODE == 'demo'){
           $this->message = draw_important_message(_OPERATION_BLOCKED, false);
		   return false;
        }
		
		// check if prepared booking exists
		$sql = 'SELECT id, booking_number
				FROM '.TABLE_BOOKINGS.'
				WHERE customer_id = '.(int)$this->currentCustomerID.' AND
					  is_admin_reservation = '.(($this->selectedUser == 'admin') ? '1' : '0').' AND
					  status = 0
				ORDER BY id DESC';

		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){
			$booking_number = $result[0]['booking_number'];
			
			$sql = 'UPDATE '.TABLE_BOOKINGS.'
					SET
						status_changed = \''.date('Y-m-d H:i:s').'\',
						additional_info = \''.$additional_info.'\',
						cc_type = \''.$cc_params['cc_type'].'\',
						cc_holder_name = \''.$cc_params['cc_holder_name'].'\',
						cc_number = AES_ENCRYPT(\''.$cc_params['cc_number'].'\', \''.PASSWORDS_ENCRYPT_KEY.'\'),
						cc_expires_month = \''.$cc_params['cc_expires_month'].'\',
						cc_expires_year = \''.$cc_params['cc_expires_year'].'\',
						cc_cvv_code = \''.$cc_params['cc_cvv_code'].'\',
						status = \'1\'
					WHERE booking_number = \''.$booking_number.'\'';
			database_void_query($sql);

			// update customer bookings/rooms amount
			$sql = 'UPDATE '.TABLE_CUSTOMERS.' SET 
						orders_count = orders_count + 1,
						rooms_count = rooms_count + '.$this->roomsCount.'
					WHERE id = '.(int)$this->currentCustomerID;
			database_void_query($sql);					
			if(!$objLogin->IsLoggedIn()){
				// clear selected user ID for non-registered visitors
				Session::Set('sel_current_customer_id', '');
			}

			$this->message = draw_success_message(str_replace('_BOOKING_NUMBER_', '<b>'.$booking_number.'</b>', _ORDER_PLACED_MSG), false);
			if($this->SendOrderEmail($booking_number, 'placed', $this->currentCustomerID)){
				$this->message .= draw_success_message(_EMAIL_SUCCESSFULLY_SENT, false);
			}else{
				if($objLogin->IsLoggedInAsAdmin()){
					$this->message .= draw_important_message(_EMAIL_SEND_ERROR, false);					
				}
			}
		}else{
			$this->message = draw_important_message(_EMAIL_SEND_ERROR, false);					
		}
		
		if(SITE_MODE == 'development' && mysql_error() != '') $this->message .= '<br>'.$sql.'<br>'.mysql_error();		
		
		$this->EmptyCart();		
	}	

	/**
	 * Makes reservation
	 * 		@param $payment_type
	 * 		@param $additional_info
	 * 		@param $extras
	 * 		@param $pre_payment_type
	 * 		@param $pre_payment_value
	 */
	public function DoReservation($payment_type = '', $additional_info = '', $extras = array(), $pre_payment_type = '', $pre_payment_value = '')
	{
		global $objLogin;
		
        if(SITE_MODE == 'demo'){
           $this->error = draw_important_message(_OPERATION_BLOCKED, false);
		   return false;
        }
		
		// check the maximum allowed room reservation per customer
		if($this->selectedUser == 'customer'){
			$sql = 'SELECT COUNT(*) as cnt FROM '.TABLE_BOOKINGS.' WHERE customer_id = '.(int)$this->currentCustomerID.' AND status < 2';
			$result = database_query($sql, DATA_ONLY);
			$cnt = isset($result[0]['cnt']) ? (int)$result[0]['cnt'] : 0;
			if($cnt >= $this->maximumAllowedReservations){
				$this->error = draw_important_message(_MAX_RESERVATIONS_ERROR, false);
				return false;
			}		
		}

		$booking_placed = false;
		$booking_number = '';
		$additional_info = substr_by_word($additional_info, 1024);

		$order_price = $this->cartTotalSum;

		// calculate extras
		$extras_sub_total = '0';
		$extras_info = array();		
		foreach($extras as $key => $val){
			$extr = Extras::GetExtrasInfo($key);
			$extras_sub_total += ($extr['price'] / $this->currencyRate) * $val;
			$extras_info[$key] = $val;
		}
		///$order_price += $extras_sub_total;

		// calculate discount			
		$discount_value = ($order_price * ($this->discountPercent / 100));
		$order_price_after_discount = $order_price - $discount_value;

		// calculate VAT			 
		$cart_total_wo_vat = round($order_price_after_discount + $extras_sub_total, 2);
		$vat_cost = (($cart_total_wo_vat + $this->bookingInitialFee) * ($this->vatPercent / 100));
		$cart_total = round($cart_total_wo_vat, 2) + $this->bookingInitialFee + $vat_cost;

		if($pre_payment_type == 'first night'){			
			$cart_total = ($this->firstNightSum * (1 + $this->vatPercent / 100));
		}else if(($pre_payment_type == 'percentage') && (int)$pre_payment_value > 0 && (int)$pre_payment_value < 100){
			$cart_total = ($cart_total * ($pre_payment_value / 100));
		}else if(($pre_payment_type == 'fixed sum') && (int)$pre_payment_value > 0){
			$cart_total = round($pre_payment_value / $this->currencyRate, 2);
		}else{			
			// $cart_total
		}		

		if($this->cartItems > 0){
            // add order to database
			if(in_array($payment_type, array('poa', 'online', 'paypal', '2co', 'authorize.net', 'bank.transfer'))){
				if($payment_type == 'bank.transfer'){
					$payed_by = '5';
					$status = '0';
				}else if($payment_type == 'authorize.net'){
					$payed_by = '4';
					$status = '0';
				}else if($payment_type == '2co'){
					$payed_by = '3';
					$status = '0';
				}else if($payment_type == 'paypal'){
					$payed_by = '2';
					$status = '0';
				}else if($payment_type == 'online'){
					$payed_by = '1';
					$status = '0';
				}else{
					$payed_by = '0';
					$status = '0';
				}
				
				// check if prepared booking exists and replace it
				$sql = 'SELECT id, booking_number
						FROM '.TABLE_BOOKINGS.'
						WHERE customer_id = '.(int)$this->currentCustomerID.' AND
							  is_admin_reservation = '.(($this->selectedUser == 'admin') ? '1' : '0').' AND
							  status = 0
						ORDER BY id DESC';
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
				if($result[1] > 0){
					$booking_number = $result[0]['booking_number'];
					// booking exists - replace it with new					
					$sql = 'DELETE FROM '.TABLE_BOOKINGS_ROOMS.' WHERE booking_number = \''.$booking_number.'\'';		
					if(!database_void_query($sql)){ /* echo 'error!'; */ }
					
					$sql = 'UPDATE '.TABLE_BOOKINGS.' SET ';
					$sql_end = ' WHERE booking_number = \''.$booking_number.'\'';
					$is_new_record = false;
				}else{
					$sql = 'INSERT INTO '.TABLE_BOOKINGS.' SET booking_number = \'\',';
					$sql_end = '';
					$is_new_record = true;
				}

				$sql .= 'booking_description = \''._ROOMS_RESERVATION.'\',
						order_price = '.$order_price.',
						pre_payment_type = \''.$pre_payment_type.'\',
						pre_payment_value = \''.(($pre_payment_type != 'full price') ? $pre_payment_value : '0').'\',
						discount_campaign_id = '.(int)$this->discountCampaignID.',
						discount_percent = '.$this->discountPercent.',
						discount_fee = '.$discount_value.',
						vat_fee = '.$vat_cost.',
						vat_percent = '.$this->vatPercent.',
						initial_fee = '.$this->bookingInitialFee.',
						extras = \''.serialize($extras_info).'\',
						extras_fee = \''.$extras_sub_total.'\',
						payment_sum = '.$cart_total.',
						additional_payment = 0,						
						currency = \''.$this->currencyCode.'\',
						rooms_amount = '.(int)$this->roomsCount.',						
						customer_id = '.(int)$this->currentCustomerID.',
						is_admin_reservation = '.(($this->selectedUser == 'admin') ? '1' : '0').',
						transaction_number = \'\',
						created_date = \''.date('Y-m-d H:i:s').'\',
						payment_type = '.$payed_by.',
						payment_method = 0,
						coupon_code = \''.$this->discountCoupon.'\',						
						additional_info = \''.$additional_info.'\',
						cc_type = \'\',
						cc_holder_name = \'\', 
						cc_number = \'\', 
						cc_expires_month = \'\', 
						cc_expires_year = \'\', 
						cc_cvv_code = \'\',
						status = '.(int)$status.',
						status_description = \'\'';
				$sql .= $sql_end;

                // handle booking details
				if(database_void_query($sql)){					
					if($is_new_record){
						$insert_id = mysql_insert_id();
						$booking_number = $this->GenerateBookingNumber($insert_id);
						$sql = 'UPDATE '.TABLE_BOOKINGS.' SET booking_number = \''.$booking_number.'\' WHERE id = '.(int)$insert_id;
						if(!database_void_query($sql)){
							$this->error = draw_important_message(_ORDER_ERROR, false);
						}
					}

					$sql = 'INSERT INTO '.TABLE_BOOKINGS_ROOMS.'
								(id, booking_number, hotel_id, room_id, room_numbers, checkin, checkout, adults, children, rooms, price, guests, guests_fee, meal_plan_id, meal_plan_price)
							VALUES ';
					$items_count = 0;
					foreach($this->arrReservation as $key => $val){					
						$sql .= ($items_count++ > 0) ? ',' : '';
						$sql .= '(NULL, \''.$booking_number.'\', '.(int)$val['hotel_id'].', '.(int)$key.', \'\', \''.$val['from_date'].'\', \''.$val['to_date'].'\', \''.$val['adults'].'\', \''.$val['children'].'\', '.(int)$val['rooms'].', '.($val['price'] / $this->currencyRate).', '.(int)$val['guests'].', '.($val['guests_fee'] / $this->currencyRate).', '.(int)$val['meal_plan_id'].', '.($val['meal_plan_price'] / $this->currencyRate).')'; 
					}
					if(database_void_query($sql)){
						$booking_placed = true;						
					}else{
						$this->error = draw_important_message(_ORDER_ERROR, false);
					}
				}else{
					$this->error = draw_important_message(_ORDER_ERROR, false);
				}
			}else{
				$this->error = draw_important_message(_ORDER_ERROR, false);
			}
		}else{
			$this->error = draw_message(_RESERVATION_CART_IS_EMPTY_ALERT, false, true);
		}
		
		if(SITE_MODE == 'development' && !empty($this->error)) $this->error .= '<br>'.$sql.'<br>'.mysql_error();		
		
		return $booking_placed;		
	}	

	/**
	 * Sends booking email
	 * 		@param booking_number
	 * 		@param $order_type
	 * 		@param $customer_id
	 */
	public function SendOrderEmail($booking_number, $order_type = 'placed', $customer_id = '')
	{		
		global $objSettings;
		
		$lang = Application::Get('lang');
		$return = true;
		$personal_information = '';
		$allow_children = ModulesSettings::Get('rooms', 'allow_children');
		$allow_guests = ModulesSettings::Get('rooms', 'allow_guests');
		$hotels_count = Hotels::HotelsCount();
		$meal_plans_count = MealPlans::MealPlansCount();

		$arr_payment_types = array(
			'0'=>_PAY_ON_ARRIVAL,
			'1'=>_ONLINE_ORDER,
			'2'=>_PAYPAL,
			'3'=>'2CO',
			'4'=>'Authorize.Net',
			'5'=>_BANK_TRANSFER
		);
	
		// send email to customer
		$sql = 'SELECT
			'.TABLE_BOOKINGS.'.id,
			'.TABLE_BOOKINGS.'.booking_number,
			'.TABLE_BOOKINGS.'.booking_description,
			'.TABLE_BOOKINGS.'.order_price,
			'.TABLE_BOOKINGS.'.discount_fee,
			'.TABLE_BOOKINGS.'.discount_percent, 
			'.TABLE_BOOKINGS.'.coupon_code,
			'.TABLE_BOOKINGS.'.vat_fee,
			'.TABLE_BOOKINGS.'.vat_percent,			
			'.TABLE_BOOKINGS.'.initial_fee,
			'.TABLE_BOOKINGS.'.extras,
			'.TABLE_BOOKINGS.'.extras_fee,
			'.TABLE_BOOKINGS.'.payment_sum,
			'.TABLE_BOOKINGS.'.currency,
			'.TABLE_BOOKINGS.'.rooms_amount,
			'.TABLE_BOOKINGS.'.customer_id,
			'.TABLE_BOOKINGS.'.transaction_number,
			'.TABLE_BOOKINGS.'.created_date,
			'.TABLE_BOOKINGS.'.payment_date,
			'.TABLE_BOOKINGS.'.payment_type,
			'.TABLE_BOOKINGS.'.payment_method,
			'.TABLE_BOOKINGS.'.status,
			'.TABLE_BOOKINGS.'.status_description,  
			'.TABLE_BOOKINGS.'.email_sent,
			'.TABLE_BOOKINGS.'.additional_info,
			'.TABLE_BOOKINGS.'.is_admin_reservation,
			CASE
				WHEN '.TABLE_BOOKINGS.'.payment_method = 0 THEN \''._PAYMENT_COMPANY_ACCOUNT.'\'
				WHEN '.TABLE_BOOKINGS.'.payment_method = 1 THEN \''._CREDIT_CARD.'\'
				WHEN '.TABLE_BOOKINGS.'.payment_method = 2 THEN \''._ECHECK.'\'
				ELSE \''._UNKNOWN.'\'
			END as mod_payment_method,						
			'.TABLE_CUSTOMERS.'.first_name,
			'.TABLE_CUSTOMERS.'.last_name,
			'.TABLE_CUSTOMERS.'.user_name as customer_name,
			'.TABLE_CUSTOMERS.'.email,
			'.TABLE_CUSTOMERS.'.preferred_language,
			'.TABLE_CUSTOMERS.'.b_address,
			'.TABLE_CUSTOMERS.'.b_address_2,
			'.TABLE_CUSTOMERS.'.b_city,
			'.TABLE_CUSTOMERS.'.b_state,
			'.TABLE_CUSTOMERS.'.b_country,
			'.TABLE_CUSTOMERS.'.b_zipcode,
			'.TABLE_CUSTOMERS.'.phone,
			'.TABLE_CUSTOMERS.'.fax,
			'.TABLE_CURRENCIES.'.symbol,
			'.TABLE_CURRENCIES.'.symbol_placement,
			'.TABLE_CAMPAIGNS.'.campaign_name			
		FROM '.TABLE_BOOKINGS.'
			INNER JOIN '.TABLE_CURRENCIES.' ON '.TABLE_BOOKINGS.'.currency = '.TABLE_CURRENCIES.'.code
			LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.TABLE_BOOKINGS.'.customer_id = '.TABLE_CUSTOMERS.'.id
			LEFT OUTER JOIN '.TABLE_CAMPAIGNS.' ON '.TABLE_BOOKINGS.'.discount_campaign_id = '.TABLE_CAMPAIGNS.'.id
		WHERE
			'.TABLE_BOOKINGS.'.customer_id = '.$customer_id.' AND
			'.TABLE_BOOKINGS.'.booking_number = \''.$booking_number.'\'';
		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
		if($result[1] > 0){					
			
			$recipient = $result[0]['email'];
			$first_name = $result[0]['first_name'];
			$last_name = $result[0]['last_name'];
			$email_sent = $result[0]['email_sent'];
			$status_description = $result[0]['status_description'];
			$preferred_language = $result[0]['preferred_language'];
			$is_admin_reservation = $result[0]['is_admin_reservation'];
			$payment_type = (int)$result[0]['payment_type'];
			
			if(ModulesSettings::Get('booking', 'mode') == 'TEST MODE'){
				$personal_information .= '<div style="text-align:center;padding:10px;color:#a60000;border:1px dashed #a60000;width:100px">TEST MODE!</div><br />';	
			}			

			$personal_information .= '<b>'._PERSONAL_INFORMATION.':</b>';
			$personal_information .= '<br />-----------------------------<br />';
			$personal_information .= _FIRST_NAME.' : '.$result[0]['first_name'].'<br />';
			$personal_information .= _LAST_NAME.' : '.$result[0]['last_name'].'<br />';
			$personal_information .= _EMAIL_ADDRESS.' : '.$result[0]['email'].'<br />';

			$billing_information  = '<b>'._BILLING_DETAILS.':</b>';
			$billing_information .= '<br />-----------------------------<br />';
			$billing_information .= _ADDRESS.' : '.$result[0]['b_address'].' '.$result[0]['b_address_2'].'<br />';
			$billing_information .= _CITY.' : '.$result[0]['b_city'].'<br />';
			$billing_information .= _STATE.' : '.$result[0]['b_state'].'<br />';
			$billing_information .= _COUNTRY.' : '.$result[0]['b_country'].'<br />';
			$billing_information .= _ZIP_CODE.' : '.$result[0]['b_zipcode'].'<br />';
			if(!empty($result[0]['phone'])) $billing_information .= _PHONE.' : '.$result[0]['phone'].'<br />';
			if(!empty($result[0]['fax'])) $billing_information .= _FAX.' : '.$result[0]['fax'].'<br />';
	
			$booking_details  = _BOOKING_DESCRIPTION.': '.$result[0]['booking_description'].'<br />';
			$booking_details .= _CREATED_DATE.': '.format_datetime($result[0]['created_date'], $this->fieldDateFormat.' H:i:s', '', true).'<br />';
			$payment_date = format_datetime($result[0]['payment_date'], $this->fieldDateFormat.' H:i:s', '', true);
			if(empty($payment_date)) $payment_date = _NOT_PAID_YET;
			$booking_details .= _PAYMENT_DATE.': '.$payment_date.'<br />';
			$booking_details .= _PAYMENT_TYPE.': '.((isset($arr_payment_types[$payment_type])) ? $arr_payment_types[$payment_type] : '').'<br />';
			$booking_details .= _PAYMENT_METHOD.': '.$result[0]['mod_payment_method'].'<br />';
			$booking_details .= _CURRENCY.': '.$result[0]['currency'].'<br />';
			$booking_details .= _ROOMS.': '.$result[0]['rooms_amount'].'<br />';
			$booking_details .= _BOOKING_PRICE.': '.Currencies::PriceFormat($result[0]['order_price'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'<br />';
			$booking_details .= (($result[0]['campaign_name'] != '') ? _DISCOUNT.': - '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '.$result[0]['campaign_name'].')<br />' : '');
			$booking_details .= (($result[0]['coupon_code'] != '') ? _DISCOUNT.': - '.Currencies::PriceFormat($result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['discount_percent'], '%', 'right', $this->currencyFormat).' - '._COUPON_CODE.': '.$result[0]['coupon_code'].')<br />' : '');
			$booking_details .= _BOOKING_SUBTOTAL.(($result[0]['campaign_name'] != '') ? ' ('._AFTER_DISCOUNT.')' : '').': '.Currencies::PriceFormat($result[0]['order_price'] - $result[0]['discount_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'<br />';

			if(!empty($result[0]['extras'])) $booking_details .= _EXTRAS_SUBTOTAL.': '.Currencies::PriceFormat($result[0]['extras_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'<br />';

			if(!empty($this->bookingInitialFee)) $booking_details .= _INITIAL_FEE.': '.Currencies::PriceFormat($result[0]['initial_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'<br />';
			if($this->vatIncludedInPrice == 'no'){
				$booking_details .= _VAT.': '.Currencies::PriceFormat($result[0]['vat_fee'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).' ('.Currencies::PriceFormat($result[0]['vat_percent'], '%', 'right', $this->currencyFormat, $this->GetVatPercentDecimalPoints($result[0]['vat_percent'])).')<br />';
		    }
			$booking_details .= _PAYMENT_SUM.': '.Currencies::PriceFormat($result[0]['payment_sum'], $result[0]['symbol'], $result[0]['symbol_placement'], $this->currencyFormat).'<br />';
			if($result[0]['additional_info'] != '') $booking_details .= _ADDITIONAL_INFO.': '.nl2br($result[0]['additional_info']).'<br />';
			$booking_details .= '<br />';

			// display list of extras in order
			// -----------------------------------------------------------------------------
			$booking_details .= Extras::GetExtrasList(unserialize($result[0]['extras']), $result[0]['currency'], 'email');

			// display list of rooms in order
			// -----------------------------------------------------------------------------
			$booking_details .= '<b>'._RESERVATION_DETAILS.':</b>';
			$booking_details .= '<br />-----------------------------<br />';
			$sql = 'SELECT
						'.TABLE_BOOKINGS_ROOMS.'.booking_number,
						'.TABLE_BOOKINGS_ROOMS.'.rooms,
						'.TABLE_BOOKINGS_ROOMS.'.adults,
						'.TABLE_BOOKINGS_ROOMS.'.children,
						'.TABLE_BOOKINGS_ROOMS.'.guests,
						'.TABLE_BOOKINGS_ROOMS.'.checkin,
						'.TABLE_BOOKINGS_ROOMS.'.checkout,
						'.TABLE_BOOKINGS_ROOMS.'.price,
						'.TABLE_BOOKINGS_ROOMS.'.meal_plan_price,
						'.TABLE_BOOKINGS_ROOMS.'.guests_fee,
						'.TABLE_BOOKINGS.'.currency,
						'.TABLE_CURRENCIES.'.symbol,
						'.TABLE_ROOMS_DESCRIPTION.'.room_type,
						'.TABLE_HOTELS.'.email as hotel_email,
						'.TABLE_HOTELS_DESCRIPTION.'.name as hotel_name,
						'.TABLE_MEAL_PLANS_DESCRIPTION.'.name as meal_plan_name,
						'.TABLE_HOTELS_DESCRIPTION.'.name as hotel_name			
					FROM '.TABLE_BOOKINGS.'
						INNER JOIN '.TABLE_BOOKINGS_ROOMS.' ON '.TABLE_BOOKINGS.'.booking_number = '.TABLE_BOOKINGS_ROOMS.'.booking_number
						INNER JOIN '.TABLE_ROOMS.' ON '.TABLE_BOOKINGS_ROOMS.'.room_id = '.TABLE_ROOMS.'.id
						INNER JOIN '.TABLE_ROOMS_DESCRIPTION.' ON '.TABLE_ROOMS.'.id = '.TABLE_ROOMS_DESCRIPTION.'.room_id AND '.TABLE_ROOMS_DESCRIPTION.'.language_id = \''.$this->lang.'\'
						LEFT OUTER JOIN '.TABLE_CURRENCIES.' ON '.TABLE_BOOKINGS.'.currency = '.TABLE_CURRENCIES.'.code
						LEFT OUTER JOIN '.TABLE_CUSTOMERS.' ON '.TABLE_BOOKINGS.'.customer_id = '.TABLE_CUSTOMERS.'.id
						LEFT OUTER JOIN '.TABLE_HOTELS.' ON '.TABLE_BOOKINGS_ROOMS.'.hotel_id = '.TABLE_HOTELS.'.id 
						LEFT OUTER JOIN '.TABLE_HOTELS_DESCRIPTION.' ON '.TABLE_BOOKINGS_ROOMS.'.hotel_id = '.TABLE_HOTELS_DESCRIPTION.'.hotel_id AND '.TABLE_HOTELS_DESCRIPTION.'.language_id = \''.$this->lang.'\'
						LEFT OUTER JOIN '.TABLE_MEAL_PLANS_DESCRIPTION.' ON '.TABLE_BOOKINGS_ROOMS.'.meal_plan_id = '.TABLE_MEAL_PLANS_DESCRIPTION.'.meal_plan_id AND '.TABLE_MEAL_PLANS_DESCRIPTION.'.language_id = \''.$this->lang.'\'						
					WHERE
						'.TABLE_BOOKINGS.'.booking_number = \''.$result[0]['booking_number'].'\' ';
	
			$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
	        ///echo $sql.'----------'.mysql_error();
			$hotelowner_emails = array();
			if($result[1] > 0){
				$booking_details .= '<table style="border:1px" cellspacing="2">';
				$booking_details .= '<tr align="center">';
				$booking_details .= '<th>#</th>';
				$booking_details .= '<th align="left">'._ROOM_TYPE.'</th>';
				if($hotels_count > 1) $booking_details .= '<th align="left">'._HOTEL.'</th>';
				$booking_details .= '<th>'._CHECK_IN.'</th>';
				$booking_details .= '<th>'._CHECK_OUT.'</th>';
				$booking_details .= '<th>'._NIGHTS.'</th>';
				$booking_details .= '<th>'._ROOMS.'</th>';
				$booking_details .= '<th>'._ADULT.'</th>';
				$booking_details .= (($allow_children == 'yes') ? '<th>'._CHILD.'</th>' : '');
				$booking_details .= (($allow_guests == 'yes') ? '<th>'._GUEST.'</th>' : '');
				$booking_details .= (($meal_plans_count) ? '<th>'._MEAL_PLANS.'</th>' : '');
				$booking_details .= '<th align="right">'._PER_NIGHT.'</th>';
				$booking_details .= '<th align="right">'._PRICE.'</th>';
				$booking_details .= '</tr>';
				for($i=0; $i < $result[1]; $i++){
					$nights = nights_diff($result[0][$i]['checkin'], $result[0][$i]['checkout']);
					$booking_details .= '<tr align="center">';
					$booking_details .= '<td width="30px">'.($i+1).'.</td>';
					$booking_details .= '<td align="left">'.$result[0][$i]['room_type'].'</td>';
					if($hotels_count > 1) $booking_details .= '<td align="left">'.$result[0][$i]['hotel_name'].'</td>';
					if(!empty($result[0][$i]['hotel_email'])) $hotelowner_emails[] = $result[0][$i]['hotel_email'];
					$booking_details .= '<td>'.format_datetime($result[0][$i]['checkin'], $this->fieldDateFormat, '', true).'</td>';
					$booking_details .= '<td>'.format_datetime($result[0][$i]['checkout'], $this->fieldDateFormat, '', true).'</td>';
					$booking_details .= '<td>'.$nights.'</td>';
					$booking_details .= '<td>'.$result[0][$i]['rooms'].'</td>';
					$booking_details .= '<td>'.$result[0][$i]['adults'].'</td>';
					$booking_details .= (($allow_children == 'yes') ? '<td>'.$result[0][$i]['children'].'</td>' : '');
					$booking_details .= (($allow_guests == 'yes' && !empty($result[0][$i]['guests'])) ? '<td>'.$result[0][$i]['guests'].' - '.Currencies::PriceFormat($result[0][$i]['guests_fee'], $result[0][$i]['symbol'], '', $this->currencyFormat).'</td>' : '');
					$booking_details .= (($meal_plans_count) ? '<td>'.(!empty($result[0][$i]['meal_plan_name']) ? $result[0][$i]['meal_plan_name'].' - ' : '').Currencies::PriceFormat($result[0][$i]['meal_plan_price'], $result[0][$i]['symbol'], '', $this->currencyFormat).'</td>' : '');
					$booking_details .= '<td align="right">'.Currencies::PriceFormat(($result[0][$i]['price'] / $nights), $result[0][$i]['symbol'], '', $this->currencyFormat).'</td>';
					$booking_details .= '<td align="right">'.Currencies::PriceFormat(($result[0][$i]['price'] + $result[0][$i]['meal_plan_price'] + $result[0][$i]['guests_fee']), $result[0][$i]['symbol'], '', $this->currencyFormat).'</td>';
					$booking_details .= '</tr>';	
				}
				$booking_details .= '</table>';			
			}
			
			// add  info for bank transfer payments
			if($payment_type == 5){
				$booking_details .= '<br />';
				$booking_details .= '<b>'._BANK_PAYMENT_INFO.':</b>';
				$booking_details .= '<br />-----------------------------<br />';
				$booking_details .= ModulesSettings::Get('booking', 'bank_transfer_info');
			}
			
			$send_order_copy_to_admin =  ModulesSettings::Get('booking', 'send_order_copy_to_admin');
			////////////////////////////////////////////////////////////
			$sender = $objSettings->GetParameter('admin_email');
			///$recipient = $result[0]['email'];

			if($order_type == 'completed'){				
				// exit if email was already sent				
				if($email_sent == '1') return true;				
				$email_template = 'order_paid';
				$admin_copy_subject = 'Customer order has been paid (admin copy)';				
			}else if($order_type == 'canceled'){
				$email_template = 'order_canceled';
				$admin_copy_subject = 'Customer has calceled order (admin copy)';
			}else if($order_type == 'payment_error'){
				$email_template = 'payment_error';
				$admin_copy_subject = 'Order payment error (admin copy)';
			}else{
				$email_template = 'order_placed_online';
				$admin_copy_subject = 'Customer has placed online order (admin copy)';
			}

			////////////////////////////////////////////////////////////
			if(!$is_admin_reservation){

				$hotel_description = '';
				if(Hotels::HotelsCount() == 1){
					$hotel_info = Hotels::GetHotelFullInfo(0, $preferred_language);
					$hotel_description .= $hotel_info['name'].'<br>';
					$hotel_description .= $hotel_info['address'].'<br>';
					$hotel_description .= _PHONE.':'.$hotel_info['phone'];
					if($hotel_info['fax'] != '') $hotel_description .= ', '._FAX.':'.$hotel_info['fax'];
				}

				$arr_send_email = array('customer');
				if($send_order_copy_to_admin == 'yes'){
					$arr_send_email[] = 'admin_copy';
					$arr_send_email[] = 'hotelowner_copy';
				}
				
				$copy_subject = '';
				$default_lang = Languages::GetDefaultLang();
				foreach($arr_send_email as $key){
					if($key == 'admin_copy'){
						$preferred_language = $default_lang;
						$recipient = $sender;
						$copy_subject = $admin_copy_subject;
					}else if($key == 'hotelowner_copy'){
						$preferred_language = $default_lang;
						$recipient = implode(',', array_unique($hotelowner_emails));
						$copy_subject = $admin_copy_subject;
					}
					send_email(
						$recipient,
						$sender,
						$email_template,
						array(
							'{FIRST NAME}' => $first_name,
							'{LAST NAME}'  => $last_name,
							'{BOOKING NUMBER}'  => $booking_number,
							'{BOOKING DETAILS}' => $booking_details,
							'{STATUS DESCRIPTION}' => $status_description,
							'{PERSONAL INFORMATION}' => $personal_information,
							'{BILLING INFORMATION}' => $billing_information,
							'{BASE URL}' => APPHP_BASE,
							'{HOTEL INFO}' => ((!empty($hotel_description)) ? '<br>-----<br>'.$hotel_description : ''),
						),
						$preferred_language,
						'',
						$copy_subject						
					);
				}				
			}
			////////////////////////////////////////////////////////////
			
			if($order_type == 'completed' && !$email_sent){
				// exit if email was already sent
				$sql = 'UPDATE '.TABLE_BOOKINGS.' SET email_sent = 1 WHERE booking_number = \''.$booking_number.'\'';
				database_void_query($sql);					
			}			
			
			////////////////////////////////////////////////////////////
			return $return;
		}
		return false;
	}	

	/**
	 * Send cancel booking email
	 * 		@param $rid
	 */
	public function SendCancelOrderEmail($rid)
	{
		$sql = 'SELECT booking_number, customer_id, is_admin_reservation FROM '.TABLE_BOOKINGS.' WHERE id = '.(int)$rid;		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$booking_number = $result[0]['booking_number'];
			$customer_id = $result[0]['customer_id'];
			$is_admin_reservation = $result[0]['is_admin_reservation'];

			if($is_admin_reservation){
				$this->error = ''; // show empty error on email sending operation
				return false;
			}else if($this->SendOrderEmail($booking_number, 'canceled', $customer_id)){
				return true;
			}
		}
		$this->error = _EMAIL_SEND_ERROR;
		return false;
	}
	
	/**
	 * Returns VAT percent
	 */
	private function GetVatPercent()
	{
		if($this->vatIncludedInPrice == 'no'){
			$sql='SELECT
					cl.*,
					count.name as country_name,
					count.vat_value
				  FROM '.TABLE_CUSTOMERS.' cl
					LEFT OUTER JOIN '.TABLE_COUNTRIES.' count ON cl.b_country = count.abbrv AND count.is_active = 1
				  WHERE cl.id = '.(int)$this->currentCustomerID;
			$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY);
			if($result[1] > 0){
				$vat_percent = isset($result[0]['vat_value']) ? $result[0]['vat_value'] : '0';
			}else{
				$vat_percent = ModulesSettings::Get('booking', 'vat_value');
			}			
		}else{
			$vat_percent = '0';
		}		
		return $vat_percent;		
	}
	
	/**
	 * Generate booking number
	 * 		@param $booking_id
	 */
	private function GenerateBookingNumber($booking_id = '0')
	{
		$booking_number_type = ModulesSettings::Get('booking', 'booking_number_type');
		if($booking_number_type == 'sequential'){
			return str_pad($booking_id, 10, '0', STR_PAD_LEFT);
		}else{
			return strtoupper(get_random_string(10));		
		}		
	}
	
	/**
	 * Get Vat Percent decimal points
	 * 		@param $vat_percent
	 */
	private function GetVatPercentDecimalPoints($vat_percent = '0')
	{
		return (substr($vat_percent, -1) == '0') ? 2 : 3;
	}	
	
	/**
	 * Load discount info
	 */
	public function LoadDiscountInfo($from_date = '', $to_date = '')
	{
		$this->discountCoupon = '';
		$this->discountCampaignID = '';
		$this->discountPercent = '0';
		
		// prepare discount info		
		if(isset($this->arrReservationInfo['coupon_code']) && $this->arrReservationInfo['coupon_code'] != ''){
			$this->discountCampaignID = '';
			$this->discountCoupon = $this->arrReservationInfo['coupon_code'];			
			$this->discountPercent = $this->arrReservationInfo['discount_percent'];			
		}else{
			$campaign_info = Campaigns::GetCampaignInfo('', $from_date, $to_date, 'global');
			if($campaign_info['id'] != ''){
				$this->discountCoupon = '';
				$this->discountCampaignID = $campaign_info['id'];
				$this->discountPercent = $campaign_info['discount_percent'];

				$this->arrReservationInfo = array(
					'coupon_code'      => '',
					'discount_percent' => ''
				);
			}
			
		}
	}
	
	/**
	 * Applies discount coupon number
	 */
	public function ApplyDiscountCoupon($coupon_code = '')
	{
		$result = Coupons::GetCouponInfo($coupon_code);
		if(count($result) > 0){
			$this->discountCampaignID = '';
			$this->discountPercent = $result['discount_percent'];
			$this->discountCoupon = $coupon_code;
			$this->arrReservationInfo = array(
				'coupon_code'   => $coupon_code,
				'discount_percent'=> $result['discount_percent']
			);
			return true;
		}else{
			$this->discountCoupon = '';
			$this->arrReservationInfo = array(
				'coupon_code'   => '',
				'discount_percent'=> ''
			);
			
			$this->LoadDiscountInfo();
			
			return false;
		}
	}
	
	/**
	 * Removes discount coupon number
	 */
	public function RemoveDiscountCoupon($coupon_code = '')
	{
		if(empty($coupon_code)){
			return false;
		}else{			
			$this->discountCoupon = '';
			unset($_SESSION['reservation_info']);
			unset($this->arrReservationInfo);

			$this->LoadDiscountInfo();

			return true;		
		}		
	}

}