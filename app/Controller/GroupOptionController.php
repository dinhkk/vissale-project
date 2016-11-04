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

    public $uses = ['Group', 'User', 'GroupOption'];
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



    }

    public function createEnableSchedule()
    {
        $this->autoRender = false;
        $this->layout = false;
        //
        $data = $this->request->data;

        $data['key'] = ENABLE_SCHEDULE;

        $data['value'] = (int)$data['enable'];
        $data['group_id'] = $this->_getGroup();

        $existed = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $data['group_id'],
                'key' => $data['key']
            )
        ));

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

    public function setScheduleTime()
    {
        $this->autoRender = false;
        $this->layout = false;
        //
        $data = $this->request->data;

        $request['key'] = $data['key'];
        $request['value'] = $data[$data['key']];
        $data['group_id'] = $this->_getGroup();


        $isExisted = $this->GroupOption->find('first', array(
            'conditions' => array(
                'group_id' => $data['group_id'],
                'key' => $data['key']
            )
        ));

        if ($isExisted) {
            return $this->updateScheduleTime($data['key'], $request);
        }

        return $this->createNewScheduleTime($data['key'], $request);
    }

    private function createNewScheduleTime($key, $request)
    {

    }

    private function updateScheduleTime($key, $request)
    {

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
        $this->setInit();
        $this->Group->recursive = 0;

        //test redis
        $key = 'test-redis';
        $value = 'valude-redis';

        //Cache::delete($key, 'redis');
        Cache::write($key, $value, 'redis');

        $test = Cache::read($key, 'redis');
        //Cache::clearGroup('group_config', 'redis');
        debug($test);
        die('group-options');
    }
}