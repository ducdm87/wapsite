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

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Database settings</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php
//                              mysql:dbname=resume;host=localhost
                                $connectionString = Yii::app()->db->connectionString;
                                $dbname = preg_replace('/^.*?dbname=([^; ]+).*?$/is', '$1', $connectionString);
                                $host = preg_replace('/^.*?host=([^; ]+).*?$/is', '$1', $connectionString);
                                ?>
                                <?php echo buildHtml::renderField("text", "config[database][hostname]", $host, "Hostname", null, "", 4, 8); ?>
                                <?php echo buildHtml::renderField("text", "config[database][username]", Yii::app()->db->username, "Username", null, "", 4, 8); ?>
                                <?php echo buildHtml::renderField("text", "config[database][databasename]", $dbname, "Database", null, "", 4, 8); ?>
                                <?php echo buildHtml::renderField("text", "config[database][prefix]", Yii::app()->db->tablePrefix, "Database Prefix", null, "", 4, 8); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Other settings</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderField("text", "config[main][adminEmail]", Yii::app()->params->adminEmail, "adminEmail", null, "", 4, 8); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Permission</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderList("radio", "Enable Permission", "config[main][permission]", array(array(1, 'Yes'), array(0, 'No')), Yii::app()->params->permission, null, 4, 8); ?>                                
                                <?php echo buildHtml::renderList("radio", "Require author edit", "config[main][copyright]", array(array(1, 'Yes'), array(0, 'No')), Yii::app()->params->copyright, null, 4, 8); ?>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-item">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Session settings</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderField("text", "config[backend][sessionlifetime]", $this->detectConfig('backend', 'timeout', 'params'), "Session lifetime(s)", null, "", 4, 8); ?>
                                <?php echo buildHtml::renderField("text", "config[backend][sessionlifetime2]", $this->detectConfig('backend', 'timeout2', 'params'), "Lifetime remember(s)", null, "", 4, 8); ?>                            
                                <?php
                                $session_name = $this->detectConfig('backend', 'sessionName', 'session');
                                md5("back-end-yii:bdasbdabdbasjdaj");
                                $session_name = str_replace('md5', "", $session_name);
                                $session_name = trim($session_name, "\"\'()");
                                ?>
                                <?php echo buildHtml::renderField("text", "config[backend][sessionname]", $session_name, "Session name (md5)", null, "", 4, 8); ?>
                            </div>
                        </div>
                    </div>
                </div> 

            </div>    
            <div class="tab-item" style="overflow: hidden;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Session settings</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderField("text", "config[site][sessionlifetime]", $this->detectConfig('frontend', 'timeout', 'params'), "Session lifetime(s)", null, "", 4, 8); ?>
                                <?php echo buildHtml::renderField("text", "config[site][sessionlifetime2]", $this->detectConfig('frontend', 'timeout2', 'params'), "Lifetime remember(s)", null, "", 4, 8); ?>
                                <?php
                                $session_name = $this->detectConfig('frontend', 'sessionName', 'session');
                                md5("back-end-yii:bdasbdabdbasjdaj");
                                $session_name = str_replace('md5', "", $session_name);
                                $session_name = trim($session_name, "\"\'()");
                                $siteoffline = $this->detectConfig('frontend', 'siteoffline', 'params');
                                ?>
                                <?php echo buildHtml::renderField("text", "config[site][sessionname]", $session_name, "Session name (md5)", null, "", 4, 8); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>Site Offline</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderList("radio", "Site Offline", "config[site][offline]", array(array('1', 'Yes'), array('0', 'No')), $siteoffline, null, 4, 8); ?>
                                <?php echo buildHtml::renderField("textarea", "config[site][offlinemessage]", $this->detectConfig('frontend', 'offlineMessage', 'params'), "Offline Message", null, "", 4, 8); ?>                                
                            </div>
                        </div>
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span><b>SEF</b></span>                            
                            </div>
                            <div class="panel-body">
                                <?php echo buildHtml::renderList("radio", "Enable sef", "config[site][sef]", array(array(1, 'Yes'), array(0, 'No')), $this->detectConfig('frontend', 'sef', 'params'), null, 4, 8); ?>
                                <?php echo buildHtml::renderList("radio", "Use url suffix", "config[site][sef_suffix]", array(array(1, 'Yes'), array(0, 'No')), $this->detectConfig('frontend', 'sef_suffix', 'params'), null, 4, 8); ?>                                
                                <?php echo buildHtml::renderField("text", "config[site][sef_urlsuffix]", $this->detectConfig('frontend', 'sef_urlsuffix', 'params'), "url suffix", null, "", 4, 8); ?>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>


        </div>
    </div>
</form>

