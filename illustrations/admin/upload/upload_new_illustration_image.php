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

		/**
		 * ▼ Tokenをチェック
		 */

		$json_data[0] = true; // バリデーション結果
		$json_data[1] = '';  // last_insert_id
		$json_data[2] = ''; // 新しいtokenをset

		$tmp_name = $_FILES['new_illust']['tmp_name'];
		$error = $_FILES['new_illust']['error'];

		/**
		 * ▼ アップロードした画像を配置するディレクトリ
		 * ▼ C:/xampp/htdocs/kami-e.fan/images/1/illustrations/original/
		 */
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $user_id . '/illustrations/original/';


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
				$json_data[] = 'アップロード可能なファイルはgif、jpag、pngのみです。';
			}
		} else {
			$json_data[0] = false;
			$json_data[] = 'アップロード可能なファイルはgif、jpag、pngのみです。';
		}

		// ▼ バリデーションの結果
		if (! $json_data[0]) {
			throw new Exception('');
		}
	} else {
	 throw new NotPostException();
	}
} catch (NotPostException $e) {
	header ('Location: ../index.php');
	exit;
} catch (CsrfErrorException $e) {
	header ('Location: ../index.php');
	exit;
} catch (Exception $e) {
	header('Content-Type: application/json; charset=utf-8');
	header('X-Content-Type-Options: nosniff');
	echo json_encode($json_data);
	exit;
}
