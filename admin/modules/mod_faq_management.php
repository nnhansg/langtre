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

if($objLogin->IsLoggedInAs('owner','mainadmin') && Modules::IsModuleInstalled('faq')){	

	$action = MicroGrid::GetParameter('action');
	$rid    = MicroGrid::GetParameter('rid');
	$mode   = 'view';
	$msg    = '';
	
	$objFaqCategories = new FaqCategories();
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objFaqCategories->AddRecord()){
			$msg .= draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objFaqCategories->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objFaqCategories->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objFaqCategories->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objFaqCategories->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objFaqCategories->error, false);
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
	draw_title_bar(prepare_breadcrumbs(array(_MODULES=>'',_FAQ=>'',_FAQ_MANAGEMENT=>'',ucfirst($action)=>'')));

	echo $msg;

	draw_content_start();
	if($mode == 'view'){		
		$objFaqCategories->DrawViewMode();	
	}else if($mode == 'add'){		
		$objFaqCategories->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objFaqCategories->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objFaqCategories->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>