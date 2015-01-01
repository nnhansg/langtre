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

	$action = MicroGrid::GetParameter('action');
	$rid    = MicroGrid::GetParameter('rid');
	$mode   = 'view';
	$msg    = '';	

	$objLanguages = new Languages();
	
	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objLanguages->AddRecord()){		
			$msg = draw_success_message(_LANGUAGE_ADDED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objLanguages->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objLanguages->UpdateRecord($rid)){
			$msg = draw_success_message(_LANGUAGE_EDITED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objLanguages->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objLanguages->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objLanguages->error, false);
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
	draw_title_bar(prepare_breadcrumbs(array(_LANGUAGES_SETTINGS=>'',_LANGUAGES=>'',ucfirst($action)=>'')));

	echo $msg;

	draw_content_start();
	if($mode == 'view'){		
		$objLanguages->DrawViewMode();	
	}else if($mode == 'add'){		
		$objLanguages->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objLanguages->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objLanguages->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>