<?php
/*******************************************************************************
 * Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 *
 * This file is part of CAMEMIS App.
 *
 * {CAMEMIS App} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, CAMEMIS Germany}
 ******************************************************************************/
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'LoginApp\Controller\Index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'LoginApp\Controller\Index' => 'LoginApp\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
