<link rel="stylesheet" type="text/css" href="<?php echo Router::url("/",true);?>news/css/bootstrap1.css">
<link rel="stylesheet" type="text/css" href="<?php echo Router::url("/",true);?>css/jquery-ui.css" />
<script type="text/javascript" src="<?php echo Router::url("/",true);?>js/jquery-ui.js"></script>

<style type="text/css">
  fieldset.list-category-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
  }

  legend.list-category-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    white-space: nowrap;
  }
</style>
<section id="appoinment" class="col-padtop">
  <div class="container">
    <div class="row">
      <div class="appoimentbg">
        <div class="col-sm-12 col-md-9 col-lg-8">
          <h2>Đặt lịch</h2>
          <p>Đặt lịch trước để hưởng những khuyến mại hấp dẫn từ Thanh Huyền Salon</p>
        </div>
        <div class="clearfix"></div>
        <div class="appfrm">	
          <div id="SuccessMessage"></div>
          <div id="ErrorMessage"></div>
          <div class="col-xs-12 col-lg-4">
            <label>1. Chọn ngày bạn muốn làm dịch vụ</label>
            <div id="input-calendar"></div>
          </div>
          <div class="col-xs-12 col-lg-8">
            <label>2. Chọn giờ và nhân viên</label>
            <div id="day-schedule"></div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
</section>
<?php echo $this->element('Setup/setup_service');?>
</div>
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="AppointmentFrm" id="AppointmentFrm" method="post" action="<?php echo Router::url(array('controller' => 'Setup','action' => 'index'));?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Thông tin đặt lịch</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
              <?php echo $this->element('Setup/form_setup');?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closed_modal" type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-primary sent-setup">Lưu lại</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $this->element('Setup/popup_content');?>
<script>
  var icons = { 
    header: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-e",
    activeHeader: "ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"
  };
  $( ".accordion" ).accordion({
    collapsible: false,
    icons: icons,
  });
  $('#input-calendar').pignoseCalendar({
    buttons: false,
    select: function(date, obj) {
      if(date[0] !== null){

        changeDateSetup(date[0].format('YYYY-MM-DD'));
      }
      
    }
  });
</script>
<script src="../news/js/index.js"></script>
<script>
  (function ($) {
    $("#day-schedule").dayScheduleSelector({
      days: <?php echo $ListStaffID;?>,
      stringDays : <?php echo $ListStaffName;?>,
    });
    $("#day-schedule").on('selected.artsy.dayScheduleSelector', function (e, selected) {
      //xu ly sau khi da chon 1 ngay nao do.....
      console.log(selected);
      var Staff_id = $(selected).data("day");
      var time = $(selected).data("time"); 
      var date = $("#input-calendar .pignose-calendar-unit-first-active").data("date");
      
      if(!checkDate(date)){
        alert("Bạn chỉ được đặt lịch ở ngày hôm nay hoặc các ngày tiếp theo.");
        setTimeout(function(){
          $(selected).click();
        },0);
        return false;
      }
      $('#AppointmentStaff').val(Staff_id);
      $('#AppointmentTime').val(time);  
      console.log(Staff_id, time);
      $('#modal').modal('show');
    });
    $("#day-schedule").on('unselected.artsy.dayScheduleSelector', function (e, selected) {
      //xu ly sau khi bo chon 1 ngay nao do.....
      console.log(selected);
      var Staff_id = $(selected).data("day");
      var time = $(selected).data("time");
      console.log(Staff_id, time);
    });
    //khi doi ngay thi ajax de lay dataTask moi roi goi lai ham nay la xong
    var dataTask = <?php echo $listTask;?>;
    $("#day-schedule").data('artsy.dayScheduleSelector').deserialize(dataTask);
  })($);
  $('.id-day').click(function(){
    $('#modal-day').modal('show');
    var id_staff = $(this).data("id");
    console.log(id_staff);
    $.ajax({
      url : '/Setup/show',
      type : 'post',
      dataType : 'json',
      data : {
        id : id_staff,
      },
      success : function (result)
      {

      }
    });
  });
</script>