<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
namespace StudentApp\Model;

use Zend\Db\TableGateway\TableGateway;

class StudentTable
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

    public function getStudent($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveStudent(Student $student)
    {
        $data = array(
            'lastname' => $student->lastname,
            'firstname'  => $student->firstname,
        );

        $id = (int) $student->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getStudent($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Student id does not exist');
            }
        }
    }

    public function deleteStudent($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}