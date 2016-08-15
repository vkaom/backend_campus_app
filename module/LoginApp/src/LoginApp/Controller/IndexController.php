<?php
namespace LoginApp\Controller;

use LoginApp\Controller\AbstractRestfulJsonController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulJsonController
{
    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to CAMEMIS App..."));
    }
}