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
* ▼ ルートURLに引数のパスをつけて返す 　引数無しはトップページにする
*/
function root_url($path = '/index.php') {
	return 'http://' . $_SERVER['HTTP_HOST'] . $path;
}

/**
* ▼ ドキュメントルートに引数のパスをつけて返す 　引数無しはトップページにする
*/
function doc_root($path = '/index.php') {
	return $_SERVER['DOCUMENT_ROOT'] . $path;
}

/**
* ▼ リダイレクト　引数にルートURL以下を渡す　引数無しはトップページにする
*/
function redirect($path = '/index.php') {
	header ('Location: ' . h(root_url($path)));
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
* ▼ CSRF対策
*/
function set_token() {
	$token = sha1(uniqid(mt_rand(),true));
	$_SESSION['tokens'][] = $token;
	
	return $token;
}

function check_token($token) {
	$key = array_search($token, $_SESSION['tokens'], true);
	if (! $key)
	{
		throw new CsrfErrorException('');
	}
	else
	{
		array_splice($_SESSION['tokens'], $key, 1);
	}
}

/**
* ▼ パスワードを生成
*/
function crypt_password($row_password) {
	return password_hash($row_password, PASSWORD_DEFAULT, array('cost'=>10));
}

/**
* ▼ サムネイル用のサイズを取得
*/
function get_new_thumb_size($w, $h, $max_w, $max_h) {
	$new_w = $w;
	$new_h = $h;
	
	// ▼ 原寸幅が最大幅より大きい　かつ　原寸高さよりも原寸幅が大きい
	if ($w > $max_w && $w > $h)
	{
		$new_w = $max_w;
		$new_h = round($h * $max_w / $w);
	}
	
	// ▼ 原寸高さが最大高さより大きい　かつ　原寸幅よりも原寸高さが大きい
	if ($h > $max_h && $h >= $w)
	{
		$new_h = $max_h;
		$new_w = round($w * $max_h / $h);
	}
	
	return array($new_w, $new_h);
}

/**
* ▼ 画像ファイルのURLを返す
*/
function image_original($resource, $user_id, $mode = 'row') {
	list($w, $h) = getimagesize(doc_root("/images/{$user_id}/illustrations/original/{$resource['filename']}"));
	$path = root_url("/images/{$user_id}/illustrations/original/{$resource['filename']}");
	if ($mode === 'row') {
		return array($path, $w, $h);
	} elseif ($mode === 'middle') {
		$max_w = 940;
		$max_h = 940;
		list($new_w, $new_h) = get_new_thumb_size($w, $h, $max_w, $max_h);
		
		return array($path, $new_w, $new_h);
	}
}

function image_thumb($resource, $user_id, $mode = 'row') {
	if (! $resource['filename_thumb']) {
		list($w, $h) = getimagesize(doc_root("/images/{$user_id}/illustrations/original/{$resource['filename']}"));
		$path = root_url("/images/{$user_id}/illustrations/original/{$resource['filename']}");
	} else {
		list($w, $h) = getimagesize(doc_root("/images/{$user_id}/illustrations/thumb/{$resource['filename_thumb']}"));
		$path = root_url("/images/{$user_id}/illustrations/thumb/{$resource['filename_thumb']}");
	}
	
	if ($mode === 'row') {
		return array($path, $w, $h);
	} elseif ($mode === 'xs') {
		$max_w = 80;
		$max_h = 80;
		list($new_w, $new_h) = get_new_thumb_size($w, $h, $max_w, $max_h);
		
		return array($path, $new_w, $new_h);
	}
}

function images($resource, $user_id, $count) {
	$paths = array();
	for ($i=0; $i<$count; $i++) {
		if (! $resource[$i]['filename_thumb']) {
			$paths[] = root_url("/images/{$user_id}/illustrations/original/{$resource[$i]['filename']}");
		} else {
			$paths[] = root_url("/images/{$user_id}/illustrations/thumb/{$resource[$i]['filename_thumb']}");
		}
	}
	
	return $paths;
}