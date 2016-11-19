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
<html ng-app="vissale">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
            '/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min',
            '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min',
            '/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min',
            '/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min',
            '/assets/global/plugins/bootstrap-toastr/toastr.min',
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
            '/assets/global/plugins/uniform/jquery.uniform.min',
            '/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min',
            '/assets/global/scripts/app.min',
            '/assets/layouts/layout/scripts/layout.min',
            '/assets/layouts/layout/scripts/demo.min',
            '/assets/global/plugins/moment.min',
            '/assets/layouts/global/scripts/quick-sidebar.min',
            '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min',
            '/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min',
            '/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min',
            '/assets/pages/scripts/components-date-time-pickers.min',
            '/assets/global/plugins/bootstrap-toastr/toastr.min',
            '/js/loadingoverlay.min',
            '/assets/pages/scripts/ui-buttons.min',
        ));
        echo $this->element('js/main');

        echo $this->fetch('script');
        
         if (isset( $base_url ) ){
             echo "<script>var base_url = '{$base_url}'; </script>"; //assign javascript base_url
         }

        ?>
        <script type="text/javascript" src="https://vissale.com:8001/faye/client.js"></script>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>

        <script
            src="http://bsalex.github.io/angular-loading-overlay/_site/dist/angular-bootstrap/ui-bootstrap-tpls.js"></script>
        <script src="https://rawgit.com/bsalex/angular-loading-overlay/master/dist/angular-loading-overlay.js"></script>
        <script
            src="https://rawgit.com/bsalex/angular-loading-overlay-spinjs/master/dist/angular-loading-overlay-spinjs.js"></script>
        <script
            src="https://rawgit.com/bsalex/angular-loading-overlay-http-interceptor/master/dist/angular-loading-overlay-http-interceptor.js"></script>

        <?php
        echo $this->Html->script(array(
            '/js/chat-app',
        ));
        ?>
        <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
        <script>
            // Display an info toast with no title
            function notify(type, title, content) {
                switch (type) {
                    case 'success' :
                        toastr.success(content, title);
                        break;
                    case 'error' :
                        toastr.error(content, title);
                        break;
                    default :
                        toastr.info(content, title);
                        break;
                }
            }
        </script>

        <script>
            window.group_id = <?=$user_group_id?>;
            console.log(base_url);
            // Enable pusher logging - don't include this in production
            //Pusher.logToConsole = true;

            var pusher = new Pusher('290cab8409da897eb293', {
                cluster: 'ap1',
                encrypted: true
            });

            var channel = pusher.subscribe('vissale_channel_<?=$user_group_id?>');
            channel.bind('my_event', function(data) {
                //alert(data.message);
                notifyMe(data.username, data.message, data.action);
            });


            function checkNotificationPermission(){

                console.log(Notification.permission);

                if (Notification.permission == 'granted') {
                    return false;
                }

                Notification.requestPermission(function (permission) {

                    if (permission == "denied") {
                        return false;
                    }

                    var options = {
                        body: "thanks for subscribing on vissale.com!",
                        icon: 'https://app.vissale.com/assets/standard/images/vissale_logo.png'
                    };
                    var notification = new Notification('vissale.com says', options);
                    setTimeout(notification.close.bind(notification), 5000);
                });
            }

            function notifyMe(username , message, action) {
                // Let's check if the browser supports notifications
                if (!("Notification" in window)) {
                    console.error("This browser does not support system notifications");
                }

                // Let's check whether notification permissions have already been granted
                else if (Notification.permission === "granted") {
                    // If it's okay let's create a notification
                    //var notification = new Notification("Hi there!");

                    if (username == undefined) {
                        username = 'vissale.com';
                    }

                    if (message == undefined) {
                        message = 'welcome to vissale.com';
                    }

                    var options = {
                        body: message,
                        icon: 'https://app.vissale.com/assets/standard/images/vissale_logo.png'
                    };
                    var notification = new Notification(username + ' ' + action, options);
                    setTimeout(notification.close.bind(notification), 5000);
                }

                // Otherwise, we need to ask the user for permission
                else if (Notification.permission !== 'denied') {
                    Notification.requestPermission(function (permission) {
                        // If the user accepts, let's create a notification

                        if (permission === "granted") {
                            var options = {
                                body: "thanks for subscribing on vissale.com!",
                                icon: 'https://app.vissale.com/assets/standard/images/vissale_logo.png'
                            };
                            var notification = new Notification(username + ' says', options);
                            setTimeout(notification.close.bind(notification), 5000);
                        }
                    });
                }

                // Finally, if the user has denied notifications and you
                // want to be respectful there is no need to bother them any more.
            }

            //notifyMe();
            checkNotificationPermission();


            //adjax loading for all page
            $(document).ready(function () {

                /*$(document).ajaxSend(function (event, jqxhr, settings) {
                 $.LoadingOverlay("show");
                 });
                 $(document).ajaxComplete(function (event, jqxhr, settings) {
                 $.LoadingOverlay("hide");
                 });*/
            });

        </script>

    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md page-sidebar-closed">
        <?php
            if (!$LoginIFrame) {
                echo $this->element('navbar');
            }
        ?>
        <div class="page-container">
            <?php
            if (!$LoginIFrame) {
                echo $this->element('sidebar');
            }
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
