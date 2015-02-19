<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/UsersModel.php'));

class SignupAction
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
	
			// ▼ Tokenをチェック
			check_token($posts['token']);
			
			$flg = true;
			$_SESSION['signup']['err_msg'] = array();
			$_SESSION['signup']['input_name'] = '';
			$_SESSION['signup']['input_email'] = '';
			$_SESSION['redirect'] = '/auth/signup_index.php';
			
			// ▼ 入力値チェック　Name
			$posts['name'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['name']); // 前後のスペースは削除
			$name_max_len = 30;
			$len = mb_strlen($posts['name']); // 文字数取得
			if (! $len) {
				$flg = false;
				$err_msg[] = '名前を入力して下さい';
			}
			
			if ($len > $name_max_len) {
				$flg = false;
				$err_msg[] = "名前は{$name_max_len}文字までです。";
			}
			
			// ▼ 入力値チェック　Email
			$posts['email'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['email']); // 前後のスペースは削除
			$email_max_len = 50;
			$len = mb_strlen($posts['email']); // 文字数取得
			if (! filter_var($posts['email'], FILTER_VALIDATE_EMAIL) || ! $len)
			{
				$flg = false;
				$err_msg[] = 'メールアドレスを入力して下さい';
			}
			
			if ($len > $email_max_len) {
				$flg = false;
				$err_msg[] = 'メールアドレスが長すぎます';
			}
			
			// ▼ POSTで渡されたEmailが登録済みか確認
			$res = $this->model->exsistEmail($posts['email']);
			if (! $res) {
				$flg = false;
				$err_msg[] = 'このメールアドレスはすでに登録されています';
			}
			
			// ▼ 入力値チェック　Password
			$posts['password'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['password']); // 前後のスペースは削除
			if (! is_match_pattern_password($posts['password'])) {
				$flg = false;
				$err_msg[] = 'もう一度パスワードを設定して下さい';
			}
			
			// ▼ バリデート結果
			if (! $flg) {
				$_SESSION['signup']['err_msg'] = $err_msg;
				$_SESSION['signup']['input_name'] = $_POST['name'];
				$_SESSION['signup']['input_email'] = $_POST['email'];
				throw new InvalidValueException('');
			}
			
			// ▼ POSTで渡されたパスワードをハッシュ化
			$hash_password = crypt_password($posts['password']);
			
			// ▼ ユーザーを登録
			$res = $this->model->registUser($posts['name'], $posts['email'], $hash_password, $regist_flg, $activation_key);
			if (! $res) {
				$_SESSION['signup']['err_msg'][] = 'エラーが発生しました。もう一度やり直して下さい。';
				throw new DbException('');
			}
			
			$_SESSION['signup_success'] = $res;

			// ▼ 内容確認画面へリダイレクト
			redirect('/auth/signup_success.php?');
		} else {
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}