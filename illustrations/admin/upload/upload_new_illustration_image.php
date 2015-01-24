<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');


try {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		/**
		 * ▼ $_POSTをエスケープ処理
		 */
		$posts = h_array($_POST);

		/**
		 * ▼ Tokenをチェック
		 */
		check_token($posts['token']);

		$json_data[0] = true; // バリデーション結果
		$json_data[1] = '';  // last_insert_id
		$json_data[2] = set_token(); // 新しいtokenをset

		$tmp_name = $_FILES['new_illust']['tmp_name'];
		$error = $_FILES['new_illust']['error'];

		// ▼ アップロードされたか
		if ($error === UPLOAD_ERR_NO_FILE || ! isset($_FILES['new_illust']) || ! $tmp_name) {
			$json_data[0] = false;
			$json_data[] = '画像ファイルを選択して下さい。';
			throw new Exception('');
		}

		// ▼ ファイルサイズをチェック
		$max = 1024 * 1024 * 2; // ファイルサイズの上限 2MB
		$size = filesize($tmp_name); // ファイルサイズを取得
		if ($size > $max){
			$json_data[0] = false;
			$json_data[] = 'ファイルサイズは2MBまでです。';
		}
		if ($size === (int)0) {
			$json_data[0] = false;
			$json_data[] = 'ファイルサイズが0MBです。';
		}

		// ▼ ファイルが壊れていないか
		$file = file_get_contents($tmp_name);
		if (! $file) {
			$json_data[0] = false;
			$json_data[] = 'ファイルが壊れています。';
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
				$json_data[0] = false;
				$json_data[] = 'アップロード可能なファイルはgif、jpeg、pngのみです。';
			}
		} else {
			$json_data[0] = false;
			$json_data[] = 'アップロード可能なファイルはgif、jpeg、pngのみです。';
		}

		// ▼ バリデーションの結果
		if (! $json_data[0]) {
			throw new ValidateErrorException('');
		}
		
		
		/**
		 * ▼ 画像を保存
		 */
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $user_id . '/illustrations/original/';
		$filename = sha1(microtime() . mt_rand());
		$original = $filename . '.' . $ext;
		if (! is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$move_to = $dir . $original;
		$upload_res = move_uploaded_file($tmp_name, $move_to);
		if (! $upload_res) {
			throw new UploadImageErrorException('');
		}
		
		
		/**
		 * ▼ サムネイルを作成
		 */
		$max_w = 160;
		$max_h = 160;
		list($w, $h) = getimagesize($move_to);
		
		// ▼ 幅か高さのどちらかが最大値を超えていたらサムネイル作成
		if ($w > $max_w || $h > $max_h) {
			$dir_thumb = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $user_id . '/illustrations/thumb/';
			$thumb = $filename . '_s.' . $ext;
			if (! is_dir($dir_thumb)) {
				mkdir($dir_thumb, 0777, true);
			}
			$thumb_move_to = $dir_thumb . $thumb;
			
			list($new_w, $new_h) = get_new_thumb_size($w, $h, $max_w, $max_h);
			
			$dest = imagecreatetruecolor($new_w, $new_h);
			if ($finfotype === 'image/gif')
			{
				$src = imagecreatefromgif($move_to);
				imagecopyresampled($dest, $src,
									0, 0,
									0, 0,
									$new_w, $new_h,
									$w, $h);
				imagegif($dest, $thumb_move_to);
			}
			elseif ($finfotype === 'image/jpeg' || $mime === 'image/pjpeg')
			{
				$src = imagecreatefromjpeg($move_to);
				imagecopyresampled($dest, $src,
									0, 0,
									0, 0,
									$new_w, $new_h,
									$w, $h);
				imagejpeg($dest, $thumb_move_to);

			}
			elseif ($finfotype === 'image/png' || $mime === 'image/x-png')
			{
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
		
		
		/**
		 * ▼ 画像を表示
		 */
		$thumb_file = file_get_contents($thumb_move_to);
		$image = base64_encode($thumb_file);
		echo '<img src="data:' . $finfotype . ';base64,' . $image . '">';
		exit;
		
	} else {
		throw new NotPostException();
	}
} catch (NotPostException $e) {
	header ('Location: ../index.php');
	exit;
} catch (CsrfErrorException $e) {
	header ('Location: ../index.php');
	exit;
} catch (ValidateErrorException $e) {
	header('Content-Type: application/json; charset=utf-8');
	header('X-Content-Type-Options: nosniff');
	echo json_encode($json_data);
	exit;
} catch (UploadImageErrorException $e) {
	echo 'アップロードに失敗しました。';
	exit;
}
