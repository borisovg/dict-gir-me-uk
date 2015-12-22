<?php

// This router file is for use with PHP's built-in web-server during development.

if (preg_match('/(\/|\.html|\.php)$/', $_SERVER["REQUEST_URI"])) {
    if (!is_file($_SERVER['DOCUMENT_ROOT'] . $_SERVER["REQUEST_URI"])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php');
        exit;
    }
}

return false;
