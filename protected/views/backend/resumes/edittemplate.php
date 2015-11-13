<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$data_type = array();
$data_type[1] = 'Input text';
$data_type[2] = 'large text input (textare)';
$data_type[3] = 'Text editor';
$data_type[4] = 'Select';
$data_type[5] = 'Date selector';
$data_type[6] = 'Select month';
$data_type[7] = 'Select Year';
$data_type[8] = 'File upload';
?>

<div id="edit-template">
    <form name="adminForm" method="post" action="" enctype="multipart/form-data">
        <fieldset class="adminform">
            <legend>Infomation</legend>
            <table cellspacing="1" class="admintable">
                <tr>
                    <td width="150" class="key"> <label for="name"> Name </label> </td>
                    <td> <input type="text" name="name" id="name" class="inputbox" size="40" value="<?php echo $item['name']; ?>"> </td>
                    <td width="150" class="key"> <label for="thumbs"> Thumbs </label> </td>
                    <td> <input type="file" name="thumbs" id="thumbs" class="inputbox" size="40" value="<?php echo $item['thumbs']; ?>"> </td>
                </tr>                
                <tr>
                    <td width="150" class="key"> <label for="status"> Status </label> </td>
                    <td> <?php echo buildHtml::choseStatus("status", $item['status']); ?> </td>
                    <td width="150" class="key"> <label for="ordering"> ordering </label> </td>
                    <td> <input type="text" name="ordering" id="ordering" class="inputbox" size="40" value="<?php echo $item['ordering']; ?>"> </td>
                </tr>                
                <tr>
                    <td width="150" class="key"> <label for="thumbs"> ID </label> </td>
                    <td> <?php echo $item['id']; ?> </td>
                    <td colspan="2"> <?php if($item['id'] != 0 ){ 
                        $link_preview = $this->createUrl("/resumes/previewtemplate") . "?cid[]=" . $item['id'];
                        echo '<span> <a href="'.$link_preview.'" class="preview-template">Preview</a> </span>'; } ?> 
                    </td>
                    <td></td>
                </tr> 
            </table>
        </fieldset>

        <fieldset class="adminform">
            <legend>Detail</legend>
            <table width="100%" class="tbl-detail-field">
                <tr>
                    <td width="305px" style="vertical-align: top;">
                        <ul class="listfield">
                            <?php
                            $df = 1;
                            foreach ($field_data as $key => $field) {
                                if (isset($item_detail[$key]))
                                    $detail = $item_detail[$key];
                                else {
                                    $detail = array();
                                    $detail['default'] = $df;
                                    $detail['status'] = $field['status'];
                                    $detail['max_record'] = $field['max_record'];
                                    $detail['content'] = "";
                                    $df = 0;
                                }
                                $style = "";
                                if($detail['content'] == ""){
                                    $style = "color: red; ";
                                }
                                ?>
                                <li>
                                    <div class="arrow"></div>
                                    <div class="left">                                        
                                        <div class="title" style="<?php echo $style; ?>"><?php echo $field['name']; ?> [<?php echo $key; ?>]</div>
                                        <div>Default <input type="radio" <?php if ($detail['default'] == 1) echo 'checked'; ?> name="field_default" value="<?php echo $key; ?>" /></div>
                                        <div>Status <?php echo buildHtml::choseStatus("temdetail[status][" . $key . "]", $detail['status'], 0); ?></div>
                                    </div>
                                    <div class="right">
                                        <a rel="1" class="btn-edit btn-controls"></a>
                                    </div>
                                    <div class="field-detail">
                                        <div class="field-detail-inner">
                                            <a title="" href="" onclick="" class="btn-close-edit-box"><img src="/templates/resume/css/img/popup-close.png" alt="" style="float: right;"></a>
                                            <span class="clr"></span>
                                            <div style="height: 180px; overflow: auto;">
                                                 <table cellspacing="1" class="admintable">
                                                    <tr>
                                                        <td style="width: 100px;" class="key"> <label> max record </label> </td>
                                                        <td><?php echo $field['max_record']; ?></td>
                                                        <td style="width: 100px;" class="key"> <label> ID </label> </td>
                                                        <td> <?php echo $key; ?> </td>
                                                        <td style="width: 100px;" class="key"> <label> Code </label> </td>
                                                        <td> {{open_title}} <?php echo $field['name']; ?> {{close_title}} <br /> {{open_block}} put content {{close_block}} </td>
                                                    </tr>
                                                </table>                                                                                                                                    
                                                <table cellspacing="1" class="adminlist" style="margin: 5px 0 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Size</th>
                                                        <th>ID</th>
                                                        <th>Code</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                foreach ($field['field_sub'] as $fsid => $field_sub) {
                                                    $dv = $field_sub['data_type']==3?$field_sub['name']:$field_sub['default_value']
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $field_sub['name'] ?></td>
                                                        <td><?php echo $data_type[$field_sub['data_type']]; ?></td>
                                                        <td><?php echo $field_sub['size'] ?></td>
                                                        <td><?php echo $fsid ?></td>
                                                        <td><?php echo '{{open_detail_' . $key . '_' . $fsid . '}}'.$dv.'{{close_detail_' . $key . '_' . $fsid . '}}' ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                            </div>
                                            <div class="items">
                                                <div class="item"><b> max record </b><input type="text" value="<?php echo $detail['max_record']; ?>" name="temdetail[max_record][<?php echo $key; ?>]" /></div>
                                                <div class="item"><b>html</b> <textarea cols="160" rows="20" name="temdetail[html][<?php echo $key; ?>]"><?php echo $detail['content']; ?></textarea></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <img src="<?php echo $item['thumbs']; ?>" alt="<?php echo $item['name']; ?>" />
                    </td>
                </tr>
            </table>

        </fieldset>
        <input type="hidden" value="<?php echo $item['id']; ?>" name="cid" />
        <input type="hidden" value="" name="task" />
    </form>
</div>
