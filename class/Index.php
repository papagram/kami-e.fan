<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Image.php'));

class Index
{
	private $model = null;
	
	public function __construct($dsn, $db_user, $db_password)
	{
		$this->model = new IllustrationsModel($dsn, $db_user, $db_password);
	}
	
	public function execute()
	{
		$limit = 11; // 最大取得件数
		$rec = $this->model->findLimit($limit); // 新着イラスト一を$limitの数だけselect 降順
		$count = count($rec); // 実取得件数
		$limit_cp = $limit;
		$max_list = --$limit_cp; // 最大表示件数
		if ($count <= $max_list) {
			$list = $count; // 10件までの場合　実表示件数を適用
		} else {
			$list = $max_list; // 11件以上の場合　最大表示件数を適用
		}
		
		// ▼ 表示件数分のimageオブジェクトを生成
		$i = 0;
		while ($i < $list) {
			$image[] = new Image($rec[$i]);
			list($w[], $h[]) = $image[$i]->getImageSize($image[$i]->getFilenameThumb());
			$max_w = 160;
			$max_h = 160;
			list($new_w[], $new_h[]) = $image[$i]->getNewImageSize($w[$i], $h[$i], $max_w, $max_h);
			$i++;
		}

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