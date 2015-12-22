<?php

namespace handlers\api;

class Ping extends Base {
    function get () {
        parent::check_auth();
        return;
    }
}
