<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="form-resumes">
    <form name="adminForm" method="post" action="">
        <table class="adminlist" cellpadding="1">
            <thead>
                <tr>
                    <th width="2%" class="title"> #	</th>                
                    <td class="title"> <?php echo buildHtml::headSort('Name', 'rs.name',$lists['filter_order'], $lists['filter_order_Dir']); ?></td>
                    <td width="15%"> <?php echo buildHtml::headSort('Template', 'tem.name',$lists['filter_order'], $lists['filter_order_Dir']); ?></td>
                    <td width="5%"> Complete </td>
                    <th width="10%"> <a>Action</a></th>
                    <td class="title" width="15%"> <?php echo buildHtml::headSort('Created date', 'cdate',$lists['filter_order'], $lists['filter_order_Dir']); ?></td>
                    <td class="title" width="15%"> <?php echo buildHtml::headSort('Modify date', 'mdate', $lists['filter_order'],$lists['filter_order_Dir']); ?></td>
                    <td class="title" width="10%"> <?php echo 'user id'; ?></td>
                    <td class="title" width="3%"> <?php echo buildHtml::headSort('ID', 'id',$lists['filter_order'],  $lists['filter_order_Dir']); ?></td>
                </tr> 
            </thead>
            <tbody>
                <?php
                $k = 0;
                foreach ($items as $i => $item) {                    
                    $link_trash = $this->createUrl("/resumes/removeresume") . "?cid[]=" . $item['id'];
                    $link_preview = $this->createUrl("/resumes/previewresume") . "?cid[]=" . $item['id'];
                    $link_preview_tem = $this->createUrl("/resumes/previewtemplate") . "?cid[]=" . $item['template_id'];
                    $step = explode("/", $item['step']);
                    if(!isset($step[1])) $step[1] = $step[0];
                    if(!isset($step[2])) $step[2] = $step[1];
                    
                    $class = "";
                    if($step[0] == $step[1]) $class = "hightlight";
                    ?>
                    <tr class="row1 <?php echo $class; ?>">
                        <td><?php echo ($i + $lists['limitstart'] + 1); ?></td>                    
                        <td><?php echo $item['name']; ?></td>
                        <td>
                            <span style="float: left;"><?php echo $item['template_name']; ?></span>
                            <a href="<?php echo $link_preview_tem; ?>" class="preview-template btn-preview-16 btn-controls-16" title="Preview"></a> 
                        </td>
                        <td align="center" title="complete: <?php echo $step[0]."\n"; ?>Display: <?php echo "\t".$step[1]."\n"; ?>Total: <?php echo "\t".$step[2]; ?>"><?php echo $item['step']; ?></td>
                         <td>                        
                            <a href="<?php echo $link_preview; ?>" class="btn-preview-16 btn-controls-16" title="Preview"></a>                            
                            <a href="<?php echo $link_trash; ?>" class="btn-trash-16 btn-controls-16" title="move to trash"></a>
                        </td>
                        <td><?php echo $item['cdate']; ?></td>
                        <td><?php echo $item['mdate']; ?></td>                       
                        <td align="center"><?php echo $item['user_id']; ?></td>
                        <td><?php echo $item['id']; ?></td>
                    </tr>
                    <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" align="center">
                        <div class="mypageing">                            
                            <div class="display">Display # <?php echo buildHtml::limit('limit', $lists['limit']); ?>  </div>
                            <div class="list-pageing"><?php echo buildHtml::pagination($lists['total'], $lists['limit'], $lists['limitstart']); ?></div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" value="0" name="boxchecked">
        <input type="hidden" value="<?php echo $lists['filter_order']; ?>" name="filter_order">
        <input type="hidden" value="<?php echo $lists['filter_order_Dir']; ?>" name="filter_order_Dir">
        <input type="hidden" value="" name="limitstart">        
        <input type="hidden" value="" name="task" />
    </form>
</div>
