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

// Draw title bar
draw_title_bar(prepare_breadcrumbs(array(_ACCOUNTS=>'',_ADMIN_LOGIN=>'')));

// Check if admin is logged in
if(!$objLogin->IsLoggedIn()){
	if($objLogin->IsWrongLogin()) draw_important_message(_WRONG_LOGIN);
?>
	<div class="pages_contents">
	<form class="login-form" action="index.php?admin=login" method="post">
		<?php draw_hidden_field('submit_login', 'login'); ?>
		<?php draw_hidden_field('type', 'admin'); ?>
		<?php draw_token_field(); ?>
		
		<table width="96%" cellspacing="4" border="0">
		<tr>
			<td width="10%" nowrap='nowrap'><?php echo _USERNAME;?>:</td>
			<td width="90%"><input type="text" id="txt_user_name" name="user_name" style="width:150px" maxlength="32" autocomplete="off" /></td>
		</tr>
		<tr>
			<td><?php echo _PASSWORD;?>:</td>
			<td><input type="password" name="password" style="width:150px" maxlength="20" autocomplete="off" /></td>
		</tr>
		<tr><td colspan='2'>&nbsp;</td></tr>				
		<tr>
			<td colspan="2">
				<input class="form_button" type="submit" name="submit" value="<?php echo _BUTTON_LOGIN;?>">
			</td>
		</tr>
		<tr><td colspan="2" nowrap="nowrap" height="5px"></td></tr>		
		<tr>
			<td valign="top" colspan="2">
				<?php echo prepare_permanent_link('index.php?admin=password_forgotten', _FORGOT_PASSWORD); ?>
			</td>
		</tr>
		<tr><td colspan="2" nowrap="nowrap" height="5px"></td></tr>		
		</table>
	</form>
	</div>
	<script>appSetFocus("txt_user_name");</script>
<?php
}else if($objLogin->IsLoggedInAsAdmin()){
	draw_important_message(_ALREADY_LOGGED);
	draw_content_start();
?>
	<form action="index.php?page=logout" method="post">
		<?php draw_hidden_field('submit_logout', 'logout'); ?>
		<?php draw_token_field(); ?>
		<input class="form_button" type="submit" name="submit" value="<?php echo _BUTTON_LOGOUT;?>">
	</form>
<?php
	draw_content_end();	
}else{
	$objSession->SetMessage('notice','');
	draw_important_message(_NOT_AUTHORIZED);	
}
?>