<?php

namespace handlers;

use \Auth;

class Home {
    function get () {
        if (Auth::isAuthenticated()) {
            echo require (ROOT_PATH . '/templates/list_of_words.php');

        } else {
            echo require (ROOT_PATH . '/templates/search.php');
        }
    }
}
