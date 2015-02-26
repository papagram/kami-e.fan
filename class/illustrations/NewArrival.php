<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Pager.php'));
require_once(doc_root('/class/Image.php'));

class NewArrival
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
		
		// ▼ 全ての件数を取得
		$count_max = $this->model->countMax();
		
		// ▼ ページング処理
		$pager = new Pager($count_max); // コンストラクタに全ての件数を渡す
	
		// ▼ 新着イラストをセレクト　1ページ当たりの表示件数はPagerクラスのper_pageプロパティ
		$rec = $this->model->findByPerPage($pager->getPerPage(), $pager->getOffset());
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
		$page_title = '新着イラスト';
		
		// ▼ viewファイル呼び出し
		require (doc_root('/view/illustrations/display/new_arrival_view.php'));
	}
}