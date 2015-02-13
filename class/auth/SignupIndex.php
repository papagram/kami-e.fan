<?php

class SignupIndex
{
	public function actionIndex()
	{
		// ▼ 変数初期化
		$input_name = (isset($_SESSION['signup']['input_name'])) ? $_SESSION['signup']['input_name'] : '';
		$input_email = (isset($_SESSION['signup']['input_email'])) ? $_SESSION['signup']['input_email'] : '';
		$err_msg = (isset($_SESSION['signup']['err_msg'])) ? $_SESSION['signup']['err_msg'] : array();
		unset($_SESSION['signup']);
		
		// ▼ ページタイトルは必ず定義
		$page_title = '新規登録';
		
		// ▼ セッションからユーザー情報を代入
		$user = set_user();
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ CSRF対策　tokenをセット
		$token = set_token();
		
		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/auth/signup_index_view.php'));
	}
}