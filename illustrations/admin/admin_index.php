<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

// ▼ ログインしていなければログインページへリダイレクト
redirect_login_index($user);


/**
 * ▼ DB処理
 * ▼ user_idをキーにセレクトする 降順
 */
$model = new IllustrationsModel($dsn, $db_user, $db_password);
$rec = $model->findByUserId($user['id']);
$count = count($rec); // 取得件数

// ▼ 画像ファイルのパスを配列で返す
$images = images($rec, $count);


// ▼ ページタイトルは必ず定義
$page_title = $user['name'] . 'さんのイラスト一覧'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/illustrations/admin/view/admin_index_view.php'));