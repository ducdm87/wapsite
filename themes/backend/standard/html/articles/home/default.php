 
<form name="adminForm" method="post" action="">
    <div class="row">  
        <div class="col-lg-7">            
        </div>
        <div class="col-lg-5">
            <?php echo $lists['filter_created_by']; ?>
            <?php echo $lists['filter_state']; ?>
        </div>
    </div>
    <table class="adminlist" cellpadding="1">
        <thead> 
            <tr>
                <th width="2%" class="title"> #	</th>
                <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </th>                
                <th class="title"> <a>Title</a></th>
                <th class="title" width="3%"> <a>Status</a></th>
                <th class="title" width="3%"> <a>Feature</a></th>                
                <th class="title" width="15%"> <a>Category</a></th>
                <th class="title" width="12%"> <a>Created By</a></th>
                <th class="title" width="15%"> <a>Created</a></th>
                <th class="title"  width="3%"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($items as $i => $item) {
                $link_edit = Router::buildLink("articles",array('layout'=>'edit', 'cid'=>$item['id']));   
                $item['slug'] = $item['id']."-".$item['alias'];
                $params = urlencode(json_encode( array("id"=>$item['slug']) ));
                 
                $link_view = "/goto.php?control=articles&action=detail&params=$params";
                $link_edit_cat = Router::buildLink("categories",array('layout'=>'edit', 'cid'=>$item['catID']));   
                $link_created = Router::buildLink("articles",array('filter_created_by'=>$item['created_by']));   
                ?>
                <tr class="row1">
                    <td><?php echo ($i + 1); ?></td>
                    <td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                    <td>
                        <a href="<?php echo $link_edit; ?>"><?php echo $item['title']; ?></a>  
                        <a  style="margin: 0px 0px 0px 10px; font-weight: bold; background: #eee; padding: 3px 5px;" 
                            target="_blank" href="<?php echo $link_view; ?>">Visit</a>
                    </td>
                    <td><?php echo buildHtml::status($i, $item['status']); ?></td>
                    <td><?php echo buildHtml::changState($i, $item['feature'],"feature."); ?></td>
                    <td>
                        <a href="<?php echo $link_edit_cat; ?>"><?php echo $item['cat_title']; ?></a>                           
                    </td>
                    <td>
                        <a href="<?php echo $link_created; ?>">
                            <?php echo $item['created_name'] ?>
                        </a>
                    </td>
                    <td><?php echo date("H:i d/m/Y", strtotime($item['cdate'])); ?></td>
                    <td><?php echo $item['id'] ?></td>
                </tr>
                <?php $k = 1 - $k;
            }
            ?>
        </tbody>


    </table>
    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
</form>




