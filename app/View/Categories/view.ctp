<div class="contents">
    <div class="custom-container color-background">
        <div class="row">
            <!-- Bread Crumb Start -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active"><?php echo $currentcate['Category']['name'];?></li>
                </ol>
            </div>
            <!-- Bread Crumb End -->
            <!-- Content Column Start -->
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 equalcol conentsection"> 

                <?php echo $this->element('Categories/list-item-two');?>

                
                <ul class="pagination">
                   <li><?php echo $this->Paginator->first('«', array(), null, array('class' => 'first disabled')); ?></li>

                   <li><?php echo $this->Paginator->prev('‹', array(), null, array('class' => 'prev disabled')); ?></li>

                   <li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>

                   <li><?php echo $this->Paginator->next('›', array(), null, array('class' => 'next disabled')); ?></li>

                   <li><?php echo $this->Paginator->last('»', array(), null, array('class' => 'last disabled')); ?></li>
               </ul>
               <div class="clearfix"></div>
               <!-- Pagination End -->
           </div>
           <!-- Content Column End -->
           <!-- Gray Sidebar Start -->
           <?php echo $this->element('landing/right_home');?>
           <!-- Gray Sidebar End -->
       </div>
   </div>
</div>