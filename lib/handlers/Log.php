<?php
namespace handlers;

use \Logger;

class Log extends Base {
    private $log;

    function __construct () {
        $this->log = new Logger;
    }

    function get () {
        parent::check_auth(true);

        $result = $this->log->get_week();

        $LOG_DATA = [];

        foreach ($result as &$r) {
            $LOG_DATA[] = [
                'Time' => date('c', $r['timestamp']),
                'Level' => strtoupper($r['level']),
                'User' => ($r['user']) ? $r['user'] : false,
                'Data' => ($r['data']) ? json_decode($r['data'], true) : false,
                'RawData' => ($r['data']) ? $r['data'] : ''
            ];
        }

        echo require ROOT_PATH . '/templates/log.php';
    }
}
