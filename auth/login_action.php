<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));

try {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// ▼ $_POSTをエスケープ処理
		$posts = h_array($_POST);

		// ▼ Tokenをチェック
		check_token($posts['token']);
		
		$_SESSION['login']['flg'] = true;
		$_SESSION['login']['err_msg'] = array();
	 	$_SESSION['login']['input_email'] = '';
		
		// ▼ POSTで渡されたEmailをキーにユーザーを検索
		$model = new UsersModel($dsn, $db_user, $db_password);
		$user = $model->findUserByEmail($posts['email']);
		
		// ▼ POSTで渡されたパスワードを照合
		if (! password_verify($posts['password'], $user['password'])) {
			throw new UserNotFoundException('ログインに失敗しました。');
		}
		
		// ▼ ユーザー情報をセッションに格納　トップページへリダイレクト
		$_SESSION['user'] = $user;
		redirect();
	} else {
		throw new NotPostException('');
	}
} catch (NotPostException $e) {
	redirect();
} catch (UserNotFoundException $e) {
		$_SESSION['login']['flg'] = false;
		$_SESSION['login']['err_msg'][] = $e->getMessage();
		$_SESSION['login']['input_email'] = $_POST['email'];
		redirect();
}