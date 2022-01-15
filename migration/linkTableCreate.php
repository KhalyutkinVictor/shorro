<?php

require_once('../src/db.php');

$config = require('../config.php');
if (!array_key_exists('db', $config))
    throw new \Exception('"db" shoud exist in //config.php');

$db = new Db($config['db']);

$query = "CREATE TABLE `shorro`.`link` ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' , `origin` TEXT NOT NULL COMMENT 'Оригинальная ссылка ' , `hash` VARCHAR(255) NOT NULL COMMENT 'Хеш для короткой ссылки ' , `type` INT NOT NULL DEFAULT '1' COMMENT 'Тип ссылки' , `deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Удалено?' , PRIMARY KEY (`id`), INDEX `idx-linkHash` (`hash`)) ENGINE = InnoDB;";

$db->runQuery($query);

echo "Done";