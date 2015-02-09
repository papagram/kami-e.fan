<?php

// ▼ 共通設定ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Pager.php'));


try {
	$model = new IllustrationsModel($dsn, $db_user, $db_password);
	
	// ▼ 全ての件数を取得
	$count_max = $model->countMax();
	
	// ▼ ページング処理
	$pager = new Pager($count_max); // コンストラクタに全ての件数を渡す

	// ▼ 新着イラストをセレクト　1ページ当たりの表示件数はPagerクラスの$per_pageプロパティ
	$rec =$model->findByPerPage($pager->getPerPage(), $pager->getOffset());
	$count = count($rec); // 取得件数
	
	// ▼ 画像ファイルのパスを配列で返す
	$images = images($rec, $user_id, $count);
} catch (GetParamErrorException $e) {
	redirect('/illustrations/new_arrival.php');
}


// ▼ ページタイトルは必ず定義
$page_title = '新着イラスト'; 

// ▼ viewファイル呼び出し
require (doc_root('/illustrations/view/new_arrival.php'));