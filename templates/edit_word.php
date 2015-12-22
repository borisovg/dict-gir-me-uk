<?php

$HTML_TITLE = "Edit Word | {$this->word['russian']}";

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    if (\Auth::isAdmin()) {
        $h .= '<li><a href="/">Index</a></li>';
        $h .= '<li><a href="/new/">New Word</a></li>';
    }
    $h .= '<li><a href="/search/">Search</a></li>';    
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container-fluid edit-form ng-cloak">';
    $h .= require (ROOT_PATH . '/templates/edit_word_form.php');
$h .= '</div>';
$HTML_BODY = $h;

$A_HTML_JS = [
    '/lib/angular/angular.js',
    '/lib/jquery/dist/jquery.min.js',
    '/lib/bootstrap/dist/js/bootstrap.min.js',
    '/js/edit-word.js'
];

return require (ROOT_PATH . '/templates/base.php');
