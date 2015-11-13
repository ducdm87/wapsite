 
<form name="adminForm" method="post" action="">   
    <table class="adminlist" cellpadding="1">
        <thead> 
            <tr>
                <th width="2%" class="title"> #	</th>
                <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </th>
                <th class="title"> <a>Name</a></th>
                <th class="title" width="3%"> <a>Status</a></th>
                <th class="title" width="3%"> <a>Feature</a></th>
                <th class="title" width="20%"> <a>Category</a></th>
                <th class="title" width="15%"> <a>Created</a></th>
                <th class="title"  width="3%"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($items as $i => $item) {
                $link_edit = $this->createUrl('videos/edit', array("cid" => $item['id']));   
                $link_edit_cat = $this->createUrl('categories/edit?cid=' . $item['catID']);   
                $item['slug'] = $item['id']."-".$item['alias'];
                $params = urlencode(json_encode( array("id"=>$item['slug']) ));
                 
                $link_view = "/goto.php?control=videos&action=detail&params=$params";
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
                    <td><?php echo $item['cdate'] ?></td>
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




