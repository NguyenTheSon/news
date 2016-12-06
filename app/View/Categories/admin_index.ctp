<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Chuyên mục</h3>
  </div>
  <div class="panel-body">
       
        <div class="row">
          <div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
                  <?php echo $this->Html->link('Thêm Chuyên mục', array('controller' => 'Categories', 'action' => 'admin_add', 'admin' => true), array('class' => 'btn btn-primary')); ?><br>
          </div>
        	<div class="col-sm-12 col-md-12">
              <div class="control-group">
                  <div id = 'resultField'>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-fixed">
                          <tr>
                            <th style="width: 15%;">Tên Chuyên Mục</th>
                            <th style="width: 20%;">Tiêu đề banner</th>
                            <th style="width: 20%;">Text Banner</th>
                            <th style="width: 20%;">Tiêu đề trái</th>
                            <th style="width: 20%;">Text trái</th>
                            <th style="width: 15%;" class="actions">Action</th>
                            
                          </tr>
                          <?php foreach ($categories as $Category): ?>
                          <tr>
                            <td><?php echo h($Category['Category']['name']); ?></td>
                            <td><?php echo $Category['Category']['title_banner'];?></td>
                            <td><?php echo h($Category['Category']['text_banner']); ?></td>
                            <td><?php echo $Category['Category']['title_left'];?></td>
                            <td><?php echo h($Category['Category']['text_left']); ?></td>
                            <td class="actions">
                              <?php echo $this->Html->link("Sửa", array('action' => 'admin_edit', $Category['Category']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                              <?php echo $this->Html->link('Xoá', array('action' => 'admin_del', $Category['Category']['id']), array('class' => 'btn btn-default btn-xs'),__("Bạn có muốn xóa chuyên mục này?")); ?>
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
