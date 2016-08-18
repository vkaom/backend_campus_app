<?php

/* * ***************************************************************************
* Copyright (C) 2016 {KAOM Vibolrith} <{vibolrith@gmail.com}>
*
* This file is part of CAMEMIS App.
*
* {CAMEMIS App} can not be copied and/or distributed without the express
* permission of {KAOM Vibolrith, Vikensoft Germany}
* ************************************************************************** */
return array(
    'router' => array(
        'routes' => array(
            'staff' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/staff[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'StaffApp\Controller\Staff',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'StaffApp\Controller\Staff' => 'StaffApp\Controller\StaffController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
