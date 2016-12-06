<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Quản lý Tin Tức</h3>
  </div>
  <div class="panel-body">
        <div class="row">
            <div class="col-sm-3 col-md-2 col-xs-2 search-form pull-left">
                <?php echo $this->Html->link('Đăng Tin', array('controller' => 'news', 'action' => 'admin_add', 'admin' => true), array('class' => 'btn btn-primary')); ?>
            </div>

            <div class="col-sm-3 col-md-3 col-xs-3 pull-left">
                <?php
                echo $this->Form->create('News', array('action'=>'index','id'=>'searchFormUser'));
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
                                'value' => $this->Session->read('News.FilterByKeyword')
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
                <?php echo $this->element('news_page'); ?>
            </div>
        </div>
        
    </div>
</div>
</div>