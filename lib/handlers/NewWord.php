<?php

namespace handlers;

use \Model;

class NewWord extends Base {
    private $error;
    private $word;

    function get () {
        parent::check_auth(true);

        echo require (ROOT_PATH . '/templates/new_word.php');
    }

    function post () {
        if (!isset ($_POST['russian'])) {
            self::http_error(400, 'Bad Request');
        }

        $w = trim($_POST['russian']);
        $this->word = $w;

        if (!$w) {
            $this->error('Please type in the Russian word.');
        }

        //if (preg_match('/[^-\x{0400}-\x{04FF}]/u', $w)) {
        //    $this->error('Word rejected due to strange characters.');
        //}

        $m = new Model();

        $r = $m->new_word(['russian' => $w]);

        if (isset ($r['error'])) {
            $this->error(json_encode($r['error'], JSON_NUMERIC_CHECK));

        } else {
            header("Location: /words/{$r['result']['id']}/edit/");
        }
    }

    private function error ($err) {
        $this->error = $err;

        echo require (ROOT_PATH . '/templates/new_word.php');

        exit;
    }
}
