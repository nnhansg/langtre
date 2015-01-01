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

if($objLogin->IsLoggedInAs('owner','mainadmin') && Modules::IsModuleInstalled('news')){	

	$action = MicroGrid::GetParameter('action');
	$rid    = MicroGrid::GetParameter('rid');
	$mode   = 'view';
	$msg    = '';	

	$objNews = News::Instance();
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objNews->AddRecord()){
			if(ModulesSettings::Get('news', 'news_rss') == 'yes'){
				$rss_result = RSSFeed::UpdateFeeds();			
			}
			$msg .= draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			if(!empty($rss_result)) $msg .= draw_important_message($rss_result, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objNews->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objNews->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objNews->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objNews->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objNews->error, false);
		}
		$mode = 'view';
	}else if($action=='details'){		
		$mode = 'details';		
	}else if($action=='cancel_add'){		
		$mode = 'view';		
	}else if($action=='cancel_edit'){				
		$mode = 'view';
	}
	
	// Start main content
	draw_title_bar(prepare_breadcrumbs(array(_MODULES=>'',_NEWS=>'',_NEWS_MANAGEMENT=>'',ucfirst($action)=>'')));

	//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	echo $msg;

	draw_content_start();
	if($mode == 'view'){		
		$objNews->DrawViewMode();	
	}else if($mode == 'add'){		
		$objNews->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objNews->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objNews->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>