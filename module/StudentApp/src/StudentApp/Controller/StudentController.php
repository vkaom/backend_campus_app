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
        $sm = $this->getServiceLocator();
        $this->studentTable = $sm->get('StudentApp\Model\StudentTable');
        var_dump($this->studentTable->fetchAll());
        return new JsonModel(
            array('data' =>
                array(
                    array('id' => 1, 'Lastname' => 'Kaom', 'Firstname' => 'Sothearos'),
                    array('id' => 2, 'Lastname' => 'Thou', 'Firstname' => 'Veasna'),
                    array('id' => 3, 'Lastname' => 'Sao', 'Firstname' => 'Sothearak'),
                )
            )
        );
    }

    public function get($id)
    {   // Action used for GET requests with resource Id
        return new JsonModel(array("data" => array('id' => 1, 'Lastname' => 'Kaom', 'Firstname' => 'Sothearos')));
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id' => 2, 'Lastname' => 'Thou', 'Firstname' => 'Veasna')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id' => 3, 'Lastname' => 'Sao', 'Firstname' => 'Sothearak')));
    }

    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'Staff id 3 deleted'));
    }
}