<div class="form-group">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Group Permissions</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-md-offset-2" id="GroupPermissions">
                    <?php echo $this->element('Permissions/group') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    $( "#GroupPermissions" ).on( "click", ".changeActionBt", function() {
        if($(this).hasClass('allow')) {
            $(this).addClass('deny');
            $(this).removeClass('allow');
            $(this).attr('src', '/img/icon_0.png');
            var gid = $(this).attr('gid');
            var aid = $(this).attr('aid');
            $.ajax({
                url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_deny"));?>',
                type: 'POST',
                data: {
                    'gid': gid,
                    'aid': aid
                },
                success: function(data) {
                    toastr.success("Cập nhật thành công!");
                },
                error: function(e) {
                    toastr.error("Có lỗi. vui lòng thử lại");
                }
            });
        } else {
            $(this).addClass('allow');
            $(this).removeClass('deny');
            $(this).attr('src', '/img/icon_1.png');
            var gid = $(this).attr('gid');
            var aid = $(this).attr('aid');
            $.ajax({
                url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_allow"));?>',
                type: 'POST',
                data: {
                    'gid': gid,
                    'aid': aid
                },
                success: function(data) {
                    toastr.success("Cập nhật thành công!");
                },
                error: function(e) {
                    toastr.error("Có lỗi. vui lòng thử lại");
                }
            });
        }
    });
</script>
