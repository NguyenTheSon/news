 <div class="col-sm-12 col-md-12 col-lg-12 appfrmleft">
  <div class="form-group">
    <label>Họ tên</label>
    <input type="text" name="FullName" id="AppointmentFullName" class="form-control required" value="<?php echo $info['name'];?>">
  </div>
  <div class="form-group mt-right0">
    <label>Địa chỉ Email</label>
    <input type="text" class="form-control" name="Email" id="AppointmentEmail" value="<?php echo $info['address'];?>"/>
  </div>
  <div class="form-group">
    <label>Số điện thoại</label>
    <input type="text" name="ContactNumber" id="AppointmentContactNumber" class="form-control required number" value="<?php echo $info['phonenumber'];?>">
  </div>
  <div hidden class="form-group mt-right0">
    <div class="input-append dateinput">
      <label class="control-label">Nhân viên</label>
      <input hidden type="text" class="form-control required" name="Staff_id" id="AppointmentStaff" />
    </div>
    <div hidden class="time">
      <label>Thời gian</label>
      <input hidden type="text" class="form-control" name="Time" id="AppointmentTime"/>
    </div>
  </div>
</div>
<div class="col-sm-12 col-md-12 col-lg-12 appfrmright">
  <div class="form-group textarea">
    <label>Dịch vụ</label>
    <div class="boxes" style="height: auto;">
      <div class="row">
        <fieldset class="" style="padding:0px;margin:0px;">
          <div class="accordion" style="padding:0px;">
            <?php foreach ($ServiceGroups as $key => $Group) :?>
              <h3 style="margin:0px;"><?php echo $Group['ServiceGroup']['group_name']; ?></h3>
              <div>
                <table class='table table-striped table-bordered table-hover table-primary table-hover service-list' style="color:#000;margin:0px;">
                 <tr>
                  <td width="70%">Loại dịch vụ</td>
                  <td width="30%">Giá</td>
                </tr>
                <?php foreach ($Group['Service'] as $key => $Service) :?>
                  <tr>
                    <td width="40%">
                    <input type="checkbox" class="choose-service" value="<?php echo $Service['StaffGroup'][0]['StaffGroupService']['id'];?>" id="service-<?php echo $Service['StaffGroup'][0]['StaffGroupService']['id'];?>"> 
                      <?php echo $Service['Service']['name'];?>
                      </td>
                    <td width="20%">
                      <?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price'], 0);?>
                        
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          <?php endforeach; ?>
        </div>
      </fieldset>
    </div>
  </div>
</div>
</div> 