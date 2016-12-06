<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Trang chủ</h3>
  </div>
  <div class="panel-body">
       
        <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="control-group">
                  <div id = 'resultField'>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-fixed">
                          <tr>
                            <th style="width: 15%;">Tên Menu</th>
                            <th style="width: 20%;">Ảnh</th>
                            <th style="width: 20%;">Url</th>
                            <th style="width: 15%;" class="actions">Action</th>
                            
                          </tr>
                          <?php foreach ($menus as $menu): ?>
                          <tr>
                            <td><?php echo h($menu['Menu']['name']); ?></td>
                            <td><img src="<?php echo $menu['Menu']['image'];?>" style="max-width: 100px;"></td>
                            <td><?php echo h($menu['Menu']['url']); ?></td>
                            <td class="actions">
                              <?php echo $this->Html->link("Sửa", array('action' => 'admin_edit', $menu['Menu']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </table>
                      </div>
                    </div>
              </div>
         
            </div>
		</div>
		
	</div>
</div>
</div>
