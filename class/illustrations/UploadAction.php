<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/IllustrationsModel.php'));

class UploadAction
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
			// ▼ 変数初期化
			$flg = true;
			$_SESSION['upload_action']['err_msg'] = array();
			$_SESSION['redirect'] = '/illustrations/admin/upload_index.php';
			$tmp_name = $_FILES['new_illust']['tmp_name'];
			$error = $_FILES['new_illust']['error'];
	
			/**
			 * ▼ php.iniのpost_max_sizeディレクティブを超えているか 32MB
			 * ▼ php.iniのupload_max_filesizeディレクティブを超えているか 32MB
			 * ▼ MAX_FILE_SIZEを超えているか 2MB
			 */
			$post_max_size = 1024 * 1024 * 32;
			if ($_SERVER['CONTENT_LENGTH'] > $post_max_size ||
			$error === UPLOAD_ERR_INI_SIZE || 
			$error === UPLOAD_ERR_FORM_SIZE) {
				$_SESSION['upload_action']['err_msg'][] = 'ファイルサイズは2MBまでです。';
				throw new InvalidValueException('');
			}
	
			// ▼ $_POSTをエスケープ処理
			$posts = h_array($_POST);
	
			// ▼ tokenをチェック
			check_token($posts['token']);
	
			// ▼ アップロードされたか
			if ($error === UPLOAD_ERR_NO_FILE || ! isset($_FILES['new_illust']) || ! $tmp_name) {
				$_SESSION['upload_action']['err_msg'][] = '画像ファイルを選択して下さい。';
				throw new InvalidValueException('');
			}
	
			// ▼ ファイルサイズをチェック
			$size = filesize($tmp_name); // ファイルサイズを取得
			if ($size > $posts['MAX_FILE_SIZE']){
				$flg = false;
				$err_msg[] = 'ファイルサイズは2MBまでです';
			}
	
			// ▼ ファイルが壊れていないか
			$file = file_get_contents($tmp_name);
			if (! $file || $size === (int)0) {
				$flg = false;
				$err_msg[] = 'ファイルが壊れています';
			}
	
			// ▼ 拡張子が許可されたものか（jpeg, ong, gif）
			$ext = '';
			$img_type = $_FILES['new_illust']['type'];
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$finfotype = $finfo->file($tmp_name); // MIMEタイプを取得
			if ($img_type === $finfotype) {
				if ($finfotype === 'image/gif') { // 拡張子を取得
					$ext = 'gif';
				} elseif ($finfotype === 'image/jpeg' ||
							$finfotype === 'image/pjpeg') {
					$ext = 'jpeg';
				} elseif ($finfotype === 'image/png' ||
							$finfotype === 'image/x-png') {
					$ext = 'png';
				} else {
					$flg = false;
					$err_msg[] = 'アップロード可能なファイルはgif、jpeg、pngのみです';
				}
			} else {
				$flg = false;
				$err_msg[] = 'アップロード可能なファイルはgif、jpeg、pngのみです';
			}
	
			// ▼ バリデーションの結果
			if (! $flg) {
				$_SESSION['upload_action']['err_msg'] = $err_msg;
				throw new InvalidValueException('');
			}
			
			
			// ▼ 画像を保存
			$dir = doc_root("/images/{$user['id']}/illustrations/original/");
			$filename = sha1(microtime() . mt_rand());
			$original = $filename . '.' . $ext;
			if (! is_dir($dir)) {
				mkdir($dir, 0777, true);
			}
			$move_to = $dir . $original;
			$upload_res = move_uploaded_file($tmp_name, $move_to);
			if (! $upload_res) {
				$_SESSION['upload_action']['err_msg'][] = '画像のアップロードに失敗しました。もう一度やり直して下さい。';
				throw new MoveUploadedFileException('');
			}
			
			// ▼ サムネイルを作成　値を定義
			$max_w = 160;
			$max_h = 160;
			list($w, $h) = getimagesize($move_to);
			
			// ▼ 幅か高さのどちらかが最大値を超えていたらサムネイル作成
			if ($w > $max_w || $h > $max_h) {
				$dir_thumb = doc_root("/images/{$user['id']}/illustrations/thumb/");
				$thumb = $filename . '_s.' . $ext;
				if (! is_dir($dir_thumb)) {
					mkdir($dir_thumb, 0777, true);
				}
				$thumb_move_to = $dir_thumb . $thumb;
				
				list($new_w, $new_h) = get_new_thumb_size($w, $h, $max_w, $max_h);
				
				$dest = imagecreatetruecolor($new_w, $new_h);
				if ($finfotype === 'image/gif'){
					$src = imagecreatefromgif($move_to);
					imagecopyresampled($dest, $src,
										0, 0,
										0, 0,
										$new_w, $new_h,
										$w, $h);
					imagegif($dest, $thumb_move_to);
				} elseif ($finfotype === 'image/jpeg' || $mime === 'image/pjpeg') {
					$src = imagecreatefromjpeg($move_to);
					imagecopyresampled($dest, $src,
										0, 0,
										0, 0,
										$new_w, $new_h,
										$w, $h);
					imagejpeg($dest, $thumb_move_to);
				} elseif ($finfotype === 'image/png' || $mime === 'image/x-png') {
					$src = imagecreatefrompng($move_to);
					imagecopyresampled($dest, $src,
										0, 0,
										0, 0,
										$new_w, $new_h,
										$w, $h);
					imagepng($dest, $thumb_move_to);
				}
				imagedestroy($dest);
				imagedestroy($src);
			}
			
			// ▼ イラスト情報をDBへインサート
			$this->model->insert($user['id'], $original, $thumb, $finfotype);
			if (! $res) {
				$_SESSION['upload_action']['err_msg'][] = '画像のアップロードに失敗しました。もう一度やり直して下さい。';
				throw new DbException('');
			}
	
			unset($_SESSION['upload_action']);
			redirect('/illustrations/admin/update_index.php?id=' . $this->model->getLastInsertId());
		} else {
			throw new IllegalPostAccessException('不正なアクセスが行われました。');
		}
	}
}