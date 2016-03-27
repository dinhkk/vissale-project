<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array(
            '/assets/global/plugins/font-awesome/css/font-awesome.min',
            '/assets/global/plugins/simple-line-icons/simple-line-icons.min',
            '/assets/global/plugins/bootstrap/css/bootstrap.min',
            '/assets/global/plugins/uniform/css/uniform.default',
            '/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min',
            '/assets/global/css/components-md.min',
            '/assets/global/css/plugins-md.min',
            '/assets/pages/css/login-4.min',
        ));
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body class="login">
        <div id="container">
            <div id="content">

                <?php echo $this->Flash->render(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
        <!--[if lt IE 9]>
        <?php
        echo $this->Html->script('/assets/global/plugins/respond.min');
        echo $this->Html->script('/assets/global/plugins/excanvas.min');
        ?>
<![endif]-->
        <?php
        echo $this->Html->script(array(
            '/assets/global/plugins/jquery.min',
            '/assets/global/plugins/bootstrap/js/bootstrap.min',
            '/assets/global/plugins/js.cookie.min',
            '/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
            '/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min',
            '/assets/global/plugins/jquery.blockui.min',
            '/assets/global/plugins/uniform/jquery.uniform.min',
            '/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min',
            '/assets/global/plugins/jquery-validation/js/jquery.validate.min',
            '/assets/global/plugins/jquery-validation/js/additional-methods.min',
            '/assets/global/plugins/backstretch/jquery.backstretch.min',
            '/assets/global/scripts/app.min',
            '/assets/pages/scripts/login-4',
        ));
        ?>
    </body>
</html>
