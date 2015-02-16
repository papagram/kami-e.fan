<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));

class LoginAction
{
	private $dsn = '';
	private $db_user = '';
	private $db_password = '';
	
	
	public function __construct($dsn, $db_user, $db_password)
	{
		$this->dsn = $dsn;
		$this->db_user = $db_user;
		$this->db_password = $db_password;
	}
	
	public function execute()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
			// ▼ $_POSTをエスケープ処理
			$posts = h_array($_POST);
	
			// ▼ CSRF対策　tokenををチェック
			check_token($posts['token']);
			
			$_SESSION['login']['flg'] = true;
			$_SESSION['login']['err_msg'] = array();
			$_SESSION['login']['input_email'] = '';
			
			// ▼ 入力値チェック　Email
			$posts['email'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['email']); // 前後のスペースは削除
			$email_max_len = 50;
			$len = mb_strlen($posts['email']); // 文字数取得
			if (! $len || $len > $email_max_len) {
				throw new InvalidValueException('ログインに失敗しました。');
			}
			
			// ▼ 入力値チェック　パスワード
			$posts['password'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['password']); // 前後のスペースは削除
			$password_max_len = 100;
			$len = mb_strlen($posts['password']); // 文字数取得
			if (! $len || $len > $password_max_len) {
				throw new InvalidValueException('ログインに失敗しました。');
			}
			
			// ▼ POSTで渡されたEmailをキーにユーザーを検索
			$model = new UsersModel($this->dsn, $this->db_user, $this->db_password);
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
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}