<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = 'アップロード'; 

/**
 * ▼ 初期化
 */
$err_msg = (isset($_SESSION['upload_new_illust']['err_msg'])) ? $_SESSION['upload_new_illust']['err_msg'] : array();
$max_file_size = 1024 * 1024 * 2; // MAX_FILE_SIZE 2MB

/**
 * ▼ tokenをセット
 */
$token = set_token();


require ('./view/upload_new_illustration.php');