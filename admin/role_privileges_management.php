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

if($objLogin->IsLoggedInAs('owner')){
	
	$action 	= MicroGrid::GetParameter('action');
	$operation 	= MicroGrid::GetParameter('opearation');
	$operation_field = MicroGrid::GetParameter('operation_field');
	$rid    	= MicroGrid::GetParameter('rid');
	$role_id  	= MicroGrid::GetParameter('role_id', false);
	$mode   	= 'view';
	$msg 		= '';
	
	$objRolePrivileges = new RolePrivileges($role_id);

	if($action=='add'){		
		$mode = 'add';
	}else if($action=='create'){
		if($objRolePrivileges->AddRecord()){
			$msg = draw_success_message(_ADDING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objRolePrivileges->error, false);
			$mode = 'add';
		}
	}else if($action=='edit'){
		$mode = 'edit';
	}else if($action=='update'){
		if($objRolePrivileges->UpdateRecord($rid)){
			$msg = draw_success_message(_UPDATING_OPERATION_COMPLETED, false);
			$mode = 'view';
		}else{
			$msg = draw_important_message($objRolePrivileges->error, false);
			$mode = 'edit';
		}		
	}else if($action=='delete'){
		if($objRolePrivileges->DeleteRecord($rid)){
			$msg = draw_success_message(_DELETING_OPERATION_COMPLETED, false);
		}else{
			$msg = draw_important_message($objRolePrivileges->error, false);
		}
		$mode = 'view';
	}else if($action=='details'){		
		$mode = 'details';		
	}else if($action=='cancel_add'){		
		$mode = 'view';		
	}else if($action=='cancel_edit'){				
		$mode = 'view';
	}
	
	$objRoles = new Roles();
	$role_info = $objRoles->GetInfoByID($role_id);
	$role_info_name = isset($role_info['name']) ? $role_info['name'] : '';

	// Start main content
	draw_title_bar(
		prepare_breadcrumbs(array(_ACCOUNTS=>'',$role_info_name=>'',_PRIVILEGES_MANAGEMENT=>'',ucfirst($action)=>'')),
		prepare_permanent_link('index.php?admin=roles_management', _BUTTON_BACK)
	);

	//if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	echo $msg;

	draw_content_start();	
	if($mode == 'view'){		
		$objRolePrivileges->DrawViewMode();	
	}else if($mode == 'add'){		
		$objRolePrivileges->DrawAddMode();		
	}else if($mode == 'edit'){		
		$objRolePrivileges->DrawEditMode($rid);		
	}else if($mode == 'details'){		
		$objRolePrivileges->DrawDetailsMode($rid);		
	}
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>