<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root() . '/class/IllustrationsModel.php');


try {
	// ▼ URLパラメータをチェック　イラストIDを取得
	if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
		throw new GetParamErrorException('');
	}
	$id = (int)$_GET['id'];
	
	$model = new IllustrationsModel($dsn, $db_user, $db_password);
	$model->Delete($id, $user_id);
} catch (GetParamErrorException $e) {
	header('Location: ../index.php');
	exit;
}

header('Location: ../index.php');
exit;