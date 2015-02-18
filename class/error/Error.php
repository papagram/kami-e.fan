<?php

class Error
{
	public function execute()
	{
		// ▼ セッションからユーザー情報を取得
		$user = set_user();
		
		// ▼ セッションからエラーメッセージを取得
		$err_msg = $_SESSION['error'];
		unset($_SESSION['error']);
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ ページタイトルは必ず定義
		$page_title = '404ERROR';
		
		// ▼ viewファイル呼び出し
		require (doc_root('/view/error/error_view.php'));
	}
}