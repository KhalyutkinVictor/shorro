<?php

require_once('src/db.php');
require_once('src/link.php');
require_once('src/router.php');
require_once('src/entry.php');

$config = require('config.php');
if (!array_key_exists('db', $config))
    throw new \Exception('"db" shoud exist in //config.php');

if (!array_key_exists('domain', $config))
    throw new \Exception('"domain" shoud exist in //config.php');

$App = (object)[
    'db' => new Db($config['db']),
    'config' => $config,
    'method' => $_SERVER['REQUEST_METHOD'],
];

$App->entry = new Entry($_GET ?? $_POST, $App->method);
