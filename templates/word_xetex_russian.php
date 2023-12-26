<?php

$code = <<<XELATEX
% {$WORD_DATA['russian']}
\\begin{longtable}{
    >{\\raggedright}p{37mm}@{\\hspace{2mm}}
    >{\\raggedright}p{24mm}@{\\hspace{2mm}}|
    p{2mm}
    >{\\raggedright}p{30mm}@{\\hspace{2mm}}
    >{\\raggedleft}p{31mm}
}
{\\textbf{\\large {$WORD_DATA['r1c1']}\index{{$WORD_DATA['index1']} -- {$WORD_DATA['index2']}}}} {$WORD_DATA['type_r']} &
{\\textit{\\large {$WORD_DATA['r1c2']}}} &&
{\\textit{\\large {$WORD_DATA['r1c3']}} {$WORD_DATA['type_s']}} &
{\\LARGE {$WORD_DATA['r1c4']}}
\\tabularnewline

XELATEX;

if (isset ($WORD_DATA['r2c1'])) {
    $code .= <<<XELATEX
{\\large {$WORD_DATA['r2c1']}} &
{\\textit{\\large {$WORD_DATA['r2c2']}}} &&
{\\textit{\\large {$WORD_DATA['r2c3']}}} &
{\\LARGE {$WORD_DATA['r2c4']}}
\\tabularnewline

XELATEX;
}

$code .= <<<XELATEX
\\multicolumn{2}{
    >{\\RaggedRight}p{63mm}@{\\hspace{2mm}}|
}
{\\textnormal{{$WORD_DATA['r3c1']}}} &
\multicolumn{1}{ c }{} &
\multicolumn{2}{
    >{\\RaggedRight}p{63mm}
}
{\\textnormal{{$WORD_DATA['r3c3']}}}
\\tabularnewline
\\end{longtable}

\\setlength{\\parindent}{0cm} {$WORD_DATA['r4c1']}\\par\\smallskip

XELATEX;

$a = [];

if ($WORD_DATA['cognates_r']) {
    $a[] = $WORD_DATA['cognates_r'] . '\\par\\smallskip';
}

if ($WORD_DATA['source_r']) {
    $a[] = preg_replace('/^(.+[^.])(\.)?$/', '{[${1}]}\\par', $WORD_DATA['source_r']);
}

if ($WORD_DATA['rating']) {
    $a[] = preg_replace('/([0-9]+)/', '\\textbf {${1}}', $WORD_DATA['rating']);
}

$code .= implode(' ', $a) . '\\\\[-3pt]' . "\n";

return $code;
