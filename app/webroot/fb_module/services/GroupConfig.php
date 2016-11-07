<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/7/16
 * Time: 1:07 PM
 */

namespace Services;

use Services\Group;

class GroupConfig
{
    private $configData;


    public function __construct()
    {

    }


    /**
     * set data for Object : GroupConfig
     * @return mixed
     */
    public function setConfig($configData)
    {
        $this->configData = $configData;

        //var_dump($this->configData);
    }

    /**
     * Kiểm tra cấu hình có trả lời comment khi CÓ số sdt
     * @return bool
     */
    public function isHideCommentHasPhone()
    {
        return boolval($this->configData['hide_phone_comment']);
    }


    /**
     * Kiểm tra cấu hình có trả lời comment khi KHÔNG số sdt
     * @return bool
     */
    public function isHideCommentHasNoPhone()
    {
        return boolval($this->configData['hide_nophone_comment']);
    }

    /**
     * Kiểm tra cấu hình có trả lời INBOX
     * @return bool
     */
    public function isReplyInbox()
    {
        return boolval($this->configData['reply_conversation']);
    }
}