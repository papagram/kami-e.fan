<?php

/**
 * ▼ var_dump関数の結果を整形
 */
	function d($var) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		exit;
	}

/**
 * ▼ XSS対策
 */
	function h($val) {
		return htmlspecialchars($val,ENT_QUOTES,'UTF-8');
	}

	function h_array($array) {
		return array_map('h', $array);
	}

/**
 * ▼ DBに接続
 */
 	function db_connect($dsn, $db_user, $db_password) {
		try{
			$dbh = new PDO($dsn, $db_user, $db_password);
			$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $dbh;
		}catch(PDOException $e){
			echo 'ただいま障害により大変ご迷惑をお掛け致しております。';
			exit;
		}
 	}
 
 /**
 * ▼ CSRF対策
 */
 	function set_token() {
		$token = sha1(uniqid(mt_rand(),true));
		$_SESSION['tokens'][] = $token;
		
		return h($token);
 	}

 	function check_token($token) {
		$key = array_search($token, $_SESSION['tokens'], true);
		if ($key === false)
		{
			throw new CsrfErrorException('');
		}
		else
		{
			array_splice($_SESSION['tokens'], $key, 1);
		}
 	}