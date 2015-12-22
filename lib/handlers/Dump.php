<?php

namespace handlers;

use \Model;

class Dump extends Base {
    private $columns;
    private $data;

    function get() {
        parent::check_auth(true);

        $m = new Model();

        $this->data = $m->dump();
        $this->columns = (empty ($this->data)) ? [] : array_keys($this->data[0]);

        echo require (ROOT_PATH . '/templates/dump_db.php');
    }
}
