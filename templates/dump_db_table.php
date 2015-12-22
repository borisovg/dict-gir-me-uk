<?php

$h = '';

$h .= '<table class="table">';
    $h .= '<thead>';
        $h .= '<tr>';

            foreach ($this->columns as $c) {
                $h .= "<th>$c</th>";
            }

        $h .= '</tr>';       
    $h .= '</thead>';
    $h .= '<tbody>';

        foreach ($this->data as &$r) {
            $h .= '<tr>';

            foreach ($r as $c) {
                $h .= "<td>$c</td>";
            }
            
            $h .= '</tr>';
        }

    $h .= '</tbody>';
$h .= '</table>';

return $h;
