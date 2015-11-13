<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="list-trash">
    <ul class="JQtabs" rel="trash-detail" reldetail="tab-item">
        <li rel="0">Resume</li>
        <li rel="1">Templates</li>
    </ul>
    <div class="JQtabs-detail" id="trash-detail">
        <div class="tab-item">            
            <table class="adminlist" cellpadding="1">
                <thead>
                    <tr>
                        <th width="2%" class="title"> #	</th>                
                        <th class="title"> <a>Name</a></th>                                
                        <th class="title" width="10%"> <a>Action</a></th>
                        <th class="title" width="15%"> <a>Created date</a></th>
                        <th class="title" width="5%"> <a>ID</a></th>
                    </tr>
                </thead>
                <?php
                if (count($items_resume) == 0)
                    echo '<tr class="row1"><td colspan="5" align="center"> Empty </td> </tr>';
                for ($i = 0; $i < count($items_resume); $i++) {
                    $item = $items_resume[$i];
                    $link_restore = $this->createUrl("/resumes/restoreresume") . "?cid[]=" . $item['id'];
                    $link_delete = $this->createUrl("/resumes/deleteresume") . "?cid[]=" . $item['id'];
                    $link_preview = $this->createUrl("/resumes/previewresume") . "?cid[]=" . $item['id'];
                    ?>
                    <tr class="row1">
                        <td><?php echo ($i + 1); ?></td>                    
                        <td><?php echo $item['name']; ?> </td>                    
                        <td align="center">
                            <a href="<?php echo $link_restore; ?>" class="btn-revert-16 btn-controls-16" title="Restore"></a>
                            <a href="<?php echo $link_delete; ?>" class="btn-delete-16 btn-controls-16" title="Delete"></a>
                            <a href="<?php echo $link_preview; ?>" class="btn-preview-16 btn-controls-16" title="Preview"></a>
                        </td>
                        <td><?php echo $item['cdate']; ?></td>
                        <td><?php echo $item['id']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <div class="tab-item"> empty </div>    
    </div>
</div>

