<?php

class LoginIndex
{
	public function execute()
	{
		// ▼ 変数初期化
		$input_email = (isset($_SESSION['login']['input_email'])) ? $_SESSION['login']['input_email'] : '';
		$err_msg = (isset($_SESSION['login']['err_msg'])) ? $_SESSION['login']['err_msg'] : array();
		unset($_SESSION['login']);

		// ▼ セッションからユーザー情報を代入
		$user = set_user();
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ CSRF対策　tokenをセット
		$token = set_token();

		// ▼ ページタイトルは必ず定義
		$page_title = 'ログイン'; 
		
		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/auth/login_index_view.php'));
	}
}