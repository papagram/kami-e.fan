<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');


// イラストIDをURLパラメータから取得
if (! ctype_digit($_GET['id'])) {
	header('Location: ./index.php');
	exit;
}
$id= h($_GET['id']);


/**
 * ▼ DB処理
 */
$dbh = db_connect($dsn, $db_user, $db_password);

try {
	$dbh->beginTransaction();

	$sql = 'DELETE FROM illustrations WHERE id = :id AND user_id = :user_id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
	$stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT); // セッションからとりたい
	$stmt->execute();
	$count = $stmt->rowCount();
	if (! $count) {
		throw new Exception('');
	}
		
	$dbh->commit();
} catch (Exception $e) {
	$dbh->rollBack();
	echo '失敗';
	exit;
}

header('Location: ../index.php');
exit;