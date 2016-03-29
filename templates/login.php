<?php

$HTML_TITLE = 'Log In';
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container">';
    $h .= '<div class="page-header">';
        $h .= '<h1>Log In</h1>';
    $h .= '</div>';
    
    if (isset ($this->error)) {
        $h .= '<div class="alert alert-danger">' . $this->error . '</div>';
    }

    $h .= '<form action="/login/" method="post" class="form" role="form">';
        $h .= '<div class="form-group row">';
            $h .= '<div class="col-lg-4">';
                $h .= '<label for="un" class="control-label sr-only">Username</label>';
                $h .= '<input type="text" name="un" id="un" class="form-control">';
            $h .= '</div>';
        $h .= '</div>';
        $h .= '<div class="form-group row">';
            $h .= '<div class="col-lg-4">';
                $h .= '<label for="pw" class="control-label sr-only">Password</label>';
                $h .= '<input type="password" name="pw" id="pw" class="form-control">';
            $h .= '</div>';
        $h .= '</div>';
        $h .= '<div class="form-group row">';
            $h .= '<div class="col-lg-4">';
                $h .= '<button class="btn btn-default" type="submit">Log In</button>';
            $h .= '</div>';
        $h .= '</div>';
    $h .= '</form>';
$h .= '</div>';
$HTML_BODY = $h;

return require (ROOT_PATH . '/templates/base.php');
