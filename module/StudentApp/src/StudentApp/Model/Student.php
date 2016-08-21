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

class Student
{

    protected $ID;
    protected $FIRSTNAME;
    protected $LASTNAME;
    protected $FIRSTNAME_LATIN;
    protected $LASTNAME_LATIN;
    protected $GENDER;
    protected $PHONE;
    protected $EMAIL;
    protected $CAMPUS;
    protected $GRADE;
    protected $SCHOOLYEAR;
    protected $CLASSROOM;
    protected $SUBJECT;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId()
    {
        return $this->ID;
    }

    public function setId($v)
    {
        $this->ID = $v;
    }

    public function getFirstname()
    {
        return $this->FIRSTNAME;
    }

    public function setFirstname($v)
    {
        $this->FIRSTNAME = $v;
    }

    public function getLastname()
    {
        return $this->LASTNAME;
    }

    public function getGender()
    {
        return $this->GENDER;
    }

    public function setGender($v)
    {
        $this->GENDER = $v;
    }

    public function setLastname($v)
    {
        $this->LASTNAME = $v;
    }

    public function setPhone($v)
    {
        $this->PHONE = $v;
    }

    public function getPhone()
    {
        return $this->PHONE;
    }

    public function setLastnameLatin($v)
    {
        $this->LASTNAME_LATIN = $v;
    }

    public function getLastnameLatin()
    {
        return $this->LASTNAME_LATIN;
    }

    public function setFistnameLatin($v)
    {
        $this->FIRSTNAME_LATIN = $v;
    }

    public function getFirstnameLatin()
    {
        return $this->FIRSTNAME_LATIN;
    }

    public function setEmail($v)
    {
        $this->EMAIL = $v;
    }

    public function getEmail()
    {
        return $this->EMAIL;
    }

    public function setCampus($v)
    {
        $this->CAMPUS = $v;
    }

    public function getCampus()
    {
        return $this->CAMPUS;
    }

    public function setGrade($v)
    {
        $this->GRADE = $v;
    }

    public function getGrade()
    {
        return $this->GRADE;
    }

    public function setSchoolyear($v)
    {
        $this->SCHOOLYEAR = $v;
    }

    public function getSchoolyear()
    {
        return $this->SCHOOLYEAR;
    }

    public function setClassroom($v)
    {
        $this->CLASSROOM = $v;
    }

    public function getClassroom()
    {
        return $this->CLASSROOM;
    }

    public function setSubject($v)
    {
        $this->SUBJECT = $v;
    }

    public function getSubject()
    {
        return $this->SUBJECT;
    }

}