<?php

$HTML_TITLE = 'Log';

$h = '';
$h .= '<ul class="nav navbar-nav navbar-right">';
    $h .= '<li><a href="/">Home</a></li>';
    $h .= '<li><a href="/logout/">Logout</a></li>';    
$h .= '</ul>';
$HTML_HEADER_NAV = $h;

$HTML_HEADER = require (ROOT_PATH . '/templates/header.php');

$h = '';
$h .= '<div class="container-fluid">';

if (!empty ($LOG_DATA)) {
    $h .= '<table class="table">';
        $h .= '<thead>';
            $h .= '<tr>';

                foreach ($LOG_DATA[0] as $k => $c) {
                    $h .= "<th>$k</th>";
                }

            $h .= '</tr>';       
        $h .= '</thead>';
        $h .= '<tbody>';

            foreach ($LOG_DATA as &$r) {
                if ($r['Level'] === 'WARN') {
                    $h .= '<tr class="warning">';

                } else if ($r['Level'] === 'ERROR') {
                    $h .= '<tr class="danger">';

                } else {
                    $h .= "<tr>";
                }

                foreach ($r as $c) {
                    $h .= "<td>$c</td>";
                }
                
                $h .= '</tr>';
            }

        $h .= '</tbody>';
    $h .= '</table>';

} else {
    $h .= '<p>No data</p>';
}

$h .= '</div>';

$HTML_BODY = $h;

return require (ROOT_PATH . '/templates/base.php');
