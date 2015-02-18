<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

class Display
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
		
		// ▼ URLパラメータをチェック
		if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
			throw new IllegalAccessException('申し訳ありません。お探しのイラストが見つかりません。');
		}
		$id = (int)$_GET['id'];
		
		// ▼ イラストIDをキーにイラストを絞り込む
		$rec = $this->model->findById($id);
		
		// ▼ 画像データを取得 パス、幅、高さを取得
		// ▼ 第3引数にモード指定で表示サイズ変更 引数無しの場合オリジナルサイズ
		$image = image_original($rec, 'middle');
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ ページタイトルは必ず定義
		$page_title = h($rec['title']) . ' | ' . h($rec['name']) . 'さんのイラスト';
		
		// ▼ viewファイル呼び出し
		require (doc_root('/view/illustrations/display/display_view.php'));
	}
}