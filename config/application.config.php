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
    'modules' => array(
        'LoginApp',
        'StudentApp',
        'StaffApp'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        // local/global config location when needed
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);