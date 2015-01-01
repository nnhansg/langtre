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

if($objLogin->IsLoggedInAsAdmin()){
	
	$task = isset($_GET['task']) ? prepare_input($_GET['task']) : '';
	$alert_state = Session::Get('alert_state');

	if($task == 'close_alert'){
		$alert_state = 'hidden';
	    Session::Set('alert_state', 'hidden');
	}else if($task == 'open_alert'){
		$alert_state = '';
		Session::Set('alert_state', '');
	}

    draw_title_bar(prepare_breadcrumbs(array(_GENERAL=>'',_HOME=>'')));

    // draw important messages 
	// ---------------------------------------------------------------------
    $actions_msg = array();
    if($objLogin->IsLoggedInAs('owner', 'mainadmin') && (file_exists('install.php') || file_exists('install/'))){
    	$actions_msg[] = '<span class="darkred">'._INSTALL_PHP_EXISTS.'</span>';
    }

	if(SITE_MODE == 'development') $actions_msg[] = '<span class="darkred">'._SITE_DEVELOPMENT_MODE_ALERT.'</span>';

	// test mode alert
	if(Modules::IsModuleInstalled('booking')){
		if(ModulesSettings::Get('booking', 'mode') == 'TEST MODE'){
			$actions_msg[] = '<span class="darkred">'._TEST_MODE_ALERT.'</span>';
		}        
	}

	if($objLogin->IsLoggedInAs('owner', 'mainadmin')){
		$arr_folders = array('images/uploads/', 'images/flags/', 'images/rooms_icons/', 'images/banners/', 'images/gallery/', 'tmp/backup/', 'tmp/cache/', 'tmp/logs/', 'feeds/');
		$arr_folders_not_writable = '';
		foreach($arr_folders as $folder){
			if(!is_writable($folder)){
				if($arr_folders_not_writable != '') $arr_folders_not_writable .= ', ';
				$arr_folders_not_writable .= $folder;
			}
		}
		if($arr_folders_not_writable != ''){
			$actions_msg[] = _NO_WRITE_ACCESS_ALERT.' <b>'.$arr_folders_not_writable.'</b>';
		}
	}	
    
	$admin_email = $objSettings->GetParameter('admin_email');    
    if($objLogin->IsLoggedInAs('owner', 'mainadmin') && ($admin_email == '' || preg_match('/yourdomain/i', $admin_email))){
        $actions_msg[] = _DEFAULT_EMAIL_ALERT;
    }
	
	$own_email = $objLogin->GetLoggedEmail();    
	if($own_email == '' || preg_match('/yourdomain/i', $own_email)){
		$actions_msg[] = _DEFAULT_OWN_EMAIL_ALERT;
	}
    
	if($objLogin->IsLoggedInAs('owner', 'mainadmin') && Modules::IsModuleInstalled('contact_us')){
        $admin_email_to = ModulesSettings::Get('contact_us', 'email');
        if($admin_email_to == '' || preg_match('/yourdomain/i', $admin_email_to)){
            $actions_msg[] = _CONTACTUS_DEFAULT_EMAIL_ALERT;
        }
    }    
	if(Modules::IsModuleInstalled('comments')){
		$comments_allow	= ModulesSettings::Get('comments', 'comments_allow');
		$comments_count = Comments::AwaitingModerationCount();
		if($comments_allow == 'yes' && $comments_count > 0){
			$actions_msg[] = str_replace('_COUNT_', $comments_count, _COMMENTS_AWAITING_MODERATION_ALERT);			
		}
	}
	
	if(ModulesSettings::Get('customers', 'reg_confirmation') == 'by admin'){
		$customers_count = Customers::AwaitingAprovalCount();
		if($customers_count > 0){
			$actions_msg[] = str_replace('_COUNT_', $customers_count, _CUSTOMERS_AWAITING_MODERATION_ALERT);			
		}
	}	
	
    if(count($actions_msg) > 0){
		if($alert_state == ''){
			$msg = '<div id="divAlertRequired" style="padding:5px 0px 5px 0px;">
				<img src="images/close.png" alt="" style="cursor:pointer;float:'.Application::Get('defined_right').';margin-right:-3px;" title="'._HIDE.'" onclick="javascript:appGoTo(\'admin=home\',\'&task=close_alert\')" />
				<img src="images/action_required.png" alt="" style="margin-bottom:-3px;" />&nbsp;&nbsp;<b>'._ACTION_REQUIRED.'</b>:				
				<ul style="margin-top:7px;margin-bottom:7px;">';
				foreach($actions_msg as $single_msg){
					$msg .= '<li>'.$single_msg.'</li>';
				}
			$msg .= '</ul></div>';
			draw_important_message($msg, true, false);        			
		}else{
			echo '<div id="divAlertRequired" style="padding:5px 17px;float:'.Application::Get('defined_right').';"><a href="javascript:void(0);" onclick="javascript:appGoTo(\'admin=home\',\'&task=open_alert\')">'._OPEN_ALERT_WINDOW.'</a></div>';
		}
    }


	$msg = '<div style="padding:9px;">
	<div class="site_version">'._VERSION.': '.CURRENT_VERSION.'</div>
	<p>'._TODAY.': <b>'.format_datetime(date('Y-m-d H:i:s'), '', '', true).'</b></p>
	<p>'._LAST_LOGIN.': <b>'.format_datetime($objLogin->GetLastLoginTime(), '', _NEVER, true).'</b></p>	
	'.($objLogin->IsLoggedInAs('hotelowner') ? '<br>'._HOTELOWNER_WELCOME_TEXT : _ADMIN_WELCOME_TEXT).'
	</div>';
	
	draw_message($msg, true, false);

    //$objSiteDescription
	echo '<div style="text-align:right;padding:80px 18px 0px 0px;vertical-align:bottom;">'.$objSiteDescription->DrawFooter(false).'</div>';
	
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>