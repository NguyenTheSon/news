<div class="form-group textarea">
  <label>Dịch vụ</label>
  <div class="boxes" style="height: 450px;">
    <div class="row">
      <fieldset class="" style="padding:0px;margin:0px;">
        <div class="accordion" style="padding:0px;">
          <?php foreach ($ServiceGroups as $key => $Group) :?>
            <h3 style="margin:0px;"><?php echo $Group['ServiceGroup']['group_name']; ?></h3>
            <div>
              <table class='table table-striped table-bordered table-hover table-primary table-hover service-list' style="color:#000;margin:0px;">
               <tr>
                <td width="30%">Loại dịch vụ</td>
                <td width="15%">Gía</td>
                <td width="15%">Chọn hay không chọn</td>
              </tr>
              <?php foreach ($Group['Service'] as $key => $Service) :?>
                <tr>
                  <td width="30%"><?php echo $Service['Service']['name'];?></td>

                  <td width="15%"><input type="radio" name="data[Service][<?php echo $Service['Service']['id'];?>]" value="<?php echo $Service['StaffGroup'][0]['StaffGroupService']['id'];?>" data-price="<?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price']);?>" > <?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price'], 0);?></td>
                  <td width="15%"><input type="radio" name="data[Service][<?php echo $Service['Service']['id'];?>]" value="0" checked='' data-price="0"></td>
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