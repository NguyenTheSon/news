<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Đăng tin mới</h3>
  </div>
  <div class="panel-body">
	    <div class="row">
	    	<div class="col-md-12 col-sm-12 ">
	    	<?php echo $this->Form->create('Bill', array('method' => 'post'));?>
			<?php echo $this->Form->input('customer', array('class' => 'form-control form-group', 'label' => 'Tên hoặc SDT')); ?>
			<div class="col-md-12 userinfo" style="">
				<input type="hidden" name="data[Bill][user_id]" id="user_id" value="<?php echo isset($this->request->data['Bill']) ? $this->request->data['Bill']['user_id']: "";?>">
				<table class=' col-md-6 table table-striped table-bordered table-hover table-primary table-hover'>
				<tr>
					<td>Họ Tên</td>
					<td class="name"><?php echo isset($this->request->data['Bill']) ? $this->request->data['User']['name']: "";?></td>
				</tr>
				<tr>
					<td>Số điện thoại</td>
					<td class="phonenumber"><?php echo isset($this->request->data['Bill']) ? $this->request->data['User']['phonenumber']:"";?></td>
				</tr>
				<tr>
					<td>Địa chỉ</td>
					<td class="address"><?php echo isset($this->request->data['Bill']) ? $this->request->data['User']['address']:"";?></td>
				</tr>
				<tr>
					<td>Số dư</td>
					<td class="balance"><?php echo isset($this->request->data['User']['balance']) ? number_format($this->request->data['User']['balance']):"0";?></td>
				</tr>
				</table>
			</div>
			<?php echo $this->Form->input('discount', array('class' => 'form-control form-group', 'label' => 'Khuyến Mại','value' => '0')); ?>
			<?php echo $this->Form->input('pay_type', array('class' => 'form-control form-group', 'label' => 'Hình thức thanh toán','options' => array("0" => "Tiền mặt", "1" => "Tài khoản thẻ"),'default' => 0)); ?>

	    		<fieldset class="list-category-border">
	            	  <legend class="list-category-border">Chọn loại dịch vụ</legend>
	            	  <div class="accordion">
					<?php
						foreach ($ServiceGroups as $key => $Group) {
					?>
						 	<h3><?php echo $Group['ServiceGroup']['group_name']; ?></h3>
						 	<div>
						 		<table class='table table-striped table-bordered table-hover table-primary table-hover service-list'>
						 		<?php
						 		foreach ($Group['Service'] as $key => $Service) {
						 			?>
						 			<tr>
								 		<td width="30%"><?php echo $Service['Service']['name'];?></td>
								 		<td width="15%"><input type="radio" name="data[Service][<?php echo $Service['Service']['id'];?>]" value="0" checked='' data-price="0"> Không</td>

								 		<td width="15%"><input type="radio" name="data[Service][<?php echo $Service['Service']['id'];?>]" value="<?php echo $Service['StaffGroup'][0]['StaffGroupService']['id'];?>" data-price="<?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price']);?>" <?php echo ($Service['StaffGroup'][0]['StaffGroupService']['selected']? "checked=''":"");?> > Nhân Viên</td>

								 		<td width="15%"><input type="radio" name="data[Service][<?php echo $Service['Service']['id'];?>]" value="<?php echo $Service['StaffGroup'][1]['StaffGroupService']['id'];?>" data-price="<?php echo number_format($Service['StaffGroup'][1]['StaffGroupService']['price']);?>" <?php echo ($Service['StaffGroup'][1]['StaffGroupService']['selected']? "checked=''":"");?> > Nhà Tạo Mẫu</td>
								 		<td width="20%" class="price"><?php echo ($Service['StaffGroup'][0]['StaffGroupService']['selected']? number_format($Service['StaffGroup'][0]['StaffGroupService']['price']) : ($Service['StaffGroup'][1]['StaffGroupService']['selected']? number_format($Service['StaffGroup'][1]['StaffGroupService']['price']) : "0"));?></td>
								 	</tr>
						 			<?php
						 		}
						 		?>
						 		</table>
							 </div>
					<?php
						 } 
					?>
				</div>
				</fieldset>
				<fieldset class="list-category-border">
	            	  <legend class="list-category-border">Chi Phí</legend>
	            	<table class="money_detail">
	            		<tr><td><b>Tổng tiền:</b></td><td><span class="total_money"><?php echo isset($this->request->data['Bill']) ? number_format($this->request->data['Bill']['total_money']) :"";?></span></td></tr>
	            		<tr><td><b>Khuyến mại:</b></td><td><span class="total_discount"><?php echo isset($this->request->data['Bill']) ? number_format($this->request->data['Bill']['discount']):"";?></span></td></tr>
	            		<tr><td><b>Thành tiền:</b></td><td><span class="money"><?php echo isset($this->request->data['Bill']) ? number_format($this->request->data['Bill']['total_money'] - $this->request->data['Bill']['discount']) :"";?></span></td></tr>
	            	</table>
	      
				</fieldset>
		
			<?php echo $this->Html->link('Quay Lại', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>

			<?php echo $this->Form->button('Thêm Hóa Đơn', array('class' => 'btn btn-primary')); ?>

			<?php echo $this->Form->end(); ?>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		var icons = { 
	      header: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-e",
	      activeHeader: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"
	    };
	    $( ".accordion" ).accordion({
	    	collapsible: false,
	    	icons: icons,
	    });
	    $(".service-list input[type=radio]").click(function(){
	    	var price = $(this).attr("data-price");
	    	$(this).parents("tr").find(".price").html(price);
	    	var total = 0;
	    	$(".price").each(function(index, el) {
	    		total += parseInt($(el).html())*1000;
	    	});
	    	$(".total_money").html(total.format());
	    	calculatemoney();
	    });
	    $("#BillDiscount").keyup(function(){
	    	var val = parseInt($(this).val());
	    	$(".total_discount").html(val.format());
	    	calculatemoney();
	    });

	    $( "#BillCustomer" ).autocomplete({
		      source: function( request, response ) {
		      	$(".userinfo").hide();
		      	$("#user_id").val(0);
		        $.ajax({
		          url: "<?php echo Router::url(array('action' => 'find_user',)); ?>",
		          type: "POST",
		          dataType: "json",
		          data: {
		            q: request.term
		          },
		          success: function( data ) {
		            response( data );
		          }
		        });
		      },
		      select: function( event, ui ) {
		      //  $("#new_userid").val(ui.item.id);
		      		$(".userinfo").show();
		      		$("#user_id").val(ui.item.id);
		      		$(".userinfo .name").html(ui.item.name);
		      		$(".userinfo .phonenumber").html(ui.item.phonenumber);
		      		$(".userinfo .address").html(ui.item.address);
		      		$(".userinfo .balance").html(parseInt(ui.item.balance).format());
		      		$("#BillCustomer").val(ui.item.name);
		    	}
		    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
		      return $( "<li>" )
		        .append( "<a>" + item.name + "<br><i>" + item.phonenumber + "</i></a>" )
		        .appendTo( ul );
		};
	 });
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};
function calculatemoney(){
	var total = parseInt($(".total_money").html().replace(/,/g,''));
	var discount = parseInt($(".total_discount").html().replace(/,/g,'')) || 0;
	
	money = total - discount;
	$(".money").html(money.format());
}
</script>
<style type="text/css">
	.money_detail td{
		text-align: right;
		padding-right: 5px;
	}
</style>