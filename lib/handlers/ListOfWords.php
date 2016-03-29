<?php

namespace handlers;

use \Auth;

class ListOfWords extends Base {
    function get () {
        parent::check_auth(true);

        echo require (ROOT_PATH . '/templates/list_of_words.php');
    }
}
