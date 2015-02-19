<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

class UpdateAction
{
	private $model = null;
	
	public function __construct($dsn, $db_user, $db_password)
	{
		$this->model = new IllustrationsModel($dsn, $db_user, $db_password);
	}
	
	public function execute()
	{
		// ▼ セッションからユーザー情報を取得
		$user = set_user();
		
		// ▼ ログインしていなければログインページへリダイレクト
		is_authenticated($user);
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			// ▼ $_POSTをエスケープ処理
			$posts = h_array($_POST);
	
			// ▼ Tokenをチェック
			check_token($posts['token']);
	
			$flg = true;
			$_SESSION['update_illust']['err_msg'] = array();
			$_SESSION['update_illust']['input_title'] = '';
			$_SESSION['update_illust']['input_price'] = 0;
			$_SESSION['redirect'] = "/illustrations/admin/update_index.php?id={$posts['id']}";

			 // ▼ 入力値チェック タイトル
			 $posts['title'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['title']); // 前後のスペースは削除
			 $max_len = 30; // 最大文字数
			 $len = mb_strlen($posts['title']); // 文字数取得
			 if ($len > $max_len) {
				$flg = false;
				$err_msg[] = 'タイトルは30文字までです';
			 }
			 
			 // ▼ 入力値チェック 価格
			 $posts['price'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['price']); // 前後のスペースは削除
			 $max_digit = 7; // 最大桁数 1000000
			 $digit = mb_strlen($posts['price']); // 桁数取得
			 if ($digit > $max_digit) {
				$flg = false;
				$err_msg[] = '価格が大きすぎます';
			 }
			 if (! ctype_digit($posts['price'])) {
				$flg = false;
				$err_msg[] = '価格は数字のみ入力して下さい';
			 }

			 // ▼ バリデート結果
			 if (! $flg) {
				$_SESSION['update_illust']['err_msg'] = $err_msg;
				$_SESSION['update_illust']['input_title'] = $_POST['title'];
				$_SESSION['update_illust']['input_price'] = $_POST['price'];
				 throw new InvalidValueException('');
			 }

			// ▼ DBを更新
			$res = $this->model->update($posts, $user['id']);
			if (! $res) {
				$_SESSION['update_illust']['err_msg'][] = 'エラーが発生しました。もう一度やり直して下さい。';
				throw new DbException('');
			}
			
			unset($_SESSION['update_illust']);
			redirect('/users/user_index.php');
		} else {
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}