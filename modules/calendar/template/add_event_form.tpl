<div id="divAddEvent" style="left:200px; top:100px;">
    <table id="divAddEvent_Header" width='100%'>				
    <tr>
        <td>						
            <table class='header{h:class_move}'>
            <tr>
                <td align='left'><b>{h:lan_add_new_event}</b></td>
                <td align='right'><a href="javascript:__HideEventForm('divAddEvent');">[{h:lan_close}]</a></td>						
            </tr>
            </table>					
        </td>					
    </tr>
    </table>
    
    <table width='100%' border='0' align='right'>				
    <tr>
        <td align='left'>{h:lan_event_name}:</td>
        <td align='left'>
            <input type='radio' id='sel_event_new' name='sel_event' value='new' checked='checked' onclick='javascript:__EventSelectedDDL(1);' />
            <input type='text' style='width:225px' id='event_name' name='event_name' maxlength='70' /><br />
        </td>
    </tr>
    <tr>
        <td align='left'></td>
        <td align='left'>
            <input type='radio' id='sel_event_current' name='sel_event' value='current' onclick='javascript:__EventSelectedDDL(2);' />
            {h:ddl_event_name}{h:ddl_category_name}
        </td>
    </tr>
    <tr>
        <td align='left' valign='top' width='95px' wrap='wrap'>{h:lan_event_description}:</td>
        <td align='center'><textarea style='width:240px; height:50px;' id='event_description' name='event_description'></textarea></td>
    </tr>
    <tr>
        <td align='left'>{h:lan_from}:</td>
        <td align='center' nowrap='nowrap'>{h:ddl_from}</td>
    </tr>
    <tr>
        <td align='left'>{h:lan_to}:</td>
        <td align='center' nowrap='nowrap'>{h:ddl_to}</td>
    </tr>
    <tr><td colspan='2' align='center' style='height:25px;padding:0px;'><div id='divAddEvent_msg'></div></td></tr>
    <tr><td colspan='2' align='right' style='padding-right:12px;'><input class='form_button' type='button' name='btnSubmit' value='{h:lan_add_event}' onclick='javascript:__AddEvent();'/></td></tr>
    </table>
</div>