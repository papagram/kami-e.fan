<?php

// ▼ セッションを開始
session_start();
session_regenerate_id(true);

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む
require_once(doc_root('/config/constants.php'));

// ▼ classファイルを読み込む
require_once(doc_root('/class/Controller.php'));
require_once(doc_root('/class/auth/SignupIndex.php'));

// ▼ コントローラー呼び出し
$controller = new Controller();
$controller->execute(new SignupIndex());