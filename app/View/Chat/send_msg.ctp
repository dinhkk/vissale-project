<div class="direct-chat-msg right">
    <img class="direct-chat-img" style="border: 1px solid #ccc;"
         src='<?php echo "https://graph.facebook.com/{$page_id}/picture?type=normal"; ?>' alt="message user image">
    <div class="direct-chat-text" style="width: auto;float: right; margin-right: 23px;">
        <?php echo h($message); ?>
        <small class="clearfix"></small>
        <small class="message-created-at"><?php //echo h($msg[$type]['created']) ?></small>
    </div>
</div>