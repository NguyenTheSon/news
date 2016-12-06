<section id="services" class="col-padtop">
  <div class="container">
    <div class="row marbottom">
      <div class="col-sm-12 col-md-7 col-lg-5 pull-right">
        <h2>Dịch vụ của Thanh Huyền Salon</h2>
        <p class="pull-right">Thanh Huyền hair salon luôn mang đến cho các bạn những dịch vụ tuyệt vời nhất bằng đội ngũ nhân viên nhiệt tình và có tay nghề cao.</p>
      </div>
    </div>
    <?php $dem = 0;?>
    <?php foreach($ServiceGroups as $ServiceGroup) :?>
      <?php if($dem%2==0) :?>
       <div class="row marbottom">
        <div class="col-sm-12 col-md-7 col-lg-7 col-padright-none">
          <div class="subtitle">
            <h2 class="titile col-xs-offset-1 col-sm-offset-0 col-md-offset-1 "><?php echo $ServiceGroup['ServiceGroup']['group_name']?></h2>
          </div>
          <img src="<?php echo Router::url("/",true);?>/news/images/cutting.jpg" class="img-responsive" alt="<?php echo $ServiceGroup['ServiceGroup']['group_name']?>"> </div>
          <div class="col-sm-12 col-md-5 col-lg-5 col-padleft-none">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th><?php echo $ServiceGroup['ServiceGroup']['group_name']?></th>
                  <th>NHÂN VIÊN THƯỜNG</th>
                  <th>NHÀ TẠO MẪU</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($ServiceGroup['Service'] as $Service):?>
                  <tr>
                    <td><?php echo $Service['Service']['name']?></td>
                    <td nowrap><?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price'], 0)." VND";?></td>
                    <td nowrap><?php echo number_format($Service['StaffGroup'][1]['StaffGroupService']['price'], 0)." VND";?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php else :?>
        <div class="row marbottom">
          <div class="col-sm-12 col-md-7 col-lg-7 col-padleft-none displayhide">
            <div class="subtitle">
              <h2 class="titile col-xs-offset-2"><?php echo $ServiceGroup['ServiceGroup']['group_name']?></h2>
            </div>
            <div class="subtitle">
              <h2 class="color"><?php echo $ServiceGroup['ServiceGroup']['group_name']?></h2>
            </div>
            <img src="<?php echo Router::url("/",true);?>/news/images/color.jpg" class="img-responsive" alt="<?php echo $ServiceGroup['ServiceGroup']['group_name']?>"> 
          </div>
          <div class="col-sm-12 col-md-5 col-lg-5 col-padright-none">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th><?php echo $ServiceGroup['ServiceGroup']['group_name']?></th>
                  <th>NHÂN VIÊN THƯỜNG</th>
                  <th>NHÀ TẠO MẪU</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($ServiceGroup['Service'] as $Service):?>
                  <tr>
                    <td><?php echo $Service['Service']['name']?></td>
                    <td>
                      <?php echo number_format($Service['StaffGroup'][0]['StaffGroupService']['price'], 0)." VND";?>
                    </td>
                    <td>
                      <?php echo number_format($Service['StaffGroup'][1]['StaffGroupService']['price'], 0)." VND";?>
                    </td>
                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
          <div class="col-sm-12 col-md-7 col-lg-7 col-padleft-none displayvisible">
            <div class="subtitle">
              <h2 class="titile col-xs-offset-2"><?php echo $ServiceGroup['ServiceGroup']['group_name']?></h2>
            </div>
            <img src="<?php echo Router::url("/",true);?>/news/images/color.jpg" class="img-responsive" alt="<?php echo $ServiceGroup['ServiceGroup']['group_name']?>"> 
          </div>
        </div>
      <?php endif; ?>
      <?php $dem++;?>
    <?php endforeach; ?>
  </div>
</section>