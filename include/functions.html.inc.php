<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// HTML FUNCTIONS
// Updated: 09.11.2011

/**
 *	Draws messages 
 *  	@param $message - message text
 *      @param $is_draw
 */
function draw_message($message, $is_draw=true, $bullet = false, $br = false, $style = '')
{
	if(!empty($style)) $style = ' style="'.$style.'"';
	if(!empty($message)) $message = '<table width="100%" align="center" class="message_box"'.$style.' border="0" cellspacing="1" cellpadding="1"><tr>'.(($bullet) ? '<td class="message_sign"><img src="images/attention_sign.gif" alt="" border="0" /></td>' : '').'<td class="message_text'.((!$bullet) ? '_single' : '').'">'.$message.'</td></tr></table>'.(($br == true) ? '<br>' : '');
	if(!$is_draw) return $message;
	else echo $message;	
}

/**
 *	Draws important messages 
 *  	@param $message - message text
 *      @param $is_draw
 */
function draw_important_message($message, $is_draw=true, $bullet = true, $br = false, $style = '')
{
	if(!empty($style)) $style = ' style="'.$style.'"';
	if(!empty($message)) $message = '<table width="100%" align="center" class="important_message_box"'.$style.' border="0" cellspacing="1" cellpadding="1"><tr>'.(($bullet) ? '<td class="message_sign"><img src="images/error_sign.gif" alt="" border="0" /></td>' : '').'<td class="message_text'.((!$bullet) ? '_single' : '').'">'.$message.'</td></tr></table>'.(($br == true) ? '<br />' : '');
	if(!$is_draw) return $message;
	else echo $message;	
}

/**
 *	Draws success messages 
 *  	@param $message - message text
 *      @param $is_draw
 */
function draw_success_message($message, $is_draw=true, $bullet = false, $br = false)
{
	if(!empty($message)) $message = '<table width="100%" align="center" class="success_message_box" border="0" cellspacing="1" cellpadding="1"><tr><td class="message_sign"><img src="images/success_sign.gif" alt="" /></td><td class="message_text">'.$message.'</td></tr></table>'.(($br == true) ? '<br />' : '');
	if(!$is_draw) return $message;
	else echo $message;	
}

/**
 *	Draws reservation bar
 *  	@param $current_tab
 */
function draw_reservation_bar($current_tab = '', $is_draw = true, $links_allowed = true)
{	
	global $objLogin;
	
	$selected_rooms_link = false;
	$booking_details_link = false;
	$reservation_link = false;
	$payment_link = false;
	if($links_allowed){
		if($current_tab == 'booking_details'){
			$selected_rooms_link = true;
		}else if($current_tab == 'reservation'){
			$booking_details_link = true;			
			$selected_rooms_link = true;
		}else if($current_tab == 'payment'){
			$booking_details_link = false;			
			$selected_rooms_link = false;
			$reservation_link = true;
		}		
	}
	
	$output = '<table class="reservation_tabs" align="center" border="0">';
	$output .= '<tr>';
	$output .= ' <td class="'.(($current_tab == 'selected_rooms') ? 'reservation_tab_active' : (($selected_rooms_link) ? 'reservation_tab_selected' : 'reservation_tab')).' hide">'.(($selected_rooms_link) ? '<a href="index.php?page=booking">'._SELECTED_ROOMS.'</a>' : _SELECTED_ROOMS).'</td>';
	$output .= ' <td class="'.(($current_tab == 'booking_details') ? 'reservation_tab_active' : (($selected_rooms_link) ? 'reservation_tab_selected' : 'reservation_tab')).' hide">'.(($booking_details_link) ? '<a href="index.php?page=booking_details'.($objLogin->IsLoggedInAsAdmin() ? '' : '&m=edit').'">'._BOOKING_DETAILS.'</a>' : _BOOKING_DETAILS).'</td>';
	$output .= ' <td class="'.(($current_tab == 'reservation') ? 'reservation_tab_active' : 'reservation_tab').'">'._RESERVATION.'</td>';
	$output .= ' <td class="'.(($current_tab == 'payment') ? 'reservation_tab_active' : 'reservation_tab').'">'._PAYMENT.'</td>';
	$output .= '</tr>';
	$output .= '</table>';
	if(!$is_draw) return $output;
	else echo $output;		
}

/**
 *	Draws title bar
 *  	@param $title_1
 *  	@param $title_2
 *      @param $draw
 */
function draw_title_bar($title_1, $title_2 = '', $draw = true)
{
	global $objLogin;
	
	$tag = ($objLogin->IsLoggedInAsAdmin() || Application::Get('preview') == 'yes') ? 'h2' : 'h1';
	
	$output = '';
	if(!empty($title_1) && empty($title_2)){
		$output = '<'.$tag.' class="center_box_heading'.((Application::Get('lang_dir') == 'ltr') ? ' align_left' : ' align_right').'">'.$title_1.'</'.$tag.'>';
	}else if(!empty($title_1) && !empty($title_2)){
		$output = '<'.$tag.' class="center_box_heading'.((Application::Get('lang_dir') == 'ltr') ? ' align_left' : ' align_right').'">';
		$output .= '<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
			<td align="'.Application::Get('defined_left').'">'.$title_1.'</td>
			<td align="'.Application::Get('defined_right').'">'.$title_2.'</td>
			</tr>
			</table>';
		$output .= '</'.$tag.'>';
	}
	if($draw) echo $output;
	else return $output;
}

/**
 *	Draws sub title bar
 *  	@param $title
 *  	@param $draw
 *      @param $tag
 */
function draw_sub_title_bar($title, $draw = true, $tag = 'h3')
{
	$output = '';	
	if (!empty($title)){
		$output = '<'.$tag.' class="center_box_sub_heading"><span>'.$title.'</span></'.$tag.'>';
	}
	if($draw) echo $output;
	else return $output;
}

/**
 *	Draws content wrapper - start
 */
function draw_content_start()
{
	echo '<div class="center_box_content">';
}

/**
 *	Draws content wrapper - end
 */
function draw_content_end()
{
	echo '</div>';
}

/**
 *	Draws line
 *  	@param $class
 *  	@param $image_directory
 */
function draw_line($class = 'no_margin_line', $image_directory = IMAGE_DIRECTORY, $draw = true)
{
	$result = '<div class="'.$class.'"><img src="'.$image_directory.'line_spacer.gif" width="100%" height="1px" alt="" /></div>';
	if($draw) echo $result;
	else return $result;
}

/**
 *  Draws dropdown box with numbers
 *  Output 'select' tag with its field name, values and default value(for numeric fields)
 *  	@param $field_name
 *  	@param $field_value
 *  	@param $start
 *      @param $end
 *  	@param $step
 *  	@param $class
 *  	@param $js_func
 *  	@param $draw
 */
function draw_numbers_select_field($field_name, $field_value, $start, $end, $step = 1, $class = '', $js_func = '', $draw = true)
{
	$output = '<select name="'.$field_name.'" class="'.$class.'" '.$js_func.'>';
	$options = '';
	for ($i = $start; $i <= $end; $i = $i + $step) {
		$options .= '<option value="'.$i.'" ';
		$options .= ($i == $field_value) ? 'selected="selected" ' : '';
		$options .= '>'.$i.'</option>';
	}
	if($options == '') $options .= _NOT_AVAILABLE;
	$output .= $options.'</select>';
	if($draw) echo $output;
	else return $output;
}

/**
 *  Draws dropdown box with date selection
 *  	@param $field_name
 *  	@param $field_value
 *  	@param $min_year
 *  	@param $max_year
 *  	@param $draw
 */
function draw_date_select_field($field_name, $field_value = '', $min_year = '90', $max_year = '10', $draw = true)
{
	global $objSettings;	
	
	$output = '';
	$lang   = array();

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

	$datetime_format = 'Y-m-d';
	
	if(strlen($field_value) < 10) $field_value = '';		
	$year = substr($field_value, 0, 4);
	$month = substr($field_value, 5, 2);
	$day = substr($field_value, 8, 2);

	$arr_ret_date = array();
	$arr_ret_date['y'] = '<select name="'.$field_name.'__nc_year" id="'.$field_name.'__nc_year"><option value="">'._YEAR.'</option>'; for($i=@date('Y')-$min_year; $i<=@date('Y')+$max_year; $i++) { $arr_ret_date['y'] .= '<option value="'.$i.'"'.(($year == $i) ? ' selected="selected"' : '').'>'.$i.'</option>'; }; $arr_ret_date['y'] .= '</select>';                            
	$arr_ret_date['m'] = '<select name="'.$field_name.'__nc_month" id="'.$field_name.'__nc_month"><option value="">'._MONTH.'</option>'; for($i=1; $i<=12; $i++) { $arr_ret_date['m'] .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($month == $i) ? ' selected="selected"' : '').'>'.$lang['months'][$i].'</option>'; }; $arr_ret_date['m'] .= '</select>';
	$arr_ret_date['d'] = '<select name="'.$field_name.'__nc_day" id="'.$field_name.'__nc_day"><option value="">'._DAY.'</option>'; for($i=1; $i<=31; $i++) { $arr_ret_date['d'] .= '<option value="'.(($i < 10) ? '0'.$i : $i).'"'.(($day == $i) ? ' selected="selected"' : '').'>'.(($i < 10) ? '0'.$i : $i).'</option>'; }; $arr_ret_date['d'] .= '</select>';

	if($objSettings->GetParameter('date_format') == 'dd/mm/yyyy'){
		$output .= $arr_ret_date[strtolower(substr($datetime_format, 4, 1))];
		$output .= $arr_ret_date[strtolower(substr($datetime_format, 2, 1))];
	}else{
		$output .= $arr_ret_date[strtolower(substr($datetime_format, 2, 1))];
		$output .= $arr_ret_date[strtolower(substr($datetime_format, 4, 1))];
	}
	$output .= $arr_ret_date[strtolower(substr($datetime_format, 0, 1))];
	
	if($draw) echo $output;
	else return $output;
}

/**
 *  Draws select box 
 *  Output 'select' tag 
 *  	@param $field_name
 *  	@param $select_array
 *  	@param $option_value
 *  	@param $option_name
 *  	@param $selected_item
 *  	@param $class
 *  	@param $on_event
 *  	@param $draw
 */
function draw_languages_box($field_name, $select_array, $option_value, $option_name, $selected_item = '', $class = '', $on_event = '', $draw = true)
{
	$output = '<select name="'.$field_name.'" '.(($class != '') ? ' class="'.$class.'"' : '').' '.$on_event.'>';
	foreach($select_array as $key => $val){
		$output .= '<option value="'.$val[$option_value].'"';
		$output .= ($selected_item == $val[$option_value]) ? ' selected="selected" ' : '';
		$output .= '>' . $val[$option_name] . '</option>';
	}
	$output .= '</select>';
	
	if($draw) echo $output;
	else return $output;	
}

/**
 *  Draw hidden fields
 *  	@param $field_name
 *  	@param $field_value
 *  	@param $draw
 *  	@param $field_id
 */
function draw_hidden_field($field_name, $field_value = '', $draw = true, $field_id = '')
{
	$output = '<input type="hidden" name="'.$field_name.'"'.(!empty($field_id) ? ' id="'.$field_id.'"' : '').' value="'.$field_value.'" />';
	if($draw) echo $output;
	else return $output;
}

/**
 *  Draw token hidden field (protection agains csrf attaks)
 *  		@param $draw
 */
function draw_token_field($draw = true)
{
	$output = '<input type="hidden" name="token" value="'.Application::Get('token').'" />';
	if($draw) echo $output;
	else return $output;
}

/**
 *  Draw top block
 *      @param $block_name
 *      @param $ind
 *      @param $status
 *  	@param $draw
 */
function draw_block_top($block_name = '', $ind = '', $status = 'maximized', $draw = true)
{
	global $objLogin;
	$block_top_image = '';
	$block_middle_image = '';
	$display = '';
	$output = '';
	$nl = "\n";

	if($objLogin->IsLoggedInAsAdmin()){
		$output .= '<div class="left_box_container" id="categories">'.$nl;
		if($ind != ''){
			$output .= '<h3 class="side_box_heading" id="categoriesHeading" onclick="toggle_menu_block('.$ind.')">'.$block_name.'</h3>'.$nl;
		}else{
			$output .= '<h3 class="side_box_heading" id="categoriesHeading">'.$block_name.'</h3>'.$nl;
		}
		if(Application::Get('preview') != 'yes'){
			$display = (isset($_COOKIE['side_box_content_'.$ind]) && ($_COOKIE['side_box_content_'.$ind] == 'maximized')) ? '' : 'none';
			if($display == '' && $status == 'maximized') $display = '';
		}
		$output .= '<div id="side_box_content_'.$ind.'" class="side_box_content'.((Application::Get('lang_dir') == 'ltr') ? ' left' :  ' right').'" style="display:'.$display.';">'.$nl;
	}else{
		$output .= '<div class="left_box_container">'.$nl;
		$output .= '<h3 class="side_box_heading">'.$block_name.'</h3>'.$nl;
		$output .= '<div class="side_box_content'.((Application::Get('lang_dir') == 'ltr') ? ' left' :  ' right').'">'.$nl;
	}

	if($draw) echo $output;
	else return $output;
}

/**
 *  Draw top enpty block 
 */
function draw_block_top_empty()
{
	global $objLogin;
	if(!$objLogin->IsLoggedInAsAdmin()){
		$width = 'width:203px;';
	}else{
		$width = 'width:195px;';
	}
	echo '<div class="left_box_container" id="categories" style="'.$width.' padding-left:0px; padding-top:5px; padding-bottom:5px;">'."\n";
	echo '<div class="side_box_content">'."\n";				
}

/**
 *  Draw bottom block
 *  	@param $draw
 */
function draw_block_bottom($draw = true)
{
	$nl = "\n";
	$output = '</div>'.$nl;
	$output .= '<div class="shadow"></div>'.$nl;
	$output .= '</div>'.$nl;

	if($draw) echo $output;
	else return $output;
}

/**
 *  Draw block footer
 *  	@param $draw
 */
function draw_block_footer($draw = true)
{
	$output = '<div>&nbsp;</div>';

	if($draw) echo $output;
	else return $output;
}

/**
 *  Draw divider image
 *  	@param $draw
 */
function draw_divider($draw = true)
{
	$output = '<img src="images/divider.gif" width="1px" height="10px" alt="" style="margin:auto;" />';
	if($draw) echo $output;
	else return $output;
}

function draw_months_select_box($field_name, $field_value, $class = '', $month_names = false, $draw = true)
{
	$output = '<select name="'.$field_name.'" '.(($class != '') ? ' class="'.$class.'"' : '').'>';
	$options = '';
	for($i = 1; $i <= 12; $i++){
		$options .= '<option value="'.convert_to_decimal($i).'"';		
		$options .= ($i == $field_value) ? ' selected="selected"' : '';
		$options .= '>'.(($month_names) ? get_month_local($i) : convert_to_decimal($i)).'</option>';
	}
	$output .= $options.'</select>';
	if($draw) echo $output;	
	else return $output;
}

function draw_years_select_box($field_name, $field_value, $class='', $draw=true)
{
	$output = '<select name="'.$field_name.'" '.(($class != '') ? ' class="'.$class.'"' : '').'>';
	$options = '';
	for($i = date('Y'); $i <= date('Y') + 10; $i++){
		$options .= '<option value="'.$i.'"';		
		$options .= ($i == $field_value) ? ' selected="selected"' : '';
		$options .= '>'.$i.'</option>';
	}
	$output .= $options.'</select>';
	if($draw) echo $output;	
	else return $output;
}


?>