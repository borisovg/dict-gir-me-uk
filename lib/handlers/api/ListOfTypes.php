<?php

namespace handlers\api;

use \Model;

class ListOfTypes extends Base {
    function get () {
        parent::check_auth();

        $m = new Model();

        parent::json_response($m->get_types());
    }
}
