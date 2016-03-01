<?php

namespace handlers\api;

use \Model;

class Word extends Base {
    function get ($id) {
        parent::check_auth();

        if (!is_numeric($id)) {
            parent::json_error(400, 'Bad Request');
        }

        $m = new Model();

        if (!$word = $m->get_word($id)) {
            parent::json_error(404, 'Not Found');
        }

        parent::json_response($word);
    }

    function post ($id) {
        parent::check_auth();

        if (!is_numeric($id)) {
            parent::json_error(400, 'Bad Request');
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data) || !isset ($data['key'])) {
            parent::json_error(400, 'Bad Request', $data);
        }

        if (!isset ($data['val'])) {
            $data['val'] = false;
        }

        $m = new Model();

        parent::json_response($m->update_word($id, $data['key'], $data['val']));
    }
}
