<form action="<?php echo Router::buildLink("users", array("view"=>"group")); ?>" method="post" name="adminForm" >
    <div class="row">
        <div class="panel">            
            <div class="panel-body">
                <div class="row">  
                    <div class="col-lg-7">
                        <input type="text" name="filter_search" value="<?php echo Request::getVar('filter_search', ""); ?>" id="filter_search" /> 
                        <button type="submit" class="btn btn-primary btn-xs">Go</button>
                        <button type="reset" class="btn btn-primary btn-xs" onClick="document.getElementById('filter_search').value = '';
                                this.form.submit();" >Reset</button>
                    </div>
                    <div class="col-lg-5">
                        <?php //echo $lists['filrer_menu']; ?>
                    </div>
                </div>
                <br/>            
                <table class="table table-bordered table-hover table-striped table-responsive">
                    <thead>
                        <tr>
                            <th width="2%"># </th>
                            <th width="2%">
                                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $items ? count($items) : 0; ?>);"> 
                            </th>
                            <th width="50%">Name</th>    
                            <th width="2%">Users</th>    
                            <th width="2%">level</th>    
                            <th width="5%">Site</th>    
                            <th width="5%" align="center">Status</th>
                            <th width="15%">Modified</th>
                            <th width="2%">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        if (isset($items) && $items) {
                            foreach ($items as $i => $item) {
                                $link_edit = Router::buildLink("users", array("view"=>"group",'layout'=>'edit', "cid" => $item['id']));                                
                                $item['name'] = str_repeat("&nbsp; &nbsp; ", $item['level']) . " - " . $item['name'];
                                $link_items = Router::buildLink('users', array("view"=>"user", 'layout'=>'tree','groupID'=>$item['id'])); 
                                if ($item['level'] == 0 OR $item['parentID'] == 0)
                                    $link_edit = "";
                                ?>
                                <tr>
                                    <td><?php echo $k + 1; ?></td>                                        
                                    <td>
                                        <input id="cb<?php echo $i; ?>" type="checkbox" name="cid[]" value="<?php echo $item["id"]; ?>" onclick="isChecked(this.checked);">                                            
                                    </td>
                                    <td>
                                        <?php if ($item['level'] == 0 OR $item['parentID'] == 0){
                                                echo $item['name'];
                                            }else{ ?>                                        
                                            <a href="<?php echo $link_edit; ?>"><?php echo $item['name']; ?></a>
                                        <?php } ?>
                                        
                                    </td>
                                    <td><?php echo buildHtml::showBtnIcon("Items", $link_items,"mainmenu.png"); ?></td>  
                                    <td align="center"><?php echo $item['level']; ?></td>                                        

                                    <td align="center"><?php if ($item['backend'] == 0) echo "Frontend";
                                else echo "Backend" ?></td>
                                    <td align="center">
                                         <?php if ($item['level'] != 0 AND $item['parentID'] != 0){
                                                echo buildHtml::status($i, $item['status']);
                                            }?>
                                    </td>
                                    <td><?php echo $item['mdate']; ?></td>
                                    <td><?php echo $item['id']; ?></td>
                                </tr>                                    
                                <?php
                                $k++;
                            };
                        }else {
                            ?>
                            <tr>
                                <td colspan="8">
                                    <h3 class="text-center">Not menu item dispplay</h3>
                                </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table
            </div>
        </div>
    </div>

    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="">
    <input type="hidden" name="limitstart" value="">    
    <input type="hidden" name="task" value="">
    <input type="hidden" name="filter_order_Dir" value="">
</form>