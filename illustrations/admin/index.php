<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));


/**
 * ▼ DB処理
 * ▼ user_idをキーにセレクトする 降順
 */
$model = new IllustrationsModel($dsn, $db_user, $db_password);
$rec = $model->findByUserId($user_id);
$count = count($rec); // 取得件数

// ▼ 画像ファイルのパスを配列で返す
$images = images($rec, $user_id, $count);


// ▼ ページタイトルは必ず定義
$page_title = $user_name . 'さんのページ'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/illustrations/admin/view/index.php'));