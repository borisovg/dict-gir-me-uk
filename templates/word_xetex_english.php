<?php

$code = '';

$code .= sprintf('%% %s', $WORD_DATA['russian']) . "\n";

$code .= '\begin{longtable}[l]{>{\hspace{-6pt}\raggedright}p{2cm}>{\raggedright}p{2cm}>{\raggedright}p{2cm}|>{\raggedright}p{2cm}>{\raggedleft}p{\dimexpr\textwidth-8cm-\arrayrulewidth-9\tabcolsep}@{}}' . "\n";
$code .= sprintf('\textbf{{\large %s\index{%s / %s@%s %s / %s}}} %s &', $WORD_DATA['r1c1'], $WORD_DATA['translit_r'], $WORD_DATA['russian'], $WORD_DATA['translit_r'], $WORD_DATA['russian'], $WORD_DATA['translit_s'], $WORD_DATA['type_r']) . "\n";
$code .= sprintf('{\large %s} &', $WORD_DATA['r1c2']) . "\n";
$code .= sprintf('{\large %s} &', $WORD_DATA['r1c3']) . "\n";
$code .= sprintf('{\large %s} %s &', $WORD_DATA['r1c4'], $WORD_DATA['type_s']) . "\n";
$code .= sprintf('{\Large %s}\tabularnewline', $WORD_DATA['r1c5']) . "\n";

// verbs have 2 extra rows
if (isset ($WORD_DATA['r2c1'])) {
    $code .= sprintf('{\large %s} & {\large %s} & {\large %s} & {\large %s} & {\Large %s}\tabularnewline', $WORD_DATA['r2c1'], $WORD_DATA['r2c2'], $WORD_DATA['r2c3'], $WORD_DATA['r2c4'], $WORD_DATA['r2c5']) . "\n";
    $code .= sprintf('{\large %s} & {\large %s} & & & \tabularnewline', $WORD_DATA['r3c1'], $WORD_DATA['r3c2']) . "\n";
}

$code .= sprintf('\multicolumn{3}{>{\hspace{-6pt}\raggedright}p{\dimexpr 6cm+4\tabcolsep}@{}|}{\textit{{\small %s}}%s} &', $WORD_DATA['r4c1'], $WORD_DATA['class_r']) . "\n";
$code .= sprintf('\multicolumn{2}{>{\raggedright}p{\dimexpr\textwidth-6cm-\arrayrulewidth-7\tabcolsep}@{}}{\textit{{\small %s}}%s}', $WORD_DATA['r4c4'], $WORD_DATA['rigveda']) . "\n";
$code .= '\end{longtable}' . "\n";
$code .= '\setlength{\parindent}{0cm}';

if (isset ($WORD_DATA['r5c1'])) {
    $code .= sprintf('%s\\\\[2pt]', $WORD_DATA['r5c1']) . "\n";
}

$code .= sprintf('%s\\\\', $WORD_DATA['r6c1']) . "\n";

$a = [];
foreach (['cognates', 'source', 'rating'] as $k) {
    if ($WORD_DATA[$k]) {
        $a[] = $WORD_DATA[$k];
    }
}
$code .= implode(' ', $a) . '\\\\[-3pt]' . "\n";

return $code;
