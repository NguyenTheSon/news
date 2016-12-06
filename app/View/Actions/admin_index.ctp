<div class="form-group">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Actions Maganement</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <?php echo $this->Form->create('Action', array('action'=>'index', 'class' => 'form-inline')); ?>
                <div class="col-sm-2 col-md-2 col-xs-4 search-form pull-left">
                    <?php echo $this->Html->link('Update', array('controller' => 'actions', 'action' => 'update'), array('class' => 'btn btn-success')); ?>
                </div>
                <div class="col-sm-3 col-md-3 col-xs-5 search-form pull-right">
                    <div class="input-group">
                        <?php
                        echo $this->Form->input('keyword',
                            array(
                                'label' => '',
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Search',
                                'value' => $this->Session->read('Action.keyword'),
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
                <div class="col-sm-12 col-md-12" id="ListActions">
                    <?php echo $this->element('action_lists') ?>
                </div>
            </div>
        </div>
    </div>
</div>