<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/3/16
 * Time: 2:40 PM
 */

App::uses('AppController', 'Controller');

/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property 'SecurityComponent $'Security
 * @property RequestHandler'Component $RequestHandler'
 * @property SessionComponent $Session
 */
class GroupOptionController extends AppController
{

    public $uses = ['Group', 'User', 'GroupOption', 'FBCronConfig'];
    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Text', 'Js', 'Time');

    /**
     * Components
     *
     * @var array
     **/
    public $components = array('Paginator', 'Flash', 'RequestHandler', 'Session');

    protected function setInit()
    {
        $this->set('model_class', $this->modelClass);
        $this->set('page_title', __('Quản lý cấu hình trả lời tự động'));
    }

    public function index()
    {
        $this->setInit();
        $this->Group->recursive = 0;

        $options = $this->GroupOption->find('all', array(
            'conditions' => array(
                'group_id' => $this->_getGroup()
            ),
        ));

        $enableSchedule = $this->getOptionValueByKey(ENABLE_SCHEDULE, $options);
        $startTime = $this->getOptionValueByKey(SCHEDULE_START_TIME, $options);
        $endTime = $this->getOptionValueByKey(SCHEDULE_END_TIME, $options);

        //var_dump($enableSchedule, $startTime, $endTime);
        $this->set('enableSchedule', $enableSchedule);
        $this->set('startTime', $startTime);
        $this->set('endTime', $endTime);
    }

    private function getOptionValueByKey($key, $options)
    {
        $value = null;

        foreach ($options as $index => $option) {

            if ($option['GroupOption']['key'] == $key) {
                $value = $option['GroupOption']['value'];
                break;
            }

        }

        return $value;
    }

    public function createEnableSchedule()
    {
        $this->autoRender = false;
        $this->layout = false;
        //
        $data = $this->request->data;

        $data['key'] = ENABLE_SCHEDULE;

        $data['value'] = $data['enable'];
        $data['group_id'] = $this->_getGroup();

        $existed = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $data['group_id'],
                'key' => $data['key']
            )
        ));

        $this->validateCreatedTime();

        $content = null;
        if (empty($existed)) {
            $save = $this->GroupOption->create($data);
            $isSaved = $this->GroupOption->save($save);

            if ($isSaved) {

                if ($data['enable'] == true) {
                    $content = "Đã BẬT tự động trả lời theo thời gian";
                }
                if ($data['enable'] == false) {
                    $content = "Đã TẮT tự động trả lời theo thời gian";
                }
                $message = $this->setMessage(array('message' => $content));
                echo json_encode($message);

            } else {

                $content = $this->convertErrorToString($this->GroupOption->validationErrors);
                $message = $this->setMessage(array('message' => $content, 'error' => 1));
                echo json_encode($message);
            }

            die;
        }


        $this->GroupOption->set($existed);
        $updated = $this->GroupOption->saveField('value', $data['enable']);

        if ($updated) {

            if ($data['enable'] == 'true') {
                $content = "BẬT";
            }
            if ($data['enable'] == 'false') {
                $content = "TẮT";
            }

            $message = $this->setMessage(array('message' => $content));
            echo json_encode($message);
        }


        die();
    }

    private function validateCreatedTime()
    {
        $start = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $this->_getGroup(),
                'key' => SCHEDULE_START_TIME
            )
        ));
        if (empty($start)) {
            $content = "Cần cài đặt thời gian bắt đầu";
            $message = $this->setMessage(array('message' => $content, 'error' => 1));
            echo json_encode($message);
            die;
        }


        $end = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $this->_getGroup(),
                'key' => SCHEDULE_END_TIME
            )
        ));
        if (empty($end)) {
            $content = "Cần cài đặt thời gian kết thúc";
            $message = $this->setMessage(array('message' => $content, 'error' => 1));
            echo json_encode($message);
            die;
        }
    }


    public function setScheduleTime()
    {
        $this->autoRender = false;
        $this->layout = false;
        //
        $data = $this->request->data;

        $data['group_id'] = $this->_getGroup();

        $isExisted = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $data['group_id'],
                'key' => $data['key']
            )
        ));

        if ($isExisted) {
            return $this->updateScheduleTime($isExisted, $data);
        }

        return $this->createNewScheduleTime($data);
    }

    private function createNewScheduleTime($data)
    {
        $save = $this->GroupOption->create($data);
        $isSaved = $this->GroupOption->save($save);

        if ($isSaved) {
            $message = "Lưu thành công";
            $message = $this->setMessage(array('message' => $message));
            echo json_encode($message);
        }

        if (!$isSaved) {
            $content = $this->convertErrorToString($this->GroupOption->validationErrors);
            $message = $this->setMessage(array('message' => $content, 'error' => 1));
            echo json_encode($message);
        }

        die;
    }

    private function updateScheduleTime($existed, $data)
    {
        $this->GroupOption->set($existed);
        $isSaved = $this->GroupOption->saveField('value', $data['value']);

        $this->GroupOption->deleteAll(
            array(
                'OR' => array(
                    ['key' => 'job_start'],
                    ['key' => 'job_end']
                ),
                array(
                    'group_id' => $this->_getGroup()
                )
            ), false
        );


        if ($isSaved) {
            $message = "Lưu thành công";
            $message = $this->setMessage(array('message' => $message));
            echo json_encode($message);
        }

        if (!$isSaved) {
            $content = $this->convertErrorToString($this->GroupOption->validationErrors);
            $message = $this->setMessage(array('message' => $content, 'error' => 1));
            echo json_encode($message);
        }

        die;
    }

    private function setMessage($extra)
    {
        $message = array(
            'error' => 0,
            'message' => 'null'
        );

        return array_merge($message, $extra);
    }

    private function convertErrorToString(Array $errors)
    {
        if (count($errors) === 0) {
            return null;
        }

        $results = array();
        foreach ($errors as $items) {
            foreach ($items as $item) {
                array_push($results, $item);
            }
        }

        return implode(",", $results);
    }

    public function test()
    {
        $allGroups = $this->FBCronConfig->query("select DISTINCT group_id from fb_cron_config where group_id != 124");


        //$this->FBCronConfig->query($query);

        foreach ($allGroups as $allGroup) {
            $groupId = $allGroup['fb_cron_config']['group_id'];
            $this->FBCronConfig->create();
            $query = "insert into `superapi_tk`.`fb_cron_config` ( `updated`, `group_id`, `level`, `created`, `value`, `description`, `type`, `_key`, `parent_id`) values ( '2016-03-23 00:30:39', '{$groupId}', '1', '2016-03-23 00:30:39', '1', 'co tra loi comment tu dong khong ?', '3', 'reply_comment', null)";

            $this->FBCronConfig->query($query);
        }
    }
}