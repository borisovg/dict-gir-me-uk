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
                'User' => ($r['user']) ? $r['user'] : '&nbsp;',
                'Data' => ($r['data']) ? "<pre>{$r['data']}</pre>" : '&nbsp;'
            ];
        }

        echo require ROOT_PATH . '/templates/log.php';
    }
}
