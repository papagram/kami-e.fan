<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

class Index
{
	private $model = null;
	
	public function __construct($dsn, $db_user, $db_password)
	{
		$this->model = new IllustrationsModel($dsn, $db_user, $db_password);
	}
	
	public function execute()
	{
		$rec = $this->model->findLimit(); // 新着イラスト一を$limitの数だけselect 降順
		$count = count($rec); // 取得件数
		
		$images = images($rec, $count); // 画像ファイルのパスを返す

		// ▼ セッションからユーザー情報を取得
		$user = set_user();
		
		// ▼ 現日時を取得
		$date = new DateTime();

		// ▼ ページタイトルは必ず定義
		$page_title = BRAND_NAME . 'へようこそ！'; 
		
		// ▼ viewファイル呼び出し
		require_once (doc_root('/view/index_view.php'));
	}
}