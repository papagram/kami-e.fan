<?php

// ▼ セッションを開始
session_start();
session_regenerate_id(true);

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む
require_once(doc_root('/config/constants.php'));

// ▼ classファイルを読み込む
require_once(doc_root('/class/Controller.php'));
require_once(doc_root('/class/auth/SignupAction.php'));

// ▼ PHPのバージョンが5.3か5.4の時はpassword_compatを読み込む
$ver = phpversion();
if (mb_strpos($ver, '5.3') === 0 || mb_strpos($ver, '5.4') === 0) {
	require_once(doc_root('/vendor/autoload.php'));
}

// ▼ コントローラー呼び出し
$controller = new Controller();
$controller->execute(new SignupAction($dsn, $db_user, $db_password));