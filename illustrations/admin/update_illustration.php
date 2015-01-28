<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = '編集'; 

// イラストIDをURLパラメータから取得
if (! ctype_digit($_GET['id'])) {
	header('Location: ./index.php');
	exit;
}
$id= h($_GET['id']);

/**
 * ▼ DB処理
 * ▼ idをキーにセレクトする
 */
$dbh = db_connect($dsn, $db_user, $db_password);
$sql = 'SELECT * FROM illustrations WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

// 変数初期化
$input_title = (isset($_SESSION['update_illust']['input_title'])) ? $_SESSION['update_illust']['input_title'] : $rec['title'];
$input_price = (isset($_SESSION['update_illust']['input_price'])) ? $_SESSION['update_illust']['input_price'] : $rec['price'];
$err_msg = (isset($_SESSION['update_illust']['err_msg'])) ? $_SESSION['update_illust']['err_msg'] : array();

// tokenをセット
$token = set_token();


require ('./view/update_illustration.php');