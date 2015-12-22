<?php

$code = '';

$code = sprintf('%% %s', $WORD_DATA['russian']) . "\n";

$code .= '\begin{longtable}[l]{>{\hspace{-6pt}\raggedright}p{2cm}>{\raggedright}p{2cm}|>{\raggedright}p{2cm}>{\raggedright}p{2cm}>{\raggedleft}p{\dimexpr\textwidth-8cm-\arrayrulewidth-9\tabcolsep}@{}}' . "\n";
$code .= sprintf('\textbf{{\large %s\index{%s / %s@%s %s / %s}}} %s &', $WORD_DATA['r1c1'], $WORD_DATA['translit_r'], $WORD_DATA['russian'], $WORD_DATA['translit_r'], $WORD_DATA['russian'], $WORD_DATA['translit_s'], $WORD_DATA['type_r']) . "\n";
$code .= sprintf('{\large %s} &', $WORD_DATA['r1c2']) . "\n";
$code .= sprintf('{\large %s} %s &', $WORD_DATA['r1c3'], $WORD_DATA['type_s']) . "\n";
$code .= sprintf('{\large %s} &', $WORD_DATA['r1c4']) . "\n";
$code .= sprintf('{\Large %s}\tabularnewline', $WORD_DATA['r1c5']) . "\n";

// verbs have an extra row
if (isset ($WORD_DATA['r2c1'])) {
    $code .= sprintf('{\large %s} & {\large %s} & {\large %s} & {\large %s} & {\Large %s}\tabularnewline', $WORD_DATA['r2c1'], $WORD_DATA['r2c2'], $WORD_DATA['r2c3'], $WORD_DATA['r2c4'], $WORD_DATA['r2c5']) . "\n";
}

$code .= sprintf('\multicolumn{2}{>{\hspace{-6pt}\raggedright}p{\dimexpr 4cm+3\tabcolsep}@{}|}{\textit{{\small %s}}} &', $WORD_DATA['r3c1']) . "\n";
$code .= sprintf('\multicolumn{2}{>{\raggedright}p{\dimexpr\textwidth-9cm-\arrayrulewidth-7\tabcolsep}@{}}{\textit{{\small %s}}%s}', $WORD_DATA['r3c3'], $WORD_DATA['rigveda']) . "\n";
$code .= '\end{longtable}' . "\n";

$code .= sprintf('\setlength{\parindent}{0cm} %s\\\\', $WORD_DATA['r4c1']) . "\n";

$a = [];
foreach (['cognates_r', 'source_r', 'rating'] as $k) {
    if ($WORD_DATA[$k]) {
        $a[] = $WORD_DATA[$k];
    }
}
$code .= implode(' ', $a) . '\\\\[-3pt]' . "\n";

return $code;
