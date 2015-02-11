<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

// ▼ ログインしていなければログインページへリダイレクト
redirect_login_index($user);


try {
	// ▼ URLパラメータをチェック　イラストIDを取得
	if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
		throw new GetParamErrorException('');
	}
	$id = (int)$_GET['id'];
	
	$model = new IllustrationsModel($dsn, $db_user, $db_password);
	
	// ▼ 削除対象のイラスト情報を取得
	$rec = $model->findById($id);
	
	// ▼ レコードを削除
	$model->Delete($id, $user['id']);
	
	// ▼ 画像ファイルを削除 2ヶ所
	$filename = doc_root("/images/{$user['id']}/illustrations/original/{$rec['filename']}"); // オリジナル画像 これは絶対ある
	$filename_thumb = ''; // 初期化
	
	if ($rec['filename_thumb']) {
		$filename_thumb = doc_root("/images/{$user['id']}/illustrations/thumb/{$rec['filename_thumb']}"); // サムネ画像 これはないかもしれないのでファイル名で判定する
	}
	
	if (file_exists($filename)) {
		unlink($filename); // オリジナル画像ファイル削除
		
		if ($filename_thumb && file_exists($filename_thumb)) { // $filename_thumbに値が代入済み かつ ファイルの存在を確認
			unlink($filename_thumb); // サムネ画像ファイル削除
		}
	}
	
	redirect('/illustrations/admin/admin_index.php');
} catch (GetParamErrorException $e) {
	redirect('/illustrations/admin/admin_index.php');
}