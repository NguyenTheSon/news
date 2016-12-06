<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý người dùng</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
			<div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
        		<?php echo $this->Html->link('Thêm Người Dùng', array('controller' => 'users', 'action' => 'admin_add', 'admin' => true), array('class' => 'btn btn-primary')); ?>
        	</div>

            <div class="col-sm-3 col-md-3 col-xs-3 pull-left">
                <?php
                echo $this->Form->create('User', array('action'=>'index','id'=>'searchFormUser'));
                echo $this->Form->select('filter_by_group',
                    $groups,
                    array(
                        'default'   => $this->Session->read('User.FilterByGroup'),
                        'class'     => 'form-control',
                        'id'        => 'FilterByGroup',
                        'empty'     => 'Filter by Group',
                        'onchange'  => 'this.form.submit()'
                    )
                );
                ?>
            </div>

            <div class="col-sm-4 col-md-4 col-xs-5 search-form pull-right">
                    <div class="input-group">
                        <?php
                        echo $this->Form->input('keyword',
                            array(
                                'label' => '',
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Tìm kiếm',
                                'value' => $this->Session->read('User.FilterByKeyword')
                            )
                        );
                        ?>

                        <div class="input-group-btn">
                        	<?php echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'btn btn-sm  btn-primary')); ?>
                        </div>

                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
        <br />
        <div class="row">
        	<div class="col-sm-12 col-md-12">
            	<?php echo $this->element('Users/index'); ?>
            </div>
		</div>
		
	</div>
</div>
</div>