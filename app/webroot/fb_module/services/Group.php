<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/5/16
 * Time: 8:38 AM
 */

namespace Services;

class Group
{
    private $options;
    private $groupId;

    public function __construct($groupId)
    {
        $this->groupId = $groupId;

        $this->setOptions();
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions()
    {

        $collection = \GroupOption::find('all', array(
            'conditions' => array(
                'group_id' => $this->groupId
            )
        ));

        $arrayOptions = [];
        foreach ($collection as $key => $value) {
            array_push($arrayOptions, $value->to_array());
        }

        $this->options = $arrayOptions;
    }
}