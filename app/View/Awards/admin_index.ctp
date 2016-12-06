<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"> <i class="glyphicon glyphicon-tasks"></i> Quản lý Award</h3>
    </div>
    <div class="panel-body">
        <div class="col-sm-3 col-md-2 col-xs-2 pull-left">
            <div style="padding-bottom: 15px;">
                <?php echo $this->Html->link('Thêm award', array('controller' => 'Awards', 'action' => 'admin_add', 'admin' => true), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Số báo danh</th>
                    <th width="5%">Ảnh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Ghi chú</th>
                    <th>Lượt bình chọn</th>
                    <th>Hành động</th>
                </thead>
                <tbody>
                    <?php foreach($listaward as $item):?>
                        <tr class="odd gradeX">
                            <td><?php echo $item['Award']['id'];?></td>
                            <td><?php echo $item['Award']['name'];?></td>
                            <td><?php echo $item['Award']['ide_number'];?></td>
                            <th>
                                <img src="<?php echo $item['Award']['imgavatar'];?>" class="img-responsive">
                            </th>
                            <td><?php echo $item['Award']['phonenumber'];?></td>
                            <td><?php echo $item['Award']['address'];?></td>
                            <td><?php echo $item['Award']['note'];?></td>
                            <td><?php echo $item['Award']['vote'];?></td>
                            <td>
                                <a href="<?php echo Router::url(array('action' => 'admin_edit', $item['Award']['id']));?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa</a>
                                <a href="<?php echo Router::url(array('action' => 'admin_delete', $item['Award']['id']));?>" class="btn btn-danger" onclick="if (confirm('Bạn có muốn xóa quảng cáo này?')) { return true; } return false;"><i class="fa fa-times" aria-hidden="true"></i> Xoá</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>