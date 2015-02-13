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
		throw new CsrfException('tokenが不正だよ！');
	}
	else
	{
		array_splice($_SESSION['tokens'], $key, 1);
	}
}

/**
* ▼ パスワードをハッシュ化
*/
function crypt_password($row_password) {
	return password_hash($row_password, PASSWORD_DEFAULT, array('cost'=>10));
}

/**
* ▼ セッションのユーザー情報を代入
*/
function set_user() {
	return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
}

/**
* ▼ $userがfalseならばログインページへリダイレクト
*/
function redirect_login_index($user) {
	if (! $user) {
		redirect('/auth/login_index.php');
	}
}

/**
* ▼ // ▼ 絞り込んだuser_idとセッションのuser_idが一致しなければエラー
*/
function match_user_id($user_id_db, $user_id_session) {
	if ($user_id_db !== $user_id_session) {
		redirect('/users/user_index.php');
	}
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
function image_original($resource, $mode = 'row') {
	$filename = "/images/{$resource['user_id']}/illustrations/original/{$resource['filename']}";
	if (! file_exists(doc_root($filename))) {
		$path = root_url('/images/common/no_image.gif');
		$w = 300;
		$h = 300;
		
		return array($path, $w, $h);
	}
	
	list($w, $h) = getimagesize(doc_root($filename));
	$path = root_url($filename);
	if ($mode === 'row') {
		return array($path, $w, $h);
	} elseif ($mode === 'middle') {
		$max_w = 940;
		$max_h = 940;
		list($new_w, $new_h) = get_new_thumb_size($w, $h, $max_w, $max_h);
		
		return array($path, $new_w, $new_h);
	}
}

function image_thumb($resource, $mode = 'row') {
	if (! $resource['filename_thumb']) {
		$filename = "/images/{$resource['user_id']}/illustrations/original/{$resource['filename']}";
		if (! file_exists(doc_root($filename))) {
			$path = root_url('/images/common/no_image.gif');
			$w = 160;
			$h = 160;
			
			return array($path, $w, $h);
		}
		
		list($w, $h) = getimagesize(doc_root($filename));
		$path = root_url($filename);
	} else {
		$filename = "/images/{$resource['user_id']}/illustrations/thumb/{$resource['filename_thumb']}";
		if (! file_exists(doc_root($filename))) {
			$path = root_url('/images/common/no_image.gif');
			$w = 160;
			$h = 160;
			
			return array($path, $w, $h);
		}
		
		list($w, $h) = getimagesize(doc_root($filename));
		$path = root_url($filename);
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

function images($resource, $count) {
	$paths = array();
	for ($i=0; $i<$count; $i++) {
		if (! $resource[$i]['filename_thumb']) {
			$filename = "/images/{$resource[$i]['user_id']}/illustrations/original/{$resource[$i]['filename']}";
			if (! file_exists(doc_root($filename))) {
				$paths[] = root_url('/images/common/no_image.gif');
			} else {
				$paths[] = root_url($filename);
			}
		} else {
			$filename = "/images/{$resource[$i]['user_id']}/illustrations/thumb/{$resource[$i]['filename_thumb']}";
			if (! file_exists(doc_root($filename))) {
				$paths[] = root_url('/images/common/no_image.gif');
			} else {
				$paths[] = root_url($filename);
			}
		}
	}
	
	return $paths;
}