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

if($objLogin->IsLoggedInAs('owner','mainadmin')){
	
	// Start main content
	draw_title_bar(prepare_breadcrumbs(array(_MODULES=>'',_MODULES_MANAGEMENT=>'',ucfirst($action)=>'')));
	
	//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	if($objModules->modulesCount <= 0){
		$msg = draw_important_message(_MODULES_NOT_FOUND, false);
	}
	echo $msg;

	draw_content_start();	
	if($mode == 'view'){		
		$objModules->DrawModules();
	}else if($mode == 'add'){		
		$objModules->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objModules->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objModules->DrawDetailsMode($rid);		
	}
	draw_content_end();
	
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>