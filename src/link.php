<?php

require_once('db.php');

class Link extends Model {

    // Add new row
    public function insert($params) {
        if (!array_key_exists('origin', $params))
            throw new \Exception('"origin" is required');

        if (!array_key_exists('hash', $params))
            throw new \Exception('"hash" is required');

        $origin = htmlspecialchars($params['origin']);
        $hash = htmlspecialchars($params['hash']);
        $type = ($params['type'] !== null) ? htmlspecialchars($params['type']) : '1';
        $deleted = ($params['deleted'] !== null) ? htmlspecialchars($params['deleted']) : 'false';

        $this->setQuery("INSERT INTO `link` (`id`, `origin`, `hash`, `type`, `deleted`) VALUES (NULL, '$origin', '$hash', $type, $deleted)");
        return $this->run();
    }

    public function selectByHash($hash) {
        $this->setQuery("SELECT * FROM `link` WHERE `hash` = '$hash'");
        return $this->run();
    }

}