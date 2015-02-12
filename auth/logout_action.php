<?php

// ▼ 共通設定ファイルを読み込む
// ▼ ここでセッションを開始している
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ セッションを破棄
$_SESSION = array();

if (isset($_COOKIE[session_name()]))
{
	setcookie(session_name(),'',time()-3600,'/');
}

session_destroy();

redirect();