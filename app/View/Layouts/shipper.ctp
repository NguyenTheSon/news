<!DOCTYPE html>
<html>
<head>
    <title>MQ Solusions - Mercari - Shippers Managenement</title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8">
    <?php
    echo $this->Html->css(
        array(
            'bootstrap.min.css',
            'shipper.css',
            'bootstrap-datetimepicker.css'
        )
    );
    ?>
    <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <?php
    echo $this->Html->script(
        array(
            'bootstrap.min.js',
            'categories.js',
            'date.format.js',
            'shipper.js',
            'bootstrap-datetimepicker.js'
        )
    ); ?>

    <?php echo $this->fetch('meta'); ?>
    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
</head>
<body>
    <?php echo $this->element('shipper_top_menu');?>

    <div class="content page-content">
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>