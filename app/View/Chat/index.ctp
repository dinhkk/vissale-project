<?php
echo $this->Html->script(array(
    //'/js/jquery.slimscroll.min',
    '/js/chat'
));
echo $this->Html->css(array(
        '/css/chat',
        //'/css/AdminLTE.min'
    )
);
?>

<div
    id="overlay-loading"
    class="well well-lg bs-loading-container"
    style="
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
    opacity: .8;"
    bs-loading-overlay
    bs-loading-overlay-delay="2000"
>
</div>

<section class="content chat-section" ng-controller="ChatController" style="padding: 0;">

    <div class="chat-left portlet light bordered" style="width: 65%; display: inline-block;vertical-align: top;">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-blue"></i>
                <span class="caption-subject font-blue bold uppercase font-blue">Conversations</span>
            </div>

            <div class="actions" style="margin-left: 10px;">
                <div class="portlet-input input-inline">
                    <div class="btn-group">

                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            Lọc tin nhắn
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-comments"></i>
                                Nhận xét
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox" checked=""></span>
                                </div>
                                <i class="fa fa-comment"></i>
                                Tin nhắn</label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-shopping-cart"></i>
                                Có Đơn hàng
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-question"></i>
                                Chưa có đơn hàng
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox" checked=""></span>
                                </div>
                                <i class="fa fa-square-o"></i>
                                Chưa đọc
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-check-square-o"></i>
                                Đã đọc
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <div class="portlet-input input-inline">
                    <div class="btn-group">
                        <button class="btn btn-lg green dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-expanded="true"> Tìm Tin Nhắn
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-content input-large hold-on-click" role="menu">
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="search..."
                                           style="height: 32px;">
                                    <span class="input-group-btn">
                                                                                <button class="btn blue"
                                                                                        type="submit"><i
                                                                                        class="icon-magnifier"></i></button>
                                                                            </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions" style="margin-left: 10px; width: 400px;">
                <div class="portlet-input" style="width: 100%;">
                    <div class="form-group" style="display: inline;">
                        <label class="col-md-2 control-label" style="margin-top: 4px;">Trang:</label>
                        <div class="col-md-10" style="padding-left: 0;">
                            <select class="form-control">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                                <option>Option 4</option>
                                <option>Option 5</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row fullHeigh">
            <div class="col-md-4 bg-white " style="padding-right: 0;">

                <!-- =============================================================== -->
                <!-- member list -->
                <ul class="friend-list">
                    <li class="active bounceInDown">
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>John Doe</strong>
                            </div>
                            <div class="last-message text-muted">Hello, Are you there?</div>
                            <small class="time text-muted">Just now</small>
                            <small class="chat-alert label label-danger">1</small>
                            <small class="chat-alert has-order label label-success">
                                <i class="fa fa-shopping-cart"></i>
                            </small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Jane Doe</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">5 mins ago</small>
                            <small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_3.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Kate</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">Yesterday</small>
                            <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Kate</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">Yesterday</small>
                            <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Kate</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">Yesterday</small>
                            <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_6.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Kate</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">Yesterday</small>
                            <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_5.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Kate</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">Yesterday</small>
                            <small class="chat-alert text-muted"><i class="fa fa-reply"></i></small>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>Jane Doe</strong>
                            </div>
                            <div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
                            <small class="time text-muted">5 mins ago</small>
                            <small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
                        </a>
                    </li>
                </ul>
            </div>

            <!--=========================================================-->
            <!-- selected chat -->
            <div class="col-md-8 bg-white ">
                <div class="chat-message">
                    <ul class="chat">
                        <li class="left clearfix">
                    	<span class="chat-img pull-left">
                    		<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">John Doe</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix">
                    	<span class="chat-img pull-right">
                    		<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Sarah</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales at.
                                </p>
                            </div>
                        </li>
                        <li class="left clearfix">
                        <span class="chat-img pull-left">
                    		<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">John Doe</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Sarah</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales at.
                                </p>
                            </div>
                        </li>
                        <li class="left clearfix">
                        <span class="chat-img pull-left">
                    		<img src="http://bootdey.com/img/Content/user_3.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">John Doe</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Sarah</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales at.
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix">
                        <span class="chat-img pull-right">
                    		<img src="http://bootdey.com/img/Content/user_1.jpg" alt="User Avatar">
                    	</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Sarah</strong>
                                    <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago
                                    </small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales at.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chat-box bg-white">
                    <div class="input-group">
                        <input class="form-control border no-shadow no-rounded" placeholder="Type your message here">
                        <span class="input-group-btn">
            			<button class="btn btn-success no-rounded" type="button">Send</button>
            		</span>
                    </div><!-- /input-group -->
                </div>
            </div>
        </div>
    </div>
    <div class="chat-right portlet light bordered" style="width: 34%; display: inline-block; vertical-align: top;">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="fullHeigh">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Comments</span>
                        </div>
                        <ul class="nav nav-tabs" style="clear: both;">
                            <li class="active">
                                <a href="#portlet_comments_1" data-toggle="tab" aria-expanded="true"> Pending </a>
                            </li>
                            <li class="">
                                <a href="#portlet_comments_2" data-toggle="tab" aria-expanded="false"> Approved </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <?php echo $this->element('Chat/customer_order'); ?>
                            <?php echo $this->element('Chat/create_order'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('#comment').slimScroll({
            height: '500px',
            railVisible: true,
            alwaysVisible: true,
            allowPageScroll: true,
        });
        $('#chatbox').slimScroll({
            height: '400px',
            railVisible: true,
            alwaysVisible: true,
            allowPageScroll: true,
        });
    });

    $(document).ready(function () {


        $('input[type="file"]#fileMessage').change(function () {

            var conversation_id = $('#listMsg').attr('conv_id');

            var file = $(this).prop('files')[0];

            var formData = new FormData();

            formData.append('file_message', file, file.name);

            formData.append('conversation_id', conversation_id);

            //loading
            $.LoadingOverlay("show");

            $.ajax({
                url: '/Attachment/uploadFile', // point to server-side PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                dataType: 'json',

                success: function (response) {
                    $.LoadingOverlay("hide");
                    //console.log(response); // display response from the PHP script, if any

                    if (response.error == 1) {
                        notify('error', 'Có Lỗi !', response.message);
                    }

                    if (response.error == 0) {
                        notify('success', 'Thống Báo', response.message);

                        $('#txtMessage').val(response.data);
                        $("#btnSend").trigger("click");
                    }

                    //clear input control
                    var control = $(this);
                    control.replaceWith(control = control.clone(true));
                }
            });

        });
    });

    function uploadTrigger() {
        var conversation_id = $('#listMsg').attr('conv_id');
        if (typeof conversation_id == 'undefined') {
            console.log('undefined conversation_id');
            return false;
        }

        $("input#fileMessage").trigger("click");
    }

</script>