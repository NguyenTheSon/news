<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th colspan="2">All</th>
        <th>Action</th>
    </tr>
    <tr>
        <th width="40%">Controllers</th>
        <th width="40%">Actions</th>
        <th>
            <?php
                echo $this->Html->image('/img/icon_1.png',
                    array(
                        'id' => 'user_allow_all',
                        'style' => 'cursor: pointer; margin-right: 5px;'
                    )
                );
                echo $this->Html->image('/img/icon_0.png',
                    array(
                        'id' => 'user_deny_all',
                        'style' => 'cursor: pointer; margin-right: 5px;'
                    )
                );
                echo $this->Html->image('/img/icon_refresh.png',
                    array(
                        'id' => 'user_refresh',
                        'style' => 'cursor: pointer;'
                    )
                );
            ?>
        </th>
    </tr>
    <?php
    foreach($controllers as $controller => $actions) {
        if($actions != null) {
            $count = sizeof($actions);
            $first = true;
            foreach($actions as $key => $action) {
                echo '<tr>';
                if($first == true) {
                    $first = false;
                    echo '<td style="vertical-align: middle;" rowspan="' . $count . '">'. $controller . '</td>';
                }
                echo '<td>' . $action['action'] . '</td>';

                echo '<td>';
                if($this->Permission->checkUserPermission($uid, $action['id'])) {
                    echo $this->Html->image('/img/icon_1.png', array('style' => 'cursor: pointer;', 'class' => 'allow changeActionBt', 'uid' => $uid, 'aid' => $action['id']));
                } else {
                    echo $this->Html->image('/img/icon_0.png', array('style' => 'cursor: pointer;', 'class' => 'deny changeActionBt', 'uid' => $uid, 'aid' => $action['id']));
                }
                echo '</td>';
                echo '</tr>';
            }
        } else {
            //echo 'Controller ' . $controller . ' is Null !!!';
        }
    }
    ?>
</table>
<script language="JavaScript">
    $( "#UserPermissions" ).on( "click", ".changeActionBt", function() {
        if($(this).hasClass('allow')) {
            $(this).addClass('deny');
            $(this).removeClass('allow');
            $(this).attr('src', '/img/icon_0.png');
            var uid = $(this).attr('uid');
            var aid = $(this).attr('aid');
            $.ajax({
                url: '<?php echo Router::url(array( "controller" => "permissions","action" => "deny"));?>',
                type: 'POST',
                data: {
                    'uid': uid,
                    'aid': aid
                },
                success: function(data) {
                    //alert('Thanh cong');
                },
                error: function(e) {
                    alert('Error, Ajax thất bại !!!');
                }
            });
        } else {
            $(this).addClass('allow');
            $(this).removeClass('deny');
            $(this).attr('src', '/img/icon_1.png');
            var uid = $(this).attr('uid');
            var aid = $(this).attr('aid');
            $.ajax({
                url: '<?php echo Router::url(array( "controller" => "permissions","action" => "allow"));?>',
                type: 'POST',
                data: {
                    'uid': uid,
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
    $('#user_allow_all').click(function() {
        var uid = $('.changeActionBt').attr('uid');
        $('.changeActionBt[uid = ' + uid + ']').attr('src', '/img/icon_1.png');
        $.ajax({
            url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_allow_all"));?>',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function(data) {
                toastr.success("Cập nhật thành công!");
            },
            error: function(e) {
                toastr.error("Có lỗi. vui lòng thử lại");
            }
        });
    });
    $('#user_deny_all').click(function() {
        var uid = $('.changeActionBt').attr('uid');
        $('.changeActionBt[uid = ' + uid + ']').attr('src', '/img/icon_0.png');
        $.ajax({
            url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_deny_all"));?>',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function(data) {
                toastr.success("Cập nhật thành công!");
            },
            error: function(e) {
                toastr.error("Có lỗi. vui lòng thử lại");
            }
        });
    });
    $('#user_refresh').click(function() {
        var uid = $('.changeActionBt').attr('uid');
        $.ajax({
            url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_user_refresh"));?>',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function(data) {
                 $('table').html(data);
                toastr.success("Cập nhật thành công!");
            },
            error: function(e) {
                toastr.error("Có lỗi. vui lòng thử lại");
            }
        });
    });
</script>