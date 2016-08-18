<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
/* * ***************************************************************************
* Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS Learning.
*
* {CAMEMIS Learning} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
namespace StaffApp\Model;

use Zend\Db\TableGateway\TableGateway;

class StaffTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getStaff($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveStaff(Staff $staff)
    {
        $data = array(
            'lastname' => $staff->lastname,
            'firstname'  => $staff->firstname,
        );

        $id = (int) $staff->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getStaff($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Staff id does not exist');
            }
        }
    }

    public function deleteStaff($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}