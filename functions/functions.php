<?php

/**
 * ▼ var_dump関数の結果を整形
 */
	function d($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		exit;
	}

/**
 * ▼ XSS対策
 */
function h($val){
	return htmlspecialchars($val,ENT_QUOTES,'UTF-8');
}