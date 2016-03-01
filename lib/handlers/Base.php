<?php

namespace handlers;

use \Auth;

class Base {
    protected static function check_auth ($admin = false) {
        if (!Auth::isAuthenticated()) {
            header('Location: /login/');
            exit;

        } else if ($admin && !Auth::isAdmin()) {
            self::http_error(403, 'Forbidden');
        }
    }

    protected static function http_error ($c, $m, $d = false) {
        http_response_code($c);

        if ($d) {
            echo "<pre>$c: $m\n\n$d</pre>";

        } else {
            echo "$c: $m";
        }

        exit;
    }
}
