<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
/**
 * Created by PhpStorm.
 * User: Sao
 * Date: 19.08.2016
 * Time: 00:31
 */

namespace StaffApp\Model;

class Staff
{
    public $id;
    public $firstname;
    public $lastname;
    public $gender;
    public $code;
    public $firstname_latine;
    public $lastname_latine;
    public $date_birth;
    public $email;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->firstname = (!empty($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname = (!empty($data['lastname'])) ? $data['lastname'] : null;
        $this->gender = (!empty($data['gender'])) ? $data['gender'] : null;
        $this->code = (!empty($data['code'])) ? $data['code'] : null;
        $this->firstname_latine = (!empty($data['firstname_latine'])) ? $data['firstname_latine'] : null;
        $this->lastname_latine = (!empty($data['lastname_latine'])) ? $data['lastname_latine'] : null;
        $this->date_birth = (!empty($data['date_birth'])) ? $data['date_birth'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
    }
}