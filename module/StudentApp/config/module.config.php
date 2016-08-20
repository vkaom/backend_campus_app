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
            'student' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/student[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'StudentApp\Controller\Student',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'StudentApp\Controller\Student' => 'StudentApp\Controller\StudentController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
