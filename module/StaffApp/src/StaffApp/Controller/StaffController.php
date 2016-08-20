<?php
/*******************************************************************************
 * Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 *
 * This file is part of CAMEMIS App.
 *
 * {CAMEMIS App} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, CAMEMIS Germany}
 ******************************************************************************/
namespace StaffApp\Controller;

use AlbumApi\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class StaffController extends AbstractRestfulJsonController
{
    public function getList()
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }

        return new JsonModel(
            array('data' =>
                array(
                    array('id'=> 1, 'Lastname' => 'Kaom','Firstname' => 'Vibolrith'),
                    array('id'=> 2, 'Lastname' => 'Sor','Firstname' => 'Veasna'),
                    array('id'=> 3, 'Lastname' => 'Chung','Firstname' => 'Veng'),
                )
            )
        );
    }

    public function get($id)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array("data" => array('id'=> 1, 'Lastname' => 'Kaom', 'Firstname' => 'Vibolrith')));
    }

    public function create($data)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => array('id'=> 2, 'Lastname' => 'Sor', 'Firstname' => 'Veasna')));
    }

    public function update($id, $data)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => array('id'=> 3, 'Lastname' => 'Chung', 'Firstname' => 'Veng')));
    }

    public function delete($id)
    {
        if (!$this->getServiceLocator()->get("UserLogin")) {
            exit();
        }
        return new JsonModel(array('data' => 'Staff id 3 deleted'));
    }
}