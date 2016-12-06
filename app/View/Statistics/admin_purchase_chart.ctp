<div class="container-fluid">
          <div class="the-box">
            <label>Biểu đồ giao dịch theo tuần</label><br>
            <select class="" id="chartweek">
              <option value="last week">Tuần trước</option>
              <option value="this week" selected=''>Tuần này</option>
            </select>
            <div id="morris-line-week" style="height: 250px;"></div>
            <div><br><br></div>
            <label>Biểu đồ giao dịch theo tháng</label><br>
            <select class="chartmonth" id="chartmonth_m">
             <?php
              for ($i=1; $i <=12; $i++){
                echo "<option value='$i' ".($i==date("m") ? "selected=''": "").">Tháng $i</option>";
              }
             ?>
            </select>
            <select class="chartmonth" id="chartmonth_y">
             <?php
              for ($i=2015; $i <=date("Y"); $i++){
                echo "<option value='$i' ".($i==date("Y") ? "selected=''": "").">Năm $i</option>";
              }
             ?>
            </select>
            <div id="morris-line-month" style="height: 250px;"></div>
            <div><br><br></div>
            <label>Biểu đồ giao dịch theo năm</label><br>
            <select class="chartyear" id="chartyear">
             <?php
              for ($i=2015; $i <=date("Y"); $i++){
                echo "<option value='$i' ".($i==date("Y") ? "selected=''": "").">Năm $i</option>";
              }
             ?>
            </select>
            <div id="morris-chart-year" style="height: 250px;"></div>
            <!-- <div id="month"><div id="week"> -->
              </div>
              </div>
            </div>
             </div><!-- /.the-box -->
          </div><!-- /.the-box -->
        </div>
 <script type="text/javascript">
/////////////////////////////////////////////
  $("#chartweek").change(function(event) {
   var value = $(this).val();
     $.ajax({
       url: '<?php echo Router::url(array("controller" => "Statistics", "action" => "admin_purchase_chart")); ?>',
       type: 'POST',
       dataType: 'json',
       data: {type: 'week', 'date': {'week': value}},
     })
     .done(function(data) {
        var data_chart = [];
        $.each(data,function(index, el) {
          data_chart.push({y: el.date, a: el.value});
        });
        //clear old chart
        $("#morris-line-week").html('');
        Morris.Line({
        element: 'morris-line-week',
        data: data_chart,
        xkey: 'y',
        ykeys: 'a',
        labels: ["Giao dịch"],
        resize: true,
        lineColors: ['#8CC152', '#F6BB42']
      });
     })
     .fail(function() {
       toastr.error("Không thể tải dữ liệu biểu đồ");
     })
  });

  ///
  $(".chartmonth").change(function(event) {
    var month = $("#chartmonth_m").val();
    var year = $("#chartmonth_y").val();
     $.ajax({
       url: '<?php echo Router::url(array("controller" => "Statistics", "action" => "admin_purchase_chart")); ?>',
       type: 'POST',
       dataType: 'json',
       data: {type: 'month', 'date': {'month': month, 'year': year}},
     })
     .done(function(data) {
        var data_chart = [];
        $.each(data,function(index, el) {
          data_chart.push({y: el.date, a: el.value});
        });
        //clear old chart
        $("#morris-line-month").html('');
        Morris.Line({
        element: 'morris-line-month',
        data: data_chart,
        xkey: 'y',
        ykeys: 'a',
        labels: ["Giao dịch"],
        resize: true,
        lineColors: ['#8CC152', '#F6BB42']
      });
     })
     .fail(function() {
       toastr.error("Không thể tải dữ liệu biểu đồ");
     })
  });
  /////////////////////////
  $("#chartyear").change(function(event) {
   var value = $(this).val();
     $.ajax({
       url: '<?php echo Router::url(array("controller" => "Statistics", "action" => "admin_purchase_chart")); ?>',
       type: 'POST',
       dataType: 'json',
       data: {type: 'year', 'date': {'year': value}},
     })
     .done(function(data) {
        var data_chart = [];
        $.each(data,function(index, el) {
          data_chart.push({y: el.date, a: el.value});
        });
        //clear old chart
        $("#morris-chart-year").html('');
        Morris.Bar({
          element: 'morris-chart-year',
          data: data_chart,
          xkey: 'y',
          ykeys: ['a'],
          labels: ['Giao dịch']
        });
     })
     .fail(function() {
       toastr.error("Không thể tải dữ liệu biểu đồ");
     })
  });
  $( document ).ready(function(){
    $("#chartweek").change();
    $(".chartmonth").change();
    $("#chartyear").change();
  });
    
</script>