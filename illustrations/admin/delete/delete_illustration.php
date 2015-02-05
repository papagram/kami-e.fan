<?php

/**
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ classファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/class/IllustrationsModel.php');


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