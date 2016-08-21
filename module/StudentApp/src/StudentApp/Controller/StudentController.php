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

        print_r($this->getServiceLocator()->get("Session"));


        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }

        $sm = $this->getServiceLocator();
        $this->studentTable = $sm->get('StudentApp\Model\StudentTable');
        //var_dump($this->studentTable->fetchAll());

        $data = array();

        foreach($sm->get('StudentApp\Model\StudentTable') as $student){

        }

        return new JsonModel(
            array('data' =>
                $this->studentTable->fetchAll()
            )
        );
    }

    public function get($id)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array("data" => array('id' => 1, 'Lastname' => 'Kaom', 'Firstname' => 'Sothearos')));
    }

    public function create($data)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => array('id' => 2, 'Lastname' => 'Thou', 'Firstname' => 'Veasna')));
    }

    public function update($id, $data)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => array('id' => 3, 'Lastname' => 'Sao', 'Firstname' => 'Sothearak')));
    }

    public function delete($id)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => 'Staff id 3 deleted'));
    }
}