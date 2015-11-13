
<?php
$data_type = array();
$data_type[1] = 'Input text';
$data_type[2] = 'large text input (textare)';
$data_type[3] = 'Text editor';
$data_type[4] = 'Select';
$data_type[5] = 'Date selector';
$data_type[6] = 'Select month';
$data_type[7] = 'Select Year';
$data_type[8] = 'File upload';
//echo "<pre>" . print_r($item, true) . "</pre>";
?>

<div id="edit-field">
    <form name="adminForm" method="post" action="">
        <div style="width: 100%;">
            <fieldset class="adminform">
                <legend>Field info</legend>
                <table cellspacing="1" class="admintable">
                    <tr>
                        <td width="150" class="key"> <label for="name"> Name </label> </td>
                        <td> <input type="text" name="name" id="name" class="inputbox" size="40" value="<?php echo $item['name']; ?>"> </td>
                    </tr>                    
                    <tr>
                        <td width="150" class="key"> <label for="status"> Status </label> </td>
                        <td> <?php echo buildHtml::choseStatus("status", $item['status']); ?> </td>
                    </tr>
                    <tr>
                        <td width="150" class="key"> <label for="ordering"> ordering </label> </td>
                        <td> <input type="text" name="ordering" id="ordering" class="inputbox" size="10" value="<?php echo $item['ordering']; ?>"> </td>
                    </tr>
                    <tr>
                        <td width="150" class="key"> <label for="max_record"> max record </label> </td>
                        <td> <input type="text" name="max_record" id="max_record" class="inputbox" size="10" value="<?php echo $item['max_record']; ?>"> </td>
                    </tr>
                </table>
            </fieldset>
        </div>

        <div>
            <fieldset class="adminform">
                <legend>Sub field manager</legend>
                <table width="100%">
                    <tr>
                        <td width="40%">
                            <table cellspacing="1" class="">
                                <tr>
                                    <td width="150" class="key"> <label for="data_name"> Name </label> </td>
                                    <td> <input type="text" name="data_name" id="data_name" class="inputbox" size="40" value="<?php echo $item['name']; ?>"> </td>
                                </tr>
                                <tr>
                                    <td width="150" class="key"> <label for="data_size"> Size </label> </td>
                                    <td> <input type="text" name="data_size" id="data_size" class="inputbox" size="20" value="50%"> </td>
                                </tr>                                
                                <tr>
                                    <td width="150" class="key"> <label for="data_type"> required </label> </td>
                                    <td> 
                                        <input type="checkbox" name="data_required" id="data_required" checked="" value="1" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150" class="key"> <label for="valid_data"> valid data </label> </td>
                                    <td> 
                                        <input type="text" name="valid_data" id="valid_data" value="1" size="60" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150" class="key"> <label for="space_before"> space before </label> </td>
                                    <td> 
                                        <input type="text" name="space_before" id="space_before" value="1" size="20" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150" class="key"> <label for="default_value"> default value </label> </td>
                                    <td> 
                                        <textarea name="space_before" id="default_value" value="1" size="20" cols="55" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="150" class="key"> <label for="data_type"> Data type </label> </td>
                                    <td> 
                                        <select id="data_type" name="data_type">
                                            <?php for ($i = 1; $i <= count($data_type); $i++) {
                                                ?>
                                                <option value="<?php echo $i; ?>" rel="0"><?php echo $data_type[$i]; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> <div id='list-data-sub-field' style=" margin: 15px 0 0;"> </div> </td>
                                </tr>
                            </table>

                            <div style="text-align: center;" > <input type="button" value="add" class="save-btn" id="add-sub-field" /> </div>
                        </td>                    
                        <td width="" style="padding: 0 0 0 30px;">
                            <a title="" href="#" id="add-record">  Add new ... </a>
                            <a title="" href="#" id="status-order-field"> ad </a>
                            <table cellpadding="1" class="adminlist" width="80%" id="display-field-sub">
                                <thead>
                                    <tr>
                                        <td width="5%"> # </td>
                                        <td width="15%"> Action </td>
                                        <td width="55%"> Name </td>            
                                        <td width="10%"> size </td>            
                                        <td width="10%"> required </td>            
                                        <td width="15%"> type </td>
                                    </tr>
                                </thead>
                                <tbody class="JQsortable tablesubfield" rel="saveOrderSubField">
                                    <?php
                                    $list_sub = $item['field_sub'];
                                    $arr_sub_order = array();
                                    $stt = 0;
                                    if (count($list_sub))
                                        foreach ($list_sub as $key => $sub) {
                                            if ($key == "")
                                                continue;
                                            $arr_sub_order[] = $key;
                                            ?>
                                            <tr class="row1 ui-state-default" rel="<?php echo $key; ?>">
                                                <td align="center"><?php echo ++$stt; ?></td>
                                                <td align="center">
                                                    <div style="width: 60px;">
                                                        <a class="btn-field-delete btn-delete btn-controls" rel="<?php echo $key; ?>"></a>
                                                        <a class="btn-field-edit btn-edit btn-controls" rel="<?php echo $key; ?>"></a>
                                                    </div>                                            
                                                </td>                                        
                                                <td><?php echo $sub['name']; ?></td>
                                                <td align="center"><?php echo $sub['size']; ?></td>
                                                <td align="center"><?php echo $sub['required']==1?'true':'false'; ?></td>
                                                <td align="center"><?php echo $data_type[$sub['data_type']]; ?></td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </fieldset>            
            <script>
                var obj_data_type_client = <?php echo json_encode($data_type); ?>;
                <?php if(count($list_sub) == 0){ ?>
                    var obj_data_sub_client = {};
                <?php }else{
                    ?>
                        var obj_data_sub_client = <?php echo json_encode($list_sub); ?>;                
                        <?php
                } ?>
                var obj_data_sub_order_client = <?php echo json_encode($arr_sub_order); ?>;
                var link_removesubfield = "<?php echo $this->createUrl("/resumes/removesubfield"); ?>";

                $(window).ready(function($) {
                    resumeFieldShowBox(obj_data_sub_order_client[0]);
                    $("#obj_data_sub_client").val(JSON.stringify(obj_data_sub_client));
                    $("#obj_data_sub_order_client").val(JSON.stringify(obj_data_sub_order_client));
                });
            </script>
        </div>        
        <input type="hidden" value="" name="obj_data_sub_client" id="obj_data_sub_client">
        <input type="hidden" value="" name="obj_data_sub_order_client" id="obj_data_sub_order_client">
        <input type="hidden" value="<?php echo $item['id']; ?>" name="cid" />
        <input type="hidden" value="" name="task" />
    </form>
</div>




