<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12"> 
  <!-- Video Detail Started -->
  <div class="blogdetail videodetail sections">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="blogtext">
          <div class="col-md-2 col-md-offset-1">
            <div class="img-award">
              <img src="<?php echo $detail['Award']['imgavatar'];?>" class="img-responsive" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <h2 class="hoten">
              <span><?php echo $detail['Award']['name'];?></span>
              <span>- MS : </span>
              <span style="color: #d20101;"><?php echo $detail['Award']['ide_number'];?></span>
            </h2>
            <div class="phonenumber">Số điện thoại : <?php echo $detail['Award']['phonenumber'];?></div>
            <div class="info">Thông tin thêm : <?php echo $detail['Award']['note'];?></div>
            <div class="vote">
              <span>Lượt bình chọn hiện tại: </span>
              <span style="color: #d20101;"><?php echo $detail['Award']['vote'];?></span>
            </div>
            <div class="cuphap">
              Để bình chọn cho <?php echo $detail['Award']['name'];?> - MS: <font color="#d20101"><b><?php echo $detail['Award']['ide_number'];?></b></font><br>
              Soạn Tin: <b><font color="#d20101">KeoVang <?php echo $detail['Award']['ide_number'];?></font></b> Gửi <b>8373</b><br><font color="#000" size="-1"><i>(<font color="#d20101">KeoVang<font color="#000" size="-1"><i>&lt;dấu cách&gt;</i></font><?php echo $detail['Award']['ide_number'];?></font> Gửi <b>8373</b>)</i></font>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div style="border-bottom: 2px solid #9a50c7; margin-bottom: 15px;">
          <p style="padding: 10px 30px 10px 20px;font-size: 14px;background: #9a50c7;display: inline-block;font-weight: bold;border-top-right-radius: 25px; color: #fff;">Một số hình ảnh khác</p>
        </div>
        <div class="oimg" style="text-align: center;">
        <?php for($i =0; $i < count($detail['Award']['images']); $i++):?>
            <img  src="<?php echo $detail['Award']['images'][$i];?>" style="padding-bottom:15px;">
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
</div>