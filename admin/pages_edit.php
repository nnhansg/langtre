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

if($objLogin->IsLoggedInAsAdmin() && $objLogin->HasPrivileges('edit_pages')){

	$button_align = (Application::Get('lang_dir') == 'ltr') ? 'text-align:right;' : 'text-align:left;';
	$editor_type = $objSettings->GetParameter('wysiwyg_type');
	$nl = "\n";

	// draw title bar
	$page_link_name = ((Application::Get('page_id') != 'home') ? ((Application::Get('type') == 'system') ? _PAGE_EDIT_SYS_PAGES : _EDIT_PAGE) : _PAGE_EDIT_HOME);
	draw_title_bar(
		prepare_breadcrumbs(array(_MENUS_AND_PAGES=>'',_PAGE_MANAGEMENT=>'', $page_link_name=>'')),
		((Application::Get('page_id') != 'home') ? '<a target="_preview_page" href="index.php?page=pages&pid='.$objPage->GetParameter('id').'&preview=yes&preview_type=single">'._PREVIEW.'</a> <img src="images/external_link.gif" alt="">' : '')
	);
	
	if($objSession->IsMessage('notice')) echo $objSession->GetMessage('notice');
	else echo $msg;

	draw_content_start();			
?>

	<link type="text/css" rel="stylesheet" href="modules/jscalendar/skins/aqua/theme.css" />
	<script type="text/javascript" src="modules/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="modules/jscalendar/lang/calendar-<?php echo ((file_exists('modules/jscalendar/lang/calendar-'.Application::Get('lang').'.js')) ? Application::Get('lang') : 'en'); ?>.js"></script>
	<script type="text/javascript" src="modules/jscalendar/calendar-setup.js"></script>

	<?php if($editor_type == 'openwysiwyg'){ ?>
		<script type="text/javascript" src="modules/wysiwyg/scripts/wysiwyg.js"></script>
		<script type="text/javascript" src="modules/wysiwyg/scripts/wysiwyg-settings.js"></script>
	<?php }else if($editor_type == 'tinymce'){ ?>		
		<script type="text/javascript" src="include/classes/js/microgrid.js"></script>
		<script type="text/javascript" src="modules/tinymce/tiny_mce.js"></script>		
		<script type="text/javascript" src="include/classes/js/microgrid_tinymce.js"></script>		
	<?php } ?>

	<script type="text/javascript">
		function Language_OnChange(val){
			appGoTo('admin=pages_edit<?php echo ((Application::Get('type') != '') ? '&type='.Application::Get('type'): ''); ?>&language_id='+val);
		}

		function Cancel(){
			appGoTo('admin=pages<?php echo ((Application::Get('type') != '') ? '&type='.Application::Get('type'): ''); ?>&mg_language_id=<?php echo $objPage->GetParameter('language_id'); ?>');
		}
	</script>

	<form name="frmPage" method="post" action="index.php?admin=pages_edit<?php echo ((Application::Get('type') != '') ? '&type='.Application::Get('type'): ''); ?>">
		<?php draw_hidden_field('act','edit'); ?>
		<?php draw_hidden_field('pid',Application::Get('page_id')); ?>
		<?php draw_hidden_field('language_id',$objPage->GetParameter('language_id')); ?>
		<?php draw_hidden_field('meta_tags_status','closed',true,'meta_tags_status'); ?>
		<?php draw_token_field(); ?>

		<table id="tblEditPage" width="100%" border="0" cellspacing="4" cellpadding="4">
		<tr>
			<td valign="top" style="border:1px solid #dedede">
				<table width="100%" border="0" cellspacing="0" cellpadding="2" class="main_text">
				<tr>
					<td width="160px"></td>
					<td width="490px"></td>
				</tr>
				<tr>
					<td><?php echo _PAGE_HEADER;?> <span class="required">*</span>:</td>
					<td><input class="form_text" name="page_title" id="frmPage_page_title" value="<?php echo $objPage->GetTitle();?>" size="45" maxlength="255"></td>
				</tr>				
				<tr>
					<td><?php echo _MENU_LINK_TEXT;?>:</td>
					<td><input class="form_text" name="menu_link" value="<?php echo $objPage->GetMenuLink();?>" size="45" maxlength="40"></td>
				</tr>
				<?php if(Application::Get('type') == 'system' && $objPage->GetParameter('system_page') != 'terms_and_conditions'){ ?>
				<tr>
					<td>
						<?php echo _LINK_PARAMETER; ?>: <span class="required">*</span>
						<img class="help" src="images/question_mark.png" alt="" title="URL: index.php?page=pages&system_page=<?php echo $objPage->GetParameter('system_page');?>" />					
					</td>
					<td>
						<input class="form_text" name="system_page" value="<?php echo $objPage->GetParameter('system_page');?>" size="30" maxlength="50">
					</td>
				</tr>
				<?php } ?>		

				<tr id="link_row_1" style="display:none;">
					<td><?php echo _LINK;?> (http://)<span class="required">*</span>:</td>
					<td><input class="form_text" name="link_url" id="frmPage_link_url" value="<?php echo $objPage->GetParameter('link_url');?>" size="50" maxlength="255" /></td>
				</tr>
				<tr id="link_row_2" style="display:none;">
					<td><?php echo _TARGET;?>:</td>
					<td>
						<select name="link_target" id="link_target">
							<option value="_self" <?php echo (($objPage->GetParameter('link_target') == '_self') ? ' selected="selected"' : ''); ?>>_self</option>
							<option value="_blank" <?php echo (($objPage->GetParameter('link_target') == '_blank') ? ' selected="selected"' : ''); ?>>_blank</option>
						</select>
					</td>
				</tr>
				
				<tr><td colspan="2" height="10px"></td></tr>
				<tr id="row_meta_1">
					<td colspan="2" height="10px">
						<div id="meta_show" onclick="javascript:toggle_meta()" style="cursor:pointer; display:;"><?php echo _SHOW_META_TAGS; ?> <a href="javascript:void('show');">+</a></div>
						<div id="meta_close" onclick="javascript:toggle_meta()" style="cursor:pointer; display:none;"><?php echo _CLOSE_META_TAGS; ?> <a href="javascript:void('close');">-</a></div>
					</td>
				</tr>		
				<tr id="row_meta_2" style="display:none;">
					<td><?php echo _TAG;?> &lt;TITLE&gt;:</td>
					<td>
						<textarea class="form_text" name="tag_title" id="frmPage_tag_title" style="width:470px" rows="1"><?php echo $objPage->GetParameter('tag_title'); ?></textarea>
					</td>
				</tr>
				<tr id="row_meta_3" style="display:none;">
					<td><?php echo _META_TAG;?> &lt;KEYWORDS&gt;:</td>
					<td>
						<textarea class="form_text" name="tag_keywords" id="frmPage_tag_keywords" style="width:470px" rows="2"><?php echo $objPage->GetParameter('tag_keywords'); ?></textarea>
					</td>
				</tr>
				<tr id="row_meta_4" style="display:none;">
					<td><?php echo _META_TAG;?> &lt;DESCRIPTION&gt;:</td>
					<td>
						<textarea class="form_text" name="tag_description" id="frmPage_tag_description" style="width:470px" rows="2"><?php echo $objPage->GetParameter('tag_description'); ?></textarea>
					</td>
				</tr>
				<tr><td colspan="2" height="10px"></td></tr>

				<tr id="page_row_1">
					<td><?php echo _PAGE_TEXT;?>:</td>
					<td style="<?php echo $button_align;?>">
						<input class="form_button" type="button" name="butCancel" value="<?php echo _BUTTON_CANCEL; ?>" onclick="Cancel()">&nbsp;&nbsp;			
						<input class="form_button" type="submit" name="subSavePage" value="<?php echo _BUTTON_SAVE_CHANGES ?>">
					</td>
				</tr>
				<tr><td colspan="2" nowrap="nowrap" height="3px"></td></tr>
				<tr id="page_row_2">
					<td colspan="2" align="center">
						<textarea name="page_text" id="my_page_text" rows="20" style="width:100%"><?php echo $objPage->GetText(); ?></textarea>
					</td>
				</tr>
				<tr id="page_row_3" style="display:none;">
					<td colspan="2" nowrap="nowrap" height="131px"></td>
				</tr>
				<tr><td colspan="2" nowrap="nowrap" height="3px"></td></tr>
				<tr>
					<td colspan="2" style="<?php echo $button_align;?>">
						<input class="form_button" type="button" name="butCancel" value="<?php echo _BUTTON_CANCEL; ?>" onclick="Cancel()">&nbsp;&nbsp;
						<input class="form_button" type="submit" name="subSavePage" value="<?php echo _BUTTON_SAVE_CHANGES; ?>">
					</td>
				</tr>
				</table>			
			</td>
			<td valign="top" style="width:270px;border:1px solid #dedede">
				<table width="100%" border="0">				
				<tr>
					<td><?php echo _ARTICLE_ID;?>:</td>
					<td colspan="2"><?php echo $objPage->GetParameter('id');?></td>
				</tr>
				<?php if(Application::Get('page_id') != 'home') { ?>
					<tr>
						<td><b><?php echo _PUBLISHED; ?></b>:</td>
						<td>
							<input type="radio" class="form_radio" name="is_published" id="is_published_no" <?php echo (($objPage->GetParameter('is_published') == '0') ? 'checked="checked"' : ''); ?> value="0" /> <label for="is_published_no"><?php echo _NO; ?></label>
						</td>
						<td nowrap>	
							<input type="radio" class="form_radio" name="is_published" id="is_published_yes" <?php echo (($objPage->GetParameter('is_published') == '1') ? 'checked="checked"' : ''); ?> value="1" /> <label for="is_published_yes"><?php echo _YES; ?></label>
						</td>
					</tr>
				<?php }else{ ?>
					<tr>
						<td colspan="3"><?php draw_hidden_field('is_published', '1', true, 'is_published'); ?></td>
					</tr>
				<?php } ?>				
				<tr><td colspan="3" nowrap="nowrap" height="3px"></td></tr>					
				<tr>
					<td><?php echo _LANGUAGE;?> <span class="required">*</span>:</td>
					<td colspan="2">
						<?php
							// display language
							$total_languages = Languages::GetAllActive();
							if(Application::Get('page_id') != 'home') {
								draw_languages_box('language_id', $total_languages[0], 'abbreviation', 'lang_name', $objPage->GetParameter('language_id'), '', 'disabled="disabled"'); 						
							}else{
								draw_languages_box('language_id', $total_languages[0], 'abbreviation', 'lang_name', $language_id, '', 'onchange="Language_OnChange(this.value)"');
							}
						?>
					</td>			
				</tr>		
				<?php if(Application::Get('page_id') != 'home'){ ?>
					<tr>	
						<td><?php echo _CONTENT_TYPE; ?>:</td>
						<td colspan="2">
							<?php
								echo Menu::DrawContentTypeBox($objPage->GetParameter('content_type'));
							?>
						</td>
					</tr>					                
                <?php } ?>
                
                <?php if(Application::Get('page_id') != 'home' && Application::Get('type') != 'system'){ ?>					
					<tr>
						<td><?php echo _ADD_TO_MENU;?>:</td>
						<td colspan="2">
							<?php Menu::DrawMenuSelectBox($objPage->GetMenuId(), $objPage->GetParameter('language_id')); ?>				
						</td>
					</tr>
					<tr>
						<td><?php echo _ACCESS; ?>:</td>
						<td colspan="2">
							<?php echo Pages::DrawPageAccessSelectBox($objPage->GetParameter('access_level')); ?>
						</td>
					</tr>					
					<?php
					if(Modules::IsModuleInstalled('comments')){
						if(ModulesSettings::Get('comments', 'comments_allow') == 'yes'){ 
							echo '<tr><td nowrap="nowrap">'._ALLOW_COMMENTS.':</td>
							<td nowrap="nowrap">
								<input type="radio" class="form_radio" name="comments_allowed" id="comments_allowed_1" '.(($objPage->GetParameter('comments_allowed') == '0') ? 'checked="checked"' : '').' value="0" /> <label for="comments_allowed_1">'._NO.'</label>
							</td>
							<td>
								<input type="radio" class="form_radio" name="comments_allowed" id="comments_allowed_2" '.(($objPage->GetParameter('comments_allowed') == '1') ? 'checked="checked"' : '').' value="1" /> <label for="comments_allowed_2" id="comments_allowed_3">'._YES.'</label>
							</td></tr>';
						}
					}
					?>
				<?php } ?>
					<tr>
						<td nowrap="nowrap"><?php echo _SHOW_IN_SEARCH;?>:</td>
						<td>
							<input type="radio" class="form_radio" name="show_in_search" id="show_in_search_no" <?php echo (($objPage->GetParameter('show_in_search') == '0') ? 'checked="checked"' : ''); ?> value="0" /> <label for="show_in_search_no"><?php echo _NO; ?></label>
						</td>
						<td>
							<input type="radio" class="form_radio" name="show_in_search" id="show_in_search_yes" <?php echo (($objPage->GetParameter('show_in_search') == '1') ? 'checked="checked"' : ''); ?> value="1" /> <label for="show_in_search_yes"><?php echo _YES; ?></label>
						</td>
					</tr>
				<?php if(Application::Get('page_id') != 'home'){ ?>	
					<tr>
						<td><?php echo _ORDER;?>:</td>
						<td colspan="2">
							<input class="form_text" name="priority_order" value="<?php echo ($objPage->GetParameter('priority_order') == '') ? '0' : $objPage->GetParameter('priority_order'); ?>" size="2" maxlength="4" />
						</td>
					</tr>
					<?php if(Application::Get('type') != 'system'){ ?>
					<tr>
						<td><?php echo _DATE_CREATED;?>:</td>
						<td colspan="2"><?php echo format_datetime($objPage->GetParameter('date_created')); ?></td>
					</tr>
					<?php } ?>
				<?php } ?>				
					<tr>
						<td><?php echo _DATE_MODIFIED;?>:</td>
						<td colspan="2"><?php echo format_datetime($objPage->GetParameter('date_updated'), '', _NEVER); ?></td>
					</tr>
				<?php if(Application::Get('page_id') != 'home' && Application::Get('type') != 'system'){ ?>
                    <tr>
                        <td nowrap="nowrap"><?php echo _FINISH_PUBLISHING;?>:</td>
                        <td colspan="2">
                            <input class="form_text" name="finish_publishing" id="frmPage_finish_publishing" value="<?php echo format_datetime($objPage->GetParameter('finish_publishing'), 'Y-m-d', _NEVER); ?>" size="8" maxlength="10" />
							<img id="finish_publishing_icon" class="calendar_icon" src="images/cal.gif" alt="" />
                        </td>
                    </tr>
				<?php } ?>
				<tr><td colspan="3" style="padding:5px 0"><?php echo draw_line(); ?></td></tr>
				<tr valign="top">
					<td><?php echo _NOTICE_MODULES_CODE;?></td>
					<td colspan="2">
						{module:gallery}<br>
						{module:album=CODE}<br>
						{module:album=CODE:closed}<br>
						{module:rooms}<br>
						{module:about_us}<br>
						{module:contact_us}<br>
						{module:testimonials}<br>
						{module:faq}
					</td>
				</tr>						
				</table>
			</td>
		</tr>
		</table>
	</form>

	<?php if($editor_type == 'openwysiwyg'){ ?>
        <script type="text/javascript">
            var mysettings = new WYSIWYG.Settings();
    
            mysettings.ImagesDir = "modules/wysiwyg/images/";
            mysettings.CSSFile = "modules/wysiwyg/styles/wysiwyg.css";
            mysettings.PopupsDir = "modules/wysiwyg/popups/";
            mysettings.PreviewWidth = "100%";
            mysettings.PreviewHeight = "300px";
            mysettings.Width = "100%";
            mysettings.Height = "300px";
    
            // Default stylesheet of the WYSIWYG editor window
            mysettings.DefaultStyle = "<?php echo (($wysiwyg_dir == 'ltr') ? 'text-align:left;' : 'text-align:right;') ?>font-family: Arial; font-size: 12px; background-color: #FFFFFF";
            // Stylesheet if editor is disabled
            mysettings.DisabledStyle = "<?php echo (($wysiwyg_dir == 'ltr') ? 'text-align:left;' : 'text-align:right;') ?>font-family: Arial; font-size: 12px; background-color: #EEEEEE";
            
            // define the location of the openImageLibrary addon
            mysettings.ImagePopupFile = "modules/wysiwyg/addons/imagelibrary/insert_image.php";
            // define the width of the insert image popup
            mysettings.ImagePopupWidth = 610; 
            // define the height of the insert image popup
            mysettings.ImagePopupHeight = 265;
    
            // Use it to attach the editor to all textareas with full featured setup
            //WYSIWYG.attach('all', full);
            
            // Use it to attach the editor directly to a defined textarea
            WYSIWYG.attach('my_page_text', mysettings); // default setup
            //WYSIWYG.attach('textarea2', full); // full featured setup
            //WYSIWYG.attach('textarea3', small); // small setup
            
            // Use it to display an iframes instead of a textareas
            //WYSIWYG.display('all', full);
        </script>
	<?php }else if($editor_type == 'tinymce'){ ?>		
		<script type='text/javascript'>
			__mgAddListener(this, "load", function() { toggleEditor("1","my_page_text"); }, false);			
		</script>
	<?php } ?>
    
    <script type="text/javascript">	
		<?php
			if($objPage->GetParameter('content_type') == 'link'){ echo 'ContentType_OnChange("link");'.$nl; }
			else if($meta_tags_status == 'opened'){ echo 'toggle_meta();'.$nl; }
		?>		
		appSetFocus("frmPage_<?php echo $objPage->focusOnField; ?>");
		<?php if(Application::Get('page_id') != 'home' && Application::Get('type') != 'system') echo 'Calendar.setup({firstDay:'.($objSettings->GetParameter('week_start_day')-1).', inputField:"frmPage_finish_publishing", ifFormat:"%Y-%m-%d", showsTime:false, button:"finish_publishing_icon"});'; ?>
	</script>

<?php
	draw_content_end();		
}else{
	draw_title_bar(_ADMIN);
	draw_important_message(_NOT_AUTHORIZED);
}
?>