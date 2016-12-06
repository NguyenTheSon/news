<table class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
		<th width="5%" class="text-center">ID</th>
		<th width="25%" class="text-center">Title</th>
		<th width="50%" class="text-center">Content</th>
		<th width="10%" class="text-center">Date</th>
		<th width="10%" class="text-center"></th>
	</tr>
	</thead>
	<tbody>
	<?php
		foreach($news as $new) {
			echo '<tr>';
			echo '<td>' . $new['News']['id'] . '</td>';
			echo '<td>' . $new['News']['title'] . '</td>';
			echo '<td>' . substr($new['News']['content'],0,300) . '...</td>';
			echo '<td>' . date("d-m-Y",strtotime($new['News']['created'])) . '</td>';
			
			echo '<td>' . $this->Html->link('Details',
					array('controller' => 'news', 'action' => 'edit', $new['News']['id'], 'admin' => true),
					array('class' => 'btn btn-default btn-xs')) .
				'</td>';
			echo '</tr>';
		}
	?>
	</tbody>
</table>
<div class="row">
	<div class="col-sm-12 col-md-12">
		<?php echo $this->element('pagination'); ?>
</div>
</div>
<?php //pr($users) ?>