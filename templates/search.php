<?php

$HTML_TITLE = 'Search';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li><a href="/">Index</a></li>';    

    if (\Auth::isAuthenticated()) {
        $h .= '<li><a href="/logout/">Logout</a></li>';    

    } else {
        $h .= '<li><a href="/login/">Login</a></li>';
    }
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container">';
    $h .= '<div class="page-header">';
        $h .= '<h1>Search</h1>';
    $h .= '</div>';
    $h .= '<form id="searchForm" class="form">';
        $h .= '<div class="form-group">';
            $h .= '<input class="form-control" id="searchString" placeholder="Search string" type="input">';
        $h .= '</div>';
    $h .= '</form>';
    $h .= '<div id="searchResults" class="row"></div>';
$h .= '</div>';
$HTML_BODY = $h;

return require (ROOT_PATH . '/templates/base.php');
