<?php

$HTML_TITLE = 'Database Dump';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li><a href="/">Home</a></li>';
$h .= '</ul>';
$HTML_HEADER_NAV = $h;
    
//$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h_table = require (ROOT_PATH . '/templates/dump_db_table.php');

/*
$h = <<<HTML
<div class="container">
{$h_table}
</div>
HTML;
 */

$HTML_BODY = $h_table;

return require (ROOT_PATH . '/templates/base.php');
