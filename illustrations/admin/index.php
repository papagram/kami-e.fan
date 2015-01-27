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
 * ▼ DB処理
 * ▼ user_idをキーにセレクトする 降順
 */
$dbh = db_connect($dsn, $db_user, $db_password);
$sql = 'SELECT * FROM illustrations WHERE user_id = :user_id ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($rec); // 取得件数


require ('./view/index.php');