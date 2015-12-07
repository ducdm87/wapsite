<div class="module row form-custom-css form-resource-edit">
    <form action="<?php echo Router::buildLink("permission"); ?>" method="post" name="adminForm">
        <input type="hidden" name="id" value="<?php echo $item->id ?>"/>
        <div class="panel"> 
            <div class="panel-body">
                <div class="col-md-7">
                    <?php echo buildHtml::renderField("label", "parentID", $lists['parentID'], "Parent", "field-short field-introduct"); ?>
                    <?php echo buildHtml::renderField("text", "title", $item->title, "Name", "field-short field-introduct"); ?>
                    <?php echo buildHtml::renderList("radio", "Affected Area", "affected", $lists['affected'], $item->affected, " field-introduct "); ?>
                    <?php echo buildHtml::renderList("radio", "Type", "type", $lists['type'], $item->type, " field-introduct "); ?>
                    <?php echo buildHtml::renderField("label", "app", $lists['apps'], "App", "field-verylong field-introduct"); ?>
                    <?php echo buildHtml::renderField("text", "params", $item->params, "Params", "field-verylong field-introduct"); ?>
                    <?php echo buildHtml::renderField("text", "redirect_url", $item->redirect_url, "Redirect URL", "field-verylong field-introduct"); ?>
                    <?php echo buildHtml::renderField("text", "redirect_msg", $item->redirect_msg, "Redirect Message", "field-verylong field-introduct"); ?>                    
                    <?php echo buildHtml::renderField("textarea", "description", $item->description, "Description", "field-long"); ?>
                    <?php echo buildHtml::renderList("radio", "Published", "status", $lists['status'], $item->status, " "); ?>
                </div> 
                <div class="col-md-5">
                    <div class="node_introduct_fields">
                        <div class="node_introduct_field node_parentID">
                            <h2>Parent Node</h2>
                            Select a resource in this select box which will be the parent node of this resource.
                            <br>
                            This will help you to:
                            <br>
                            <ul>
                                <li>easier to organize your resources</li>
                                <li>Use the benefit of "Sticky" feature</li>
                            </ul>
                        </div>
                        <div class="node_introduct_field node_title">
                            <h2>Resource Name</h2>
                            This name will be displayed in the Resource Tree. 
                        </div>
                        <div class="node_introduct_field node_affected">
                            <h2>Affected Area</h2>
                            You can define a resource in back-end, fron-end or both of them.<br>
                            There are 3 types:
                            <ul>
                                <li><b>Back-end</b>: This resource is used only in back-end.</li>
                                <li><b>Front-end</b>: This resource is used only in front-end.</li>
                                <li><b>Both of 2 sides</b>: This resource is used in both of back-end and front-end.</li>
                            </ul>
                        </div>
                        <div class="node_introduct_field node_type">
                            <h2>Type</h2
                            <ul>
                                <li><b>Request</b>: What variable you see in the urls and the from are in Request.</li>
                                <li><b>Label</b>: Use this type when you just want to define a node for easier to organize your Resources Tree. 
                                    This won't be processed when the system runs. 
                                    If you select this, you won't need to fill the below information like "app", "params"...etc
                                </li>
                            </ul>		
                        </div>
                        <div class="node_introduct_field node_params_app">
                            <h2>App</h2>app's values are application. 
                            If you selected the Type's value above is <i>Request</i>, 
                            then now you must select a application. If not, the system will pass this resource.
                        </div>
                        <div class="node_introduct_field node_params">
                            <h2>Params</h2>
                            <p>Here you can define all variable you can catch in the REQUEST array (variables in url and form)</p>
                            <p>You can use these expressions to define your resource: <b>(</b>, <b>)</b>, <b>|</b>, <b>&amp;</b></p>
                            <p><b>Some examples:</b></p>
                            <p>view=article&amp;id=5<br>
                                This will define a resource, which is an article with id is #5</p>
                            <p>view=article&amp;(id=5|id=6)<br>This will define a resource, which can be two articles with id is #5 or #6</p>                            		
                        </div>
                         <div class="node_introduct_field node_redirect_url">
                            <h2>Redirect URL</h2>
                            <p>If an user is not allow to access this resource, he(she) will be redirected to this url</p>
                        </div>
                        <div class="node_introduct_field node_redirect_msg">
                            <h2>Redirect Message</h2>
                            <p>If an user is redirected to the above url, this is the redirect message</p>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </form>
</div>

