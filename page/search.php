<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// *** Make sure the file isn't accessed directly
defined('APPHP_EXEC') or die('Restricted Access');
//--------------------------------------------------------------------------

$task    = isset($_POST['task']) ? prepare_input($_POST['task']) : '';
$keyword = isset($_POST['keyword']) ? strip_tags(prepare_input($_POST['keyword'])) : '';
		   if($keyword == _SEARCH_KEYWORDS.'...') $keyword = '';
$p       = isset($_POST['p']) ? (int)$_POST['p'] : '';

$objSearch = new Search();
$search_result = '';

$title_bar = '<table width="100%" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td align="'.Application::Get('defined_left').'"><b>'._SEARCH_RESULT_FOR.': '.$keyword.'</b></td>
		<td align="'.Application::Get('defined_right').'">
			'._LOOK_IN.':
			<select class="look_in" name="search_in" onchange="javascript:document.getElementById(\'search_in\').value=this.value;appQuickSearch();">
				<option value="rooms" '.((Application::Get('search_in') == 'rooms') ? 'selected="selected"' : '').'>'._ROOMS.'</option>
				<option value="pages" '.((Application::Get('search_in') == 'pages') ? 'selected="selected"' : '').'>'._PAGES.'</option>
				<option value="news" '.((Application::Get('search_in') == 'news') ? 'selected="selected"' : '').'>'._NEWS.'</option>
			</select>
		</td>
	</tr>
	</table>';

// Check if there is a page 
if($keyword != ''){		
	draw_title_bar($title_bar); 
	
	if($task == 'quick_search'){
		$search_result = $objSearch->SearchBy($keyword, $p, Application::Get('search_in'));	
	}	
	$objSearch->DrawPopularSearches();
	$objSearch->DrawSearchResult($search_result, $p, $keyword);
}else{
	draw_title_bar(_SEARCH_RESULT_FOR.': '.$keyword.'');	
	draw_important_message(_NO_RECORDS_FOUND);		
}
	
?>