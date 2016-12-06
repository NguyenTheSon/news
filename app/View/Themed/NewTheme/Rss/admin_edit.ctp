<h2>Admin Edit Rss</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Rss'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('name', array('label' => '登録名', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('url', array('label' => 'RSS用URL', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('active', array('label' => 'アクティブ', 'type' => 'checkbox')); ?>
<br />
<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

</div>

</div>