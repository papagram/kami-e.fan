<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む


// ▼ ページタイトルは必ず定義
$page_title = 'NOT FOUND！'; 

// ▼ viewファイル呼び出し
require_once (doc_root('/view/not_found.php'));