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

$nav_panel_state = '1';
if($objLogin->IsLoggedInAsAdmin()){
	$nav_panel_state = (isset($_COOKIE['nav_panel_state']) && ($_COOKIE['nav_panel_state'] == 'collapsed')) ? '0' : '1';				
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo $objSiteDescription->GetParameter('tag_keywords'); ?>" />
	<meta name="description" content="<?php echo $objSiteDescription->GetParameter('tag_description'); ?>" />

    <title><?php echo $objSiteDescription->GetParameter('tag_title'); ?> :: <?php echo _ADMIN_PANEL; ?></title>

    <base href="<?php echo APPHP_BASE; ?>" /> 
	<link href="<?php echo APPHP_BASE; ?>images/icons/apphp.ico" rel="SHORTCUT ICON" />
	
	<link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style.css" type="text/css" rel="stylesheet" />
	<?php if(Application::Get('lang_dir') == 'rtl'){ ?>
		<link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style-rtl.css" type="text/css" rel="stylesheet" />
	<?php } ?>
	<!--[if IE]>
	<link href="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/css/style-ie.css" type="text/css" rel="stylesheet" />
	<![endif]-->

	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>js/cart.js"></script>
	<script type="text/javascript" src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template'); ?>/js/menu.js"></script>	
</head>    
<body dir="<?php echo Application::Get('lang_dir');?>">
<div id="mainWrapper">
<div id="headerWrapper">

	<?php include_once 'templates/'.Application::Get('template').'/header.php'; ?>

	<table id="contentMainWrapper" cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tbody>
	<tr>
		<td id="navColumnLeft">
			<div id="navColumnLeftWrapper" class="no_print">
				<!-- LEFT COLUMN -->
				<?php                        
					$objLogin->DrawLoginLinks();
					if(!Application::Get('preview')){
						if(Application::Get('admin') == 'login'){
							echo '<br>'._LOGIN_PAGE_MSG;
						}else if(Application::Get('admin') == 'password_forgotten'){
							echo '<br>'._PASSWORD_FORGOTTEN_PAGE_MSG;
						}						
					}
				?>
				<!-- END OF LEFT COLUMN -->			
			</div>		
	    </td>
		<?php
			if($objLogin->IsLoggedInAsAdmin()){
				$output  = '<td id="navColumnIcon" class="no_print">';
				$output .= '<img id="imgCollapse" title="'._COLLAPSE_PANEL.'" onclick="toggle_navigation_panel(0);" src="templates/'.Application::Get('template').'/images/'.((Application::Get('lang_dir') == 'ltr') ? 'collapse_panel.gif' : 'expand_panel.gif').'" alt="collapse" />';
				$output .= '<img id="imgExpand" title="'._EXPAND_PANEL.'" onclick="toggle_navigation_panel(1);"  src="templates/'.Application::Get('template').'/images/'.((Application::Get('lang_dir') == 'ltr') ? 'expand_panel.gif' : 'collapse_panel.gif').'" alt="expand" />';
				$output .= '</td>';
				echo $output;
			}
		?>		
		<td id="navColumnMain" valign="top">		
			<?php
				if($objLogin->IsLoggedInAsAdmin()){
					echo '<script type="text/javascript">toggle_navigation_panel('.$nav_panel_state.');</script>';
				}
			?>
			<div id="indexDefault" class="center_column">
			<div id="indexDefaultMainContent">			
			<div class="center_box_wrapper">
				<!-- MAIN CONTENT -->
				<?php		
					if((Application::Get('page') != '') && file_exists('page/'.Application::Get('page').'.php')){
						include_once('page/'.Application::Get('page').'.php');
					}else if((Application::Get('customer') != '') && file_exists('customer/'.Application::Get('customer').'.php')){
						include_once('customer/'.Application::Get('customer').'.php');
					}else if((Application::Get('admin') != '') && !preg_match('/mod_/', Application::Get('admin')) && file_exists('admin/'.Application::Get('admin').'.php')){
						include_once('admin/'.Application::Get('admin').'.php');	
					}else if((Application::Get('admin') != '') && preg_match('/mod_/', Application::Get('admin')) && file_exists('admin/modules/'.Application::Get('admin').'.php')){
						include_once('admin/modules/'.Application::Get('admin').'.php');	
					}else{
						if(Application::Get('template') == 'admin'){
							include_once('admin/home.php');
						}else{										
							include_once('page/pages.php');										
						}
					}
				?>
			</div>
			</div>
			</div>			
		</td>		
	</tr>
	</tbody>
	</table>
</div>
</div>
	
<?php
	if($objLogin->IsLoggedInAsAdmin()){
		echo '<script type="text/javascript">set_active_menu_count('.$objLogin->GetActiveMenuCount().');</script>';
	}
?>

</body>
</html>