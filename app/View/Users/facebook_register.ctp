<div class="page-container">
    <?php
    echo $this->Form->create('User', array(
        'url' => "/Users/createPage"
    ));
    ?>
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
                    <ul class="chats">
                        <?php

                        $count = count($pages);
                        if ($count == 0) {
                            echo "<li>Không tìm thấy kết quả</li>";
                        }

                        if ($count > 0) {
                            foreach ($pages as $page) {
                                echo "<li onclick='setPage(this)' page-id='{$page['id']}' page-name='{$page['name']}' page-token='{$page['access_token']}'>
                            <img alt=\"\" class=\"avatar\" 
                            src=\"https://graph.facebook.com/{$page['id']}/picture?access_token={$page['access_token']}\">
                            <label>{$page['name']}</label>
                    </li>";
                            }
                        }


                        ?>

                    </ul>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" name="group_id" value="<?=$group_id?>">
    <input type="hidden" name="page_token" id="page_token"  value="">
    <input type="hidden" name="page_id" id="page_id" value="">
    <input type="hidden" name="csrf_token" id="csrf_token" value="<?=$csrf_token?>">


    <?php echo $this->Form->end(); ?>
    <style type="text/css">
        .page-container{text-align: center; max-width: 70%;margin: auto auto}
        .chats li {display: inline-block; color: #333; cursor: pointer; margin-left: 5px;}
        .login .chats li label{color: #333; font-size: 13px; font-weight: bold;}
        .login .chats li:hover label{color: #ed6b75;}
        .login .chats li:hover img{opacity: 0.7;}
    </style>
    <script type="text/javascript">

        function setPage(element) {
            var object = jQuery(element);
            jQuery('#page_id').val( object.attr('page-id') );
            jQuery('#page_token').val( object.attr('page-token') );

            createGroupPage();
        }

        function createGroupPage() {
            var form = jQuery('form');
            form.submit();
        }

    </script>
</div>