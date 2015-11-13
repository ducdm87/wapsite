
<?php $items = $field_data; ?>

<form name="adminForm" method="post" action="">
    <?php
    //echo "<pre>" . print_r($items, true) . "</pre>";
    ?>
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <td width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($items); ?>);" value="" name="toggle"> </td>
                <th class="title"> <a>Name</a></th>                
                <th class="title"> <a>Status</a></th>
                <th class="title"> <a>Ordering</a></th>
                <th class="title"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody class="JQsortable tablefields" rel="saveOrderFields">
            <?php
            $k = 0;
            $stt = 0;
            foreach ($items as $i => $item) {
                $link_edit = $this->createUrl("/resumes/editfield")."?cid[]=" . $i;
                ?>
                <tr class="row1 ui-state-default" rel="<?php echo $i ?>">
                    <td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $i ?>" name="cid[]" id="cb<?php echo ($stt); ?>"></td>
                    <td>
                        <a href="<?php echo $link_edit; ?>">
                            <?php echo $item['name']; ?>
                        </a>
                    </td>
                    <td><?php echo buildHtml::status($stt, $item['status']); ?></td>
                    <td><?php echo $item['ordering']; ?></td>
                    <td><?php echo $i ?></td>
                </tr>
                <?php $k = 1 - $k; $stt++;
            }
            ?>
        </tbody>


    </table>
    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
</form>




