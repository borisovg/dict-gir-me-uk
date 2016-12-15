<?php

namespace handlers;

class XeTeX extends Base {
    private $classes;
    private $genders;
    private $handler;
    private $types;
    private $word;

    function post () {
        parent::check_auth(true);

        if (!isset ($_POST['lang']) || !in_array($_POST['lang'], ['eng', 'rus'])) {
            parent::http_error(400, 'Bad Request');
        }

        if (!isset ($_POST['ids']) || preg_match('/[^\d,]/', $_POST['ids'])) {
            parent::http_error(400, 'Bad Request');
        }

        if (!isset ($_POST['file']) || preg_match('/[^\w\.]/', $_POST['file'])) {
            parent::http_error(400, 'Bad Request');
        }

        $m = new \Model();

        $this->classes = $m->get_classes();
        $this->genders = $m->get_genders();
        $this->types = $m->get_types();

        $this->handler = new Word();

        $fn = ($_POST['lang'] === 'eng') ? 'xetex_english' : 'xetex_russian';

        $code = '';
        foreach (explode(',', $_POST['ids']) as $id) {
            if (!$w = $m->get_word($id)) {
                parent::http_error(404, 'Not Found', "ID: $id");
            }

            foreach(array ('comments_eng', 'comments_rus', 'other_lang', 'cognates', 'cognates_r') as $k) {
                if ($w[$k]) {
                    // convert to italic
                    $w[$k] = preg_replace('/#(.+?)#/', '\\textit{\1}', $w[$k]);
                    // cyrillic font
                    $w[$k] = preg_replace('/\/(\S+)\//', '{\\cyr{\1}}', $w[$k]);
                }
            }

            foreach ($w as $k => $v) {
                if ($w[$k]) {
                    // escape any remaining special chars
                    $w[$k] = preg_replace('/([#&])/', "\\\\$1", $w[$k]);
                }
            }

            $code .= $this->$fn($w, $_POST['lang']) . "\n";
        }

        header('Content-type: text/plain, charset=utf8');
        header("Content-Disposition: attachment; filename=\"{$_POST['file']}\"");
        echo $code;
    }

    private function xetex_english ($w) {
        $WORD_DATA = $this->handler->english_data($w, $this->classes, $this->genders, $this->types);

        $WORD_DATA['class_r'] = ($WORD_DATA['class_r']) ? "{\small {$WORD_DATA['class_r']}}" : '';
        $WORD_DATA['rating'] = ($WORD_DATA['rating']) ? " \mbox{{$WORD_DATA['rating']}}" : '';
        $WORD_DATA['rigveda'] = ($WORD_DATA['rigveda']) ? "{\small {$WORD_DATA['rigveda']}}" : '';

        $WORD_DATA['russian'] = $w['russian'];
        $WORD_DATA['translit_r'] = $w['translit_r'];
        $WORD_DATA['translit_s'] = $w['translit_s'];

        return require (ROOT_PATH . '/templates/word_xetex_english.php');
    }

    private function xetex_russian ($w) {
        $WORD_DATA = $this->handler->russian_data($w, $this->genders, $this->types);

        $WORD_DATA['rating'] = ($WORD_DATA['rating']) ? "\\mbox{{$WORD_DATA['rating']}}" : '';
        $WORD_DATA['rigveda'] = ($WORD_DATA['rigveda']) ? "{\\small {$WORD_DATA['rigveda']}}" : '';

        foreach (['type_r', 'type_s'] as $k) {
            $WORD_DATA[$k] = ($WORD_DATA[$k]) ? "{\\small \\textit{{$WORD_DATA[$k]}}}" : '';
        }

        $WORD_DATA['russian'] = $w['russian'];

        if ($w['type_r'] == 2) {
            $WORD_DATA['index1'] = $w['russian_form'];
            $WORD_DATA['index2'] = $w['sanskrit_form'];

        } else {
            $WORD_DATA['index1'] = $w['russian'];
            $WORD_DATA['index2'] = $w['translit_s'];
        }

        return require (ROOT_PATH . '/templates/word_xetex_russian.php');
    }
}
