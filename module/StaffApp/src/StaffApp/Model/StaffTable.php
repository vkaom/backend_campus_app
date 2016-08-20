<?php
/*******************************************************************************
 * Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 *
 * This file is part of CAMEMIS App.
 *
 * {CAMEMIS App} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, CAMEMIS Germany}
 ******************************************************************************/

namespace StaffApp\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class StaffTable extends AbstractTableGateway
{

    protected $table = 't_members';

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
            $entity = new Entity\Staff();
            $entity->setId($row->id)
                ->setLastname($row->lastname)
                ->setFirstname($row->firstname);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getStaff($id)
    {
        $row = $this->select(array('id' => (int)$id))->current();
        if (!$row)
            return false;

        $staff = new Entity\Staff(array(
            'id' => $row->id,
            'lastname' => $row->lastname,
            'firstname' => $row->firstname,
        ));
        return $staff;
    }

    public function saveStudent(Entity\Staff $staff)
    {
        $data = array(
            'lastname' => $staff->getLastname(),
            'firstname' => $staff->getFirstname(),
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