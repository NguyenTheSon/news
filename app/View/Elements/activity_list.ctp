<div class="col-sm-6 col-xs-12">
	<div class="panel panel-warning panel-square panel-no-border">
		<div class="panel-heading">
			<h2 class="panel-title"><i class="fa fa-question-circle"></i> 活動一覧</h2>
		 </div>
	<?php if(isset($activities)) { ?>
		<ul class="list-group currency-rates widget-currency-ticker" style="height: 410px; overflow: hidden;">
			<?php foreach ($activities as $activity):?>							  
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-5 col-sm-5 col-xs-5"><?php echo $activity['Activity']['content'] ?></div>
					<div class="col-md-5 col-sm-5 col-xs-5"><small>回答数:  <?php echo $activity['Activity']['view_num'] ?>件</small></div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<i class="fa fa-arrow-circle-o-right icon-sm"></i>
					</div>
				</div><!-- /.row -->
			</li>
			<?php endforeach; ?>
		</ul>
	<?php } ?>
	</div>
</div>