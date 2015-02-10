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
		
		// ▼ 入力値チェック　Email
		$posts['email'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['email']); // 前後のスペースは削除
		$email_max_len = 50;
		$len = mb_strlen($posts['email']); // 文字数取得
		if (! $len || $len > $email_max_len) {
			throw new ValidateErrorException('ログインに失敗しました。');
		}
		
		// ▼ 入力値チェック　パスワード
		$posts['password'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['password']); // 前後のスペースは削除
		$password_max_len = 100;
		$len = mb_strlen($posts['password']); // 文字数取得
		if (! $len || $len > $password_max_len) {
			throw new ValidateErrorException('ログインに失敗しました。');
		}
		
		// ▼ POSTで渡されたEmailをキーにユーザーを検索
		$model = new UsersModel($dsn, $db_user, $db_password);
		$user = $model->findUserByEmail($posts['email']);
		
		// ▼ POSTで渡されたパスワードを照合
		if (! password_verify($posts['password'], $user['password'])) {
			throw new UserNotFoundException('ログインに失敗しました。');
		}
		
		// ▼ ユーザー情報をセッションに格納　マイページへリダイレクト
		unset($user['password']);
		unset($user['regist_flg']);
		unset($user['activation_key']);
		$_SESSION['user'] = $user;
		redirect('/users/user_index.php');
	} else {
		throw new NotPostException('');
	}
} catch (NotPostException $e) {
	redirect();
} catch (ValidateErrorException $e) {
	$_SESSION['login']['flg'] = false;
	$_SESSION['login']['err_msg'][] = $e->getMessage();
	$_SESSION['login']['input_email'] = $_POST['email'];
	redirect('/auth/login_index.php');
} catch (UserNotFoundException $e) {
	$_SESSION['login']['flg'] = false;
	$_SESSION['login']['err_msg'][] = $e->getMessage();
	$_SESSION['login']['input_email'] = $_POST['email'];
	redirect('/auth/login_index.php');
}