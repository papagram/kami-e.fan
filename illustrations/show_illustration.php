<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));


try {
	// ▼ URLパラメータをチェック
	if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
		throw new GetParamErrorException('');
	}
	$id = (int)$_GET['id'];

	/**
	 * ▼ DB処理 IDをキーにイラストを絞り込む
	 */
	$model = new IllustrationsModel($dsn, $db_user, $db_password);
	$rec = $model->findById($id);
	
	/**
	 * ▼ 画像データを取得 パス、幅、高さを取得
	 * ▼ 第3引数にモード指定で表示サイズ変更 引数無しの場合オリジナルサイズ
	 */
	$image = image_original($rec, $user_id, 'middle');
	
	
	// ▼ ページタイトルは必ず定義
	$page_title = h($rec['title']) . ' | ' . h($user_name) . 'さんのイラスト';
	
	// ▼ viewファイル呼び出し
	require (doc_root('/illustrations/view/show_illustration.php'));
} catch (GetParamErrorException $e) {
	redirect('/not_found.php');
} catch (NotFoundException $e) {
	redirect('/not_found.php');
}