<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form name="adminForm" action="" method="post">
    <div id="list-config">
        <ul class="JQtabs" rel="trash-detail" reldetail="tab-item">
            <li rel="0">System</li>
            <li rel="1">Backend</li>
            <li rel="2">Site</li>
        </ul>
        <div class="JQtabs-detail" id="trash-detail">
            <div class="tab-item">
                <table>
                    <tr style="vertical-align: top;">
                        <td class="width-60">
                            <fieldset class="adminform">
                                <legend>Database settings</legend>
                                <table class="admintable" cellspacing="1">
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_host"> Hostname </label> </td>
                                        <?php
//                                        mysql:dbname=resume;host=localhost
                                            $connectionString = Yii::app()->db->connectionString;
                                            $dbname = preg_replace('/^.*?dbname=([^; ]+).*?$/is', '$1', $connectionString);
                                            $host = preg_replace('/^.*?host=([^; ]+).*?$/is', '$1', $connectionString);
                                        ?>
                                        <td> <input type="text" value="<?php echo $host; ?>" size="40" class="inputbox" id="config_database_host" name="config[database][hostname]"> </td>
                                    </tr>
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_username"> Username </label> </td>
                                        <td> <input type="text" value="<?php echo Yii::app()->db->username; ?>" size="40" class="inputbox" id="config_database_username" name="config[database][username]"> </td>
                                    </tr>
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_databasename"> Database </label> </td>
                                        <td> <input type="text" value="<?php echo $dbname; ?>" size="40" class="inputbox" id="config_database_databasename" name="config[database][databasename]"> </td>
                                    </tr>
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_prefix"> Database Prefix </label> </td>
                                        <td> <input type="text" value="<?php echo Yii::app()->db->tablePrefix; ?>" size="40" class="inputbox" id="config_database_prefix" name="config[database][prefix]"> </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td class="width-40">
                                <fieldset class="adminform">
                                <legend>Other settings</legend>
                                <table class="admintable" cellspacing="1">
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_host"> adminEmail </label> </td>
                                        <td> <input type="text" value="<?php echo Yii::app()->params->adminEmail; ?>" size="40" class="inputbox" id="config_other_adminEmail" name="config[other][adminEmail]"> </td>
                                    </tr>                                    
                                </table>
                            </fieldset>                                
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-item"> 
                <table>
                    <tr style="vertical-align: top;">                    
                        <td class="width-70">
                            <fieldset class="adminform">
                                <legend>Session settings</legend>
                                <table class="admintable" cellspacing="1">
                                    <tr>
                                        <td width="250" class="key"> <label for="config_database_host"> Session lifetime </label> </td>
                                        <td> <input type="text" value="<?php echo Yii::app()->params->timeout; ?>" size="40" class="inputbox" id="config_bk_session_lifetime" name="config[backend][sessionlifetime]"> </td>
                                    </tr>                    
                                    <tr>
                                        <td width="250" class="key"> <label for="config_database_host"> Session name (md5) </label> </td>
                                        <?php
                                        $session_name = $this->detectConfig('backend','sessionName','session');
                                        md5("back-end-yii:bdasbdabdbasjdaj");
                                        $session_name = str_replace('md5', "", $session_name);
                                        $session_name = trim($session_name, "\"\'()");
                                        ?>
                                        <td> <input type="text" value="<?php echo $session_name; ?>" size="40" class="inputbox" id="config_bk_session_name" name="config[backend][sessionname]"> </td>
                                    </tr>                    
                                </table>
                            </fieldset>
                        </td>
                        <td class="width-30"></td>
                    </tr>
                </table>  
            </div>    
            <div class="tab-item"> 
                <table>
                    <tr style="vertical-align: top;">                    
                        <td class="width-50">
                            <fieldset class="adminform">
                                <legend>Session settings</legend>
                                <table class="admintable" cellspacing="1">
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_host"> Session lifetime </label> </td>
                                        <td> <input type="text" value="<?php echo $this->detectConfig('frontend','timeout','params'); ?>" size="40" class="inputbox" id="config_site_session_lifetime" name="config[site][sessionlifetime]"> </td>
                                    </tr>                    
                                    <?php
                                        $session_name = $this->detectConfig('frontend','sessionName','session');
                                        md5("back-end-yii:bdasbdabdbasjdaj");
                                        $session_name = str_replace('md5', "", $session_name);
                                        $session_name = trim($session_name, "\"\'()");
                                       $siteoffline =  $this->detectConfig('frontend','siteoffline','params');
                                    ?>
                                    <tr>
                                        <td width="150" class="key"> <label for="config_database_host"> Session name (md5) </label> </td>
                                        <td> <input type="text" value="<?php echo $session_name; ?>" size="40" class="inputbox" id="config_site_session_name" name="config[site][sessionname]"> </td>
                                    </tr>                    
                                </table>
                            </fieldset>
                        </td>
                        <td class="width-50">
                            <fieldset class="adminform">
                                <legend>Site settings</legend>
                                <table class="admintable" cellspacing="1">
                                    <tr>
                                        <td width="150" class="key"> <label> Site Offline </label> </td>
                                        <td> 
                                            <input type="radio" value="0" <?php if($siteoffline == 0 ) echo 'checked=""'; ?> class="inputbox" name="config[site][offline]" id="offline0" />  <label for="offline0">No</label>                                        
                                            <input type="radio" value="1" <?php if($siteoffline == 1 ) echo 'checked=""'; ?>class="inputbox" name="config[site][offline]" id="offline1">   <label for="offline1">Yes</label>
                                        </td>
                                    </tr>                    
                                    <tr>
                                        <td width="150" class="key"> <label for="config_site_offlinemessage"> Offline Message  </label> </td>
                                        <td> 
                                            <textarea type="text" rows="3" cols="50" class="inputbox" id="config_site_offlinemessage" name="config[site][offlinemessage]"><?php echo $this->detectConfig('frontend','offlineMessage','params'); ?></textarea>
                                        </td>
                                    </tr>                    
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </div>    
        </div>
    </div>
</form>

