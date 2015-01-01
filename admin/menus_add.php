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

if($objLogin->IsLoggedInAsAdmin() && $objLogin->HasPrivileges('add_menus')){

    draw_title_bar(prepare_breadcrumbs(array(_MENUS_AND_PAGES=>'',_MENU_MANAGEMENT=>'',_MENU_ADD=>'')));
	echo $msg;

	draw_content_start();	
?>
	<form name="frmAddMenu" method="post">
		<?php draw_hidden_field('act', 'add'); ?>
		<?php draw_token_field(); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="2" class="main_text">
		<tr>
			<td width="20%"><?php echo _MENU_NAME;?> <span class="required">*</span>:</td>
			<td><input class="form_text" name="name" id="frmAddMenu_name" value="" size="40" maxlength="30"></td>
		</tr>
		<tr>
			<td><?php echo _DISPLAY_ON;?>:</td>
			<td><?php echo Menu::DrawMenuPlacementBox(); ?></td>
		</tr>
		<tr>
			<td nowrap="nowrap">
				<?php echo _ACCESS; ?>:&nbsp;
			</td>
			<td>
				<?php echo Menu::DrawMenuAccessSelectBox(); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo _LANGUAGE;?> <span class="required">*</span>:</td>
			<td>
				<?php
					// display language
					$total_languages = Languages::GetAllActive();
					draw_languages_box('language_id', $total_languages[0], 'abbreviation', 'lang_name', $language_id); 
				?>
			</td>
		</tr>
		<tr><td height="10px" nowrap="nowrap"></td></tr>		
		<tr>
			<td colspan="2">
				<input class="form_button" type="submit" name="subAddMenu" value="<?php echo _BUTTON_CREATE;?>">
				<input class="form_button" type="button" onclick="javascript:appGoTo('admin=menus')" value="<?php echo _BUTTON_CANCEL; ?>">
			</td>
		</tr>		
		</table>
		<br />
	</form>
	<script type="text/javascript">appSetFocus("frmAddMenu_name");</script>
<?php
	draw_content_end();	
}else{
	draw_title_bar(_ADMIN);
    draw_important_message(_NOT_AUTHORIZED);
}
?>