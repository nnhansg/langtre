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

<!-- footer -->
<div id="footer">
    <div class="wrapper">
        <div class="fleft">
            <ul class="_nav">
                <?php 
                    // Draw footer menu
                    Menu::DrawFooterMenu();	
                ?>		  
                </li>
            </ul>
        </div>
        <div class="fright">
            <form name="frmLogout" id="frmLogout" style="padding:0px;margin:0px;" action="<?php echo APPHP_BASE; ?>index.php" method="post">
            <?php if($objLogin->IsLoggedIn()){ ?>
                <?php draw_hidden_field('submit_logout', 'logout'); ?>
                <a class="main_link" href="javascript:appFormSubmit('frmLogout');"><?php echo _BUTTON_LOGOUT; ?></a>
            <?php }else{ ?>
				<?php
					if(Modules::IsModuleInstalled('customers')){
						if(ModulesSettings::Get('customers', 'allow_login') == 'yes'){
							echo prepare_permanent_link('index.php?customer=login', _CUSTOMER_LOGIN, '', 'main_link');
							echo '&nbsp;&nbsp;'.draw_divider(false).'&nbsp;&nbsp;';
						}
					}
					echo prepare_permanent_link('index.php?admin=login', _ADMIN_LOGIN, '', 'main_link');
				?>                
            <?php } ?>
            </form>
        </div>
    </div>
</div>
<div id="footer-2">
<?php echo $footer_text = $objSiteDescription->DrawFooter(false); ?>
<?php if(!empty($footer_text)) echo '&nbsp;'.draw_divider(false).'&nbsp;'; ?>
<?php
    if($objSettings->GetParameter('rss_feed')){
        echo '<a href="feeds/rss.xml" title="RSS Feed"><img src="templates/'.Application::Get('template').'/images/rss.jpg" alt="RSS Feed" /></a>&nbsp;';
    }
?>
</div>