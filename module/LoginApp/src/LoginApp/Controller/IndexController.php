<?php

namespace LoginApp\Controller;

use Zend\Session\Container;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use LoginApp\Controller\AbstractRestfulJsonController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulJsonController {

    const USER_URI = "school-vn.camemis.home";

    public function getList() {

        $this->setChooseDBName();
        return new JsonModel(array('data' => "Welcome to CAMEMIS App..."));
    }

    protected function getUserDB() {
        $sql = new Sql($this->getServiceLocator()->get('AdminAdapter'));
        $select = $sql->select();
        $select->from('t_customer', array('*'));
        $select->where(array('URL' => self::USER_URI));
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
        $result = $resultSet->initialize($statement->execute())->toArray();
        if ($result) {
            return $result[0]["DB_NAME"];
        } else {
            die("Error.....");
        }
    }

    protected function setChooseDBName() {
        $session = new Container();
        $session->offsetSet('choose_db_name', $this->getUserDB());
    }

}
