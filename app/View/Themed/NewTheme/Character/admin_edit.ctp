<div class="row">

<div class="col col-lg-3">

<?php echo $this->Form->create('Character', array('enctype' => "multipart/form-data")); ?>
<?php echo $this->Form->input('rarity', array('label' => 'レア度', 'class' => 'form-control', 'empty' => false, 'options' => $options)); ?>
<br />
<?php echo $this->Form->input('name', array('label' => '名前', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('story', array('label' => 'ストーリー', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('illustrator', array('label' => 'イラストレーター', 'class' => 'form-control')); ?>
<br />
<h6>セリプ</h6>
<?php echo $this->Form->label('Lv1~(進化度1)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('serif_lv1_1', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv1_2', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv1_3', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv1_4', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv1_5', array('label' => '', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->label('Lv10~(進化度2)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('serif_lv10_1', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv10_2', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv10_3', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv10_4', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv10_5', array('label' => '', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->label('Lv40~(進化度3)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('serif_lv40_1', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv40_2', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv40_3', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv40_4', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv40_5', array('label' => '', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->label('Lv80~(進化度4)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('serif_lv80_1', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv80_2', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv80_3', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv80_4', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv80_5', array('label' => '', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->label('Lv100~(進化度5)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('serif_lv100_1', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv100_2', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv100_3', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv100_4', array('label' => '', 'class' => 'form-control')); ?>
<?php echo $this->Form->input('serif_lv100_5', array('label' => '', 'class' => 'form-control')); ?>
<br />

<h6>イメージ</h6>
<?php echo $this->Form->label('Lv1~(進化度1)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('evolution1_image', array('label' => '全角キャラ', 'type' => 'file')); ?>
<?php echo $this->Form->input('evolution1_image_small', array('label' => '四角いキャラ', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->label('Lv10~(進化度2)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('evolution10_image', array('label' => '全角キャラ', 'type' => 'file')); ?>
<?php echo $this->Form->input('evolution10_image_small', array('label' => '四角いキャラ', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->label('Lv40~(進化度3)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('evolution40_image', array('label' => '全角キャラ', 'type' => 'file')); ?>
<?php echo $this->Form->input('evolution40_image_small', array('label' => '四角いキャラ', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->label('Lv80~(進化度4)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('evolution80_image', array('label' => '全角キャラ', 'type' => 'file')); ?>
<?php echo $this->Form->input('evolution80_image_small', array('label' => '四角いキャラ', 'type' => 'file')); ?>
<br />
<?php echo $this->Form->label('Lv100~(進化度5)', null, array('class' => 'control-label')); ?>
<?php echo $this->Form->input('evolution100_image', array('label' => '全角キャラ', 'type' => 'file')); ?>
<?php echo $this->Form->input('evolution100_image_small', array('label' => '四角いキャラ', 'type' => 'file')); ?>
<br />

<?php echo $this->Form->button('変更', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<br />
<br />
</div>
