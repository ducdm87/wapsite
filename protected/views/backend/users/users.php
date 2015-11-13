
<form name="adminForm" method="post" action="">   
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <th width="2%" class="title"> #	</th>
                <th width="3%" class="title"> <input type="checkbox" onclick="checkAll(<?php echo count($list_user); ?>);" value="" name="toggle"> </th>
                <th class="title"> <a>Name</a></th>
                <th class="title"> <a>User Name</a></th>
                <th class="title"> <a>Login</a></th>
                <th class="title"> <a>Enable</a></th>
                <th class="title"> <a>Group</a></th>
                <th class="title"> <a>Email</a></th>
                <th class="title"> <a>Last login</a></th>
                <th class="title"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($list_user as $i => $item) {
                $link_edit = $this->createUrl("/users/edit")."?cid[]=" . $item['id'];
                ?>
                <tr class="row1">
                    <td><?php echo ($i + 1); ?></td>
                    <td><input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid[]" id="cb<?php echo ($i); ?>"></td>
                    <td>
                        <a href="<?php echo $link_edit; ?>">
                            <?php echo $item['first_name'] . " " . $item['last_name']; ?>
                        </a>
                    </td>
                    <td><?php echo $item['username'] ?></td>
                    <td>v</td>
                    <td><?php echo buildHtml::status($i, $item['status']); ?></td>
                    <td><?php echo isset($arr_group[$item['groupID']])?$arr_group[$item['groupID']]['name']:""; ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo $item['lastvisit'] ?></td>
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




