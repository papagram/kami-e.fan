<?php

/**
 * ▼ 外部ファイルを読み込む
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ classファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/class/IllustrationsModel.php');


$model = new IllustrationsModel($dsn, $db_user, $db_password);
$rec = $model->findLimit(); // 新着イラスト一を$limitの数だけselect 降順
$count = count($rec); // 取得件数

$images = images($rec, $user_id, $count); // 画像ファイルのパスを返す


/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = BRAND_NAME . 'へようこそ！'; 

/**
 * ▼ viewファイル呼び出し
 */
require ('./view/index.php');