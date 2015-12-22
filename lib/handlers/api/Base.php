<?php

namespace handlers\api;

use \Auth;

class Base {
    protected static function check_auth () {
        if (!Auth::isAuthenticated(false)) {
            self::json_response(["error" => ["code" => 401, "message" => "Login Required"]]);
        }
    }

    protected static function json_response ($a) {
        header('Content-Type: application/json');

        if (isset ($a['error'])) {
            http_response_code($a['error']['code']);
        }

        exit (json_encode($a, JSON_NUMERIC_CHECK));
    }

    protected static function json_error ($c, $m, $d = false) {
        $err = ['code' => $c, 'message' => $m];

        if ($d) {
            $err['data'] = $d;
        }

        self::json_response(['error' => $err]);
    }
}
