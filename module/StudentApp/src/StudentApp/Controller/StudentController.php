<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */

namespace StudentApp\Controller;

use Zend\View\Model\JsonModel;


class StudentController extends AbstractRestfulJsonController
{
    public function getList()
    {
        $student_id = $this->getServiceLocator()->get("getTokenId");

        $data = array();
        $userAgent = $this->params()->fromHeader();
        switch (strtoupper($userAgent["Authorization"])) {
            case "CURRENT-ACADEMIC":
                $studentAcademicTable = $this->getServiceLocator()->get("StudentAcademicTable");
                $data = $studentAcademicTable->getStudentCurrentAcademics($student_id);
                break;
            case "STUDENT-ATTENDANCE":
                $data = array("actionKey" => strtoupper($userAgent["Authorization"]));
                break;
            case "STUDENT-DISCIPLINE":
                $data = array("actionKey" =>strtoupper($userAgent["Authorization"]));
                break;
            case "STUDENT-GRADEBOOK":
                $data = array("actionKey" => strtoupper($userAgent["Authorization"]));
                break;
            case "STUDENT-WEEKLY-SCHEDULE":
                $studentAcademicTable = $this->getServiceLocator()->get("StudentAcademicTable");
                print_r($studentAcademicTable->getStudentWeeklySchedule($student_id, 75));

                $data = array("actionKey" => strtoupper($userAgent["Authorization"]));
                break;
            case "STUDENT-DAILY-SCHEDULE":
                $data = array("actionKey" => strtoupper($userAgent["Authorization"]));
                break;
        }

        return new JsonModel(
            array('data' => $data)
        );
    }


    public function get($id)
    {

        return new JsonModel(array("data" => array('id' => $this->getServiceLocator()->get("getTokenId"))));
    }

    public function create($data)
    {

        return new JsonModel(array('data' => array('id' => 2, 'Lastname' => 'Thou', 'Firstname' => 'Veasna')));
    }

    public function update($id, $data)
    {

        return new JsonModel(array('data' => array('id' => 3, 'Lastname' => 'Sao', 'Firstname' => 'Sothearak')));
    }

    public function delete($id)
    {

        return new JsonModel(array('data' => 'Staff id 3 deleted'));
    }
}