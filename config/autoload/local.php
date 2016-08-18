<?php

/* * ***************************************************************************
 * Copyright (C) 2015 {KAOM Vibolrith} <{vibolrith@gmail.com}>
 * 
 * This file is part of CAMEMIS Learning.
 * 
 * {CAMEMIS Learning} can not be copied and/or distributed without the express
 * permission of {KAOM Vibolrith, Vikensoft Germany}
 * ************************************************************************** */
if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "camemis_admin";
} else {
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "camemis_admin";
}
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being comitted into version control.
 */
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => "mysql:dbname=" . $DB_NAME . ";host=localhost",
        'username' => $DB_USERNAME,
        'password' => $DB_PASSWORD,
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    )
);