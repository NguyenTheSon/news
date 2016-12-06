<h2>カテゴリー別記事投稿</h2>
<?php echo $this->Html->script('jquery');?>

<div class="row">

<div class="col col-lg-3">


<?php echo $this->Form->create('Rss'); ?>
<?php echo $this->Form->input('name', array('label' => '登録名', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('url', array('label' => 'RSS用URL', 'class' => 'form-control')); ?>
<br />
<?php echo $this->Form->input('active', array('label' => 'アクティブ', 'type' => 'checkbox')); ?>
<br />
<?php echo $this->Form->button('登録', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>

<br />
<br />
</div>

<div id="rssPaging">
<?php echo $this->element('rss_page'); ?>
</div>


<br />
<br />

<div id="articlePaging">
<?php echo $this->element('article_page'); ?>
</div>

</div>
</div>

