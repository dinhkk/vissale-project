<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/5/16
 * Time: 8:38 AM
 */

namespace Services;

use Carbon\Carbon;

class Group
{
    private $options;
    private $groupId;
    private $jobStart;
    private $jobEnd;

    public function __construct($groupId)
    {
        $this->groupId = $groupId;

        $this->setOptions();

        $this->init();
    }

    /**
     * @return mixed
     */
    private function getOptions()
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


    /**
     *
     */
    public function isEnableSchedule()
    {
        $options = $this->getOptions();
        $isEnable = false;
        $start = null;
        $end = null;

        foreach ($options as $option) {
            if ($option['key'] == 'enable_schedule' && $option['value'] == 'true') {
                $isEnable = true;
            }

            if ($option['key'] == 'enable_schedule' && $option['value'] == 'false') {
                $isEnable = false;
            }
        }

        return $isEnable;
    }


    //lay thoi gian bat dau theo setting tu admin
    private function getStartTime()
    {
        $startTime = null;
        foreach ($this->getOptions() as $option) {
            if ($option['key'] == SCHEDULE_START_TIME) {
                $startTime = $option['value'];
                break;
            }
        }
        return Carbon::parse(date('Y-m-d') . " {$startTime}");
    }

    //lay thoi gian ket thuc theo setting tu admin
    private function getEndTime()
    {
        $end = null;
        foreach ($this->getOptions() as $option) {
            if ($option['key'] == SCHEDULE_END_TIME) {
                $end = $option['value'];
                break;
            }
        }

        $tempEnd = Carbon::parse(date('Y-m-d') . " {$end}");
        $tempStart = $this->getStartTime();

        if ($tempEnd->timestamp - $tempStart->timestamp < 0) {
            $tempEnd->day += 1;
        }

        return $tempEnd;
    }


    //set startJob
    private function setJobStart(Carbon $time)
    {
        $this->jobStart = $time;

    }


    public function getJobStart()
    {
        $jobStart = null;
        $tmp = null;

        foreach ($this->getOptions() as $option) {
            if ($option['key'] == JOB_START) {
                $tmp = $option['value'];
                break;
            }
        }

        if (!empty($tmp)) {
            $jobStart = Carbon::parse($tmp);

            $this->jobStart = $jobStart;
        }

        if (empty($tmp)) {
            $this->createJobStartRecord();
        }

        return $this->jobStart;
    }

    private function createJobStartRecord()
    {
        var_dump('call createJobStartRecord');

        $time = $this->getStartTime();

        $option = new \GroupOption();
        $option->key = JOB_START;
        $option->value = $time->toDateTimeString();
        $option->group_id = $this->groupId;

        $option->save();
        $this->setJobStart($time);
    }

    private function updateJobStart()
    {
        $jobStart = $this->getJobStart();
        $jobStart->day += 1;

        $option = \GroupOption::find('first', array(
            'conditions' => array(
                'group_id' => $this->groupId,
                'key' => JOB_START
            )
        ));
        $option->value = $jobStart->toDateTimeString();
        $option->save();
    }

    private function setJobEnd(Carbon $time)
    {
        $this->jobEnd = $time;
    }

    public function getJobEnd()
    {
        $jobEnd = null;
        $tmp = null;

        foreach ($this->getOptions() as $option) {
            if ($option['key'] == JOB_END) {
                $tmp = $option['value'];
                break;
            }
        }

        if (!empty($tmp)) {
            $jobEnd = Carbon::parse($tmp);
            $this->jobEnd = $jobEnd;
        }

        if (empty($tmp)) {
            $this->createJobEndRecord();
        }

        return $this->jobEnd;
    }

    private function createJobEndRecord()
    {

        $time = $this->getEndTime();

        $option = new \GroupOption();
        $option->key = JOB_END;
        $option->value = $time->toDateTimeString();
        $option->group_id = $this->groupId;

        $option->save();
        $this->setJobEnd($time);
    }

    private function updateJobEnd()
    {
        $jobEnd = $this->getJobEnd();
        $jobEnd->day += 1;

        $option = \GroupOption::find('first', array(
            'conditions' => array(
                'group_id' => $this->groupId,
                'key' => JOB_END
            )
        ));
        $option->value = $jobEnd->toDateTimeString();
        $option->save();
    }


    /**
     * init before start
     */
    private function init()
    {
        $now = Carbon::now();
        $jobStart = $this->getJobStart();
        $jobEnd = $this->getJobEnd();
        $diff = $now->timestamp - $jobEnd->timestamp;

        if ($diff > 0) {
            $this->updateJobStart();
            $this->updateJobEnd();

            //get options again
            $this->setOptions();
        }
    }


    public function isJobAvailable()
    {
        $now = Carbon::now();
        return $this->isEnableSchedule() && $now->between($this->jobStart, $this->jobEnd);
    }
}