<?php

use Borisov\Config;

class Logger {
    private $db;

    function __construct () {
        ob_start();

        try {
            $dir = Config::get('data_dir');
            $this->db = new DB(false, [], $dir . '/log.sqlite');

        } catch (Exception $e) {
            self::error_exit(500, 'Internal Server Error', $e, ob_get_contents());
        }

        ob_end_flush();
    }

    function error ($data) {
        self::do_log('error', $data);
    }

    function info ($data) {
        self::do_log('info', $data);
    }

    function warn ($data) {
        self::do_log('warn', $data);
    }

    function get_week () {
        $t = time() - 604800;
        $sql = "SELECT * FROM log WHERE timestamp > $t ORDER BY timestamp DESC";

        return $this->db->get($sql);
    }

    private function do_log ($level, $data) {
        ob_start();

        try {
            $this->db->insert('log', ['timestamp' => time(), 'level' => $level, 'user' => Auth::getUserName(), 'data' => json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)]);

        } catch (Exception $e) {
            $this->error_exit(500, 'Internal Server Error', $e, ob_get_contents());
        }

        ob_end_flush();
    }

    private function error_exit ($code, $message, $e, $data) {
        ob_end_clean();

        http_response_code($code);

        echo "<p>$code $message</p>";

        echo "<pre>$e</pre>";

        if ($data) {
            echo "<pre>$data</pre>";
        }

        exit;
    }
}
