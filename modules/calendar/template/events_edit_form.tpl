<fieldset class='cal_fieldset'>
<legend class='cal_legend bold'>{h:lan_edit_event}</legend>
<table class='fieldset_content' align='center' border='0' cellspacing='4'>
<tr valign='middle'>
    <td width='30%' align='right'>{h:lan_event_name}:</td>
    <td>&nbsp;</td>
    <td align='left'><input type='text' style='width:400px' id='event_name' name='event_name' value='{h:event_name}' maxlength='70' /></td>
</tr>
<tr valign='top'>
    <td align='right'>{h:lan_event_description}:</td>
    <td></td>
    <td align='left'><textarea style='width:400px; height:65px;' id='event_description' name='event_description'>{h:event_description}</textarea></td>
</tr>
<tr valign='middle'>
    <td align='right'>{h:lan_category_name}</td>
    <td></td>
    <td align='left'>{h:ddl_categories}</td>
</tr>
<tr valign='top'>
    <td align='right'>{h:lan_event_date}</td>
    <td></td>
    <td align='left'><label type='text'>{h:event_date}</label></td>
</tr>
<tr valign='top'>
    <td align='right'>{h:lan_start_time}</td>
    <td></td>
    <td align='left'><label type='text'>{h:event_time}</label></td>
</tr>
<tr><td colspan='3' align='center' style='height:25px;padding:0px;'><div id='divEventsEdit_msg'></div></td></tr>
<tr>
    <td colspan='3' align='center'>
        <input class='form_button' type='button' name='btnSubmit' value='{h:lan_update_event}' onclick='javascript:__EventsUpdate({h:event_id});'/>
        &nbsp;- {h:lan_or} -&nbsp;
        <a class='form_cancel_link' name='lnkCancel' href='javascript:void(0);' onclick='javascript:__EventsBack();'>{h:lan_cancel}</a>
    </td>
</tr>
</table>
</fieldset>