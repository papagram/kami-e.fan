<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));
require_once(doc_root('/class/Image.php'));

class DeleteAction
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
		
		// ▼ URLパラメータをチェック
		if (! isset($_GET['id']) || ! ctype_digit($_GET['id'])) {
			throw new IllegalAccessException('エラーが発生しました。もう一度やり直して下さい。');
		}
		$id = (int)$_GET['id'];
		
		// ▼ 削除対象のイラスト情報を取得
		$rec = $this->model->findById($id);
		
		// ▼ imageオブジェクトを生成
		$image = new Image($rec);
		
		// ▼ 絞り込んだuser_idとセッションのuser_idが一致しなければエラー
		if ($image->getUserId() !== (int)$user['id']) {
			throw new IllegalUserException('エラーが発生しました。もう一度やり直して下さい。');
		}
		
		// ▼ レコードを削除
		$res = $this->model->delete($id, $user['id']);
		if (! $res) {
			$_SESSION['redirect'] = '/illustrations/admin/admin_index.php';
			throw new DbException('');
		}
		
		// ▼ 画像ファイルを削除 2ヶ所
		$filename = $image->getImagePath($type = 'original'); // オリジナル画像 これは絶対ある
		$filename_thumb = ''; // 初期化
		if (mb_strlen($image->getFilenameThumb()) > 0) {
			$filename_thumb = $image->getImagePath($type = 'thumb'); // サムネ画像 これはないかもしれないのでファイル名で判定する
		}
		
		if (file_exists($filename)) {
			unlink($filename); // オリジナル画像ファイル削除
			
			if ($filename_thumb && file_exists($filename_thumb)) { // $filename_thumbに値が代入済み かつ ファイルの存在を確認
				unlink($filename_thumb); // サムネ画像ファイル削除
			}
		}
		
		redirect('/illustrations/admin/admin_index.php');
	}
}