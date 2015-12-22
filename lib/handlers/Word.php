<?php

namespace handlers;

use \Model;

class Word extends Base {
    private $classes;
    private $genders;
    private $types;
    private $word;

    function get ($id) {
        parent::check_auth();

        if (!is_numeric($id)) {
            parent::http_error(400, 'Bad Request');
        }

        $m = new Model();

        if (!$this->word = $m->get_word($id)) {
            parent::http_error(404, 'Not Found');
        }

        $this->classes = $m->get_classes();
        $this->genders = $m->get_genders();
        $this->types = $m->get_types();

        foreach(array ('comments_eng', 'comments_rus', 'other_lang', 'cognates', 'cognates_r') as $k) {
            if (isset ($this->word[$k])) {
                // convert to italic
                $this->word[$k] = preg_replace('/#(.+?)#/', '<i>\1</i>', $this->word[$k]);
                // cyrillic font
                $this->word[$k] = preg_replace('/\/(\S+)\//', '<span class="cyrillic">\1</span>', $this->word[$k]);
            }
        }

        echo require (ROOT_PATH . '/templates/word.php');
    }

    static function english_data ($w, $c, $g, $t) {
        $data['r1c1'] = $w['translit_r'];
        $data['r1c2'] = $w['russian'];
        $data['r1c4'] = $w['translit_s'];
        $data['r1c5'] = $w['devanagari'];

        if ($w['type_r'] == 2) {
            $data['r1c3'] = $w['transcr_r_root'];

            $data['r2c1'] = $w['translit_r_root'];
            $data['r2c2'] = $w['russian_root'];
            $data['r2c3'] = $w['transcr_r_form'];
            $data['r2c4'] = $w['sanskrit_form'];
            $data['r2c5'] = $w['devanagari_form'];

            $data['r3c1'] = $w['translit_r_form'];
            $data['r3c2'] = $w['russian_form'];

            foreach (['type_r', 'type_s'] as $k) {
                if ($w[$k]) {
                    $data[$k] = $t[$w[$k]]['abbreviation'];
                }
            }

        } else {
            $data['r1c3'] = $w['transcr_r'];

            foreach (['r', 's'] as $k) {
                if ($w["type_$k"] == 1) {
                    $data["type_$k"] = ($w["gender_$k"]) ? $g[$w["gender_$k"]]['abbreviation'] : '';

                } else {
                    $data["type_$k"] = ($w["type_$k"]) ? $t[$w["type_$k"]]['abbreviation'] : '';
                }
            }
        }

        $data['r4c1'] = $w['translation_r'];
        $data['r4c4'] = $w['translation_s'];

        if ($w['other_lang']) {
            $data['r5c1'] = $w['other_lang'];
        }

        $data['r6c1'] = $w['comments_eng'];

        $data['cognates'] = ($w['cognates']) ? 'I-E cognates: ' . $w['cognates'] : '';
        $data['class_r'] = ($w['classification_r']) ? "({$c[$w['classification_r']]['abbreviation']})" : '';
        $data['rating'] = ($w['score']) ? 'Rating: ' . $w['score'] . '.' : '';
        $data['rigveda'] = ($w['rigveda']) ? ' (RV)' : '';
        $data['source'] = $w['source'];

        return $data;
    }

    static function russian_data ($w, $g, $t) {
        if ($w['type_r'] == 2) {
            $data['r1c1'] = $w['russian_form'];
            $data['r1c2'] = $w['translit_r_form'];
            $data['r1c3'] = $w['sanskrit_form'];
            $data['r1c4'] = $w['translit_form_s2r'];
            $data['r1c5'] = $w['devanagari_form'];

            $data['r2c1'] = $w['russian_root'];
            $data['r2c2'] = $w['translit_r_root'];
            $data['r2c3'] = $w['translit_s'];
            $data['r2c4'] = $w['translit_s2r'];
            $data['r2c5'] = $w['devanagari'];

            if ($w['type_r']) {
                $data['type_r'] = $t[$w['type_r']]['abbreviation_r'];
            }

            if ($w['type_s']) {
                $data['type_s'] = $t[$w['type_s']]['abbreviation'];
            }

        } else {
            $data['r1c1'] = $w['russian'];
            $data['r1c2'] = $w['translit_r'];
            $data['r1c3'] = $w['translit_s'];

            $data['r1c4'] = $w['translit_s2r'];
            $data['r1c5'] = $w['devanagari'];

            if ($w["type_r"] == 1) {
                $data["type_r"] = ($w["gender_r"]) ? $g[$w["gender_r"]]['abbreviation_r'] : '';

            } else {
                $data["type_r"] = ($w["type_r"]) ? $t[$w["type_r"]]['abbreviation_r'] : '';
            }

            if ($w["type_s"] == 1) {
                $data["type_s"] = ($w["gender_s"]) ? $g[$w["gender_s"]]['abbreviation'] : '';

            } else {
                $data["type_s"] = ($w["type_s"]) ? $t[$w["type_s"]]['abbreviation'] : '';
            }
        }

        $data['r3c1'] = $w['notes_r'];
        $data['r3c3'] = $w['translation_s_rus'];

        $data['r4c1'] = $w['comments_rus'];

        $data['cognates_r'] = ($w['cognates_r']) ? 'Родств. слова: ' . $w['cognates_r'] : '';
        $data['rating'] = ($w['score']) ? 'Рейт. ' . $w['score'] . '.' : '';
        $data['rigveda'] = ($w['rigveda']) ? ' (вед.)' : '';
        $data['source_r'] = $w['source_r'];

        return $data;
    }

    private function english_html () {
        $WORD_DATA = $this->english_data($this->word, $this->classes, $this->genders, $this->types);
        return require (ROOT_PATH . '/templates/word_html_english.php');
    }

    private function russian_html () {
        $WORD_DATA = $this->russian_data($this->word, $this->genders, $this->types);
        return require (ROOT_PATH . '/templates/word_html_russian.php');
    }
}
