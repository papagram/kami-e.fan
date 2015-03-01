<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Image.php'));

class ImageView
{
	public function execute()
	{
		// ▼ URLパラメータをチェック
		if (!isset($_GET['filename']) || !isset($_GET['mime']) || !isset($_GET['user_id'])) {
			throw new IllegalAccessException('申し訳ありません。お探しのイラストが見つかりません。');
		}
		$filename = $_GET['filename'];
		$mime = $_GET['mime'];
		$user_id = $_GET['user_id'];
		
		if (mb_strpos($filename, '_s.') === false) {
			$image =  doc_root("/../images/{$user_id}/illustrations/original/{$filename}");
		} else {
			$image =  doc_root("/../images/{$user_id}/illustrations/thumb/{$filename}");
		}
		
		header ('Content-type: ' . h($mime));
		header ('X-Content-Type-Options: nosniff');
		readfile($image);
	}
}