<?php

namespace LoginApp\Controller;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulJsonController
{

    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to CAMEMIS App..."));
    }

    /**
     * Post Login
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {   // Action used for POST requests
        $action_key = isset($data["action_key"]) ? $data["action_key"] : "";

        switch ($action_key) {
            case "Pu0QUvj82x":
                $url = isset($data["url"]) ? $data["url"] : "";
                if ($this->getSchoolData($url)) {
                    return new JsonModel(array('success' => true, 'data' => $this->getSchoolData($url)));
                } else {
                    return new JsonModel(array('success' => false, 'data' => "Not available"));
                }

                break;
            case "EnOLNTB1Q":
                $username = isset($data["username"]) ? $data["username"] : "";
                $password = isset($data["password"]) ? $data["password"] : "";
                $role = isset($data["role"]) ? $data["role"] : "";
                if ($this->actionLogin($role, $username, $password)) {
                    return new JsonModel(array('success' => true, 'data' => $this->actionLogin($role, $username, $password)));
                } else {
                    return new JsonModel(array('success' => false, 'data' => "Not available"));
                }
                break;
        }
    }

    /**
     * @param $role
     * @param $username
     * @param $password
     * @return string
     */
    protected function actionLogin($role, $username, $password)
    {
        $loginTable = $this->getServiceLocator()->get('LoginTable');
        return $loginTable->getTokenData($role, $username, $password);
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function getSchool($url)
    {
        $SchoolTable = $this->getServiceLocator()->get('SchoolTable');
        return $SchoolTable->getSchoolByUrl($url);
    }

    /**
     * @param $mobileUri
     */
    protected function setChooseDBName($mobileUri)
    {
        $this->getServiceLocator()->get('Session')->offsetSet('USER_DB', $this->getSchool($mobileUri)->DB_NAME);
    }

}
