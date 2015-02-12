<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ ログインしていなければログインページへリダイレクト
redirect_login_index($user);


// ▼ ページタイトルは必ず定義
$page_title = 'プロフィール編集'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/users/setting/view/profile_index_view.php'));