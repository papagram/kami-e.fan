<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));

class LoginAction
{
	private $model = null;
	
	public function __construct($dsn, $db_user, $db_password)
	{
		$this->model = new UsersModel($dsn, $db_user, $db_password);
	}
	
	public function execute()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
			// ▼ $_POSTをエスケープ処理
			$posts = h_array($_POST);
	
			// ▼ CSRF対策　tokenををチェック
			check_token($posts['token']);
			
			$flg = true;
			$_SESSION['login']['err_msg'] = array();
			$_SESSION['login']['input_email'] = '';
			$_SESSION['redirect'] = '/auth/login_index.php';
			
			// ▼ 入力値チェック　Email
			$posts['email'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['email']); // 前後のスペースは削除
			$email_max_len = 50;
			$len = mb_strlen($posts['email']); // 文字数取得
			if (! $len || $len > $email_max_len) {
				$flg = false;
			}
			
			// ▼ 入力値チェック　パスワード
			$posts['password'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['password']); // 前後のスペースは削除
			$password_max_len = 100;
			$len = mb_strlen($posts['password']); // 文字数取得
			if (! $len || $len > $password_max_len) {
				$flg = false;
			}
			
			// ▼ POSTで渡されたEmailをキーにユーザーを検索
			$user = $this->model->findUserByEmail($posts['email']);
			
			// ▼ POSTで渡されたパスワードを照合
			if (! password_verify($posts['password'], $user['password'])) {
				$flg = false;
			}
			
			// ▼ バリデート結果
			if (! $flg) {
				$_SESSION['login']['err_msg'][] = 'ログインに失敗しました';
				$_SESSION['login']['input_email'] = $_POST['email'];
				throw new InvalidValueException('');
			}
			
			// ▼ ユーザー情報をセッションに格納　マイページへリダイレクト
			unset($user['password']);
			unset($user['regist_flg']);
			unset($user['activation_key']);
			unset($_SESSION['login']);
			$_SESSION['user'] = $user;
			redirect('/users/user_index.php');
		} else {
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}