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

class StudentAcademicTable extends AbstractTableGateway
{

    protected $table = '';

    public function __construct(Adapter $adapter)
    {
        $this->sql = new Sql($adapter);
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
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
        return $entries;

    }
}