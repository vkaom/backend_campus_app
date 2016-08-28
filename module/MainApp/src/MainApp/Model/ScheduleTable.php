<?php
/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, CAMEMIS Germany}
* ************************************************************************** */

namespace MainApp\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Application\Utility\Utilities;

use MainApp\Model\CamHelper;

class ScheduleTable extends AbstractTableGateway
{

    protected $table = '';
    protected $camHelper;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter);
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
        $this->camHelper = new CamHelper();
    }

    public function getScheduleTermAcademic($term, $academic_id)
    {

        $data = array();

        /*
        $data = array();

        $sql = $this->sql->select();
        $sql->from(array(
            't1' => "t_schedule"
        ));
        $sql->columns(array('*'));
        $sql->where(array("t1.ACADEMIC_ID='" . $academic_id . "'"));
        $sql->where(array("t1.TERM='" . $term . "'"));
        $sql->order('t1.START_TIME ASC');
        $sql->order('t1.END_TIME ASC');
        $statement = $this->sql->prepareStatementForSqlObject($sql);
        $entries = $this->resultSetPrototype->initialize($statement->execute())
            ->toArray();
        if ($entries) {
            foreach ($entries as $value) {
                $room_id = $value["ROOM_ID"];
                $teacher_id = $value["TEACHER_ID"];
                $subject_id = $value["SUBJECT_ID"];
                if ($subject_id) {

                } else {
                    $data[]["event"] = $value["ROOM_ID"];
                }

                $data[]["time"] = $this->$this->camHelper->secondToHour($value["START_TIME"]) . " - " . $this->$this->camHelper->secondToHour($value["END_TIME"]);
            }
        }
        */

        return $data;

    }
}