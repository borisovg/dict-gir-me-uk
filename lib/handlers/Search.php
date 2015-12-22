<?php

namespace handlers;

class Search {
    function get () {
        echo require (ROOT_PATH . '/templates/search.php');
    }
}
