<h2>Admin Edit Message</h2>

<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Message', array('enctype' => 'multipart/form-data')); ?>
<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->input('nickname', array('label' => 'Nick Name', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('subject', array('label' => 'Message Subject', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('body', array('label' => 'Message Content', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('image_url', array('label' => 'Image Url', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->input('password', array('label' => 'Password', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('read_count', array('label' => 'Read Count', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('end_time', array('label' => 'End Time', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('login_id', array('label' => 'User ID', 'class' => 'form-control', 'options' => $users)); ?>
<br />
<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

</div>

</div>