
<?php $items = $temp_data; ?>

<form name="adminForm" method="post" action="">
    <?php
    //echo "<pre>" . print_r($list_user, true) . "</pre>";
    ?>
    <p id="log"></p>
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <th width="2%" class="title"> #	</th>
                <td width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </td>
                <th class="title"> <a>Name</a></th>                
                <th class="title"> <a>Enable</a></th>
                <th class="title"> <a>Ordering</a></th>
                <th class="title"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody class="JQsortable tabletemplate" rel="saveOrderTemplates">
            <?php
            $k = 0;
            foreach ($items as $i => $item) {
                $link_edit = $this->createUrl("/resumes/edittemplate") . "?cid[]=" . $item['id'];
                ?>
                <tr class="row1 ui-state-default" rel="<?php echo $item['id']; ?>">
                    <td><?php echo ($i + 1); ?></td>
                    <td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id']; ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                    <td>
                        <a href="<?php echo $link_edit; ?>" class="gallery-preview" rel="<?php echo $item['thumbs']; ?>">
                            <?php echo $item['name']; ?>
                        </a>
                    </td>                    
                    <td><?php echo buildHtml::status($i, $item['status']); ?></td>
                    <td><?php echo $item['ordering']; ?></td>
                    <td><?php echo $item['id']; ?></td>
                </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
        </tbody>


    </table>
    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
</form>




