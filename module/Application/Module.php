<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
//namespace Application;
//
//use Zend\Mvc\ModuleRouteListener;
//use Zend\Mvc\MvcEvent;
//
//class Module {
//
//    public function onBootstrap(MvcEvent $e) {
//        $e->getApplication()->getServiceManager()->get('translator');
//        $eventManager = $e->getApplication()->getEventManager();
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
//    }
//
//    public function getConfig() {
//        return include __DIR__ . '/config/module.config.php';
//    }
//
//    public function getAutoloaderConfig() {
//        return array(
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }
//
//}



/* * ***************************************************************************
 * Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 * 
 * This file is part of CAMEMIS Learning.
 * 
 * {CAMEMIS Learning} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, Vikensoft Germany}
 * ************************************************************************** */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
//use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
//use Zend\Session\Container;
//use Application\Model\User;
//use Application\Model\UserRole;
//use File\Model\File;
//use Application\Model\PermissionTable;
//use Application\Model\ResourceTable;
//use Application\Model\RolePermissionTable;
//use Zend\Authentication\AuthenticationService;
//use Application\Model\Role;
//use Application\Utility\Acl;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
                ), 100);
    }
    
    function boforeDispatch(MvcEvent $event) {
        $RESPONSE = $event->getResponse();

//        $MODUL_WHITELIST = array(
//            'Application\Controller\ApplicationController-index',
//            'Application\Controller\ApplicationController-main',
//            'Application\Controller\ApplicationController-logout',
//            'Application\Controller\ApplicationController-permission',
//            'Application\Controller\ApplicationController-lockscreen',
//            'Location\Controller\LocationAPIController',
//            'Setting\Controller\SettingController-index',
//            'Setting\Controller\SettingAPIController',
//            'Translation\Controller\TranslationAPIController',
//            'User\Controller\RoleAPIController',
//            'User\Controller\ModulResourceAPIController',
//            'User\Controller\ModulPermissionAPIController',
//            'Test\Controller\TestAPIController',
//            'Test\Controller\TestUserAPIController',
//            'Course\Controller\CourseAPIController',
//            'Course\Controller\CourseUserAPIController',
//            'User\Controller\UserAPIController',
//            'File\Controller\FileAPIController',
//            'Category\Controller\CategoryAPIController',
//            'Document\Controller\DocumentAPIController',
//            'Document\Controller\DocumentUserAPIController',
//            'Role\Controller\RoleAPIController',
//            'Role\Controller\RolePermissionAPIController',
//            'Bookcollection\Controller\BookcollectionAPIController',
//            'Bookcollection\Controller\BookcollectionUserAPIController',
//            'Application\Controller\ApplicationAPIController',
//            'Application\Controller\VideoAPIController',
//            'Application\Controller\NoteAPIController',
//            'Application\Controller\AnswerAPIController',
//            'Application\Controller\QuestionAPIController',
//            'Preview\Controller\PreviewAPIController',
//            'Preview\Controller\DiscussionAPIController',
//            'Preview\Controller\ChatAPIController',
//            'Preview\Controller\PreviewController-index',
//            'Preview\Controller\PreviewController-course',
//            'Preview\Controller\PreviewController-document',
//            'Preview\Controller\PreviewController-bookcollection',
//            'Preview\Controller\PreviewController-test',
//            'Publish\Controller\PublishController-index',
//            'Publish\Controller\PublishController-course',
//            'Publish\Controller\PublishController-test',
//            'Publish\Controller\PublishController-book',
//            'Publish\Controller\PublishController-doc',
//            'Publish\Controller\PublishController-pdfviewer',
//            'Application\Controller\RatingAPIController',
//            'Application\Controller\ApplicationController-login'
//        );
        //$CONTROLLER = $event->getRouteMatch()->getParam('controller') . "Controller";
        //$ACTION = $event->getRouteMatch()->getParam('action');
        //$REQUESTED_RESOURSE = $ACTION ? $CONTROLLER . "-" . $ACTION : $CONTROLLER;
//        $SESSION = new Container('User');
//
//        if ($SESSION->offsetExists('email')) {
//            if (in_array($REQUESTED_RESOURSE, $MODUL_WHITELIST)) {
//                $RESPONSE->setHeaders($RESPONSE->getHeaders()->addHeaderLine('Location', '/permission'));
//            } else {
//                $SERVICE_MANAGER = $event->getApplication()->getServiceManager();
//                $USER_ROLE = $SESSION->offsetGet('roleName');
//                $ACL = $SERVICE_MANAGER->get('Acl');
//                $ACL->initAcl();
//
//                $STATUS = $ACL->isAccessAllowed($USER_ROLE, $CONTROLLER, $ACTION);
//                if (!$STATUS) {
//                    //die('Permission denied');
//                    $RESPONSE->setHeaders($RESPONSE->getHeaders()->addHeaderLine('Location', '/permission'));
//                    $RESPONSE->setStatusCode(302);
//                    $RESPONSE->sendHeaders();
//                }
//            }
//        } else {
//
//            if (!in_array($REQUESTED_RESOURSE, $MODUL_WHITELIST)) {
//                //$url = '/permission';
//                ////////////////////////////////////////////////////////////////
//                // !$REQUESTED_RESOURSE Redirection to Login Page...
//                ////////////////////////////////////////////////////////////////
//
//                $url = "/login";
//                $RESPONSE->setHeaders($RESPONSE->getHeaders()->addHeaderLine('Location', $url));
//                //$RESPONSE->setStatusCode(302);
//                $RESPONSE->sendHeaders();
//            }
//            $RESPONSE->sendHeaders();
//        }

        $RESPONSE->sendHeaders();
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig() {
        return array(
//            'factories' => array(
//                'AuthService' => function ($SERVICE_MANAGER) {
//                    $adapter = $SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter');
//                    $dbAuthAdapter = new DbAuthAdapter($adapter, 'users', 'email', 'password');
//                    $auth = new AuthenticationService();
//                    $auth->setAdapter($dbAuthAdapter);
//                    return $auth;
//                },
//                'Acl' => function ($SERVICE_MANAGER) {
//                    return new Acl();
//                },
//                'UserTable' => function ($SERVICE_MANAGER) {
//                    return new User($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'RoleTable' => function ($SERVICE_MANAGER) {
//                    return new Role($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'UserRoleTable' => function ($SERVICE_MANAGER) {
//                    return new UserRole($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'PermissionTable' => function ($SERVICE_MANAGER) {
//                    return new PermissionTable($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'ResourceTable' => function ($SERVICE_MANAGER) {
//                    return new ResourceTable($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'RolePermissionTable' => function ($SERVICE_MANAGER) {
//                    return new RolePermissionTable($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                },
//                'FileTable' => function ($SERVICE_MANAGER) {
//                    return new File($SERVICE_MANAGER->get('Zend\Db\Adapter\Adapter'));
//                }
//            )
        );
    }

}
