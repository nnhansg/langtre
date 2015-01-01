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

$email = isset($_REQUEST['email']) ? prepare_input($_REQUEST['email']) : '';
$task = isset($_REQUEST['task']) ? prepare_input($_REQUEST['task']) : '';
$focus_field = '';

draw_title_bar(_SUBSCRIBE_TO_NEWSLETTER); 	

if(Modules::IsModuleInstalled('news')){
	$objNews = News::Instance();
	
	if($task == 'subscribe'){		
		if($objNews->ProcessSubscription($email)){
			draw_success_message(_NEWSLETTER_SUBSCRIBE_SUCCESS);
		}else{
			draw_important_message($objNews->error);
			$focus_field = 'subscribe_email';
		}
	}else if($task == 'unsubscribe'){
		if($objNews->ProcessUnsubscription($email)){
			draw_success_message(_NEWSLETTER_UNSUBSCRIBE_SUCCESS);
		}else{
			draw_important_message($objNews->error);
			$focus_field = 'unsubscribe_email';
		}		
	}else if($task == 'pre_subscribe'){
		draw_message(_NEWSLETTER_PRE_SUBSCRIBE_ALERT);
		$focus_field = 'subscribe_email';
	}else if($task == 'pre_unsubscribe'){
		draw_message(_NEWSLETTER_PRE_UNSUBSCRIBE_ALERT);
		$focus_field = 'unsubscribe_email';
	}
	
	echo '<div class="pages_contents">';
	$objNews->DrawSubscribeBlockMain($focus_field, $email);	
	echo '</div>';
}else{		
	draw_important_message(_PAGE_UNKNOWN);		
}
	
?>