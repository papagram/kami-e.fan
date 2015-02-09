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

	// ▼ DB処理 IDをキーにイラストを絞り込む
	$model = new IllustrationsModel($dsn, $db_user, $db_password);
	$rec = $model->findById($id);
	
	/**
	 * ▼ 画像データを取得 パス、幅、高さを取得
	 * ▼ 第3引数にモード指定で表示サイズ変更 引数無しの場合オリジナルサイズ
	 */
	$image = image_thumb($rec, $user_id);
	
	
	// ▼ 変数初期化
	$input_title = (isset($_SESSION['update_illust']['input_title'])) ? $_SESSION['update_illust']['input_title'] : $rec['title'];
	$input_price = (isset($_SESSION['update_illust']['input_price'])) ? $_SESSION['update_illust']['input_price'] : $rec['price'];
	$err_msg = (isset($_SESSION['update_illust']['err_msg'])) ? $_SESSION['update_illust']['err_msg'] : array();
	unset($_SESSION['update_illust']);
	
	// ▼ tokenをセット
	$token = set_token();
	
	// ▼ ページタイトルは必ず定義
	$page_title = '編集'; 
	
	// ▼ viewファイル呼び出し
	require_once (doc_root('/illustrations/admin/view/update_illustration.php'));
} catch (GetParamErrorException $e) {
	redirect('/not_found.php');
} catch (NotFoundException $e) {
	redirect('/not_found.php');
}