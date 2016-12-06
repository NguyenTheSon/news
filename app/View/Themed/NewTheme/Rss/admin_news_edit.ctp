<h2>ニュースを編集</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Article'); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('title', array('label' => 'タイトル', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('permalink', array('label' => 'URL', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('description', array('label' => '説明', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('date', array('label' => '日付', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

</div>

</div>