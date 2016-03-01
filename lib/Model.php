<?php

class Model {
	protected $db;

    function __construct () {
		$this->db = new DB();
    }

	function init_db () {
        $dir = Config::get('data_dir');

		if (!file_exists($dir)) {
			mkdir($dir);
			chmod($dir, 02770);
		}

		$sql = file_get_contents(ROOT_PATH . '/schema.sql');
		$this->db->exec($sql);

		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));

		foreach($iterator as $f) {
			if (preg_match('/\.sqlite$/', $f)) {
				chmod($f, 0660);
			}
		}
	}

    function dump () {
        $sql = "SELECT * FROM data";
        return $this->try_request('get', $sql);
    }

    function get_word ($id) {
        $sql = "SELECT * FROM data WHERE id='$id'";

        if (!$w = $this->try_request('getRow', $sql)) {
            return false;
        }

        foreach ($w as $k => $v) {
            if ($w[$k]) {
                // trim whitespace
                $v = trim($v);

                // remove double spaces
                $v = preg_replace('/\s\s+/', ' ', $v);

                $w[$k] = $v;
            }
        }

        // fix missing dash verb root
        foreach(array ('transcr_r_root', 'translit_r_root', 'russian_root') as $k) {
            if ($w[$k] && substr($w[$k], -1, 1) !== '-') {
                $w[$k] .= '-';
            }
        }

        // fix missing period
        foreach(array ('comments_eng', 'comments_rus', 'other_lang', 'cognates', 'cognates_r', 'source', 'source_r') as $k) {
            if ($w[$k] && substr($w[$k], -1, 1) !== '.') {
                $w[$k] .= '.';
            }
        }

        return $w;
    }

    function get_classes () {
        $sql = "SELECT * FROM tags_classification";
        return $this->db->getIndexed($sql, 'id');
    }

    function get_genders () {
        $sql = "SELECT * FROM tags_genders";
        return $this->db->getIndexed($sql, 'id');
    }

    function get_types () {
        $sql = "SELECT * FROM tags_types";
        return $this->db->getIndexed($sql, 'id');
    }

    function list_words ($opts) {
        $a_sql_filter = [];

        if (isset ($opts['letter'])) {
            if ($opts['letter'] === 'NULL') {
                $a_sql_filter[] = 'russian IS NULL';

            } elseif ($opts['letter']) {
                $a_sql_filter[] = "(russian LIKE '{$opts['letter']}%' OR russian LIKE '" . mb_strtolower($opts['letter'], 'utf8') . "%')";
            }
        }

        if (isset ($opts['printOK']) && $opts['printOK']) {
            $a_sql_filter[] = 'ready_for_print IS NOT NULL';
        }

        if (isset ($opts['printRusOK']) && $opts['printRusOK']) {
            $a_sql_filter[] = 'ready_for_print_r IS NOT NULL';
        }

        if (isset ($opts['printNotOK']) && $opts['printNotOK']) {
            $a_sql_filter[] = 'ready_for_print IS NULL';
        }

        if (isset ($opts['printRusNotOK']) && $opts['printRusNotOK']) {
            $a_sql_filter[] = 'ready_for_print_r IS NULL';
        }

        if (isset ($opts['scores']) && !empty ($opts['scores'])) {
            $a_sql_score = [];

            foreach ($opts['scores'] as $i) {
                if (!$i) {
                    $a_sql_score[] = 'score IS NULL';

                }

                $a_sql_score[] = "score='$i'";
            }

            $a_sql_filter[] = '(' . implode(' OR ', $a_sql_score) . ')';
        }

        if (empty ($a_sql_filter)) {
            $sql = 'SELECT id, russian FROM data';

        } else {
            $filter = implode(' AND ', $a_sql_filter);
            $sql = "SELECT id, russian FROM data WHERE {$filter} ORDER BY russian";
        }

        //print_r($opts);
        //echo $sql;
        //exit;

        return $this->try_request('get', $sql);
    }

    function list_letters () {
        $sql = 'SELECT DISTINCT SUBSTR(russian, 1, 1) AS russian FROM data';

        $r = $this->try_request('getColumn', $sql);

        return $r;
    }

    function update_word($id, $col, $val) {
        if (!$this->check_column($col, 'data')) {
            return ['error' => ['code' => 400, 'message' => 'Bad Key', 'data' => ['key' => $col]]];
        }

        $sql = "SELECT * FROM data WHERE id='$id'";

        if (!$w = $this->db->getRow($sql)) {
            return ['error' => ['code' => '404', 'message' => 'Not Found']];
        }

        $log = new Logger();

        ob_start();

        try {
            $this->db->update('data', [$col => $val], ['id' => $id]);
            $r = ['result' => 'ok'];

        } catch (Exception $e) {
            $r = ['error' => ['code' => 500, 'message' => $e]];
        }

        if ($output = ob_get_contents()) {
            $r['output'] = $output;
        }

        ob_end_clean();

        $log->info(['action' => 'edit', 'word_id' => $id, 'column' => $col, 'value_before' => $w[$col], 'value_after' => $val]);

        return $r;
    }

    private function check_column ($col, $table) {
        $sql = "PRAGMA table_info ($table)";
        $list = array_keys($this->db->getIndexed($sql, 'name'));

        return in_array($col, $list);
    }

    private function try_request ($method, $sql) {
        ob_start();

        try {
            $r = $this->db->$method($sql);

        } catch (Exception $e) {
            $r = ['error' => ['code' => 500, 'message' => $e, 'data' => ['sql' => $sql]]];

            if ($output = ob_get_contents()) {
                $r['error']['output'] = $output;
            }
        }

        ob_end_clean();

        return $r;
    }
}
