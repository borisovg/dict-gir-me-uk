<?php

$HTML_TITLE = 'List of Words';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    if (\Auth::isAdmin()) {
        $h .= '<li><a href="/new/">New Word</a></li>';
    }
    $h .= '<li><a href="/search/">Search</a></li>';    
    if (\Auth::isAdmin()) {
        $h .= '<li><a href="/log/">Logs</a></li>';    
        $h .= '<li><a href="/dump/">Database</a></li>';    
    }
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container ng-cloak">';
    $h .= '<form id="filterWords" class="form-inline no-print" action="/xetex" method="post" ng-controller="filterCtrl">';
        $h .= '<table class="table">';
            $h .= '<tr>';
                $h .= '<th>First Letter</th>';
                $h .= '<th>Ready</th>';
                $h .= '<th>Not Ready</th>';
                $h .= '<th>Only Scores</th>';
                if (\Auth::isAdmin()) {
                    $h .= '<th>XeTeX Language</th>';
                    $h .= '<th>&nbsp;</th>';
                }
            $h .= '</tr>';
            $h .= '<tr>';
                $h .= '<td rowspan=2>';
                    $h .= '<select ng-model="filters.letter">';
                        $h .= '<option value="">Any</option>';
                        $h .= '<option ng-repeat="l in letters" value="{{l}}">{{l}}</option>';
                    $h .= '</select>';
                $h .= '</td>';
                $h .= '<td>';
                    $h .= '<label><input type="checkbox" ng-model="filters.printOK"> English</label>';
                $h .= '</td>';
                $h .= '<td>';
                    $h .= '<label><input type="checkbox" ng-model="filters.printNotOK"> English</label>';
                $h .= '</td>';
                $h .= '<td rowspan=2>';
                    $h .= '<div id="score" class="form-group">';
                        $h .= '<label ng-repeat="s in scores">';
                            $h .= '<input type="checkbox" ng-checked="filters.scores.indexOf(s) > -1" ng-click="toggleScore(s)"> {{s}}';
                        $h .= '</label>';
                    $h .= '</div>';
                $h .= '</td>';
                if (\Auth::isAdmin()) {
                    $h .= '<td rowspan=2>';
                        $h .= '<select name="lang" ng-model="lang">';
                            $h .= '<option value="eng">English</option>';
                            $h .= '<option value="rus">Russian</option>';
                        $h .= '</select>';
                    $h .= '</td>';
                    $h .= '<td rowspan=2>';
                        $h .= '<input name="ids" type="hidden" ng-value="xids">';
                        $h .= '<input name="file" type="hidden" xfile>';
                        $h .= '<button class="btn btn-default" type="submit">XeTex</button>';
                    $h .= '</td>';
                }
            $h .= '</tr>';
            $h .= '<tr>';
                $h .= '<td>';
                    $h .= '<label><input type="checkbox" ng-model="filters.printRusOK"> Russian</label>';
                $h .= '</td>';
                $h .= '<td>';
                    $h .= '<label><input type="checkbox" ng-model="filters.printRusNotOK"> Russian</label>';
                $h .= '</td>';
            $h .= '</tr>';
        $h .= '</table>';
    $h .= '</form>';
$h .= '</div>';
                
$h .= '<div class="container ng-cloak">';
    $h .= '<div class="no-print" ng-controller="errorCtrl">';
        $h .= '<pre class="alert alert-danger alert-dismissible" ng-show="error">{{error}}</pre>';
    $h .= '</div>';
$h .= '</div>';

$h .= '<div class="container ng-cloak">';
    $h .= '<div ng-controller="wordsCtrl">';
        $h .= '<div class="pull-right no-print">{{wordCount}} {{(wordCount === 1) ? "word" : "words"}}</div>';
        $h .= '<div class="row" ng-repeat="l in letters">';
            $h .= '<h2>{{l}}</h2>';
            $h .= '<div class="col-sm-4" ng-repeat="col in words[l]">';
                $h .= '<ul class="list-unstyled">';
                    $h .= '<li ng-repeat="word in col">';
                        $h .= '<a href="/words/{{word.id}}/">{{word.russian || "NULL"}}</a>';
                    $h .= '</li>';
                $h .= '</ul>';
            $h .= '</div>';
        $h .= '</div>';
    $h .= '</div>';
$h .= '</div>';
$HTML_BODY = $h;

$A_HTML_JS = [
    '/lib/angular/angular.min.js',
    '/lib/jquery/dist/jquery.min.js',
    '/lib/bootstrap/dist/js/bootstrap.min.js',
    '/js/cfg_no_debug.js',
    '/js/list.js',
    '/js/svc_sub.js'
];

return require (ROOT_PATH . '/templates/base.php');
