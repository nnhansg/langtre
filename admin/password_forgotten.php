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

$act 		    = isset($_POST['act']) ? prepare_input($_POST['act']) : '';
$password_sent 	= (bool)Session::Get('password_sent');
$email 			= isset($_POST['email']) ? prepare_input($_POST['email']) : '';
$msg 			= '';

if($act == 'send'){
	if(!check_email_address($email)){
		$msg = draw_important_message(_EMAIL_IS_WRONG, false);					
	}else{
		if(!$password_sent){
			$objAdmin = new Admins(Session::Get('session_account_id'));
			if($objAdmin->SendPassword($email)){
				$msg = draw_success_message(_PASSWORD_SUCCESSFULLY_SENT, false);
				Session::Set('password_sent', true);
			}else{
				$msg = draw_important_message($objAdmin->error, false);					
			}
		}else{
			$msg = draw_message(_PASSWORD_ALREADY_SENT, false);
		}
	}
}

// Draw title bar
draw_title_bar(prepare_breadcrumbs(array(_ADMIN=>'',_PASSWORD_FORGOTTEN=>'')));

// Check if admin is logged in
if(!$objLogin->IsLoggedIn()){
	echo $msg;
	draw_content_start();	
?>
	<form class="forgot-password-form" action="index.php?admin=password_forgotten" method="post">
		<?php draw_hidden_field('act', 'send'); ?>
		<?php draw_token_field(); ?>
		
		<table width="96%" border="0">
		<tr>
			<td colspan="2">
				<?php echo '<p>'._PASSWORD_RECOVERY_MSG.'</p>'; ?>
			</td>
		</tr>
		<tr>
			<td width="12%" nowrap="nowrap"><?php echo _EMAIL_ADDRESS;?>:</td>
			<td width="88%"><input type="text" name="email" id="txt_forgotten_email" size="32" maxlength="70" autocomplete="off" /></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2">
				<input class="form_button" type="submit" name="btnSend" value="<?php echo _SEND;?>">
			</td>
		</tr>
		<tr><td colspan="2" nowrap="nowrap" height="5px"></td></tr>		
		<tr>
			<td valign="top" colspan="2">
				<?php echo prepare_permanent_link('index.php?admin=login', _ADMIN_LOGIN); ?>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>						
		</table>
	</form>
	<script type="text/javascript">appSetFocus("txt_forgotten_email");</script>
<?php
	draw_content_end();	
}else if($objLogin->IsLoggedInAsAdmin()){
	draw_important_message(_ALREADY_LOGGED);
}else{
	draw_important_message(_NOT_AUTHORIZED);
}
?>