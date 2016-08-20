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

        $mobileUri = isset($data["url"]) ? $data["url"] : "";
        $username = isset($data["username"]) ? $data["username"] : "";
        $password = isset($data["password"]) ? $data["password"] : "";
        $role = isset($data["role"]) ? $data["role"] : "";

        $this->setChooseDBName($mobileUri);
        $token = $this->actionLogion($role, $username, $password);
        return new JsonModel(array('tokenId' => $token));
    }

    /**
     * @param $role
     * @param $username
     * @param $password
     * @return string
     */
    protected function actionLogion($role, $username, $password)
    {
        $sql = new Sql($this->getServiceLocator()->get('UserAdapter'));
        $select = $sql->select();
        switch ($role) {
            case 1:
                $select->from('t_student', array('*'));
                break;
            case 2:
                $select->from('t_member', array('*'));
                break;
        }

        $select->where(array('loginname' => $username));
        $select->where(array('password' => md5($password . "-D99A6718-9D2A-8538-8610-E048177BECD5")));
        //echo ($sql->getSqlstringForSqlObject($select));
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
        $output = $resultSet->initialize($statement->execute())->toArray();

        $tokenId = $output ? $output[0]["ID"] : "";
        $this->getServiceLocator()->get('Session')->offsetSet('tokenId', $tokenId);

        return $tokenId;
    }

    /**
     * @param $mobileUri
     * @return mixed
     */
    protected function getUserDB($mobileUri)
    {
        $sql = new Sql($this->getServiceLocator()->get('AdminAdapter'));
        $select = $sql->select();
        $select->from('t_customer', array('*'));
        $select->where(array('url' => $mobileUri));
        $statement = $sql->prepareStatementForSqlObject($select);
        //echo ($sql->getSqlstringForSqlObject($select));
        $resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
        $result = $resultSet->initialize($statement->execute())->toArray();

        if ($result) {
            return $result[0]["DB_NAME"];
        } else {
            die("Error.....");
        }
    }

    /**
     * @param $mobileUri
     */
    protected function setChooseDBName($mobileUri)
    {
        $this->getServiceLocator()->get('Session')->offsetSet('USER_DB', $this->getUserDB($mobileUri));
    }

}
