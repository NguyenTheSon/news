<h2>M2Y.jp</h2>

<div class="row">

<div class="col col-lg-3">
<?php if  ($showLogin == true) { ?>
<?php echo $this->Form->create('Login'); ?>
<?php echo $this->Form->input('id', array('label' => 'メッセージID', 'class' => 'form-control', 'value' => $message_id, 'readonly' => 'readonly')); ?>
<br />
<?php echo $this->Form->input('password', array('label' => '閲覧用パスワード', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
<?php }  else { ?>
	<?php if  ($showMessage == true) { ?>
		<?php echo $this->Form->label($message['Message']['nickname'].'さんからのメッセージです。', null, array('class' => 'control-label')); ?>
		<br />
		<?php echo $this->Form->label('登録日時	'.$message['Message']['created'], null, array('class' => 'control-label')); ?>
		<br />

		<?php echo $this->Form->input('', array('type' => 'textarea', 'value' => $message['Message']['body'], 'class' => 'alert alert-warning', 'readonly' => 'readonly')); ?>
	<?php }  else { ?>
		<?php echo $this->Form->label($message['Message']['nickname'].'さんからのメッセージですが、 なんらかの理由により閲覧できません。', null, array('class' => 'control-label')); ?>
		<br />
		<?php echo $this->Form->label($message['Message']['nickname'].'さんに直接確認してください。', null, array('class' => 'control-label')); ?>
		<br />
	<?php } ?>		
<?php } ?>
</div>



</div>