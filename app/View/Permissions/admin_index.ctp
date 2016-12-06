<div class="form-group">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Permissions Maganement</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <?php echo $this->Form->create('Permission', array('action'=>'index', 'class' => 'form-inline')); ?>
                <div class="col-sm-3 col-md-3 col-xs-5 search-form pull-right">
                    <div class="input-group">
                        <?php
                        echo $this->Form->input('keyword',
                            array(
                                'label' => '',
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Search',
                                'value' => $this->Session->read('Permission.keyword'),
                            )
                        );
                        ?>

                        <div class="input-group-btn">
                            <?php echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'btn btn-sm  btn-primary', 'type' => 'button')); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
            <br />

            <div class="row">
                <div class="col-sm-12 col-md-12" id="PermissionsIndex">
                    <?php echo $this->element('Permissions/index') ?>
                </div>
            </div>
        </div>
    </div>
</div>