<?php
/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, CAMEMIS Germany}
* ************************************************************************** */

namespace LoginApp\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class LoginTable extends AbstractTableGateway
{

    public $table = "";

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    protected function getSchoolByUrl($url)
    {
        $this->table = "t_customer";
        $rowset = $this->select(array('URL' => $url));
        return $rowset->current();
    }

    public function getSchoolData ($url){
        $facette = $this->getSchoolByUrl($url);
        $data = array();
        if($facette){
            $data["name"] = $facette->SCHOOL_NAME;
            $data["phone"] = $facette->CONTACT_PHONE;
            $data["email"] = $facette->CONTACT_EMAIL;
        }
        return $data;
    }

    protected function getToken($role, $username, $password)
    {

        switch ($role) {
            case 1:
                $this->table = "t_student";
                break;
            case 2:
                $this->table = "t_members";
                break;
            case 3:
                break;
        }
        $rowset = $this->select(array(
            'loginname' => $username,
            'password' => md5($password . "-D99A6718-9D2A-8538-8610-E048177BECD5")
        ));
        return $rowset->current();
    }

    public function getTokenData ($role, $username, $password){
        $facette = $this->getToken($role, $username, $password);
        $data = array();
        if($facette){
            $data["tokenId"] = $facette->ID;
            $data["code"] = $facette->CODE;
            $data["lastname"] = $facette->LASTNAME;
            $data["firstname"] = $facette->FIRSTNAME;
            $data["email"] = $facette->EMAIL;
            $data["phone"] = $facette->PHONE;
        }
        return $data;
    }
}