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
$page_title = BRAND_NAME . 'へようこそ！'; 


/**
 * ▼ DB処理
 * ▼ 新着イラスト一覧表示　全てselect 降順
 */
$dbh = db_connect($dsn, $db_user, $db_password);
$sql = 'SELECT * FROM illustrations ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($rec); // 取得件数
$images = image($rec, $user_id, $count); // 画像ファイルのバイナリをbase64で返す


/**
 * ▼ viewファイル呼び出し
 */
require ('./view/index.php');