<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));


$model = new IllustrationsModel($dsn, $db_user, $db_password);
$rec = $model->findLimit(); // 新着イラスト一を$limitの数だけselect 降順
$count = count($rec); // 取得件数

$images = images($rec, $count); // 画像ファイルのパスを返す


// ▼ ページタイトルは必ず定義
$page_title = BRAND_NAME . 'へようこそ！'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/view/index_view.php'));