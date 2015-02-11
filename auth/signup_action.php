<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));
// require_once(doc_root('/vendor/autoload.php')); // windowsでやる時（php5.4）はコメントアウトを外す

try {

	// ▼ ここに適当な値を設定すれば、とりあえずusersテーブルに登録できる
	$posts['name'] = '';
	$posts['email'] = '';
	$posts['password'] = '';



	// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// ▼ $_POSTをエスケープ処理
		// $posts = h_array($_POST);

		// ▼ Tokenをチェック
		// check_token($posts['token']);
		
		// $_SESSION['signup']['flg'] = true;
		// $_SESSION['signup']['err_msg'] = array();
	 	// $_SESSION['signup']['input_name'] = '';
		// $_SESSION['signup']['input_email'] = '';
		
		// ▼ バリデートを考える
		
		
		$model = new UsersModel($dsn, $db_user, $db_password);
		
		// ▼ POSTで渡されたEmailが登録済みか確認
		/*
		$res = $model->exsistEmail($posts['email']);
		if (! $res) {
			throw new IllegalPostException('このメールアドレスはすでに登録されています。');
		}
		*/
		
		// ▼ POSTで渡されたパスワードをハッシュ化
		$hash_password = crypt_password($posts['password']);
		$regist_flg = 0;
		$activation_key = md5(uniqid(mt_rand(), true));
		
		// ▼ ユーザーを仮登録
		$model->registUser($posts['name'], $posts['email'], $hash_password, $regist_flg, $activation_key);
		
		// ▼ メール送信
		
		
		// ▼ signup_index.phpへリダイレクト　メールを確認させるメッセージを表示する
		// redirect('/auth/signup_index.php?status=prob');
	// } else {
		// throw new NotPostException('');
	// }
} catch (NotPostException $e) {
	redirect();
} catch (IllegalPostException $e) {
	$_SESSION['signup']['flg'] = false;
	$_SESSION['signup']['err_msg'][] = $e->getMessage();
	$_SESSION['signup']['input_name'] = $_POST['name'];
	$_SESSION['signup']['input_email'] = $_POST['email'];
	redirect('/auth/signup_index.php');
} catch (PDOException $e) {
	$_SESSION['signup']['flg'] = false;
	$_SESSION['signup']['err_msg'][] = $e->getMessage();
	$_SESSION['signup']['input_name'] = $_POST['name'];
	$_SESSION['signup']['input_email'] = $_POST['email'];
	redirect('/auth/signup_index.php');
}