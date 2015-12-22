<?php

namespace handlers;

use \Auth;

class Logout {
    protected $error;

    function get () {
        // will redirect
        Auth::logout();
    }
}
