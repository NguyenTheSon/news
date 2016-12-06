<div class="form-group">
<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title">Quản lý Dịch Vụ</h3>
  </div>
  <div class="panel-body">
	    <div class="row">

            <div class="col-sm-2 col-md-2 col-xs-2 search-form pull-left">
                <?php
                echo $this->Form->select('filter_by_date',
                    array(
                        '0' => 'Filter by Date',
                        '1' => 'This Day',
                        '2' => 'Last Day',
                        '3' => 'Tomorrow',
                        '4' => 'This Month',
                        '5' => 'Customize'
                    ),
                    array(
                        'default' => $this->Session->read('Service.filter'),
                        'class' => 'form-control',
                        'id' => 'FilterByDate',
                        'empty' => false,
                        'onchange' => 'customize()'
                    )
                );
                ?>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4 search-form pull-left">
                <!-- HIDDEN BLOCK -->
                <div class="row" id="hidden-input" style="display:none;">
                    <div class="input-group">
                        <input class="form-control" type="date" onchange="filter_submit()" id="begin_date" value="<?php echo $this->Session->read('Service.begin_date') ?>">
                        <span class="input-group-addon">To</span>
                        <input class="form-control" type="date" onchange="filter_submit()" id="end_date" value="<?php echo $this->Session->read('Service.end_date') ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-md-3 col-xs-5 search-form pull-right">
                <?php echo $this->Form->create('Service', array('action'=>'index','id'=>'searchFormProduct'));?>
                    <div class="input-group">
                        <?php echo $this->Form->input('keyword', array('label' => '', 'class' => 'form-control input-sm', 'placeholder' => 'Tìm kiếm', 'value' => $this->Session->read('Service.filter_keyword'))); ?>

                        <div class="input-group-btn">
                        	<?php echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'btn btn-sm  btn-primary')); ?>
                        </div>

                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
        <br />
        <div class="row">
        	<div class="col-sm-12 col-md-12" id="ListProducts">
            	<?php echo $this->element('Feedback/admin_index'); ?>
            </div>
		</div>
		
	</div>
</div>
</div>
<script>

    $( document ).ready(function() {
        if($("#FilterByDate").val() == 5) {
            $('#hidden-input').show();
        } else {
            $('#hidden-input').hide();
        }
    });

    function customize() {
        if($("#FilterByDate").val() == 5) {
            $('#hidden-input').show();
        } else {
            $('#hidden-input').hide();
            var begin_date  = new Date();
            var end_date    = new Date();
            var filter      = $('#FilterByDate').val();
            //alert(begin_date);
            if(filter == 1) {
                end_date.setDate(end_date.getDate() + 1);
            } else {
                if(filter == 2) {
                    begin_date.setDate(begin_date.getDate() - 1);
                } else {
                    if(filter == 3) {
                        begin_date.setDate(begin_date.getDate()+1);
                        end_date.setDate(end_date.getDate() + 2);
                    } else {
                        if(filter == 4) {
                            begin_date.setDate(begin_date.getDate() - begin_date.getDate() + 1);
                            end_date.setDate(end_date.getDate() + 1);
                        } else {
                            begin_date.setDate(begin_date.getDate() - 1000);
                            end_date.setDate(end_date.getDate() + 1);
                        }
                    }
                }
            }
            //alert(begin_date.format('Y-m-d') + ' -> ' + end_date.format('Y-m-d'));
            $.ajax({
                url: '<?php echo Router::url(array("action" => "index"));?>',
                type: 'POST',
                data: {
                    'data[Setup][filter]': $("#FilterByDate").val(),
                    'data[Setup][begin_date]': begin_date.format('Y-m-d'),
                    'data[Setup][end_date]': end_date.format('Y-m-d')
                },
                success: function(data) {
                    $('#ListProducts').html(data);
                },
                error: function(e) {
                    alert('Ajax that bai');
                }
            });
        }
    }

    function filter_submit() {
        var begin_date = new Date($('#begin_date').val());
        var end_date = new Date($('#end_date').val());
        if($('#begin_date').val()) {
            var begin_date = new Date($('#begin_date').val());
        } else {
            var begin_date = new Date();
        }
        if($('#end_date').val()) {
            var end_date = new Date($('#end_date').val());
        } else {
            var end_date = new Date();
        }
        $.ajax({
            url: '<?php echo Router::url(array("action" => "index"));?>',
            type: 'POST',
            data: {
                'data[Setup][filter]': $("#FilterByDate").val(),
                'data[Setup][begin_date]': begin_date.format('Y-m-d'),
                'data[Setup][end_date]': end_date.format('Y-m-d')
            },
            success: function(data) {
                $('#ListProducts').html(data);
            },
            error: function(e) {
                alert('Ajax that bai');
            }
        });
    }
</script>
<?php
  $data = $this->Js->get('#searchFormProduct')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#searchFormProduct')->event(
    'submit',
    $this->Js->request(
      array('action' => 'index', 'controller' => 'Setup',),
      array(
        'update' => '#resultField',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST'
      )
    )
  );
  echo $this->Js->writeBuffer();                                                 
?>