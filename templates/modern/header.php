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

if (Application::Get('page') != 'home' ||
        (Application::Get('page') == 'home' && Application::Get('admin') != '') ||
        (Application::Get('page') == 'home' && Application::Get('customer') != '')
) {
    $show_banner = $objLogin->IsLoggedInAsCustomer() ? false : false;
} else {
    $show_banner = $objLogin->IsLoggedInAsCustomer() ? false : true;
}
?>

<!-- header -->
<div id="header">
    <div class="row-1">
        <div class="wrapper pos-rel">
            <div class="logo <?php echo 'f' . Application::Get('defined_left'); ?>">
                <h1>
                    <a href="<?php echo APPHP_BASE; ?>index.php">
<?php //echo ($objLogin->IsLoggedInAsAdmin()) ? _ADMIN_PANEL : $objSiteDescription->DrawHeader('header_text');  ?>
                        <img src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template'); ?>/images/logo.png" alt="Bamboo Village" />
                    </a>
                </h1>
            </div>
            <div class="top-add">
                <img src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template'); ?>/images/ico_local.png" width="14" height="20" alt="local bamboo">38 Nguyen Dinh Chieu Street, Ham Tien Ward, Phan Thiet City, Binh Thuan Province, Vietnam <img src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template'); ?>/images/ico_phone.png" width="12" height="20" alt="phone bamboo"> +84 62 3847 007 <img src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template'); ?>/images/ico_email.png" width="20" height="13" alt="email bamboo"><a href="mailto:info@bamboovillageresortvn.com" style="color: #719430;">Email Us</a></div>
            <!--<div class="phones <?php echo 'f' . Application::Get('defined_right'); ?>">
<?php Hotels::DrawPhones(); ?>
            </div>-->
        </div>
    </div>	
</div>
<div id="top-nav">
    <div id="menu-page-menu" class="clearfix">
<!--        <ul id="nav">-->
<!--			--><?php
//				$urlLangTre = "http://langtre.ntitss.com.palm.arvixe.com";
//			?>
<!--            <li><a href="--><?php //echo $urlLangTre ?><!--/category/rooms/">Rooms</a>-->
<!--            </li>-->
<!--            <li> <a href="--><?php //echo $urlLangTre; ?><!--/category/dining/" title="Dining">Dining</a></li>-->
<!--            <li><a href="--><?php //echo $urlLangTre; ?><!--/category/spa-fitness/" title="spa and Fitness"> Spa &amp; Fitness</a></li>-->
<!--            <li> <a href="--><?php //echo $urlLangTre; ?><!--/category/offers/">Offers</a></li>-->
<!--            <li> <a href="--><?php //echo $urlLangTre; ?><!--/category/room/amenities/">Amenities</a></li>-->
<!--            <li> <a href="--><?php //echo $urlLangTre; ?><!--/gallery/">Gallery</a></li>-->
<!--            <li> <a href="--><?php //echo $urlLangTre; ?><!--/about-us/">About Us</a></li>-->
<!--			<li> <a href="--><?php //echo $urlLangTre; ?><!--/testimonials/">Testimonials</a></li>-->
<!--			<li> <a href="--><?php //echo $urlLangTre; ?><!--/resorts-policies/">Resort's Policies</a></li>			-->
<!--        </ul>-->
    </div>
    <!--End #menu-page-menu -->

    <!--<div class="booking-now"><a href="/">book now</a></div>-->
	<div class="booking-now"><a class="headline-abp" href="/widgets/ipanel-left/index.php?host=aHR0cCUzQS8vYm9va2luZ2xhbmd0cmUubnRpdHNzLmNvbS5wYWxtLmFydml4ZS5jb20v&key=c2tyMXNicnc1Zw==" class="fancybox-iframe">book now</a></div>
</div>

<div id="slider">
    <iframe width="1000" scrolling="no" height="380" frameborder="0" style="overflow: hidden;" src="<?php echo $urlLangTre; ?>/slide-banner-home/" marginwidth="0" marginheight="0"></iframe>
</div>
<div id="breadcrumb">
    <a href="/">
        <img src="<?php echo APPHP_BASE; ?>templates/<?php echo Application::Get('template');?>/images/ico_breadcrumb.png" width="34" height="20" alt="icon home bamboo">
    </a>
    > <a href="<?php echo $urlLangTre; ?>/category/rooms/">Rooms</a>
</div>