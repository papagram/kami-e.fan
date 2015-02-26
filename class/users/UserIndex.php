<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Image.php'));

class UserIndex
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
		
		// ▼ ユーザーIDをキーにイラストを取得
		$rec = $this->model->findByUserId($user['id']);
		$count = count($rec); // 取得件数
		
		// ▼ 表示件数分のimageオブジェクトを生成
		$i = 0;
		while ($i < $count) {
			$image[] = new Image($rec[$i]);
			$i++;
		}
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ ページタイトルは必ず定義
		$page_title = "{$user['name']}さんのマイページ"; 
		
		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/users/user_index_view.php'));
	}
}