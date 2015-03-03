<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Image.php'));

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
		
		// ▼ imageオブジェクトを生成
		$image = new Image($rec);
		list($w, $h) = $image->getImageSize($image->getFilename());
		$max_w = 450;
		$max_h = 450;
		list($new_w, $new_h) = $image->getNewImageSize($w, $h, $max_w, $max_h);
		
		// ▼ 現日時を取得
		$date = new DateTime();
		
		// ▼ ページタイトルは必ず定義
		$page_title = h($image->getTitle()) . ' | ' . h($image->getName()) . 'さんのイラスト';
		
		// ▼ viewファイル呼び出し
		require (doc_root('/view/illustrations/display/display_view.php'));
	}
}