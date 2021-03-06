<?php

$HTML_TITLE = "Edit Word | {$this->word['russian']}";

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li>';
        $h .= '<button type="button" class="btn btn-default navbar-btn toggle-keyboard">';
            $h .= '<img class="icon" src="/img/keyboard.png" alt="keyboard">';
        $h .= '</button>';
    $h .= '</li>';
    $h .= '<li><a href="/words/' . $this->word['id'] . '/">Preview</a></li>';
    $h .= '<li><a href="/">Index</a></li>';
    $h .= '<li><a href="/search/">Search</a></li>';    
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container-fluid edit-form" ng-controller="editWordCtrl">';
    $h .= require (ROOT_PATH . '/templates/edit_word_form.php');
    $h .= require (ROOT_PATH . '/templates/edit_word_keyboard.php');
$h .= '</div>';
$HTML_BODY = $h;

$A_HTML_JS = [
    '/lib/angular/angular.min.js',
    '/lib/jquery/dist/jquery.min.js',
    '/lib/bootstrap/dist/js/bootstrap.min.js',
    '/js/cfg_no_debug.js',
    '/js/edit_word.js'
];

return require (ROOT_PATH . '/templates/base.php');
