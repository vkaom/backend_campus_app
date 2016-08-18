<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
namespace StaffApp;

use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\View\Model\JsonModel;
use Zend\Db\TableGateway\TableGateway;
use StaffApp\Model\Staff;
use StaffApp\Model\StaffTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);
    }

    public function onDispatchError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e)
    {
        $error = $e->getError();
        if (!$error) {
            return;
        }

        $exception = $e->getParam('exception');
        $exceptionJson = array();
        if ($exception) {
            $exceptionJson = array(
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString()
            );
        }

        $errorJson = array(
            'message' => 'An error occurred during execution; please try again later.',
            'error' => $error,
            'exception' => $exceptionJson,
        );
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }

        $model = new JsonModel(array('errors' => array($errorJson)));

        $e->setResult($model);

        return $model;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'UserAdapter' => function ($sm) {
                    $config = $sm->get('config');
                    $session = new Container();
                    $dbAdapterConfig = array(
                        'driver' => $config["db"]["driver"],
                        'dsn' => "mysql:dbname=" . $session->offsetGet('choose_db_name') . ";host=localhost",
                        'username' => $config["db"]["username"],
                        'password' => $config["db"]["password"],
                    );
                    return new Adapter($dbAdapterConfig);
                }, 'StaffApp\Model\StaffTable' => function ($sm) {
                    $tableGateway = $sm->get('StaffTableGateway');
                    $table = new StaffTable($tableGateway);
                    return $table;
                },
                'StaffTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('UserAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Staff());
                    return new TableGateway('t_staff', $dbAdapter, null, $resultSetPrototype);
                },
            )
        );
    }
}
