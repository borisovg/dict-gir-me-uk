<?php

namespace handlers;

use \Model;

class EditWord extends Base {
    private $word;

    function get ($id) {
        parent::check_auth();

        if (!is_numeric($id)) {
            parent::http_error(400, 'Bad Request');
        }

        $m = new Model();

        if (!$this->word = $m->get_word($id)) {
            parent::http_error(404, 'Not Found');
        }

        echo require (ROOT_PATH . '/templates/edit_word.php');
    }
}
