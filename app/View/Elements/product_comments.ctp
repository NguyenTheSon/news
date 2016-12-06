<table width="100%;" id="tablePurchases" class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th width="4%"><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
        <th width="40%"><?php echo $this->Paginator->sort('comment', 'Comment'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('poster_id', 'Poster'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('product_id', 'Product'); ?></th>
        <th width="15%"><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
        <th width="5%"><?php echo $this->Paginator->sort('is_block', 'State'); ?></th>
    </tr>
    <?php
    foreach($ProductComments as $ProductComment) {
        echo '<tr>';
            echo '<td>' . $ProductComment['ProductComment']['id'] . '</td>';
            echo '<td>' . $ProductComment['ProductComment']['comment'] . '</td>';
            echo '<td>' . $ProductComment['User']['username'] . '</td>';
            echo '<td>';
                echo $this->Html->link(
                    $ProductComment['Product']['name'],
                    array('controller' => 'productcomments', 'action' => 'view', $ProductComment['Product']['id'])
                );
            echo '</td>';
            echo '<td>' . $ProductComment['ProductComment']['created'] . '</td>';
            echo '<td>';
            if($ProductComment['ProductComment']['is_block']) {
                echo $this->Html->image("/img/block.png",
                    array(
                        "alt" => "Block",
                        "title" => "Block",
                        'url' => array('controller' => 'productcomments', 'action' => 'publish', $ProductComment['ProductComment']['id']),
                        'style' => $this->Html->style(
                            array(
                                'width'         => '16px'
                            )
                        )
                    )
                );
            } else {
                echo $this->Html->image("/img/publish.png",
                    array(
                        "alt" => "Publish",
                        "title" => "Publish",
                        'url' => array('controller' => 'productcomments', 'action' => 'block', $ProductComment['ProductComment']['id']),
                        'style' => $this->Html->style(
                            array(
                                'width'         => '16px'
                            )
                        )
                    )
                );
            }
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