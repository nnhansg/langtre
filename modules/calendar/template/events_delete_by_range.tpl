<fieldset class='cal_fieldset'>
{h:legend}
<table class='fieldset_content' align='center' border='0'>
<tr valign='top'>
    <td align='right'>
        <table border=0>
        <tr valign='top'>
            <td align='right' nowrap='nowrap'>{h:lan_from}:</td>
            <td></td>
            <td align='right' nowrap='nowrap'>{h:ddl_from}</td>
        </tr>
        <tr valign='top'>
            <td align='right' nowrap='nowrap'>{h:lan_to}:</td>
            <td></td>
            <td align='right' nowrap='nowrap'>{h:ddl_to}</td>
        </tr>
        </table>
    </td>
    <td width='20px'></td>
    <td align='left'>
        {h:lan_category_name}
        {h:ddl_categories}
    </td>
</tr>
<tr><td colspan='3' align='center' style='height:30px;padding:0px;'><div id='divEventsDeleteByRange_msg'></div></td></tr>
<tr>
    <td colspan='3' align='center'>
        <input class='form_button' type='button' name='btnSubmit' value='{h:lan_delete_events}' onclick='javascript:__EventsDeleteByRange();'/>
        &nbsp;- {h:lan_or} -&nbsp;
        <a class='form_cancel_link' name='lnkCancel' href='javascript:void(0);' onclick='javascript:__EventsBack();'>{h:lan_cancel}</a>
    </td>
</tr>
</table>
</fieldset>