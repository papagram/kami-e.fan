<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');


try {
	// ▼ URLパラメータをチェック
	if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
		throw new GetParamErrorException('');
	}
	$id = (int)$_GET['id'];
	
	/**
	 * ▼ DB処理
	 * ▼ illust_idをキーにセレクトする
	 */
	$dbh = db_connect($dsn, $db_user, $db_password);
	$sql = 'SELECT * FROM illustrations WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if (! $rec) {
		throw new NotFoundException('');
	}
	
	/**
	 * ▼ 画像データを取得 バイナリデータをbase64で返し、幅、高さを取得
	 * ▼ 第3引数にモード指定で表示サイズ変更 引数無しの場合オリジナルサイズ
	 */
	$image = image_original($rec, $user_id, 'middle');
	
	
	/**
	 * ▼ ページタイトルは必ず定義
	 */
	$page_title = h($rec['title']) . ' | ' . h($user_name) . 'さんのイラスト';
	
	/**
	 * ▼ viewファイル呼び出し
	 */
	require ('./view/show_illustration.php');
} catch (GetParamErrorException $e) {
	header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/not_found.php');
	exit;
} catch (NotFoundException $e) {
	header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/not_found.php');
	exit;
}