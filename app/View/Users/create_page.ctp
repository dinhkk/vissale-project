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
                    <h1><?=$message?></h1>

                    <?php
                    if ($is_success == true) {
                        echo "<button class='btn btn-primary' onclick='goToAppVissale()'> Sử dụng dịch vụ </button>";
                    }
                    if ($is_success == false) {
                        echo "<button class='btn btn-primary' onclick='goBack()'> Danh sách pages </button>";
                    }
                    ?>
                </div>


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

        function goToAppVissale() {
            var url = "https://www.facebook.com/dialog/oauth?client_id=1317628464949315&redirect_uri=https://app.vissale.com/?page=dang-nhap&cmd=fb_login";
            window.location.assign(url)
        }
    </script>
</div>