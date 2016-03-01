<?php

set_include_path(ROOT_PATH . '/lib/PEAR/');

require_once 'Horde/Autoloader/Default.php';

$renderer = new Horde_Text_Diff_Renderer_Inline();

$HTML_TITLE = 'Log';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li><a href="/">Home</a></li>';
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;

$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container-fluid logs">';

if (!empty ($LOG_DATA)) {
    foreach ($LOG_DATA as &$r) {
        if ($r['Level'] === 'WARN') {
            $h .= '<p class="bg-warning">';

        } else if ($r['Level'] === 'ERROR') {
            $h .= '<p class="bg-danger">';

        } else {
            $h .= '<p>';
        }

        //var_dump($r);

        $h .= "{$r['Time']}:{$r['Level']}:";
        if ($r['User']) {
            $h .= strtoupper("{$r['User']}:");
        }
        $h .= strtoupper("{$r['Data']['action']}:: ");

        if ($r['Data']['action'] === 'edit') {
            if (isset ($r['Data']['word_id'])) {
               $m = new \Model(); 
               $w = $m->get_word($r['Data']['word_id']);

               $h .= "Word: {$w['russian']}, Column: {$r['Data']['column']}";

            } else if (isset ($r['Data']['word'])) {
               $h .= "Word: {$r['Data']['word']}, Column: {$r['Data']['column']}";
            }

            //$h .= "<p>{$r['RawData']}</p>";

            $diff = new Horde_Text_Diff('auto', [
                explode("\n", $r['Data']['value_before']),
                explode("\n", $r['Data']['value_after'])
            ]);

            $h .= '<pre>' . $renderer->render($diff) . "</pre>";

        } else {
            $h .= $r['RawData'];
        }

        $h .= '</p>';
    }

} else {
    $h .= '<p>No data</p>';
}

$h .= '</div>';

$HTML_BODY = $h;

return require (ROOT_PATH . '/templates/base.php');
