<?php

class UploadIndex
{
	public function execute()
	{
		// ▼ 変数初期化
		$err_msg = (isset($_SESSION['upload_action']['err_msg'])) ? $_SESSION['upload_action']['err_msg'] : array();
		unset($_SESSION['upload_action']);
		$max_file_size = 1024 * 1024 * 2; // MAX_FILE_SIZE 2MB

		// ▼ セッションからユーザー情報を取得
		$user = set_user();
		
		// ▼ ログインしていなければログインページへリダイレクト
		is_authenticated($user);

		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ CSRF対策　tokenをセット
		$token = set_token();

		// ▼ ページタイトルは必ず定義
		$page_title = 'アップロード'; 

		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/illustrations/admin/upload_index_view.php'));
	}
}