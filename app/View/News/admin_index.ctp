<div id="reload"> 
<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Tin Tức</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
            <div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
                <?php echo $this->Html->link('Thêm tin tức', array('controller' => 'News', 'action' => 'admin_edit', 'admin' => true), array('class' => 'btn btn-primary')); ?>
            </div>
            <div class="col-sm-2 col-md-2 col-xs-2 search-form pull-left">
                <?php
                $List = array("" =>"Tất cả");
                foreach($ListCategories as $ListCategory)
                {
                    $List[$ListCategory["Category"]["id"]] = $ListCategory["Category"]["name"];
                }
                echo $this->Form->select('filter_by_type',
                    $List,
                    array(
                        'default' => $cat_id,
                        'class' => 'form-control',
                        'id' => 'FilterByType',
                        'empty' => false,
                        'onchange' => 'changefilter()',
                    )
                );
                ?>
            </div>


            <div class="col-sm-3 col-md-3 col-xs-5 search-form pull-right">
                <?php echo $this->Form->create('News', array('action'=>'index','id'=>'searchFormProduct'));?>
                    <div class="input-group">
                        <?php echo $this->Form->input('keyword', array('label' => '', 'class' => 'form-control input-sm', 'placeholder' => 'Tìm kiếm', 'value' => $this->Session->read('News.keyword'))); ?>

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
            	<?php echo $this->element('News/admin_index'); ?>
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
      array('action' => 'index', 'controller' => 'News',(isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0]: "")),
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