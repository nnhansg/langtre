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

if($objLogin->IsLoggedInAsCustomer()){

	draw_title_bar(prepare_breadcrumbs(array(_MY_ACCOUNT=>'',_EDIT_MY_ACCOUNT=>'')));
	
?>
	<script type="text/javascript"> 
	function btnSubmitPD_OnClick(){
		frmEdit = document.getElementById("frmEditAccount");
		
		if(frmEdit.first_name.value == ""){
			alert("<?php echo _FIRST_NAME_EMPTY_ALERT; ?>");
			frmEdit.first_name.focus();
			return false;
		}else if(frmEdit.last_name.value == ""){
			alert("<?php echo _LAST_NAME_EMPTY_ALERT; ?>");
			frmEdit.last_name.focus();
			return false;        
		}else if(frmEdit.b_address.value == ""){
			alert("<?php echo _ADDRESS_EMPTY_ALERT; ?>");
			frmEdit.b_address.focus();
			return false;        
		}else if(frmEdit.b_city.value == ""){
			alert("<?php echo _CITY_EMPTY_ALERT; ?>");
			frmEdit.b_city.focus();
			return false;        
		}else if(frmEdit.b_zipcode.value == ""){
			alert("<?php echo _ZIPCODE_EMPTY_ALERT; ?>");
			frmEdit.b_zipcode.focus();
			return false;        
		}else if(frmEdit.b_country.value == ""){
			alert("<?php echo _COUNTRY_EMPTY_ALERT; ?>");
			frmEdit.b_country.focus();
			return false;        
		}else if(frmEdit.phone.value == ""){
			alert("<?php echo _PHONE_EMPTY_ALERT; ?>");
			frmEdit.phone.focus();
			return false;        
		}else if(frmEdit.email.value == ""){
			alert("<?php echo _EMAIL_EMPTY_ALERT; ?>");
			frmEdit.email.focus();
			return false;        
		}else if(!appIsEmail(frmEdit.email.value)){
			alert("<?php echo _EMAIL_VALID_ALERT; ?>");
			frmEdit.email.focus();
			return false;        
		}else if((frmEdit.user_password1.value != "") && (frmEdit.user_password1.value != frmEdit.user_password2.value)){
			alert("<?php echo _CONF_PASSWORD_MATCH; ?>");
			frmEdit.user_password2.focus();
			return false;        		
		}
		return true;
	}
	</script>

	<?php echo (($msg == '') ? $msg_default : $msg); ?>
	<?php draw_content_start(); ?>

	<p style='padding-left:3px;'>
		<?php echo _ALERT_REQUIRED_FILEDS; ?>						
	</p>						
	
	<form action="index.php?customer=my_account" method="post" name="frmEditAccount" id="frmEditAccount">
		<?php draw_hidden_field('task', 'update'); ?>
		<?php draw_token_field(); ?>
		
		<table cellspacing="2" cellpadding="2" width="100%">
		<tbody>
		
		<tr><td colspan="3"><b><?php echo _PERSONAL_DETAILS;?></b><hr size="1" noshade="noshade" /></td></tr>	
		<tr>
			<td width="38%" align="right"><?php echo _FIRST_NAME;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="first_name" name="first_name" size="32" maxlength="32" value="<?php echo decode_text($customer_info['first_name']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _LAST_NAME;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="last_name" name="last_name" size="32" maxlength="32" value="<?php echo decode_text($customer_info['last_name']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _BIRTH_DATE;?></td>
			<td>&nbsp;</td>
			<td>
				<?php echo draw_date_select_field('birth_date', $customer_info['birth_date'], '90', '0', false); ?>
			</td>
		</tr>
		<tr>
			<td align="right"><?php echo _COMPANY;?></td>
			<td>&nbsp;</td>
			<td nowrap="nowrap"><input type="text" id="company" name="company" size="32" maxlength="128" value="<?php echo decode_text($customer_info['company']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _WEB_SITE;?></td>
			<td>&nbsp;</td>
			<td nowrap="nowrap"><input type="text" id="url" name="url" size="32" maxlength="255" value="<?php echo decode_text($customer_info['url']);?>" /></td>
		</tr>

		<tr><td colspan="3"><b><?php echo _BILLING_ADDRESS;?></b><hr size="1" noshade="noshade" /></td></tr>		    
		<tr>
			<td align="right"><?php echo _ADDRESS;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="b_address" name="b_address" size="32" maxlength="64" value="<?php echo decode_text($customer_info['b_address']);?>" /></td>
		</tr>	
		<tr>
			<td align="right"><?php echo _ADDRESS_2;?></td>
			<td>&nbsp;</td>
			<td nowrap="nowrap"><input type="text" id="b_address_2" name="b_address_2" size="32" maxlength="64" value="<?php echo decode_text($customer_info['b_address_2']);?>" /></td>
		</tr>	
		<tr>
			<td align="right"><?php echo _CITY;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="b_city" name="b_city" size="32" maxlength="64" value="<?php echo decode_text($customer_info['b_city']);?>" /></td>
		</tr>	
		<tr>
			<td align="right"><?php echo _ZIP_CODE;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="b_zipcode" name="b_zipcode" size="32" maxlength="32" value="<?php echo decode_text($customer_info['b_zipcode']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _COUNTRY;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap">			
				<?php
					Countries::DrawAllCountries('b_country', ((!empty($b_country)) ? $b_country : $customer_info['b_country']), true);
				?>
			</td>
		</tr>	
		<tr>
			<td align="right"><?php echo _STATE_PROVINCE;?></td>
			<td></td>
			<td nowrap="nowrap"><input type="text" id="b_state" name="b_state" size="32" maxlength="64" value="<?php echo decode_text($customer_info['b_state']);?>" /></td>
		</tr>					

		<tr><td height="20" colspan="3"><b><?php echo _CONTACT_INFORMATION;?></b><hr size="1" noshade="noshade" /></td></tr>
		<tr>
			<td align="right"><?php echo _PHONE;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="text" id="phone" name="phone" size="32" maxlength="32" value="<?php echo decode_text($customer_info['phone']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _FAX;?></td>
			<td></td>
			<td nowrap="nowrap"><input type="text" id="fax" name="fax" size="32" maxlength="32" value="<?php echo decode_text($customer_info['fax']);?>" /></td>
		</tr>
		<tr>
			<td align="right"><?php echo _EMAIL_ADDRESS;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap">				 
				<?php echo _ENTER_EMAIL_ADDRESS;?>
				<br />
				<input type="text" id="email" name="email" size="32" maxlength="70" value="<?php echo decode_text($customer_info['email']);?>" />
			</td>
		</tr>

		<tr><td colspan="3"><b><?php echo _ACCOUNT_DETAILS;?></b><hr size="1" noshade="noshade" /></td></tr>
		<tr>
			<td align="right"><?php echo _PREFERRED_LANGUAGE;?></td>
			<td></td>
			<td nowrap="nowrap"><?php echo Languages::GetAllActiveSelectBox('', $customer_info['preferred_language']);?></td>
		</tr>		    
		<?php
			if($customer_info['group_id'] != 0){						
				echo '<tr><td align="right">'._CUSTOMER_GROUP.'</td><td class="mandatory_star"></td><td nowrap="nowrap"><label>';
				echo $arr_groups[$customer_info['group_id']];
				echo '</label></td></tr>';
			}
		?>		
		<tr>
			<td align="right"><?php echo _USERNAME;?></td>
			<td></td>
			<td nowrap="nowrap"><label><?php echo decode_text($customer_info['user_name']);?></label></td>
		</tr>		    
		<tr>
			<td align="right"><?php echo _PASSWORD;?></td>
			<td><span class="mandatory_star">*</span></td>
			<td nowrap="nowrap"><input type="password" id="user_password1" name="user_password1" size="32" maxlength="20" value="" /></td>
		</tr>		    
		<tr>
			<td align="right"><?php echo _CONFIRM_PASSWORD;?></td>
			<td class="mandatory_star">*</td>
			<td nowrap="nowrap"><input type="password" id="user_password2" name="user_password2" size="32" maxlength="20" value="" /></td>
		</tr>

		<tr><td colspan="3" nowrap height="7px"></td></tr>
		<tr>
			<td colspan="3" align="left">
			<table>					
			<tr valign="top">
				<td align="right"><input type="checkbox" name="send_updates" id="send_updates" <?php echo (($customer_info['email_notifications'] == '1') ? 'checked="checked"' : '');?> value="1"></td>
				<td>&nbsp;</td>
				<td><?php echo _NOTIFICATION_MSG; ?></td>
			</tr>					
			</table>
			</td>
		</tr>

		<tr>
			<td colspan="3" align="center">
				<br /><br />
				<input type="submit" class="form_button" name="btnSubmitPD" id="btnSubmitPD" value="<?php echo _BUTTON_UPDATE; ?>" onclick="return btnSubmitPD_OnClick()">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
			<td colspan="3" align="right">
				<hr size="1" noshade="noshade" />
				<input type="button" class="form_button" name="btnRemoveAccount" id="btnRemoveAccount" value="<?php echo _REMOVE_ACCOUNT; ?>" onclick="javascript:appGoTo('customer=remove_account');" />
			</td>
		</tr>

		</table>
	</form>

	<script type="text/javascript">
	appSetFocus("<?php echo $focus_field; ?>");
	</script>
	<?php draw_content_end(); ?>

<?php
} else{
	draw_title_bar(prepare_breadcrumbs(array(_CUSTOMERS=>'')));
	draw_important_message(_NOT_AUTHORIZED);
}
?>