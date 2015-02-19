<?php

class SignupSuccess
{
	public function execute()
	{
		if (! isset($_SESSION['signup_success'])) {
			redirect('/auth/login_index.php');
		}
		
		$user = $_SESSION['signup_success'];
		unset($_SESSION['signup_success']);
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ ページタイトルは必ず定義
		$page_title = 'ようこそ！' . BRAND_NAME . 'へ'; 

		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/auth/signup_success_view.php'));
	}
}