<?php

namespace handlers\api;

use \Model;

class ListOfClasses extends Base {
    function get () {
        parent::check_auth();

        $m = new Model();

        parent::json_response($m->get_classes());
    }
}
