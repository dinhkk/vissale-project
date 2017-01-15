<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/14/17
 * Time: 8:52 AM
 */


cli_set_process_title ( "inbox_worker.php" );

$worker = new GearmanWorker();
$worker->addServer("127.0.0.1", 4730);

$worker->addFunction("update_inbox_conversation_messenger_id", "update_inbox_conversation_messenger_id");



function update_inbox_conversation_messenger_id(GearmanJob $job){
    $workload = json_decode($job->workload());
    // Save the logs to the database, write them to a single file, index them, ship them to splunk, whatever
    printf('message_id = %s, conversation_id=%s', $workload->message_id, $workload->conversation_id);
    $path = dirname( __DIR__ ) . "/vendor/autoload.php";
    include_once($path);

    //1. search message in cache
    $inboxMessageCache =  \Services\RedisService::getInstance()->get( $workload->message_id );
    if (!$inboxMessageCache) {
        printf('$inboxMessageCache not found ' );

        return false;
    }
    //2. search existing conversation in cache and db
    $messageService = new \Services\MessageService();
    $conversationInbox = $messageService->getConversationInbox($inboxMessageCache['sender_id'], $inboxMessageCache['page_id']);

    if ($conversationInbox) {
        printf('$conversation existed ' );
        return false;
    }

    //3. handle with not existing inbox-conversation

    $options = array(
        'conditions' => array(
            'id = ? AND messenger_fb_id IS NULL', $workload->conversation_id
        )
    );
    $conversation = Conversation::find('first', $options);

    printf('$conversation %s', !empty($conversation) ? $conversation->to_json() : null );
    printf('$inboxMessageCache %s', json_encode($inboxMessageCache) );

    //update if exist $conversation
    $isSaved = false;
    if ( $conversation && $inboxMessageCache &&
        $conversation->page_id == $inboxMessageCache['page_id']
    ) {
        $conversation->messenger_fb_id = $inboxMessageCache['sender_id'];
        $isSaved = $conversation->save();
    }

    //4. if update messenger_fb_id, set cache one day
    if ($isSaved) {
        $ttl = (86400*30);
        $data = $conversation->to_array();
        $key = $redisKey = $inboxMessageCache['sender_id'].$inboxMessageCache['page_id'];

        \Services\RedisService::getInstance()->set( $key, $data, $ttl );

        printf('%s', "\n saved sender = {$inboxMessageCache['sender_id']} to conversation {$conversation->id} ");
    }

}


while (1) {
    print "\nWaiting for job...\n";
    $ret = $worker->work(); // work() will block execution until a job is delivered
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        break;
    }
}