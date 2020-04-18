<?php

$config = array(
    "db" => array(
        "dbname" => "",
        "username" => "",
        "password" => "",
        "host" => ""
    ),
    "url" => array(
        "api" => "",
        "cover" => ""
    )
);

defined("COMPONENTS_PATH")
    or define("COMPONENTS_PATH", realpath(dirname(__FILE__) . '/components'));
     
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

?>