<?php

class Router {

    // Redirect to $url
    public static function redirect($url) {
        header("Location: $url", true);
    }

}