
<form action="<?php echo Router::buildLink('menus', array("view"=>"menuitem")) ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel panel-primary">             
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Name</label>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control title-generate" value="<?php echo $item->title; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Alias</label>
                        <div class="col-md-9">
                            <input type="text" name="alias" class="form-control alias-generate" value="<?php echo $item->alias; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Menu Type</label>
                        <div class="input-group left col-md-9 btn-group-lg">
                            <input type="text" name="menu_type" class="form-control" placeholder="" value='<?php echo isset($item->params->app)?$item->params->app:""; ?>' >
                            <span class="input-group-btn">
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeMenutype">Change Menu Type</button>
                            </span>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Display in</label>
                        <div class="col-md-9"><?php echo $list['menuID']; ?></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Link</label>
                        <div class="col-md-9"> 
                            <input <?php if(isset($item->params->app) AND $item->params->app !== "System") echo 'readonly="true"'; ?> id='field_link' type="text" name="link" class="form-control" value="<?php echo $item->link; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Status</label>
                        <div class="col-md-9"><?php echo buildHtml::choseStatus("status", $item->status); ?></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Parent Item</label>
                        <div class="col-md-9"><?php echo $list['parentID']; ?></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label left col-md-3">Ordering</label>
                        <div class="col-md-9"><?php echo $list['ordering']; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                     <ul class="nav nav-tabs nav-pills">
                        <li class="active"><a data-toggle="tab" href="#param-advance" id="title-param-custome">Advance<small>(Custome)</small></a></li>           
                        <li><a data-toggle="tab" href="#param-sys">Parameters <small>(System)</small></a></li>
                         
                      </ul>
                      <div class="tab-content">
                            <div id="param-advance" class="tab-pane fade in active" style="padding: 10px;">
                                Parameters Custome
                            </div> 

                            <div id="param-sys" class="tab-pane fade in">                                
                                Browser Page Title                                
                                Page Class
                                Meta Description                                
                                Meta Keywords
                            </div>
                      </div>
                </div>
            </div>
        </div>
    </div> 
    
    <input type="hidden" id='params_app' name="params[app]" value="<?php echo isset($item->params->app)?$item->params->app:""; ?>">    
    <input type="hidden" id='params_view' name="params[view]" value="<?php echo isset($item->params->view)?$item->params->view:""; ?>">    
    <input type="hidden" id='params_layout' name="params[layout]" value="<?php echo isset($item->params->layout)?$item->params->layout:""; ?>">    
    <input type="hidden" id='type' name="type" value="<?php echo $item->type; ?>">    
    
    <input type="hidden" name="id" value="<?php echo $item->id; ?>">    
    <input type="hidden" name="cid[]" value="<?php echo $item->id; ?>">    
</form>


<div class="modal fade" id="changeMenutype" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadExtentionLabel">
    <div class='model-blind'></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 id="myModalLabel" class="modal-title">Menu Item Type</h4>
            </div>
            <div class="modal-body">
                <div class="panel-group panel-items-app">
                 <?php
                $list_app = $list['apps'];
                 foreach($list_app as $_item){
                     ?>
                        <div class="panel panel-primary panel-item" rel="<?php echo $_item['name']; ?>">
                          <div class="panel-heading">
                              <span><b><?php echo $_item['title']; ?></b></span>
                              <div class="caption pull-right">
                                <i class="fa fa-sm fa-chevron-down btn-arrow" type="button"></i>
                            </div>
                          </div>                          
                          <div class="panel-body">
                              <?php
                              echo '<ul>';
                              if(isset($_item['views']) AND count($_item['views'])>0){
                                  foreach($_item['views'] as $_view){
                                      if(isset($_view->layouts)){
                                          foreach($_view->layouts as $_layout){
                                              $desc = $_layout->desc != ""?$_layout->desc:$_view->desc;
                                              echo '<li title="'.$_layout->title.'" onclick="setmenutype(\''.$_item['name'].'\',\''.$_view->name.'\',\''.$_layout->value.'\')">';
                                                    echo '<a>'.$_view->title . ' - ' .$_layout->title. '<small class="muted">'.$desc.'</small> </a>';
                                                echo '</li>';
                                          }
                                      }else{
                                          echo '<li title="'.$_view->title.'" onclick="setmenutype(\''.$_item['name'].'\',\''.$_view->name.'\',\'\')">';
                                            echo '<a>'.$_view->title. '<small class="muted">'.$_view->desc.'</small> </a>';
                                        echo '</li>';
                                      }                                    
                                  }
                              }
                              echo '</ul>';
                              ?>
                          </div>
                        </div>

                     <?php
                 }
               ?>
                </div>
            </div>
       </div>
    </div>
</div>
<script type="text/javascript">
    var link_load_config_menu = "<?php echo Router::buildLink('menus', array("view"=>"menuitem","layout"=>'loadconfigmenuitem')) ?>";
    <?php
    if($item->id !=0 AND is_object($item->params)){ 
        if(isset($item->params->app) AND isset($item->params->view)){ ?>
        loadConfigFile('<?php echo $item->params->app; ?>', '<?php echo $item->params->view ?>');
        <?php } } ?>
    
</script>
 