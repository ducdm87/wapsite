 
<form name="adminForm" method="post" action="">   
    <table class="adminlist" cellpadding="1">
        
    </table>
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <th width="2%" class="title"> #	</th>
                <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </th>
                <th class="title"> <a>Name</a></th>
                <th class="title" width="3%"> <a>Status</a></th>
                <th class="title" width="7%"> <a>Feature</a></th>                                
                <th class="title" width="12%"> <a>Scope</a></th>                                
                <th class="title"  width="5%"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($items as $i => $item) {
                $link_edit = $this->createUrl('categories/edit', array("cid" => $item['id']));   
                ?>
                <tr class="row1">
                    <td><?php echo ($i + 1); ?></td>
                    <td align="center"><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                    <td><a href="<?php echo $link_edit; ?>"><?php echo $item['title']; ?></a></td>                     
                    <td align="center"><?php echo buildHtml::status($i, $item['status']); ?></td>
                    <td align="center"><?php echo buildHtml::changState($i, $item['feature'],"feature."); ?></td>
                    <td align="center"><?php echo $item['scope'] ?></td>                    
                    <td align="center"><?php echo $item['id'] ?></td>
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




