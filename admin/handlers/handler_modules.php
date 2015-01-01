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

	$action 	= MicroGrid::GetParameter('action');
	$operation 	= MicroGrid::GetParameter('opearation');
	$operation_field = MicroGrid::GetParameter('operation_field');
	$rid    	= MicroGrid::GetParameter('rid');
	$mode   	= 'view';
	$msg 		= '';
	
	$objModules = new Modules();

	if($action=='add'){		
		$mode = 'view';
	}else if($action=='create'){
		$mode = 'view';
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objModules->UpdateRecord($rid)){
			$mst_text = ($objModules->error != '') ? $objModules->error : _UPDATING_OPERATION_COMPLETED;
			$msg = draw_success_message($mst_text, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objModules->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		$mode = 'view';
	}else if($action=='details'){		
		$mode = 'view';
	}else if($action=='cancel_add'){		
		$mode = 'view';		
	}else if($action=='cancel_edit'){				
		$mode = 'view';
	}

}

?>