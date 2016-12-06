<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th width="5%"><?php echo $this->Paginator->sort('User.id', 'ID'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('User.name', 'UserName'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('User.phonenumber', 'Phone number'); ?></th>
        <th>Action</th>
    </tr>
    <?php
    foreach($users as $user) {
        echo '<tr>';
            echo '<td>' . $user['User']['id'] . '</td>';
            echo '<td>' . $user['User']['name'] . '</td>';
            echo '<td>' . $user['User']['email'] . '</td>';
            echo '<td>' . $user['User']['phonenumber'] . '</td>';
            echo '<td width="10%">';
                echo $this->Html->link('Permission',
                    array('controller' => 'permissions','action' => 'user_details', $user['User']['id']),
                    array('class' => 'btn btn-default btn-xs')
                );
            echo '</td>';
        echo '</tr>';
    }
    ?>
</table>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <?php echo $this->element('pagination-counter'); ?>
        <?php echo $this->element('pagination'); ?>
    </div>
</div>