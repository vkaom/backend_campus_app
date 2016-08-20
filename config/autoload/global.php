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
    'service_manager' => array(
        'factories' => array(
            'AdminAdapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
