<?php
/********************************************************************
 * openImageLibrary addon Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 * ----------------
 * Last change by ApPHP: 28.06.2011
 ********************************************************************/
require_once('config.inc.php');

error_reporting(0);

if($objLogin->IsLoggedInAsAdmin()){	

	if((substr($imagebaseurl, -1, 1)!='/') && $imagebaseurl!='') $imagebaseurl = $imagebaseurl . '/';
	if((substr($imagebasedir, -1, 1)!='/') && $imagebasedir!='') $imagebasedir = $imagebasedir . '/';
	$leadon = $imagebasedir;
	if($leadon=='.') $leadon = '';
	if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
	$startdir = $leadon;
	
	$file = isset($_GET['file']) ? prepare_input($_GET['file']) : "";
	$get_dir = isset($_GET['dir']) ? prepare_input($_GET['dir']) : "";
	$get_sort = isset($_GET['sort']) ? prepare_input($_GET['sort']) : "";
	$get_order = isset($_GET['order']) ? prepare_input($_GET['order']) : "";
	$dotdotdir = "";
	$dirok = false;
	$basedir = "";

	// delete image from gallery
	if($allowuploads ){
		if(!$is_demo){
			@unlink($leadon.$file);
		}
	}	

	if($get_dir){
		$dir = base64_decode($get_dir);
		
		if(substr($dir, -1, 1)!='/') {
			$dir = $dir . '/';
		}
		$dirok = true;
		$dirnames = explode('/', $dir);
		for($di=0; $di<sizeof($dirnames); $di++) {
			if($di<(sizeof($dirnames)-2)) {
				$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
			}
		}
		if(substr($dir, 0, 1)=='/') {
			$dirok = false;
		}
	
		if($dir == $leadon) {
			$dirok = false;
		}
		
		if($dirok) {
			$leadon = $dir;
		}
	}
	
	$opendir = $leadon;
	if(!$leadon) $opendir = '.';
	if(!file_exists($opendir)) {
		$opendir = '.';
		$leadon = $startdir;
	}
	
	clearstatcache();
	if($handle = opendir($opendir)){
		$n=0;
		while(false !== ($file = readdir($handle))){ 
			//first see if this file is required in the listing
			if($file == "." || $file == "..")  continue;
			
			if(@filetype($leadon.$file) == "dir") {
				if(!$browsedirs) continue;			
				$n++;
				if($get_sort == "date"){
					$key = @filemtime($leadon.$file) . ".$n";
				}
				else {
					$key = $n;
				}
				$dirs[$key] = $file . "/";
			}else{
				$n++;
				if($get_sort == "date"){
					$key = @filemtime($leadon.$file) . ".$n";
				}elseif($get_sort == "size"){
					$key = @filesize($leadon.$file) . ".$n";
				}else {
					$key = $n;
				}
				$files[$key] = $file;
			}
		}
		closedir($handle); 
	}
	
	//sort our files
	if($get_sort == "date"){
		@ksort($dirs, SORT_NUMERIC);
		@ksort($files, SORT_NUMERIC);
	}elseif($get_sort == "size"){
		@natcasesort($dirs); 
		@ksort($files, SORT_NUMERIC);
	}else{
		@natcasesort($dirs); 
		@natcasesort($files);
	}
	
	//order correctly
	if($get_order == "desc" && $get_order != "size") {$dirs = @array_reverse($dirs);}
	if($get_order == "desc") {$files = @array_reverse($files);}
	$dirs = @array_values($dirs); $files = @array_values($files);
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
	
	<html>
	<head>
	<title>openWYSIWYG | Select Image</title>
	<style type="text/css">
	body {
		margin: 0px;
	}
	a {
		font-family: Arial, verdana, helvetica; 
		font-size: 11px; 
		color: #000000;
		text-decoration: none;
	}
	a:hover {
		text-decoration: underline;
	}
	</style>
	<script type="text/javascript">
		function selectImage(url) {
			if(parent) {
				parent.document.getElementById("src").value = url;
			}
		}
		
		function deleteImage(url) {
			document.location.href = document.location.href + '&file='+url;
		}
		
		if(parent) {
			parent.document.getElementById("dir").value = '<?php echo $leadon; ?>';
		}
		
	</script>
	</head>
	<body>
		<table border="0">
			<tbody>
			 <?php
				
				$breadcrumbs = explode('/', str_replace($basedir."/", "", $leadon));
				if(($bsize = sizeof($breadcrumbs)) > 0) {
					if(($bsize-1) > 0) {	
						echo "<tr><td>";
						$sofar = '';
						for($bi=0;$bi<($bsize-1);$bi++) {
							$sofar = $sofar . $breadcrumbs[$bi] . '/';
							echo '<a href="select_image.php?dir='.urlencode($sofar).'" style="font-size:10px;font-family:Tahoma;">&raquo; '.$breadcrumbs[$bi].'</a><br>';
						}
						echo "</td></tr>";
					}
				}
			  ?>
			<tr>
				<td>
					  <?php
						$class = 'b';
						if($dirok) {
						?>
						<a href="select_image.php<?php echo '?dir='.urlencode($dotdotdir); ?>"><img src="images/dirup.png" alt="Folder" border="0" /> <strong>..</strong></a><br>
						<?php
							if($class=='b') $class='w';
							else $class = 'b';
						}
						$arsize = sizeof($dirs);
						for($i=0;$i<$arsize;$i++) {
							$dir = substr($dirs[$i], 0, strlen($dirs[$i]) - 1);
						?>
						<a href="select_image.php<?php echo '?dir='.urlencode($leadon.$dirs[$i]); ?>"><img src="images/folder.png" alt="<?php echo $dir; ?>" border="0" /> <strong><?php echo $dir; ?></strong></a><br>
						<?php
							if($class=='b') $class='w';
							else $class = 'b';	
						}
						
						$arsize = sizeof($files);
						echo "<table>";
						for($i=0;$i<$arsize;$i++) {
							$icon = 'unknown.png';
							$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
							if(in_array($ext, $supportedextentions)) {
								
								$thumb = '';
								if($filetypes[$ext]) {
									$icon = $filetypes[$ext];
								}
								
								$filename = $files[$i];
								if(strlen($filename)>43) {
									$filename = substr($files[$i], 0, 40) . '...';
								}
								$fileurl = $leadon . $files[$i];
								$filedir = str_replace($imagebasedir, "", $leadon);
						?>
						
						<tr>
							<td><a href="javascript:void(0)" onclick="selectImage('<?php echo $imagebaseurl.$filedir.$filename; ?>');"><img src="<?php echo (file_exists($imagebasedir.$filename)) ? $imagebasedir.$filename : "images/".$icon ; ?>" width='20px' height='20px' alt="<?php echo $files[$i]; ?>" border="0" /></a></td>
							<td>
								<a href="javascript:void(0)" onclick="selectImage('<?php echo $imagebaseurl.$filedir.$filename; ?>');"><strong><?php echo $filename; ?></strong></a>
							    <?php if(!$is_demo){ ?>
									<a href="javascript:void(0)" onclick="if(confirm('Are you sure?')) deleteImage('<?php echo $filename; ?>');" title="Delete"><strong>[x]</strong></a>								
								<?php } ?>
							</td>
						</tr>
						<?php
								if($class=='b') $class='w';
								else $class = 'b';	
							}
						}
						echo "</table>";
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
	</html>
	
<?php	
}else{
	include_once($basedir."include/messages.inc.php");	
	echo "<html><head><link href='".$basedir."templates/admin/css/style.css' type='text/css' rel='stylesheet'></head><body>";
	draw_important_message(_NOT_AUTHORIZED);
	echo "</body></html>";
}
?>