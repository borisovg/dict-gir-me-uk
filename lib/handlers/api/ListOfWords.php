<?php

namespace handlers\api;

use \Model;

class ListOfWords extends Base {
    function post () {
        parent::check_auth();

        $data = json_decode(file_get_contents('php://input'), true);
        $filters = self::validate_filters($data);
        $m = new Model();

        parent::json_response($m->list_words($filters));
    }

    private static function validate_filters ($in) {
        $out = [];

        if (!is_array($in)) {
            self::validator_error();
        }

        if (isset ($in['letter']) && $in['letter']) {
            if (mb_strlen($in['letter'], 'utf8') !== 1 && $in['letter'] !== 'NULL') {
                self::validator_error('letter');
            }

            $out['letter'] = $in['letter'];
        }

        if (isset ($in['scores'])) {
            if (!is_array($in['scores'])) {
                self::validator_error('scores');
            }

            foreach ($in['scores'] as $s) {
                if (!is_numeric($s)) {
                    self::validator_error('scores');
                }
            }

            $out['scores'] = $in['scores'];
        }

        foreach (['printOK', 'printNotOK', 'printRusOK', 'printRusNotOK'] as $k) {
            if (isset ($in[$k]) && $in[$k]) {
                $out[$k] = true;
            }
        }

        return $out;
    }

    private static function validator_error ($key) {
        parent::json_response(['error' => ['code' => 400, 'message' => 'Bad Filter', 'data' => ['key' => $key]]]);
    }
}
