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

if($objLogin->IsLoggedInAsAdmin() && $objLogin->HasPrivileges('edit_menus')){
	
    draw_title_bar(prepare_breadcrumbs(array(_MENUS_AND_PAGES=>'',_MENU_MANAGEMENT=>'',_MENU_EDIT=>'')));
	echo $msg;

	draw_content_start();				
?>
	<form name="frmEditMenu" method="post" action="index.php?admin=menus_edit">
		<?php draw_hidden_field('act', 'edit'); ?>
		<?php draw_hidden_field('mid', $mid); ?>
		<?php draw_hidden_field('language_id', $menu->GetParameter('language_id')); ?>
		<?php draw_token_field(); ?>

		<table width="100%" border="0" cellspacing="0" cellpadding="2" class="main_text">
		<tr>
			<td><?php echo _MENU_NAME;?> <span class="required">*</span>:</td>
			<td><input class="form_text" name="name" value="<?php echo $menu->GetName();?>" size="40" maxlength="30"></td>
		</tr>
		<tr>
			<td><?php echo _MENU_ORDER;?> <span class="required">*</span>:</td>
			<td>
				<?php
					// output select tag as a total number of menus available
					$total_menus = Menu::GetAll(' menu_order ASC', TABLE_MENUS, '', $menu->GetParameter('language_id'));
					draw_numbers_select_field('order', $menu->GetOrder(2), 1, $total_menus[1]);
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo _DISPLAY_ON;?>:</td>
			<td><?php echo Menu::DrawMenuPlacementBox($menu->GetParameter('menu_placement')); ?></td>
		</tr>
		<tr>
			<td nowrap="nowrap">
				<?php echo _ACCESS; ?>:&nbsp;
			</td>
			<td>
				<?php echo Menu::DrawMenuAccessSelectBox($menu->GetParameter('access_level')); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo _LANGUAGE;?>:</td>
			<td>
				<?php
					// display language
					echo '<label>'.$menu->GetParameter('language_name').'</label>';
				?>
			</td>
		</tr>
		<tr><td height="10px" nowrap="nowrap"></td></tr>		
		<tr>
			<td colspan="2">
				<input class="form_button" type="submit" name="subEditMenu" value="<?php echo _BUTTON_SAVE_CHANGES ?>">
				<input class="form_button" type="button" onclick="javascript:appGoTo('admin=menus')" value="<?php echo _BUTTON_CANCEL; ?>">					
			</td>
		</tr>		
		</table>
		<br />
	</form>
<?php
	draw_content_end();	
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>