<?php

$h = '';
$h .= '<div class="navbar navbar-default navbar-static-top no-print">';
    $h .= '<div class="container-fluid">';
        $h .= '<a class="navbar-brand" href="/">Dictionary</a>';

        if (isset ($HTML_HEADER_NAV)) {
            $h .= $HTML_HEADER_NAV;
        }
    $h .= '</div>';
$h .= '</div>';

return $h;
