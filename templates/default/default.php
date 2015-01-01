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

header('content-type: text/html; charset=utf-8');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo Application::Get('tag_keywords'); ?>" />
	<meta name="description" content="<?php echo Application::Get('tag_description'); ?>" />

    <title><?php echo Application::Get('tag_title'); ?></title>

    <base href="<?php echo APPHP_BASE; ?>" /> 
	<link href="<?php echo APPHP_BASE; ?>images/icons/apphp.ico" rel="SHORTCUT ICON" />
  
    <link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style.css" type="text/css" rel="stylesheet" />
	<?php if(Application::Get('lang_dir') == 'rtl'){ ?>
		<link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style-rtl.css" type="text/css" rel="stylesheet" />
	<?php } ?>
	<!--[if IE]>
	<link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style-ie.css" type="text/css" rel="stylesheet" />
	<![endif]-->

	<!-- Opacity Module -->
	<link href="<?php echo APPHP_BASE; ?>modules/opacity/opacity.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>modules/opacity/opacity.js"></script>
	
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>js/cart.js"></script>

    <?php echo Application::SetLibraries(); ?>    	
	<?php
	    $banner_image = '';
		if(!$objLogin->IsLoggedIn() || Application::Get('preview') == 'yes'){
			Banners::DrawBannersTop($banner_image, true);
        }
    ?>		

</head>

<body dir="<?php echo Application::Get('lang_dir');?>">
<a name="top"></a>
<div id="wrap">
	
	<!-- HEADER -->
	<?php include_once 'templates/'.Application::Get('template').'/header.php'; ?>
	
		<!-- header-box begin -->
		<?php
			if(!$objLogin->IsLoggedInAsCustomer()){
				echo '<div id="header-wrap">'.$banner_image.'</div>';
			}else{
				echo '<div id="header-wrap-logged"></div>';
			}		
		?>
		<!-- header-box end -->
	
	
	<div id="languages-wrap">
		<!-- languages -->
		<?php				
			$objLang = new Languages();				
			if($objLang->GetLanguagesCount('front-end') > 1){
				echo '<div style="margin-right:6px;">'._LANGUAGES.'</div>';			
				echo '<div style="margin-top:3px;margin-right:3px;">';
				$objLang->DrawLanguagesBar();
				echo '</div>';
			}			
		?>
	</div>

	<?php
		// Draw header menu
		Menu::DrawHeaderMenu();
	?>		  

	<div id="content-wrap">
		<div id="left-column<?php echo '-'.Application::Get('defined_left'); ?>">
			<!-- currencies -->
			<div class='left_box_container'>
				<div class='side_box_content <?php echo Application::Get('defined_left'); ?>'>
					<?php			
						echo Currencies::GetCurrenciesDDL();
					?>
				</div>
			</div>

			<!-- LEFT COLUMN -->
			<?php
				// Draw menu tree
				Menu::DrawMenu('left');
			?>                            
			<!-- END OF LEFT COLUMN -->				
		</div>

		<div id="content<?php echo '-'.Application::Get('defined_right'); ?>">
			<!-- MAIN CONTENT -->
			<?php					
				if((Application::Get('page') != '') && file_exists('page/'.Application::Get('page').'.php')){
					include_once('page/'.Application::Get('page').'.php');
				}else if((Application::Get('customer') != '') && file_exists('customer/'.Application::Get('customer').'.php')){
					if(Modules::IsModuleInstalled('customers')){	
						include_once('customer/'.Application::Get('customer').'.php');
					}else{
						include_once('customer/404.php');
					}
				}else if((Application::Get('admin') != '') && file_exists('admin/'.Application::Get('admin').'.php')){
					include_once('admin/'.Application::Get('admin').'.php');
				}else{
					if(Application::Get('template') == 'admin'){
						include_once('admin/home.php');
					}else{
						include_once('page/pages.php');										
					}
				}
			?>
			<!-- END OF MAIN CONTENT -->			
		</div>
		
		<!-- FOOTER -->
		<?php include_once 'templates/'.Application::Get('template').'/footer.php'; ?>
	</div>
</div>

<?php Rooms::DrawSearchAvailabilityFooter(); ?>

</body>
</html>