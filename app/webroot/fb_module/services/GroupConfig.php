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
    private $groupId;
    private $groupService;

    public function __construct($groupId)
    {
        $this->setGroup($groupId);
        $this->groupService = new Group($groupId);
    }


    /**
     * set data for Object : GroupConfig
     * @return mixed
     */
    public function setConfig($configData)
    {
        $this->configData = $configData;
    }

    public function setGroup($groupId)
    {
        $this->groupId = $groupId;
    }


    /**
     * @return bool
     */
    public function checkReplyCommentByTime()
    {
        if (!$this->isReplyComment()) {
            return false;
        }

        if ($this->isReplyComment() &&
            $this->groupService->isEnableSchedule() &&
            !$this->groupService->isJobAvailable()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function checkReplyInboxByTime()
    {
        if (!$this->isReplyInbox()) {
            return false;
        }

        if ($this->isReplyInbox() &&
            $this->groupService->isEnableSchedule() &&
            !$this->groupService->isJobAvailable()
        ) {
            return false;
        }

        return true;
    }


    public function isReplyComment()
    {
        return boolval($this->configData['reply_comment']);
    }

    public function isLikeComment()
    {
        return boolval($this->configData['like_comment']);
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


    /**
     * Lấy câu trả lời INBOX có sdt, chung cho cả group
     * @return string
     */
    public function getGroupAutoInboxHasPhone()
    {
        return $this->configData['reply_conversation_has_phone'];
    }


    /**
     * Lấy câu trả lời INBOX KHÔNG sdt, chung cho cả group
     * @return string
     */
    public function getGroupAutoInboxHasNoPhone()
    {
        return $this->configData['reply_conversation_nophone'];
    }


    /**
     * Lấy câu trả lời COMMENT có sdt, chung cho cả group
     * @return string
     */
    public function getGroupAutoCommentHasPhone()
    {
        return $this->configData['reply_comment_has_phone'];
    }

    /**
     * Lấy câu trả lời COMMENT KHÔNG sdt, chung cho cả group
     * @return string
     */
    public function getGroupAutoCommentHasNoPhone()
    {
        return $this->configData['reply_comment_nophone'];
    }

}