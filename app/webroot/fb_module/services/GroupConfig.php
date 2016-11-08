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

    public function __construct()
    {
        $log = new Debugger();
        $this->debug = $log->getLogObject("debug");
        $this->error = $log->getLogObject("error");
    }


    /**
     * set data for Object : GroupConfig
     * @return mixed
     */
    public function setConfig($configData)
    {
        $this->configData = $configData;

        $this->debug->info('Config Data:GroupConfig', $this->configData);
        $this->debug->info($this->getReplyMessageForCommentHasNoPhone());
    }

    public function setGroup($groupId)
    {
        $this->groupId = $groupId;
        $this->groupService = new Group($groupId);

    }


    /**
     * @return bool
     */
    public function isReplyCommentByTime()
    {
        if (!$this->isReplyComment()) {
            return false;
        }

        $this->debug->info('log GroupService', array(
            'group_id' => $this->groupId,
            'isEnableSchedule' => $this->groupService->isEnableSchedule(),
            'isJobAvailable' => $this->groupService->isEnableSchedule(),
            __FILE__,
            __LINE__
        ));

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
    public function isReplyInboxByTime()
    {
        if (!$this->isReplyInbox()) {
            return false;
        }

        $this->debug->info('log GroupService', array(
            'group_id' => $this->groupId,
            'isEnableSchedule' => $this->groupService->isEnableSchedule(),
            'isJobAvailable' => $this->groupService->isEnableSchedule(),
            __FILE__,
            __LINE__
        ));

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
    public function getMessageForInboxHasPhone()
    {
        return $this->configData['reply_conversation_has_phone'] ? $this->configData['reply_conversation_has_phone'] : null;
    }


    /**
     * Lấy câu trả lời INBOX KHÔNG sdt, chung cho cả group
     * @return string
     */
    public function getMessageForInboxHasNoPhone()
    {
        return $this->configData['reply_conversation_nophone'] ? $this->configData['reply_conversation_nophone'] : null;
    }


    /**
     * Lấy câu trả lời COMMENT có sdt, chung cho cả group
     * @return string
     */
    public function getReplyMessageForCommentHasPhone()
    {
        return $this->configData['reply_comment_has_phone'] ? $this->configData['reply_comment_has_phone'] : null;
    }

    /**
     * Lấy câu trả lời COMMENT KHÔNG sdt, chung cho cả group
     * @return string
     */
    public function getReplyMessageForCommentHasNoPhone()
    {
        return $this->configData['reply_comment_nophone'] ? $this->configData['reply_comment_nophone'] : null;
    }

}