<?php

/**
 * ▼ 外部ファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = 'NOT FOUND！'; 


/**
 * ▼ viewファイル呼び出し
 */
require ('./view/not_found.php');