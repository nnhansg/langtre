<?php

$host = isset($_GET['host']) ? urldecode(base64_decode($_GET['host'])) : '';
$key = isset($_GET['key']) ? base64_decode($_GET['key']) : '';

$basedir = '../../';

require_once($basedir.'include/base.inc.php');
if($key != INSTALLATION_KEY) exit(0);

require_once($basedir.'include/shared.inc.php');
require_once($basedir.'include/settings.inc.php');
require_once($basedir.'include/functions.database.inc.php');
require_once($basedir.'include/functions.common.inc.php');
require_once($basedir.'include/functions.html.inc.php');

require_once($basedir.'include/classes/Session.class.php');
require_once($basedir.'include/classes/Login.class.php');
require_once($basedir.'include/classes/MicroGrid.class.php');
require_once($basedir.'include/classes/Modules.class.php');
require_once($basedir.'include/classes/ModulesSettings.class.php');
require_once($basedir.'include/classes/Application.class.php');
require_once($basedir.'include/classes/Hotels.class.php');
require_once($basedir.'include/classes/HotelsLocations.class.php');
require_once($basedir.'include/classes/Rooms.class.php');
require_once($basedir.'include/classes/Packages.class.php');

define('APPHP_BASE', get_base_url());
@date_default_timezone_set(TIME_ZONE);

// setup connection
//------------------------------------------------------------------------------
$database_connection = @mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die(((SITE_MODE == 'development') ? mysql_error() : 'Fatal Error: Please check database connection parameters!'));
@mysql_select_db(DATABASE_NAME, $database_connection) or die(((SITE_MODE == 'development') ? mysql_error() : 'Fatal Error: Please check your database exists!'));

Modules::Init();
ModulesSettings::Init();

require_once($basedir.'include/messages.en.inc.php');

$objSession = new Session();
$objLogin = new Login();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reservation Form</title>
    <link href="<?php echo $host; ?>templates/modern/css/style.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo $host; ?>templates/modern/css/integration.css" type="text/css" rel="stylesheet" />
</head>
<body class="integration">
	<div class="header-1">
		<h3 class="headline">Bamboo Village Beach Resort & Spa</h3>
		<h5>38 Nguyen Dinh Chieu Street, Ham Tien Ward, Phan Thiet City, Binh Thuan Province, Vietnam | +84 62 3847 007</h5>
	</div>
	<h2 class="title headline">Travel Dates</h2>
	<div class="content">
    <?php
        //echo '<h2>'._RESERVATION.'</h2>';				
        Rooms::DrawSearchAvailabilityBlock2(false, '', 8, 3, false, $host, '_parent', true);
        Rooms::DrawSearchAvailabilityFooter('', $host);
    ?>
	</div>
</body>
</html>