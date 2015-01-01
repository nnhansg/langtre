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

$objNews = News::Instance();
$news = $objNews->GetNews(Application::Get('news_id'));

// Draw title bar
if($objSession->IsMessage('notice')){
	draw_title_bar(_NEWS);
	echo $objSession->GetMessage('notice');
}else if($news[1] == 1){		
	$news_type = isset($news[0]['type']) ? $news[0]['type'] : 'news';
	$header_text = isset($news[0]['header_text']) ? str_replace("\'", "'", $news[0]['header_text']) : '';
	$body_text = isset($news[0]['body_text']) ? str_replace("\'", "'", $news[0]['body_text']) : '';
	$date_created = isset($news[0]['mod_date_created']) ? $news[0]['mod_date_created'] : '';

	if($news_type == 'events'){
		draw_title_bar(prepare_breadcrumbs(array(_EVENTS=>'',$header_text=>'')));
	}else{
		draw_title_bar(prepare_breadcrumbs(array(_NEWS=>'',$header_text=>'')));
	}
	
	echo '<div class="center_box_heading_news">'.$header_text.'</div>';
	echo '<div class="center_box_contents_news">'.$body_text.'</div>';
	echo '<div class="center_box_bottom_news"><i><b>'._POSTED_ON.':</b>&nbsp;'.$date_created.'</i></div>';

	if($news_type == 'events'){
		$objNews->DrawRegistrationForm(Application::Get('news_id'), $header_text);
	}
}else{
	draw_title_bar(_NEWS); echo '<br>';
	draw_important_message(_WRONG_PARAMETER_PASSED);
}        

?>