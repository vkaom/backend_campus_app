<?php

/* * ***************************************************************************
 * Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 * 
 * This file is part of CAMEMIS Learning.
 * 
 * {CAMEMIS Learning} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, Vikensoft Germany}
 * ************************************************************************** */
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'AdminAdapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Institution' => function ($sm) {
                //return $sm->get('AdminAdapter');
                $sql = new Sql($sm->get('AdminAdapter'));
                $select = $sql->select();
                $select->from('t_customer', array('*'));
                $statement = $sql->prepareStatementForSqlObject($select);
                $resultSet= new ResultSet(ResultSet::TYPE_ARRAY);
                return $resultSet->initialize($statement->execute())->toArray();
            },
        ),
    ),


    /**
     *  //return $sm->get('AdminAdapter');
    $sql = new Sql($sm->get('AdminAdapter'));
    $select = $sql->select();
    $select->from('t_customer', array('*'));
    $statement = $sql->prepareStatementForSqlObject($select);
    $resultSet= new ResultSet(ResultSet::TYPE_ARRAY);
    return $resultSet->initialize($statement->execute())->toArray();
     */
);
