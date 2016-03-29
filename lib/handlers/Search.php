<?php

namespace handlers;

class Search extends Base {
    function get () {
        parent::check_auth(true);

        echo require (ROOT_PATH . '/templates/search.php');
    }
}
