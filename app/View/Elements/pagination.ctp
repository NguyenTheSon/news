
<div class="pagination square">
	<li><?php echo $this->Paginator->first('«', array(), null, array('class' => 'first disabled')); ?></li>

	<li><?php echo $this->Paginator->prev('‹', array(), null, array('class' => 'prev disabled')); ?></li>

	<li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>

	<li><?php echo $this->Paginator->next('›', array(), null, array('class' => 'next disabled')); ?></li>

	<li><?php echo $this->Paginator->last('»', array(), null, array('class' => 'last disabled')); ?></li>
</div>

	