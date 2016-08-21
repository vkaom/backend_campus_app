<?php
/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, CAMEMIS Germany}
* ************************************************************************** */

namespace StaffApp\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class StaffTable extends AbstractTableGateway
{

    protected $table = 't_student';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll()
    {
        $resultSet = $this->select(function (Select $select) {
            $select->order('lastname ASC');
        });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Staff();
            $entity->setId($row->ID);
            $entity->setGender($row->GENDER);
            $entity->getLastname($row->LASTNAME);
            $entity->setFirstname($row->FIRSTNAME);
            $entity->setPhone($row->PHONE);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getStaff($id)
    {
        $row = $this->select(array('ID' => $id));
        if (!$row)
            return false;

        $student = new Staff(array(
            'ID' => $row->ID,
            'LASTNAME' => $row->LASTNAME,
            'FIRSTNAME' => $row->FIRSTNAME,
            'FIRSTNAME_LATIN' => $row->FIRSTNAME_LATIN,
            'LASTNAME_LATIN' => $row->LASTNAME_LATIN,
            'DATE_BIRTH' => $row->DATE_BIRTH,
            'EMAIL' => $row->EMAIL,
            'PHONE' => $row->PHONE,
        ));
        return $student;
    }

    public function saveStudent(Staff $staff)
    {
        $data = array(
            'LASTNAME' => $staff->getLastname(),
            'FIRSTNAME' => $staff->getFirstname(),
        );

        $id = (int)$staff->getId();

        if ($id == 0) {
            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        } elseif ($this->getStaff($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        } else
            return false;
    }

    public function removeStaff($id)
    {
        return $this->delete(array('id' => (int)$id));
    }

}