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

		$_SESSION['update_illust']['flg'] = true;
		$_SESSION['update_illust']['err_msg'] = array();
	 	$_SESSION['update_illust']['input_title'] = '';
	 	$_SESSION['update_illust']['input_price'] = '';

		/**
		 * ▼ タイトルは必須　30文字まで
		 */
		 $posts['title'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['title']); // 前後のスペースは削除
		 $max_len = 30; // 最大文字数
		 $len = mb_strlen($posts['title']); // 文字数取得
		 if ($len > $max_len) {
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = 'タイトルは30文字までです。';
		 }
		 if (! $len) {
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = 'タイトルが入力されていません。';
		 }
		 
		/**
		 * ▼ 価格は必須 数字のみ 7桁まで
		 */
		 $posts['price'] = mb_ereg_replace('\A(\s)+|(\s)+\z', '', $posts['price']); // 前後のスペースは削除
		 $max_digit = 7; // 最大桁数 1000000
		 $digit = mb_strlen($posts['price']); // 桁数取得
		 if ($digit > $max_digit) {
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = '価格が大きすぎます。';
		 }
		 if (! $digit) {
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = '価格が入力されていません。';
		 }
		 if (! ctype_digit($posts['price'])) {
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = '価格は数字のみ入力して下さい。';
		 }

		/**
		 * ▼ バリデート結果
		 */
		 if (! $_SESSION['update_illust']['flg']) {
		 	throw new ValidateErrorException('');
		 }
		 
		/**
		 * ▼ DB処理
		 */
		 $dbh = db_connect($dsn, $db_user, $db_password);
		 
		 try {
		 	$dbh->beginTransaction();

			$sql = 'UPDATE illustrations 
						SET title = :title, price = :price 
					WHERE id = :id';
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':title', $posts['title'], PDO::PARAM_STR);
			$stmt->bindValue(':price', (int)$posts['price'], PDO::PARAM_INT);
			$stmt->bindValue(':id', (int)$posts['id'], PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->rowCount();
			if (! $count) {
				throw new Exception('');
			}
		 	
		 	$dbh->commit();
		 } catch (Exception $e) {
		 	$dbh->rollBack();
		 	echo '失敗';
		 	exit;
		 }
		 
		unset($_SESSION['update_illust']);
		header('Location: ../index.php');
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
 	$_SESSION['update_illust']['input_title'] = $_POST['title'];
 	$_SESSION['update_illust']['input_price'] = $_POST['price'];
	header('Location: ../update_illustration.php?id=' . (int)$posts['id']);
	exit;
}
