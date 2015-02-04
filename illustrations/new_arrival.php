<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = '新着イラスト'; 

/**
 * ▼ ページング処理
 */
try {
	$per_page = 5; // 1ページ当たりの表示件数
	$first_page = (int)1;
	
	/**
	 * ▼ DB処理
	 */
	$dbh = db_connect($dsn, $db_user, $db_password);

	// ▼ 全ての件数を取得
	$sql = 'SELECT COUNT(id) AS count FROM illustrations';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$count_all = $stmt->fetch(PDO::FETCH_ASSOC);
	$last_page = ($count_all['count'] % $per_page === (int)0) ? $count_all['count'] / $per_page : floor($count_all['count'] / $per_page + 1);

	// ▼ URLパラメータをチェック 現在ページを特定 パラメータ無しは1ページ目とする
	if (isset($_GET['page'])) {
		if (ctype_digit($_GET['page']) && $_GET['page'] <= $last_page && $_GET['page'] > (int)0) {
			$current_page = (int)$_GET['page'];
		} else {
			throw new GetParamErrorException('');
		}
	} else {
		$current_page = 1;
	}
	
	$offset = ($current_page - 1) * $per_page; // select時にoffsetする数

	// ▼ 新着イラストを$per_pageの数だけ取得 降順
	$sql = 'SELECT * FROM illustrations ORDER BY id DESC 
				LIMIT :per_page OFFSET :offset';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
	$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();
	$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$count = count($rec); // 取得件数
	$images = images($rec, $user_id, $count); // 画像ファイルのパスを配列で返す
	
	$prev = ($current_page !== $first_page) ? $current_page - 1 : $first_page;
	$next = ($current_page !== $last_page) ? $current_page + 1 : $last_page;
	$active = 'active';
} catch (GetParamErrorException $e) {
	header('Location: ' . $_SERVER['SCRIPT_NAME']);
	exit;
}


/**
 * ▼ viewファイル呼び出し
 */
require ('./view/new_arrival.php');