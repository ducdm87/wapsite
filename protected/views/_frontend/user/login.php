<?php $this->createUrl('user/login'); ?>
<center>        
    <form method="post" action="" class="ui_form">
        <input type="hidden" value="/" name="page" class="ui_hidden">
        <table width="40%" class="shrinkwrapper" id="sortableTableNaN">
            <tbody>
                <tr>
                    <td> </td>
                    <td>
                        <table width="40%" class="ui_table" id="sortableTableNaN">                          
                            <tbody> 
                                <tr class="ui_table_body"> 
                                    <td colspan="1">			
                                        <table width="100%" id="sortableTableNaN">
                                            <tbody>
                                                <tr class="ui_form_pair">
                                                    <td align="center" colspan="2" class="ui_form_value">You must enter a username and password to login to the ...</td>                                                    
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="2" class="ui_form_value"><?php YiiMessage::showMessage(); ?> </td>
                                                </tr>
                                                <tr class="ui_form_pair">
                                                    <td class="ui_form_label"><b>Username</b></td>
                                                    <td colspan="1" class="ui_form_value"><input size="20" value="" name="LoginForm[username]" class="ui_textbox"></td>
                                                </tr>
                                                <tr class="ui_form_pair">
                                                    <td class="ui_form_label"><b>Password</b></td>
                                                    <td colspan="1" class="ui_form_value"><input type="password" size="20" value="" name="LoginForm[password]" class="ui_password"></td>
                                                </tr>
                                                <tr class="ui_form_pair">
                                                    <td class="ui_form_label"><b> </b></td>
                                                    <td colspan="1" class="ui_form_value"><input type="checkbox" id="save_1" value="1" name="LoginForm[rememberMe]" class="ui_checkbox"> 
                                                        <label for="save_1">Remember login permanently?</label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="Login" class="ui_submit">
        <input type="reset" value="Clear">            
    </form>
</center>

