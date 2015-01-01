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

if($objLogin->IsLoggedInAs('owner','mainadmin') && Modules::IsModuleInstalled('comments')){	
	
    $pid    = isset($_REQUEST['pid']) ? (int)$_REQUEST['pid'] : '';
	$action = MicroGrid::GetParameter('action');
	$rid    = MicroGrid::GetParameter('rid');
	$mode   = 'view';
	$msg    = '';
	
	$objComments = new Comments($pid);
	$page_name = $objComments->GetPageName($pid); 
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objComments->AddRecord()){
			$msg = draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objComments->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objComments->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objComments->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objComments->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objComments->error, false);
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
	draw_title_bar(prepare_breadcrumbs(array(_MODULES=>'',_COMMENTS=>'',_COMMENTS_MANAGEMENT=>'',(!empty($page_name)?$page_name:'')=>'',(($action)?ucfirst($action):'')=>'')));
	echo $msg;

	draw_content_start();
	if($mode == 'view'){		
		$objComments->DrawViewMode();	
	}else if($mode == 'add'){		
		$objComments->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objComments->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objComments->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>