<?php

namespace handlers;

use \Auth;
use \Logger;

class Login {
    protected $error;

    function get () {
        if (Auth::isAuthenticated(false)) {
            header('Location: /');
            exit;
        }

        echo require (ROOT_PATH . '/templates/login.php');
    }

    function post () {
        $log = new Logger();

        if (isset ($_POST['un']) && isset ($_POST['pw'])) {
            if (!session_id()) {
                session_start();
            }

            $lastURI = (isset ($_SESSION['lastURI'])) ? $_SESSION['lastURI'] : $_SERVER['REQUEST_URI'];
            $a = ['action' => 'login', 'success' => false, 'ip' => $_SERVER['REMOTE_ADDR']];

            if (\Auth::login($_POST['un'], $_POST['pw'], false)) {
                $a['success'] = true;
                $log->info($a);

                header("Location: $lastURI");
                exit;
            }
        }

        $a['username'] = $_POST['un'];
        $log->warn($a);

        sleep(3);

        http_response_code(401);
        $this->error = 'Login Failed';
        echo require (ROOT_PATH . '/templates/login.php');
    }
}
