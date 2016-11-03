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

    public $uses = ['Group', 'User'];
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

        //test redis
        $key = 'test-redis';
        $value = 'valude-redis';

        Cache::delete($key, 'redis');
        //Cache::write($key, $value, 'redis');

        $test = Cache::read($key, 'redis');
        //Cache::clearGroup('group_config', 'redis');
        debug($test);
        die('group-options');
    }
}