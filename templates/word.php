<?php

$HTML_TITLE = $this->word['russian'];

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
    $h .= '<div class="no-print">';
        $h .= '<form action="/xetex" method="post">';
            $h .= '<input name="ids" type="hidden" xid>';
            $h .= '<input name="lang" type="hidden" xlang>';
            $h .= '<input name="file" type="hidden" xfile>';
            $h .= '<div class="btn-toolbar pull-right" role="toolbar">';
                if (\Auth::isAdmin()) {
                    $h .= '<div class="btn-group" role="group">';
                        $h .= '<button class="btn btn-default" type="submit">XeTeX Code</button>';
                    $h .= '</div>';
                }
                $h .= '<div class="btn-group" role="group">';
                    $h .= '<a class="btn btn-default" href="/words/' . $this->word['id'] . '/edit/">Edit</a>';
                $h .= '</div>';
                /* FIXME: Need to add code to delete word
                if (\Auth::isAdmin()) {
                    $h .= '<div class="btn-group" role="group">';
                        $h .= '<button class="btn btn-default">Delete</button>';
                    $h .= '</div>';
                }
                */
            $h .= '</div>';
        $h .= '</form>';
    $h .= '</div>';
    $h .= '<div class="no-print">';
        $h .= '<ul class="nav nav-tabs" role="tablist">';
            $h .= '<li role="presentation">';
                $h .= '<a href="#eng" aria-controls="home" role="tab" data-toggle="tab" language>English</a>';
            $h .= '</li>';
            $h .= '<li role="presentation">';
                $h .= '<a href="#rus" aria-controls="profile" role="tab" data-toggle="tab" language>Russian</a>';
            $h .= '</li>';
        $h .= '</ul>';
    $h .= '</div>';
    $h .= '<div class="page-header">';
        $h .= '<h1 class="word">' . $this->word['russian'] . '</h1>';
    $h .= '</div>';
    $h .= '<div class="tab-content">';
        $h .= '<div role="tabpanel" class="tab-pane" id="eng">';
            $h .= $this->english_html();
        $h .= '</div>';
        $h .= '<div role="tabpanel" class="tab-pane" id="rus">';
            $h .= $this->russian_html();
        $h .= '</div>';
    $h .= '</div>';
$h .= '</div>';
$HTML_BODY = $h;

$A_HTML_JS = [
    '/lib/jquery/dist/jquery.min.js',
    '/lib/bootstrap/dist/js/bootstrap.min.js'
];

if (\Auth::isAdmin()) {
    $A_HTML_JS[] = '/lib/angular/angular.min.js';
    $A_HTML_JS[] = '/js/word.js';
    $A_HTML_JS[] = '/js/svc_sub.js';
}

return require (ROOT_PATH . '/templates/base.php');
