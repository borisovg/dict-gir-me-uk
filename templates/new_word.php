<?php

$HTML_TITLE = 'New Word';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li><a href="/">Index</a></li>';
    $h .= '<li><a href="/search/">Search</a></li>';    
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container">';
    $h .= '<div class="page-header">';
        $h .= '<h1>New Word</h1>';
    $h .= '</div>';
    
    if ($this->error) {
        $h .= '<div class="alert alert-danger">' . $this->error . '</div>';
    }

    $h .= '<form action="/new/" method="post" class="form" role="form">';
        $h .= '<div class="form-group row">';
            $h .= '<div class="col-lg-4">';
                $h .= '<label for="russian" class="control-label sr-only">Russian</label>';
                $h .= '<input type="text" name="russian" class="form-control" placeholder="Russian word" value="' . $this->word . '">';
            $h .= '</div>';
        $h .= '</div>';
        $h .= '<div class="form-group row">';
            $h .= '<div class="col-lg-4">';
                $h .= '<button class="btn btn-default" type="submit">Send</button>';
            $h .= '</div>';
        $h .= '</div>';
    $h .= '</form>';
$h .= '</div>';
$HTML_BODY = $h;

return require (ROOT_PATH . '/templates/base.php');
