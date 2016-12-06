<div id="reload"> 
<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Dịch Vụ</h3>
  </div>
  <div class="panel-body">
	    <div class="row">

            <div class="col-sm-2 col-md-2 col-xs-2 search-form pull-left">
                <?php
                echo $this->Form->select('filter_by_type',
                    array(
                        '0' => 'Câu hỏi mới nhất',
                        '1' => 'Câu hỏi chưa trả lời',
                        '2' => 'Câu hỏi đã trả lời',
                    ),
                    array(
                        'default' => $this->Session->read('Askme.filter'),
                        'class' => 'form-control',
                        'id' => 'FilterByType',
                        'empty' => false,
                        'onchange' => 'changefilter()',
                    )
                );
                ?>
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

            <div class="col-sm-3 col-md-3 col-xs-5 search-form pull-right">
                <?php echo $this->Form->create('Service', array('action'=>'index','id'=>'searchFormProduct'));?>
                    <div class="input-group">
                        <?php echo $this->Form->input('keyword', array('label' => '', 'class' => 'form-control input-sm', 'placeholder' => 'Tìm kiếm', 'value' => $this->Session->read('Service.filter_keyword'))); ?>

                        <div class="input-group-btn">
                        	<?php echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'btn btn-sm  btn-primary')); ?>
                        </div>

                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
        <br />
        <div class="row">
        	<div class="col-sm-12 col-md-12" id="ListProducts">
            	<?php echo $this->element('Askme/admin_index'); ?>
            </div>
		</div>
		
	</div>
</div>
</div>
</div>
<script>
    $("#FilterByType").change(function(){
        var val = $(this).val();
        window.location = "<?php echo Router::url(array('action' => 'index','admin' => true)); ?>/index/"+val;
    });
</script>
<?php
  $data = $this->Js->get('#searchFormProduct')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#searchFormProduct')->event(
    'submit',
    $this->Js->request(
      array('action' => 'index', 'controller' => 'Askme',),
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