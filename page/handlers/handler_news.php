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

$new_news_id = News::GetNewsId(Application::Get('news_id'), Application::Get('lang'));
if($new_news_id != '' && Application::Get('news_id') != $new_news_id){
    
    $url = get_page_url(false);

    if($objSettings->GetParameter('seo_urls') == '1'){
        $url = str_replace('/'.Application::Get('news_id').'/', '/'.$new_news_id.'/', $url);						
    }else{
        $url = str_replace('nid='.Application::Get('news_id'), 'nid='.$new_news_id, $url);
    }

    header('location: '.$url);
    exit;
}else if(empty($new_news_id)){
    $objSession->SetMessage('notice', draw_important_message(_PAGE_UNKNOWN, false));    
}

?>