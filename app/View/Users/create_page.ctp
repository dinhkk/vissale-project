<div class="page-container">

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Chọn Fan Page</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <?=$message?>
                </div>

                <button onclick="goBack()">Quay lại</button>
            </div>
        </div>
    </div>

    <style type="text/css">
        .page-container{text-align: center; max-width: 70%;margin: auto auto}
        .chats li {display: inline-block; color: #333; cursor: pointer; margin-left: 5px;}
        .login .chats li label{color: #333; font-size: 13px; font-weight: bold;}
        .login .chats li:hover label{color: #ed6b75;}
        .login .chats li:hover img{opacity: 0.7;}
    </style>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>