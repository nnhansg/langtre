<fieldset class='cal_fieldset'>
{h:legend}
<table class='fieldset_content' align='center' border='0'>
<tr>
    <td valign='top' align='left'>
        <table align='center' border='0' width='325px'>
        <tr valign='top'>
            <td align='left'>
                {h:lan_event_name}:<br />
                <input type='text' style='width:320px' id='event_name' name='event_name' maxlength='70' />
            </td>
        </tr>
        <tr valign='top'>
            <td align='left'>
                {h:lan_event_description}:<br />
                <textarea style='width:320px; height:65px;' id='event_description' name='event_description'></textarea>
            </td>
        </tr>
        </table>
    </td>
    <td width='30px' nowrap='nowrap'></td>
    <td valign='top'>
        <table align='left' border='0' width='350px'>				
        <tr>
            <td colspan='3' align='left'>
                {h:lan_category_name}
                {h:ddl_categories}
            </td>
        </tr>
        <tr><td colspan='3' align='left' nowrap='nowrap' height='9px'></td></tr>
        <tr>
            <td colspan='3' align='left'>
                <input type="radio" class="btn_radio" name="event_insertion_type" value="1" checked="checked" onclick="__EventInsertionType(1)" /> {h:lan_add_event_to_list}
                <br />
                <input type="radio" class="btn_radio" name="event_insertion_type" value="2" onclick="__EventInsertionType(2)" /> {h:lan_add_event_occurrences}
            </td>
        </tr>
        <tr>
            <td colspan='3' align='left'>
                <input type="hidden" id="event_insertion_subtype" name="event_insertion_subtype" value="one_time" />
                <div id='ea_wrapper' style='display:none;width:350px;'>
                <fieldset>
                <legend>
                    <a id="ea_lnk_1" style='font-weight:bold;' href='javascript:void(0);' onclick='javascript:__switchElements("ea_one_time", "ea_repeatedly", "1", "ea_lnk_1", "ea_lnk_2", "event_insertion_subtype", "one_time")'>[{h:lan_one_time}]</a>
                    <a id="ea_lnk_2" href='javascript:void(0);' onclick='javascript:__switchElements("ea_one_time", "ea_repeatedly", "2", "ea_lnk_1", "ea_lnk_2", "event_insertion_subtype", "repeat")'>[{h:lan_repeatedly}]</a>
                </legend>
                <div id='ea_one_time' style='display:;padding:5px;'>
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
                </div>
                <div id='ea_repeatedly' style='display:none;padding:5px;'>
                    <table border=0>
                    <tr valign='top'>
                        <td align='right' nowrap='nowrap'>{h:lan_from}:</td>
                        <td></td>
                        <td align='left' nowrap='nowrap'>{h:ddl_from_date}</td>
                    </tr>
                    <tr valign='top'>
                        <td align='right' nowrap='nowrap'>{h:lan_to}:</td>
                        <td></td>
                        <td align='left' nowrap='nowrap'>{h:ddl_to_date}</td>
                    </tr>                
                    <tr valign='top'>
                        <td align='right' nowrap='nowrap'>{h:lan_hours}:</td>
                        <td></td>
                        <td align='left' nowrap='nowrap'>{h:ddl_from_time} - {h:ddl_to_time}</td>
                    </tr>
                    <tr><td colspan='3' nowrap height='5px'></td></tr>
                    <tr valign='top'>
                        <td colspan='3'>
                            {h:lan_repeat_every}:<br />
                            <input type='checkbox' name='repeat_sun' />{h:lan_sun}
                            <input type='checkbox' name='repeat_mon' />{h:lan_mon}
                            <input type='checkbox' name='repeat_tue' />{h:lan_tue}
                            <input type='checkbox' name='repeat_wed' />{h:lan_wed}
                            <input type='checkbox' name='repeat_thu' />{h:lan_thu}
                            <input type='checkbox' name='repeat_fri' />{h:lan_fri}
                            <input type='checkbox' name='repeat_sat' />{h:lan_sat}
                        </td>
                    </tr>                
                    </table>
                </div>
                </fieldset>
                </div>
            </td>
        </tr>
        </table>
    </td>
</tr>  
<tr><td align='center' colspan='3' style='height:30px;padding:0px;'><div id='divEventsAdd_msg'></div></td></tr>
<tr>
    <td align='center' colspan='3'>
        <input class='form_button' type='button' name='btnSubmit' value='{h:lan_add_event}' onclick='javascript:__EventsAdd();' />
        &nbsp;- {h:lan_or} -&nbsp;
        <a class='form_cancel_link' name='lnkCancel' href='javascript:void(0);' onclick='javascript:__EventsCancel();'>{h:lan_cancel}</a>
    </td>
</tr>
</table>
</fieldset>

<script type='text/javascript'>
<!--
__SetFocus('event_name');
//-->
</script>