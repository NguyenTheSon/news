<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
        <th><?php echo $this->Paginator->sort('controller', 'Controllers'); ?></th>
        <th><?php echo $this->Paginator->sort('action', 'Actions'); ?></th>
        <th><?php echo $this->Paginator->sort('descriptions', 'Descriptions'); ?></th>
    </tr>
    <?php
    foreach($actions as $action) {
        echo '<tr>';
            echo '<td width="5%">' . $action['Action']['id'] . '</td>';
            echo '<td width="20%">' . $action['Action']['controller'] . '</td>';
            echo '<td width="20%">' . $action['Action']['action'] . '</td>';
            echo '<td>' . $action['Action']['descriptions'] . '</td>';
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