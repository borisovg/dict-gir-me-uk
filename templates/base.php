<?php

// This is a base page template

$TS = floor(time() / 60);

$h = '';
$h .= '<!DOCTYPE html>';
$h .= '<html lang="en">';
$h .= '<head>';
    $h .= '<title>' . $HTML_TITLE . ' | Russian-Sanskrit Dictionary</title>';
    $h .= '<meta charset="utf-8">';
    $h .= '<link rel="stylesheet" href="/css/bootstrap.css" media="screen">';
    $h .= '<link rel="stylesheet" href="/css/bootstrap_print.css" media="print">';
    $h .= '<link rel="stylesheet" href="/css/screen.css?' . $TS . '">';
    $h .= '<link rel="stylesheet" href="/css/print.css" media="print">';
$h .= '</head>';
$h .= '<body>';
    if (isset ($HTML_HEADER)) {
        $h .= $HTML_HEADER;
    }
    if (isset ($HTML_BODY)) {
        $h .= $HTML_BODY;
    }
    if (isset ($HTML_FOOTER)) {
        $h .= $HTML_FOOTER;
    }
    if (isset ($A_HTML_JS)) {
        foreach ($A_HTML_JS as $s) {
            $h .= "<script src=\"$s\"></script>";
        }
    }
$h .= '</body>';
$h .= '</html>';

return $h;
