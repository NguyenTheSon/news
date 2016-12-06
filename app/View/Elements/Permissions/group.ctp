<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th colspan="2"><?php echo $group['UserGroup']['name'] . ' Controller'; ?></th>
        <th>Action</th>
    </tr>
    <tr>
        <th width="40%">Controllers</th>
        <th width="40%">Actions</th>
        <th>
            <?php
            echo $this->Html->image('/img/icon_1.png',
                array(
                    'id' => 'group_allow_all',
                    'style' => 'cursor: pointer; margin-right: 5px;'
                )
            );
            echo $this->Html->image('/img/icon_0.png',
                array(
                    'id' => 'group_deny_all',
                    'style' => 'cursor: pointer; margin-right: 5px;'
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
                    if($this->Permission->checkGroupPermission($gid, $action['id'])) {
                        echo $this->Html->image('/img/icon_1.png', array('style' => 'cursor: pointer;', 'class' => 'allow changeActionBt', 'gid' => $gid, 'aid' => $action['id']));
                    } else {
                        echo $this->Html->image('/img/icon_0.png', array('style' => 'cursor: pointer;', 'class' => 'deny changeActionBt', 'gid' => $gid, 'aid' => $action['id']));
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
    $('#group_allow_all').click(function() {
        var gid = $('.changeActionBt').attr('gid');
        $('.changeActionBt[gid = ' + gid + ']').attr('src', '/img/icon_1.png');
        $.ajax({
            url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_allow_all"));?>',
            type: 'POST',
            data: {
                'gid': gid
            },
            success: function(data) {
                toastr.success("Cập nhật thành công!");
            },
            error: function(e) {
                toastr.error("Có lỗi. vui lòng thử lại");
            }
        });
    });
    $('#group_deny_all').click(function() {
        var gid = $('.changeActionBt').attr('gid');
        $('.changeActionBt[gid = ' + gid + ']').attr('src', '/img/icon_0.png');
        $.ajax({
            url: '<?php echo Router::url(array( "controller" => "permissions","action" => "admin_deny_all"));?>',
            type: 'POST',
            data: {
                'gid': gid
            },
            success: function(data) {
                toastr.success("Cập nhật thành công!");
            },
            error: function(e) {
                toastr.error("Có lỗi. vui lòng thử lại");
            }
        });
    });
</script>