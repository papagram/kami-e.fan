<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ ログインしていなければログインページへリダイレクト
redirect_login_index($user);


// ▼ 変数初期化
$err_msg = (isset($_SESSION['upload_new_illust']['err_msg'])) ? $_SESSION['upload_new_illust']['err_msg'] : array();
unset($_SESSION['upload_new_illust']);
$max_file_size = 1024 * 1024 * 2; // MAX_FILE_SIZE 2MB

// ▼ tokenをセット
$token = set_token();

// ▼ ページタイトルは必ず定義
$page_title = 'アップロード'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/illustrations/admin/view/upload_new_illustration_view.php'));