<?php

$h = '';

$h = '<table class="word">';
    $h .= '<tr>';
        $h .= "<td><b>{$WORD_DATA['r1c1']}</b> <i>{$WORD_DATA['type_r']}</i></td>";
        $h .= "<td>{$WORD_DATA['r1c2']}</td>";
        $h .= "<td class=\"left-border\">{$WORD_DATA['r1c3']} <i>{$WORD_DATA['type_s']}</i></td>";
        $h .= "<td class=\"devanagari\">{$WORD_DATA['r1c4']}</td>";
    $h .= '</tr>';
    if (isset ($WORD_DATA['r2c1'])) {
        $h .= '<tr>';
            $h .= "<td>{$WORD_DATA['r2c1']}</td>";
            $h .= "<td>{$WORD_DATA['r2c2']}</td>";
            $h .= "<td class=\"left-border\">{$WORD_DATA['r2c3']}</td>";
            $h .= "<td class=\"devanagari\">{$WORD_DATA['r2c4']}</td>";
        $h .= '</tr>';
    }
    $h .= '<tr>';
        $h .= "<td colspan=2><i>{$WORD_DATA['r3c1']}</i></td>";
        if (isset ($WORD_DATA['rigveda'])) {
            $h .= "<td colspan=3 class=\"left-border\"><i>{$WORD_DATA['r3c3']} {$WORD_DATA['rigveda']}</i></td>";
        } else {
            $h .= "<td colspan=3 class=\"left-border\"><i>{$WORD_DATA['r3c3']}</i></td>";
        }
    $h .= '</tr>';
    $h .= '<tr>';
        $h .= "<td colspan=5>";
            $h .= "<p>{$WORD_DATA['r4c1']}</p>";

            $a = [];
            foreach (['cognates_r', 'source_r', 'rating'] as $k) {
                if (isset ($WORD_DATA[$k])) {
                    $a[] = $WORD_DATA[$k];
                }
            }
            $h .= implode(' ', $a);

        $h .= "</td>";
    $h .= '</tr>';
$h .= '</table>';

return $h;
