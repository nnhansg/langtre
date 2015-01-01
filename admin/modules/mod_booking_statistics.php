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

if(Modules::IsModuleInstalled('booking') &&
  (ModulesSettings::Get('booking', 'is_active') != 'no') && 
  ($objLogin->IsLoggedInAs('owner','mainadmin','admin') || ($objLogin->IsLoggedInAs('hotelowner') && $objLogin->HasPrivileges('view_hotel_reports')))
){

    define ('TABS_DIR', 'modules/tabs/');
    require_once(TABS_DIR.'tabs.class.php');
	
	echo '<script type="text/javascript" src="http://www.google.com/jsapi"></script>';

	$first_tab_content 	= '';
	$second_tab_content = '';
	$third_tab_content 	= '';	
	$fourth_tab_content = '';	
	$tabid 				= isset($_POST['tabid']) ? prepare_input($_POST['tabid']) : '1_1';
	$nl = "\n";
	
	$chart_type = isset($_POST['chart_type']) ? prepare_input($_POST['chart_type']) : 'columnchart';
	$year 		= isset($_POST['year']) ? prepare_input($_POST['year']) : date('Y');
	$country_id = isset($_POST['country_id']) ? prepare_input($_POST['country_id']) : '0';
	$hotel_id   = isset($_POST['hotel_id']) ? prepare_input($_POST['hotel_id']) : '0';

	if($tabid == '1_1') {		
		$first_tab_content = '
			<script type="text/javascript">
				function drawVisualization(){
				// Create and populate the data table.
				var data = new google.visualization.DataTable();
				data.addColumn("string", "'._MONTH.'");
				data.addColumn("number", "'._BOOKINGS.'");';
				
				$selStatType = 'COUNT(*)';
				$join_clause = ' LEFT OUTER JOIN '.TABLE_CUSTOMERS.' cust ON b.customer_id = cust.id ';
				if(!empty($hotel_id) || $objLogin->IsLoggedInAs('hotelowner')) $join_clause .= ' INNER JOIN '.TABLE_BOOKINGS_ROOMS.' br ON b.booking_number = br.booking_number ';
				$where_clause = ' AND b.status = 2 '.(($country_id != '0') ? ' AND cust.b_country = \''.$country_id.'\'' : '');
				if(!empty($hotel_id)) $where_clause .= ' AND br.hotel_id = '.(int)$hotel_id;
				else if(empty($hotel_id) && $objLogin->IsLoggedInAs('hotelowner')){
					$hotels_list = implode(',', $objLogin->AssignedToHotels());
					$where_clause .= ' AND br.hotel_id IN ('.$hotels_list.')';
				}
	
				$sql = 'SELECT
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'01\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month1,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'02\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month2,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'03\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month3,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'04\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month4,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'05\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month5,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'06\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month6,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'07\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month7,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'08\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month8,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'09\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month9,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'10\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month10,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'11\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month11,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'12\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month12
				  FROM '.TABLE_BOOKINGS.'
				  GROUP BY month1';
				  
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
				
		$first_tab_content .= $nl.' data.addRows(12);';		
		if($result[1] >= 0){
			$first_tab_content .= draw_set_values($result[0], $chart_type, _AMOUNT);
		}				 
		$first_tab_content .= ' } </script>';
				 
		$first_tab_content .= '<script type="text/javascript">';
		$first_tab_content .= $nl.' google.load("visualization", "1", {packages: ["'.$chart_type.'"]});';
		$first_tab_content .= $nl.' google.setOnLoadCallback(drawVisualization);';
		$first_tab_content .= $nl.' function frmStatistics_Submit() { document.frmStatistics.submit(); }';
		$first_tab_content .= '</script>';
				   
		$first_tab_content .= get_chart_changer('1_1', $chart_type, $year, $country_id, $hotel_id, 'mod_booking_statistics');		

		$first_tab_content .= '<div id="div_visualization" style="width:600px;height:310px;">
		<img src="images/loading.gif" style="margin:100px auto;" alt="'._LOADING.'..."></div>';

	}else if($tabid == '1_2'){
		
		$second_tab_content = '<script type="text/javascript">
				function drawVisualization(){
				// Create and populate the data table.
				var data = new google.visualization.DataTable();
				data.addColumn("string", "'._MONTH.'");
				data.addColumn("number", "'._BOOKINGS.'");';
				
				// calculate summ according to default currency
				$selStatType = (!empty($hotel_id) || (empty($hotel_id) && $objLogin->IsLoggedInAs('hotelowner'))) ? 'FORMAT(SUM((br.price + br.meal_plan_price) * c.rate + b.additional_payment * c.rate), 2) ' : 'FORMAT(SUM(b.payment_sum * c.rate + b.additional_payment * c.rate), 2) ';
				$join_clause = ' INNER JOIN '.TABLE_CURRENCIES.' c ON b.currency = c.code ';
				$join_clause .= ' LEFT OUTER JOIN '.TABLE_CUSTOMERS.' cust ON b.customer_id = cust.id ';  
				if(!empty($hotel_id) || $objLogin->IsLoggedInAs('hotelowner')) $join_clause .= ' INNER JOIN '.TABLE_BOOKINGS_ROOMS.' br ON b.booking_number = br.booking_number ';
				$where_clause = ' AND b.status = 2 '.(($country_id != '0') ? ' AND cust.b_country = \''.$country_id.'\'' : '');
				if(!empty($hotel_id)) $where_clause .= ' AND br.hotel_id = '.(int)$hotel_id;
				else if(empty($hotel_id) && $objLogin->IsLoggedInAs('hotelowner')){
					$hotels_list = implode(',', $objLogin->AssignedToHotels());
					$where_clause .= ' AND br.hotel_id IN ('.$hotels_list.')';
				}
				
				$sql = 'SELECT
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'01\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month1,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'02\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month2,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'03\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month3,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'04\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month4,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'05\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month5,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'06\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month6,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'07\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month7,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'08\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month8,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'09\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month9,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'10\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month10,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'11\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month11,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'12\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month12
				  FROM '.TABLE_BOOKINGS.'
				  GROUP BY month1';
				  
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
				
		$second_tab_content .= $nl.' data.addRows(12);';		
		if($result[1] >= 0){
			$default_currency = Currencies::GetDefaultCurrency();
			$second_tab_content .= draw_set_values($result[0], $chart_type, _INCOME, $default_currency);
		}				 
		$second_tab_content .= ' } </script>';
				 
		$second_tab_content .= '<script type="text/javascript">';
		$second_tab_content .= $nl.' google.load("visualization", "1", {packages: ["'.$chart_type.'"]});';
		$second_tab_content .= $nl.' google.setOnLoadCallback(drawVisualization);';
		$second_tab_content .= $nl.' function frmStatistics_Submit() { document.frmStatistics.submit(); }';
		$second_tab_content .= '</script>';
				   
		$second_tab_content .= get_chart_changer('1_2', $chart_type, $year, $country_id, $hotel_id, 'mod_booking_statistics');		

		$second_tab_content .= '<div id="div_visualization" style="width:600px;height:310px;">
		<img src="images/loading.gif" style="margin:100px auto;" alt="'._LOADING.'..."></div>';
		
	}else if($tabid == '1_3'){

		$third_tab_content = '<script type="text/javascript">
				function drawVisualization(){
				// Create and populate the data table.
				var data = new google.visualization.DataTable();
				data.addColumn("string", "'._MONTH.'");
				data.addColumn("number", "'._BOOKINGS.'");';
				
				// calculate summ according to default currency
				$selStatType = 'FORMAT(SUM(b.vat_fee * c.rate), 2) ';
				$join_clause = ' INNER JOIN '.TABLE_CURRENCIES.' c ON b.currency = c.code ';
				$join_clause .= ' INNER JOIN '.TABLE_CUSTOMERS.' cust ON b.customer_id = cust.id ';  
				$where_clause = ' AND b.status = 2 '.(($country_id != '0') ? ' AND cust.b_country = \''.$country_id.'\'' : '');
	
				$sql = 'SELECT
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'01\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month1,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'02\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month2,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'03\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month3,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'04\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month4,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'05\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month5,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'06\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month6,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'07\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month7,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'08\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month8,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'09\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month9,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'10\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month10,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'11\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month11,
				  (SELECT '.$selStatType.' FROM '.TABLE_BOOKINGS.' b '.$join_clause.' WHERE SUBSTRING(b.payment_date, 6, 2) = \'12\' AND SUBSTRING(b.payment_date, 1, 4) = '.(int)$year.' '.$where_clause.') as month12
				  FROM '.TABLE_BOOKINGS.'
				  GROUP BY month1';         
	
				$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
				
		$third_tab_content .= $nl.' data.addRows(12);';		
		if($result[1] >= 0){
			$default_currency = Currencies::GetDefaultCurrency();
			$third_tab_content .= draw_set_values($result[0], $chart_type, _INCOME, $default_currency);
		}				 
		$third_tab_content .= ' } </script>';
				 
		$third_tab_content .= '<script type="text/javascript">';
		$third_tab_content .= $nl.' google.load("visualization", "1", {packages: ["'.$chart_type.'"]});';
		$third_tab_content .= $nl.' google.setOnLoadCallback(drawVisualization);';
		$third_tab_content .= $nl.' function frmStatistics_Submit() { document.frmStatistics.submit(); }';
		$third_tab_content .= '</script>';
				   
		$third_tab_content .= get_chart_changer('1_3', $chart_type, $year, $country_id, '-1', 'mod_booking_statistics');		

		$third_tab_content .= '<div id="div_visualization" style="width:600px;height:310px;">
		<img src="images/loading.gif" style="margin:100px auto;" alt="'._LOADING.'..."></div>';

	}else{
		
		$sql = 'SELECT
					COUNT(*) as cnt,
					c.abbrv as country_abbrv,
					c.name as country_name
				FROM '.TABLE_BOOKINGS.' b
					INNER JOIN '.TABLE_CUSTOMERS.' u ON b.customer_id = u.id
					INNER JOIN '.TABLE_COUNTRIES.' c ON u.b_country = c.abbrv AND c.is_active = 1
				GROUP BY c.abbrv';				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS);
		$fourth_tab_content = '			
			<script type="text/javascript">
			 google.load("visualization", "1", {"packages": ["geomap"]});
			 google.setOnLoadCallback(drawMap);
			
			  function drawMap() {
				var data = new google.visualization.DataTable();';
				
				if($result[1] > 0){
					$fourth_tab_content .= $nl.' data.addRows('.$result[1].');';
					$fourth_tab_content .= $nl.' data.addColumn("string", "'._COUNTRY.'");';
					$fourth_tab_content .= $nl.' data.addColumn("number", "'._POPULARITY.'");';
					$fourth_tab_content .= $nl.' data.addColumn("string", "HOVER", "");';
					for($i=0; $i < $result[1]; $i++){
						$fourth_tab_content .= $nl.' data.setValue('.$i.', 0, "'.$result[0][$i]['country_abbrv'].'");';
						$fourth_tab_content .= $nl.' data.setValue('.$i.', 1, '.(int)$result[0][$i]['cnt'].');';
						$fourth_tab_content .= $nl.' data.setValue('.$i.', 2, "'.$result[0][$i]['country_name'].'");';
					}
				}else{
					$fourth_tab_content .= $nl.' data.addRows(1);';
					$fourth_tab_content .= $nl.' data.addColumn("string", "'._COUNTRY.'");';
					$fourth_tab_content .= $nl.' data.addColumn("number", "'._POPULARITY.'");';
					$fourth_tab_content .= $nl.' data.addColumn("string", "HOVER", "");';
					$fourth_tab_content .= $nl.' data.setValue(0, 0, "USA");';
					$fourth_tab_content .= $nl.' data.setValue(0, 1, 0);';
					$fourth_tab_content .= $nl.' data.setValue(0, 2, "USA");';										
				}
				
		$fourth_tab_content .= '	
				var options = {};
				options["dataMode"] = "regions";
				options["width"] = "675px";
				options["showLegend"] = true;
			
				var container = document.getElementById("map_canvas");
				var geomap = new google.visualization.GeoMap(container);
				geomap.draw(data, options);
			};
			</script>
			<div id="map_canvas" style="padding:1px 10px 1px 10px;"></div>		
		';	
	}
	

	$tabs = new Tabs(1, 'xp', TABS_DIR, '?admin=mod_booking_statistics');
	$tabs->SetToken(Application::Get('token'));
	//$tabs->SetHttpVars(array('admin'));
 
	$tab1=$tabs->AddTab(_BOOKINGS.' ('._AMOUNT.')', $first_tab_content);
	$tab2=$tabs->AddTab(_BOOKINGS.' ('._INCOME.')', $second_tab_content);
	if(!$objLogin->IsLoggedInAs('hotelowner'))  $tab3=$tabs->AddTab(_BOOKINGS.' ('._TAXES.')', $third_tab_content);
	if(!$objLogin->IsLoggedInAs('hotelowner'))  $tab4=$tabs->AddTab(_BOOKINGS.' ('._MAP_OVERLAY.')', $fourth_tab_content);
	 
	## +---------------------------------------------------------------------------+
	## | 2. Customizing:                                                           |
	## +---------------------------------------------------------------------------+
	## *** set container's width in pixels (px), inches (in) or points (pt)
	$tabs->SetWidth('790px');
 
	## *** set container's height in pixels (px), inches (in) or points (pt)
	$tabs->SetHeight('auto'); // 'auto'
 
	## *** set alignment inside the container (left, center or right)
	$tabs->SetAlign('left');
 
	## *** set container's color in RGB format or using standard names
	/// $tabs->SetContainerColor('#64C864');
	## *** set border's width in pixels (px), inches (in) or points (pt)
	/// $tabs->SetBorderWidth('5px');
	## *** set border's color in RGB format or using standard names
	/// $tabs->SetBorderColor('#64C864');
	/// $tabs->SetBorderColor('blue');
	/// $tabs->SetBorderColor('#445566');
	## *** show debug info - false|true
	$tabs->Debug(false);
	## *** allow refresh selected tabs - false|true
	/// $tabs->AllowRefreshSelectedTabs(true);
	## *** set form submission type: 'get' or 'post'
	$tabs->SetSubmissionType('post');


	draw_title_bar(prepare_breadcrumbs(array(_BOOKINGS=>'',_INFO_AND_STATISTICS=>'',_STATISTICS=>'')));	

	draw_content_start();	
	$tabs->Display();
	draw_content_end();

}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}

?>