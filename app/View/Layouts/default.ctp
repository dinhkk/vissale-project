<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = Configure::read('fbsale.App.name');
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
        echo $this->fetch('meta');

        echo $this->Html->css(array(
            '/assets/global/plugins/font-awesome/css/font-awesome.min',
            '/assets/global/plugins/simple-line-icons/simple-line-icons.min',
            '/assets/global/plugins/bootstrap/css/bootstrap.min',
            '/assets/global/plugins/uniform/css/uniform.default',
            '/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min',
            '/assets/global/css/components-md.min',
            '/assets/global/css/plugins-md.min',
            '/assets/layouts/layout/css/layout.min',
            '/assets/layouts/layout/css/themes/darkblue.min',
            '/assets/layouts/layout/css/custom.min',
            '/css/admin',
        ));
        echo $this->fetch('css');
        ?>
        <!--[if lt IE 9]>
        <?php
        echo $this->Html->script(array(
            '/assets/global/plugins/respond.min',
            '/assets/global/plugins/excanvas.min',
        ));
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
            //'/assets/global/plugins/uniform/jquery.uniform.min',
            '/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min',
            '/assets/global/scripts/app.min',
            '/assets/layouts/layout/scripts/layout.min',
            '/assets/layouts/layout/scripts/demo.min',
            '/assets/layouts/global/scripts/quick-sidebar.min',
            '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        ));
        echo $this->element('js/main');
        echo $this->fetch('script');
        
         if (isset( $base_url ) ){
             echo "<script>var base_url = '{$base_url}'; </script>"; //assign javascript base_url
         }

        ?>


    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md page-sidebar-closed">
        <?php
        echo $this->element('navbar');
        ?>
        <div class="page-container">
            <?php
            echo $this->element('sidebar');
            ?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <?php echo $this->fetch('breadcrumb'); ?>
                    <?php if (!empty($page_title)): ?>
                        <h3 class="page-title"><?php echo $page_title ?></h3>
                    <?php endif; ?>
                    <?php
                    $flashMessage = $this->Flash->render();
                    //var_dump($flashMessage);
                    ?>
                    <?php if (!empty($flashMessage)): ?>
                        <div class="note note-danger">
                            <?php printf("%s",$flashMessage); ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $ajax_action = !empty($ajax_action) ? $ajax_action : Router::url(array(
                                'action' => $this->action,
                                '?' => $this->request->query,
                    ));
                    ?>
                    <div class="ajax-container" data-action="<?php echo $ajax_action ?>">
                        <?php echo $this->fetch('content'); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php // echo $this->element('sql_dump'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
