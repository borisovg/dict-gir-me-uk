<?php

$h = '';

$h .= '<table class="word">';
    $h .= '<tr>';
        $h .= "<td><b>{$WORD_DATA['r1c1']}</b> <i>{$WORD_DATA['type_r']}</i></td>";
        $h .= "<td>{$WORD_DATA['r1c2']}</td>";
        $h .= "<td>{$WORD_DATA['r1c3']}</td>";
        $h .= "<td class=\"left-border\">{$WORD_DATA['r1c4']} <i>{$WORD_DATA['type_s']}</i></td>";
        $h .= "<td class=\"devanagari\">{$WORD_DATA['r1c5']}</td>";
    $h .= '</tr>';
    if (isset ($WORD_DATA['r2c1'])) {
        $h .= '<tr>';
            $h .= "<td>{$WORD_DATA['r2c1']}</td>";
            $h .= "<td>{$WORD_DATA['r2c2']}</td>";
            $h .= "<td>{$WORD_DATA['r2c3']}</td>";
            $h .= "<td class=\"left-border\">{$WORD_DATA['r2c4']}</td>";
            $h .= "<td class=\"devanagari\">{$WORD_DATA['r2c5']}</td>";
        $h .= '</tr>';
    }
    if (isset ($WORD_DATA['r3c1'])) {
        $h .= '<tr>';
            $h .= "<td>{$WORD_DATA['r3c1']}</td>";
            $h .= "<td colspan=2>{$WORD_DATA['r3c2']}</td>";
            $h .= "<td class=\"left-border\" colspan=2>&nbsp;</td>";
        $h .= '</tr>';
    }
    $h .= '<tr>';
        if (isset ($WORD_DATA['class_r'])) {
            $h .= "<td colspan=3><i>{$WORD_DATA['r4c1']}</i> {$WORD_DATA['class_r']}</td>";
        } else {
            $h .= "<td colspan=3><i>{$WORD_DATA['r4c1']}</i></td>";
        }
        if (isset ($WORD_DATA['rigveda'])) {
            $h .= "<td colspan=2 class=\"left-border\"><i>{$WORD_DATA['r4c4']}</i> {$WORD_DATA['rigveda']}</td>";
        } else {
            $h .= "<td colspan=2 class=\"left-border\"><i>{$WORD_DATA['r4c4']}</i></td>";
        }
    $h .= '</tr>';
    if (isset ($WORD_DATA['r5c1'])) {
        $h .= '<tr>';
            $h .= "<td colspan=5>{$WORD_DATA['r5c1']}</td>";
        $h .= '</tr>';
    }
    $h .= '<tr>';
        $h .= "<td colspan=5>";
            $h .= "{$WORD_DATA['r6c1']}<br>";

            $a = [];
            foreach (['cognates', 'source', 'rating'] as $k) {
                if (isset ($WORD_DATA[$k])) {
                    $a[] = $WORD_DATA[$k];
                }
            }
            $h .= implode(' ', $a);

        $h .= "</td>";
    $h .= '</tr>';
$h .= '</table>';

return $h;
