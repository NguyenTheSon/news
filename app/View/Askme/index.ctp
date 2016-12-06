  <link rel="stylesheet" type="text/css" href="<?=Router::url("/",true);?>/news/css/bootstrap1.css">
  <section id="appoinment" class="col-padtop">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="appoimentbg" style="background: transparent url('<?=Router::url("/",true);?>/news/images/askme-bg.jpg') no-repeat fixed center top;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2>Tư vấn dịch vụ</h2>
              <p>Hãy gửi cho chúng tôi những vướng mắc của các bạn. Chúng tôi sẽ cùng bạn giải quyết những vướng mắc đó một cách chuyên nghiệp nhất</p>
            </div>
            <div class="clearfix"></div>
                 <div id="SuccessMessage"><?php echo $msg_success;?></div>
                 <div id="ErrorMessage"></div>
                 <form name="AskMe" id="AskMe" method="post"  enctype="multipart/form-data">
                   <input type="text" name="UserID" hidden value="1">
                   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 appfrmleft">
                    <div class="form-group" style="width:100%;">
                      <label>Tiêu đề câu hỏi:</label>
                      <input type="text" name="title" id="question" class="form-control required" style="color: #fff;">
                    </div>
                     <div class="form-group " style="width:100%;">
                      <label>Nội dung câu hỏi</label>
                      <textarea class="form-control required" name="content" id="AppointmentEmail" style="color: #fff;"></textarea>
                    </div>
                     <div class="form-group " style="width:100%;">
                      <label>Hình ảnh đính kèm</label>
                      <input type="file" name="data[img][0]" id="" class="" style="color: #fff;">
                       <input type="file" name="data[img][1]" id="" class="" style="color: #fff;">
                        <input type="file" name="data[img][2]" id="" class="" style="color: #fff;">
                    </div>
                    <div id="loading" style="width:100%;"><?php echo $loading;?></div>
                   <div class="form-group " style="width:100%;">
                         <div class="submitbtn">
                            <button type="setup" class="btn btn-default" value="Submit" >SUBMIT</button>
                         </div>	
                  </div>

                   </div>
                   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 appfrmright">
                    <label>Câu hỏi thường gặp</label>
                   </div> 
                 </form>
                 <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
    <section id="services" class="col-padtop">
    <div class="container">
      <div class="row marbottom">
        <div class="hidden-xs col-sm-12 col-md-4 col-lg-4 col-padleft-none">
          <div class="subtitle">
            <h4 class="titile col-xs-offset-1 col-sm-offset-0 col-md-offset-1 ">Chúng tôi trên facebook</h4>
          </div>
        <div class="fb-page" data-href="https://www.facebook.com/facebook" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"></div></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-padright-none">
          <div class="subtitle">
            <h4 class="titile col-xs-offset-1 col-sm-offset-0 col-md-offset-1 ">Câu hỏi mới nhất</h4>
          </div>
          <?
            $dem =0;
            foreach($Questions as $q)
            {
              if($dem%2==0)
              {
          ?>
          <div class="col-sm-4 col-md-4 col-lg-4">
            <a href="<? echo Router::url("/",true);?>Askme/detail/<? echo $q["Question"]["id"];?>"><img src="<? if($q["Question"]["image"]!=""){ $img = explode("|",$q["Question"]["image"]); echo $img[0];} else echo Router::url("/",true)."news/images/question.png" ?>" style="width:200px;height:auto;"></a>
          </div>
          <div class="col-sm-8 col-md-8 col-lg-8" style="min-height:200px;">
             <a href="<? echo Router::url("/",true);?>Askme/detail/<? echo $q["Question"]["id"];?>"><label><?php echo $q["Question"]["question"]?></label></a>
            <p><?php echo $q["Question"]["content"]?></p>
            <div class="fb-like" data-href="http://haihip.com"></div>
          </div>
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height:20px;border-top:1px black solid;">
           </div>
           <?
              }
              else
              {
           ?>
          <div class="col-sm-8 col-md-8 col-lg-8" style="min-height:200px;">
             <a href="<? echo Router::url("/",true);?>Askme/detail/<? echo $q["Question"]["id"];?>"><label><?php echo $q["Question"]["question"]?></label></a>
            <p><?php echo $q["Question"]["content"]?></p>
            <div class="fb-like" data-href="http://haihip.com"></div>
          </div>

             <div class="col-sm-4 col-md-4 col-lg-4">
             <a href="<? echo Router::url("/",true);?>Askme/detail/<? echo $q["Question"]["id"];?>"><img src="<? if($q["Question"]["image"]!=""){ $img = explode("|",$q["Question"]["image"]); echo $img[0];} else echo Router::url("/",true)."news/images/question.png" ?>" style="width:200px;height:auto;"></a>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-12" style="min-height:20px;border-top:1px black solid;">
           </div>
          <?
              }
              $dem++;
            }
          ?>

        </div>
      </div>
    </div>
