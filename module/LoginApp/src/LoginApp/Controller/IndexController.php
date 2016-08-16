<?php
namespace LoginApp\Controller;
use LoginApp\Controller\AbstractRestfulJsonController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulJsonController
{
    public function getList()
    {
        $a = $this->getServiceLocator()->get('AuthService');
        print_r($a);
        return new JsonModel(array('data' => "Welcome to CAMEMIS App..."));
    }
}