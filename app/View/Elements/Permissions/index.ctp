<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
        <th><?php echo $this->Paginator->sort('name', 'Groups'); ?></th>
        <th><?php echo $this->Paginator->sort('description', 'Description'); ?></th>
        <th>Action</th>
    </tr>
    <?php
    foreach($groups as $group) {
        echo '<tr>';
            echo '<td width="5%">' . $group['UserGroup']['id'] . '</td>';
            echo '<td width="40%">' . $group['UserGroup']['name'] . '</td>';
            echo '<td>' . $group['UserGroup']['description'] . '</td>';
            echo '<td width="10%">';
                echo $this->Html->link('Permission',
                    array('controller' => 'permissions','action' => 'group', $group['UserGroup']['id']),
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