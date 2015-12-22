<?php

namespace handlers\api;

use \Model;

class ListOfLetters extends Base {
    function get () {
        parent::check_auth();

        $m = new Model();

        parent::json_response($m->list_letters());
    }
}
