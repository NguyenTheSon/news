<h2>お知らせ</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Notification', array('enctype' => "multipart/form-data")); ?>
<?php echo $this->Form->input('title', array('label' => '題名', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('content', array('label' => 'お知らせ記入事項', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('image_url', array('label' => 'abc', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->button('変更', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<br />
<br />
</div>
