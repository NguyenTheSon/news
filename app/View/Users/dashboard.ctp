<div class="panel panel-info">
  <div class="panel-heading">
  <h3 class="panel-title">Thông tin cá nhân</h3>
  </div>
  <div class="panel-body">
      <div class="row">
        <div class="col-md-6 col-sm-6 ">
        <?php echo $this->Form->create('User');?>
        <?php echo $this->Form->input('phonenumber', array('class' => 'form-control form-group','label' => "Số điện thoại")); ?>
        <?php echo $this->Form->input('name', array('class' => 'form-control form-group','label' => "Họ Tên")); ?>
        <?php echo $this->Form->input('birthday', array('class' => 'form-control form-group','label' => "Ngày Sinh",'minYear' => date('Y') - 70, 'maxYear' => date('Y'))); ?>
        <?php echo $this->Form->input('password', array('class' => 'form-control form-group', 'label' => 'Mật Khẩu', 'placeholder' => 'Mật khẩu', 'value' => '', 'required' => false)); ?>
        <?php echo $this->Form->input('repassword', array('class' => 'form-control form-group','type' =>'password', 'label' => 'Nhập lại mật khẩu', 'placeholder' => 'Nhập lại mật khẩu', 'value' => '', 'required' => false)); ?>
        <div class="input balance">
            <label for="UserBalance">Số dư tài khoản:</label>
            <?php echo number_format($this->request->data['User']['balance']);?>
        </div>
        <?php echo $this->Form->button('Lưu Lại', array('class' => 'btn btn-primary'));?>
        <?php echo $this->Form->end();?>
            </div>
        </div>
  </div>
</div>