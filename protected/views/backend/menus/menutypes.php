<form action="<?php echo $this->createUrl('menus/menutypes') ?>" method="post" name="adminForm" >
 
    <div class="row">
        <div class="panel">            
            <div class="panel-body">
                <div class="row">  
                    <div class="col-lg-7">
                        <input type="text" name="filter_search" value="<?php echo Request::getVar('filter_search', ""); ?>" /> 
                        <button type="submit" class="btn btn-primary btn-xs">Go</button>
                        <button type="reset" class="btn btn-primary btn-xs">Reset</button>
                    </div>
                    <div class="col-lg-5">
                        
                    </div>
                </div>
                <br/>            
                    <table class="table table-bordered table-hover table-striped table-responsive">
                        <thead>
                            <tr>
                                <th width="2%"># </th>
                                <th width="3%">
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $items?count($items):0; ?>);"> 
                                </th>
                                <th width="40%">Name</th>
                                <th width="5%">Items</th>
                                <th width="5%" align="center">Status</th>
                                <th width="30%">Description</th>
                                <th width="15%">Modified</th>
                                <th width="5%">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($items) && $items): ?>                                
                                <?php foreach ($items as $i=> $item): 
                                    $link_edit = $this->createUrl('menus/editmenutype',array("cid" => $item['id'])); 
                                    $link_items = $this->createUrl('menus/menuitems', array("menu" => $item['id']));
                                    ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>                                        
                                        <td>
                                            <input id="cb<?php echo $i; ?>" type="checkbox" name="cid[]" value="<?php echo $item["id"]; ?>" onclick="isChecked(this.checked);">                                            
                                        </td>
                                        <td>
                                            <a href="<?php echo $link_edit; ?>"><?php echo $item['title']; ?></a>
                                        </td>
                                        <td><?php echo buildHtml::showBtnIcon("Items", $link_items,"mainmenu.png"); ?></td>                                        
                                        <td align="center"><?php echo buildHtml::status($i, $item['status']); ?></td>
                                        <td><?php echo $item['description'];  ?></td>
                                        <td><?php echo $item['mdate'];  ?></td>
                                        <td><?php echo $item['id'];  ?></td>
                                    </tr>                                    
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">
                                        <h3 class="text-center">Not menu dispplay</h3>
                                    </td>
                                </tr>
                            <?php endif; ?>
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