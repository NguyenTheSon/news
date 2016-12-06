<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Dịch Vụ</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
            <div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
                <?php echo $this->Html->link('Thêm Nhóm sản phẩm', array('controller' => 'Products', 'action' => 'admin_group_edit', 'admin' => true), array('class' => 'btn btn-primary')); ?>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4 search-form pull-left">
                <!-- HIDDEN BLOCK -->
                <div class="row" id="hidden-input" style="display:none;">
                    <div class="input-group">
                        <input class="form-control" type="date" onchange="filter_submit()" id="begin_date" value="<?php echo $this->Session->read('Service.begin_date') ?>">
                        <span class="input-group-addon">To</span>
                        <input class="form-control" type="date" onchange="filter_submit()" id="end_date" value="<?php echo $this->Session->read('Service.end_date') ?>">
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
        	<div class="col-sm-12 col-md-12" id="ListProducts">
            	<div id = 'resultField'>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-fixed">
                            <tr>
                                <th style="width: 40%;">Tên nhóm sản phẩm</th>
                                <th style="width: 20%;">mã nhóm</th>
                                <th style="width: 20%;">Thứ tự</th>
                                <th style="width: 20%;" class="actions">Action</th>
                                
                            </tr>
                            <?php foreach ($ProdCategories as $ProdCategory): ?>
                            <tr>
                                <td><?php echo h($ProdCategory['ProdCategory']['name']); ?></td>
                                <td><?php echo h($ProdCategory['ProdCategory']['code']); ?></td>
                                <td><?php echo h($ProdCategory['ProdCategory']['order']); ?></td>
                                <td class="actions">
                                    <?php echo $this->Html->link("Sửa", array('action' => 'admin_group_edit', $ProdCategory['ProdCategory']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                                    <?php echo $this->Html->link('Xoá', array('action' => 'admin_group_del', $ProdCategory['ProdCategory']['id']), array('class' => 'btn btn-default btn-xs'),__("Bạn có chắc chắn muốn xóa nhóm sản phẩm: ".$ProdCategory['ProdCategory']['name'])); ?>
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
<script>

    $( document ).ready(function() {
        if($("#FilterByDate").val() == 5) {
            $('#hidden-input').show();
        } else {
            $('#hidden-input').hide();
        }
    });

    function customize() {
       
            var filter      = $('#FilterByDate').val();
            //alert(begin_date.format('Y-m-d') + ' -> ' + end_date.format('Y-m-d'));
            $.ajax({
                url: '<?php echo Router::url(array("action" => "index"));?>',
                type: 'POST',
                data: {
                    'data[filter]': $("#FilterByDate").val(),
                },
                success: function(data) {
                    $('#ListProducts').html(data);
                },
                error: function(e) {
                    alert('Ajax that bai');
                }
            });
    }

    function filter_submit() {
        var begin_date = new Date($('#begin_date').val());
        var end_date = new Date($('#end_date').val());
        if($('#begin_date').val()) {
            var begin_date = new Date($('#begin_date').val());
        } else {
            var begin_date = new Date();
        }
        if($('#end_date').val()) {
            var end_date = new Date($('#end_date').val());
        } else {
            var end_date = new Date();
        }
        $.ajax({
            url: '<?php echo Router::url(array("action" => "index"));?>',
            type: 'POST',
            data: {
                'data[Setup][filter]': $("#FilterByDate").val(),
                'data[Setup][begin_date]': begin_date.format('Y-m-d'),
                'data[Setup][end_date]': end_date.format('Y-m-d')
            },
            success: function(data) {
                $('#ListProducts').html(data);
            },
            error: function(e) {
                alert('Ajax that bai');
            }
        });
    }
</script>
<?php
  $data = $this->Js->get('#searchFormProduct')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#searchFormProduct')->event(
    'submit',
    $this->Js->request(
      array('action' => 'index', 'controller' => 'Setup',),
      array(
        'update' => '#resultField',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST'
      )
    )
  );
  echo $this->Js->writeBuffer();                                                 
?>