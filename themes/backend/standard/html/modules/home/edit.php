<div class="">
    <form action="<?php echo $this->createUrl('modules/dopost') ?>" method="post" name="adminForm">
        <input type="hidden" name="id"  value="<?php echo $item->id; ?>"/>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Detail</b></span>
                </div>
                <div class="panel-body"> 
                    <div class="form-group row">
                        <div class="col-md-3">Tên</div>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control" value="<?php echo $item->title; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">Module</div>
                        <div class="col-md-9"><?php echo $item->module; ?></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">Hiển thị tên</div>
                        <div class="col-md-9">
                            <input type="radio" value="1" name="showtitle" <?php if ($item->showtitle == 1) echo 'checked=""'; ?>  /> Yes
                            <input type="radio" value="0" name="showtitle" <?php if ($item->showtitle == 0) echo 'checked=""'; ?> /> No
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">Vị Trí</div>
                        <div class="col-md-9">
                            <?php echo $lists['position']; ?>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3">Trạng thái</div>
                        <div class="col-md-9">
                            <select name="status" class="">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                        </div>
                    </div>                      
                    <div class="form-group row">
                        <div class="col-md-3">Mô tả</div>
                        <div class="col-md-9"><?php echo $item->description; ?></div>
                    </div> 
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <span><b>Menu Assignment</b></span>
                </div>
                <div class="panel-body">                
                    <div class="form-group row">
                        <div class="col-md-4">Menus</div>
                        <div class="col-md-8">
                            <select name="selection-menu-select" class="selection-menu-select">
                                <option value="all" <?php if($item->menu == "all") echo 'selected =""'; ?>>On all pages</option>
                                <option value="none" <?php if($item->menu == "none") echo 'selected =""'; ?>>No pages</option>
                                <option value="selected" <?php if($item->menu == "selected") echo 'selected =""'; ?>>Only on the pages selected</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row row-menu-select <?php if($item->menu == "all" OR $item->menu == "none") echo "hide"?>">
                        <div class="col-md-4">Menu Selection</div>
                        <div class="col-md-8">                                
                            <?php echo $lists['selection-menu']; ?>
                        </div>
                    </div>
               </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php
            $tabs = array();
            foreach ($item->params as $param) {
                $str_tab = "";
                foreach ($param->fields as $field) {
                    $str_tab .= $field;
                }
                $tabs[$param->title] = $str_tab;
            }

//                    http://www.yiiframework.com/doc/api/1.1/CJuiTabs
            $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => $tabs, 'options' => array('collapsible' => true,),));
            ?>
        </div>
    </form>
</div>

<script>
    $(".selection-menu-select").change(function() {
        changeSelectMenu();
    });
    
    function changeSelectMenu(){
        var val = $(".selection-menu-select").val();        
        var opts = $("#selection-menu").find("option");
        if (val == "all") {
//            $("#selection-menu").attr("disabled", true);
            $(".row-menu-select").hide();            
        } else if (val == "none") {
//            $("#selection-menu").attr("disabled", true);            
            $(".row-menu-select").hide();
        } else {
            $("#selection-menu").attr("disabled", false);
            $(".row-menu-select").show();
            $(".row-menu-select").removeClass("hide");
        }
    }
    changeSelectMenu();
</script>