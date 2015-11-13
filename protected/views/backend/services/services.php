<div class="row">

    <div class="col-lg-4 col-md-6 col-xs-12 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel panel-heading">
                <span>Add Service</span>
            </div>
            <div class="panel-body">
                <form action="<?php echo $this->createUrl('services/add'); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($item['id']) ? $item['id'] : '' ?>"/>
                    <div class="form-group">
                        <label class="control-label">Dịch Vụ (*)</label>
                        <div >
                            <input type="text" name="name" class="form-control" value="<?php echo isset($item['name']) ? $item['name'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Alias (*)</label>
                        <div >
                            <input type="text" name="alias" class="form-control" value="<?php echo isset($item['alias']) ? $item['alias'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Giá (*)</label>
                        <div >
                            <input type="number" name="price" class="form-control" value="<?php echo isset($item['price']) ? $item['price'] : '' ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Trạng thái (*)</label>
                        <div >
                            <select name="status" class="form-control">
                                <option value="1" <?php isset($item['status']) && ($item['status'] == 1) ? 'selected' : '' ?>>Đăng</option>
                                <option value="0" <?php isset($item['status']) && ($item['status'] == 0) ? 'selected' : '' ?>>Đóng</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-info"><i class="fa fa-refresh"></i>  Làm mới</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>  <?php echo isset($item['id']) ? 'Thay đổi' : 'Thêm'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form name="adminForm" method="post" action="">
        <div class="col-lg-8 col-md-6 col-xs-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel panel-heading">
                    <span><i class="fa fa-bars"></i> Services</span>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 60%">Dịch vụ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($lists) && $lists): ?>
                                <?php $i = 1; ?>
                                <?php foreach ($lists as $item): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td>
                                            <a href="<?php echo $this->createUrl('/services?id=' . $item['id']) ?>" role="edit"><i class="fa fa-edit"> Sửa</i></a>
                                            ||
                                            <a href="<?php echo $this->createUrl('/services/delete?id=' . $item['id']) ?>"><i class="fa fa-times"></i> Xóa</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">
                                        <h3 class="text-center">Chưa có dữ liệu</h3>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                    <tfoot>
                        <?php echo buildHtml::pagination($total,isset($_GET['limitstart'])?$_GET['limitstart']:0) ?>
                    </tfoot>
                </div>
            </div>
        </div>
        <input type="hidden" value="0" name="boxchecked">
        <input type="hidden" value="" name="filter_order">
        <input type="hidden" value="5" name="limitstart" >
        <input type="hidden" value="" name="filter_order_Dir">
        <input type="hidden" value="" name="task" />

    </form>
</div>
