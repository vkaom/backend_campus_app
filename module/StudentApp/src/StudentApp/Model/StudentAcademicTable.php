<?php
/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, CAMEMIS Germany}
* ************************************************************************** */

namespace StudentApp\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Application\Utility\Utilities;

use MainApp\Model\AcademicTable;
use MainApp\Model\CamHelper;

class StudentAcademicTable extends AbstractTableGateway
{

    protected $table = '';
    protected $academicTalbe;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter);
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();

        $this->academicTalbe = new AcademicTable($this->adapter);
    }

    public function getStudentCurrentAcademics($studentId)
    {

        $sql = $this->sql->select();
        $sql->from(array(
            't1' => "t_student_current_academic"
        ));
        $sql->columns(array('*'));
        $sql->where(array("t1.STUDENT='" . $studentId . "'"));
        $statement = $this->sql->prepareStatementForSqlObject($sql);
        $entries = $this->resultSetPrototype->initialize($statement->execute())
            ->toArray();

        $data = array();
        if ($entries) {
            foreach ($entries as $value) {
                $data[]["academic_id"] = $value["CLASS"];
                $data[]["campus_name"] = $value["CAMPUS_NAME"];
                $data[]["campus_name_en"] = $value["CAMPUS_NAME_EN"];
                $data[]["academic_name"] = $value["CLASS_NAME"];
                $data[]["academic_name_en"] = $value["CLASS_NAME_EN"];
                $data[]["education_type"] = $value["EDUCATION_TYPE"];
            }

        }

        return $data;
    }

    public function getStudentWeeklySchedule($student_id, $academic_id)
    {
        $academic_object = $this->academicTalbe->getAcademicById($academic_id);
        $schoolyear_object = $this->academicTalbe->getSchoolyearById($academic_object->SCHOOL_YEAR);
        if ($schoolyear_object) {
            switch ($schoolyear_object->TERM_NUMBER) {
                case 1:
                    $data["first_term"] = 1;
                    $data["second_term"] = 1;
                    $data["third_term"] = 1;
                    break;
                case 2:
                    $data["first_quarter"] = 1;
                    $data["second_quarter"] = 1;
                    $data["third_quarter"] = 1;
                    $data["fourth_quarter"] = 1;
                    break;
                default:
                    $data["first_semester"] = $this->getScheduleTermAcademic("FIRST_SEMESTER", $academic_id);
                    $data["second_semester"] = $this->getScheduleTermAcademic("SECOND_SEMESTER", $academic_id);
                    break;
            }
        }

        return $data;
    }

    protected function getScheduleTermAcademic($term, $academic_id){

        $data = array();



        return $data;

    }

}