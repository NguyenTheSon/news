<ul class="list-group currency-rates widget-currency-ticker" style="height: 410px; overflow: hidden;">
	<?php foreach ($themes as $theme):?>							  
	<li class="list-group-item">
		<div class="row">
			<div class="col-md-5 col-sm-5 col-xs-5"><?php echo $theme['Theme']['name'] ?></div>
			<div class="col-md-5 col-sm-5 col-xs-5"><small>回答数:  <?php echo $theme['Theme']['view_num'] ?>件</small></div>
			<div class="col-md-2 col-sm-2 col-xs-2">
				<?php
					echo $this->Js->link('<i class="fa fa-arrow-circle-o-right icon-sm"></i>', array('controller'=>'theme', 'action'=>'activitylist', $theme['Theme']['id']), array('update'=>'#resultActivity', 'escape' => false));
					echo $this->Js->writeBuffer();
				?>
			</div>
		</div><!-- /.row -->
	</li>
	<?php endforeach; ?>
</ul>