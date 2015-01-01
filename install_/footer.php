<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/
    
    $current_file = basename($_SERVER['SCRIPT_FILENAME']);
    $license_dir = '';
    if($current_file == 'step1.php' || $current_file == 'step2.php'){
        $license_dir = '../';
    }    

?>

<table cellspacing="0" cellpadding="0" width="250px" border="0">
<tbody>
<tr><td height="20px"></td></tr>
<tr>
    <td class="footer_line">
        &laquo;ApPHP <span style="color:#bb5500">Hotel</span> Site&raquo; <?php echo EI_APPLICATION_VERSION;?> &nbsp;ApPHP
        <?php if(EI_LICENSE_AGREEMENT_PAGE != ''){ ?>
             : <a href="<?php echo $license_dir.EI_LICENSE_AGREEMENT_PAGE;?>" target="_blank">License</a>
        <?php } ?>    
    </td>
</tr>
<tr><td height="7px"></td></tr>
</tbody>
</table>

