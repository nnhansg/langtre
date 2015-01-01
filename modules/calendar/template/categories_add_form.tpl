<fieldset class='cal_fieldset'>
{h:legend}
<table class='fieldset_content' align='center' border='0'>
<tr valign='top'>
    <td width='30%' align='right'>{h:lan_cat_name}:</td>
    <td>&nbsp;</td>
    <td align='left'><input type='text' style='width:400px' id='category_name' name='category_name' maxlength='50' /></td>
</tr>
<tr valign='top'>
    <td align='right'>{h:lan_cat_description}:</td>
    <td></td>
    <td align='left'><textarea style='width:400px; height:65px;' id='category_description' name='category_description'></textarea></td>
</tr>
<tr valign='top'>
    <td align='right'>{h:lan_cat_color}</td>
    <td></td>
    <td>{h:ddl_colors}</td>
</tr>
<tr valign='middle'>
    <td align='right'>{h:lan_duration}:</td>
    <td></td>
    <td align='left'>{h:ddl_durations}</td>
</tr>
<tr><td align='center' colspan='3' style='height:30px;padding:0px;'><div id='divCategoriesAdd_msg'></div></td></tr>
<tr>
    <td align='center' colspan='3'>
        <input class='form_button' type='button' name='btnSubmit' value='{h:lan_add_category}' onclick='javascript:__CategoriesAdd();' />
        &nbsp;- {h:lan_or} -&nbsp;
        <a class='form_cancel_link' name='lnkCancel' href='javascript:void(0);' onclick='javascript:__CategoriesCancel();'>{h:lan_cancel}</a>
    </td>
</tr>
</table>
</fieldset>

<script type='text/javascript'>
<!--
__SetFocus('category_name');
//-->
</script>