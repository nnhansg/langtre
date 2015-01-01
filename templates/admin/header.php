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

?>
<div id="logoTop">
	<div id="siteLogo" class="<?php echo 'float_'.Application::Get('defined_left'); ?>">
		<a href="<?php echo APPHP_BASE; ?>index.php"><?php echo $objSiteDescription->GetParameter('header_text'); ?></a>
	</div>
	<div id="siteSlogan" class="<?php echo 'float_'.Application::Get('defined_left'); ?>">
		<?php echo ($objLogin->IsLoggedInAsAdmin()) ? _ADMIN_PANEL : $objSiteDescription->GetParameter('slogan_text') ?>
	</div>	
	<div id="siteLinks" class="<?php echo 'float_'.Application::Get('defined_right'); ?>">
		<?php if($objLogin->IsLoggedIn()){ ?>
			<form name="frmLogout" id="frmLogout" style="padding:0px;margin:0px;" action="<?php echo APPHP_BASE; ?>index.php" method="post">
				<?php draw_hidden_field('submit_logout', 'logout'); ?>
				<?php draw_token_field(); ?>
				
				<?php /*_YOU_ARE_LOGGED_AS.': '*/ echo $objLogin->GetLoggedName(); ?>
				<?php
					echo '&nbsp;'.draw_divider(false).'&nbsp;&nbsp;';
					echo prepare_permanent_link('index.php?admin=home', _HOME, '', 'main_link');
					echo '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;';
					echo prepare_permanent_link('index.php?admin=my_account', _MY_ACCOUNT, '', 'main_link');
					echo '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;';
				?>				
				<a class="main_link" href="javascript:appFormSubmit('frmLogout');"><?php echo _BUTTON_LOGOUT; ?></a>				
			</form>
		<?php } ?>
	</div>	
</div>