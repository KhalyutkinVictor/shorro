<?php

class Entry {

    public function __construct($request, $method) {
        if ($method == 'GET' && count($request) === 0) {
            Router::redirect('/create');
        }

        if ($method == 'GET' && count($request) > 1) {
            Router::redirect('/');
        }
        $uri = "";
        foreach ($request as $req => $val) {
            $uri = $req;
            break;
        }
        if (count(explode('/', $uri)) > 1) {
            Router::redirect('/');
        }

        if ($method == 'GET' && $uri == 'create') {
            echo file_get_contents('pages/create.html');
            exit();
        }

        if ($method == 'POST' && $uri == 'create') {
            if (!$request['hash'] || !self::validateHash($request['hash'])) {
                echo json_encode(['success' => false, 'reason' => 'Wrong hash']);
                exit();
            }
            if (!$request['origin'] || !self::checkUrl($request['origin'])) {
                echo json_encode(['success' => false, 'reason' => 'Wrong url']);
                exit();
            }
            $link = new Link();
            $out = $link->selectByHash($request['hash']);
            if (!$out) {
                $out = $link->insert([
                    'origin' => $request['origin'],
                    'hash' => $request['hash']
                ]);

                if ($out) {
                    echo json_encode(['success' => true, "href" => $request['hash']]);
                    exit();
                }
                echo json_encode(['success' => false, 'reason' => 'Server error']);
                exit();
            }
            echo json_encode(['success' => false, 'reason' => 'This hash already exist']);
            exit();
        }
        
        $link = new Link();
        $out = $link->setQuery("SELECT * FROM `link` WHERE `deleted` = false AND `hash` = '$uri'")->run();
        if ($out === null) {
            echo file_get_contents('pages/pageNotFound.html');
            exit();
        }

        Router::redirect($out['origin']);
    }

    public static function validateHash(&$hash) {
        return (preg_match("/^[a-zA-Z0-9\-_]+$/", $hash)) ? true : false;
    }

    public static function checkUrl($url) {
        return (filter_var($url, FILTER_VALIDATE_URL) === false) ? false : true;
    }

}