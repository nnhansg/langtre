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

if($objLogin->IsLoggedInAsCustomer()){

    draw_title_bar(prepare_breadcrumbs(array(_GENERAL=>'',_CUSTOMER_PANEL=>'')));

	draw_content_start();

		Campaigns::DrawCampaignBanner('standard');
		Campaigns::DrawCampaignBanner('global');

		$msg = '<div style="padding:9px;min-height:250px">';
        $welcome_text = _WELCOME_CUSTOMER_TEXT;
        $welcome_text = str_replace('_FIRST_NAME_', $objLogin->GetLoggedFirstName(), $welcome_text);
		$welcome_text = str_replace('_LAST_NAME_', $objLogin->GetLoggedLastName(), $welcome_text);
        $welcome_text = str_replace('_TODAY_', _TODAY.': <b>'.format_datetime(@date('Y-m-d H:i:s'), '', '', true).'</b>', $welcome_text);
		$welcome_text = str_replace('_LAST_LOGIN_', _LAST_LOGIN.': <b>'.format_datetime($objLogin->GetLastLoginTime(), '', _NEVER, true).'</b>', $welcome_text);
        $msg .= $welcome_text;
        $msg .= '</div>';
		
		draw_message($msg, true, false);
	
	draw_content_end();		

} else{
	draw_title_bar(prepare_breadcrumbs(array(_CUSTOMERS=>'')));
	draw_important_message(_NOT_AUTHORIZED);
	
} 
?>