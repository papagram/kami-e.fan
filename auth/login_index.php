<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ 変数初期化
$input_email = (isset($_SESSION['login']['input_email'])) ? $_SESSION['login']['input_email'] : '';
$err_msg = (isset($_SESSION['login']['err_msg'])) ? $_SESSION['login']['err_msg'] : array();
unset($_SESSION['login']);

// ▼ tokenをセット
$token = set_token();

// ▼ ページタイトルは必ず定義
$page_title = 'ログイン'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/auth/view/login_index_view.php'));