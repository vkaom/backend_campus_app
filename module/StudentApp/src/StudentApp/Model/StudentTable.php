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
use Zend\Db\Sql\Select;

class StudentTable extends AbstractTableGateway
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
            $entity = new Student();
            $entity->setId($row->ID);
            $entity->setGender($row->GENDER);
            $entity->getLastname($row->LASTNAME);
            $entity->setFirstname($row->FIRSTNAME);
            $entity->setPhone($row->PHONE);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getStudent($id)
    {
        $row = $this->select(array('ID' => $id));
        if (!$row)
            return false;

        $student = new Student(array(
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

    public function saveStudent(Student $student)
    {
        $data = array(
            'LASTNAME' => $student->getLastname(),
            'FIRSTNAME' => $student->getFirstname(),
        );

        $id = (int)$student->getId();

        if ($id == 0) {
            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        } elseif ($this->getStudent($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        } else
            return false;
    }

    public function removeStudent($id)
    {
        return $this->delete(array('id' => (int)$id));
    }

    /*
    public function getCurrentAcademicByStudent($id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table)
            ->join('t_student_schoolyear', 'tracks.album_id = album.id');

        $where = new  Where();
        $where->equalTo('album_id', $id);
        $select->where($where);

        //you can check your query by echo-ing :
        // echo $select->getSqlString();
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result;
    }
    */

    public function getStudentAcademic($id)
    {
        /*
        $this->table = "t_student_current_academic";
        $select = $this->tableGateway->getSql()->select();
        $select->where(array(
            'menu_flag' => 'y',
            'delete_flag' => 'n',
            'catalog_id' => $subQuery,
        ));
        $select->order('level, sort DESC');

        $row = $this->tableGateway->selectWith($select);
        return $row;

        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from("t_student_current_academic");
        */
        $sql = new Sql($this->adapter);
        $maxStartYearSQL = $sql->select();
        $maxStartYearSQL->from("t_student_schoolyear", array('MAX(START_YEAR)'));
        $maxEndYearSQL = $sql->select();
        $maxEndYearSQL->from("t_student_schoolyear", array('MAX(END_YEAR)'));
        $select = $sql->select();
        $select->from(array('A' => "t_student_schoolyear"), array('*'));
        $select->join(array('B' => 't_academicdate'), 'A.SCHOOL_YEAR=B.ID', array("NAME AS SCHOOLYEAR", "NAME_EN AS SCHOOLYEAR_EN"));
        $select->where(array("A.STUDENT='" . $id . "'"));
        $select->where(array("A.START_YEAR IN (" . $maxStartYearSQL . ")"));
        $select->where(array("A.END_YEAR IN (" . $maxEndYearSQL . ")"));
        //error_log($SQL->__toString());
        return $this->tableGateway->selectWith($select);
    }

}