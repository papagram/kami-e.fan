<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));

class SignupAction
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
	
			// ▼ Tokenをチェック
			check_token($posts['token']);
			
			$_SESSION['signup']['flg'] = true;
			$_SESSION['signup']['err_msg'] = array();
			$_SESSION['signup']['input_name'] = '';
			$_SESSION['signup']['input_email'] = '';
			
			// ▼ バリデートを考える
			
			
			$model = new UsersModel($this->dsn, $this->db_user, $this->db_password);
			
			// ▼ POSTで渡されたEmailが登録済みか確認
			$res = $model->exsistEmail($posts['email']);
			if (! $res) {
				throw new AlreadyExistsException('このメールアドレスはすでに登録されています。');
			}
			
			// ▼ POSTで渡されたパスワードをハッシュ化
			$hash_password = crypt_password($posts['password']);
			$regist_flg = 0;
			$activation_key = md5(uniqid(mt_rand(), true));
			
			// ▼ ユーザーを登録
			$model->registUser($posts['name'], $posts['email'], $hash_password, $regist_flg, $activation_key);
			
			// ▼ メール送信・・・はやめるかも
			
			
			// ▼ ログイン画面へリダイレクト
			redirect('/auth/login_index.php?');
		} else {
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}