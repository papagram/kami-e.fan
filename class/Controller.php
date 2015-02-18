<?php

require_once (doc_root('/class/exception/IllegalPostAccessException.php'));
require_once (doc_root('/class/exception/CsrfException.php'));
require_once (doc_root('/class/exception/InvalidValueException.php'));
require_once (doc_root('/class/exception/UserAuthenticatedException.php'));
require_once (doc_root('/class/exception/MoveUploadedFileException.php'));
require_once (doc_root('/class/exception/IllegalUserException.php'));
require_once (doc_root('/class/exception/PageNotFoundException.php'));
require_once (doc_root('/class/exception/IllegalAccessException.php'));
require_once (doc_root('/class/exception/DbException.php'));


class Controller
{
	public function execute($obj)
	{
		try {
			$obj->execute();
		} catch (PageNotFoundException $e) {
			// ▼ 指定されたIDでイラストが見つからない時
			$_SESSION['error'] = $e->getMessage();
			redirect('/error/error.php');
		} catch (IllegalUserException $e) {
			// ▼ ユーザーが一致しない時
			$_SESSION['error'] = $e->getMessage();
			redirect('/error/error.php');
		} catch (MoveUploadedFileException $e) {
			// ▼ 画像の保存に失敗した時
			redirect ( h( get_redirect_to() ) );
		} catch (IllegalAccessException $e) {
			// ▼ GETの値が不正な時
			$_SESSION['error'] = $e->getMessage();
			redirect('/error/error.php');
		} catch (InvalidValueException $e) {
			// ▼ POSTされた値が不正な時
			redirect ( h( get_redirect_to() ) );
		} catch (CsrfException $e) {
			// ▼ CSRFエラー
			$_SESSION['error'] = $e->getMessage();
			redirect('/error/error.php');
		} catch (IllegalPostAccessException $e) {
			// ▼ 不正なPOSTアクセス
			$_SESSION['error'] = $e->getMessage();
			redirect('/error/error.php');
		} catch (UserAuthenticatedException $e) {
			// ▼ 認証が必要なページに来た時
			redirect('/auth/login_index.php');
		} catch (DbException $e) {
			// ▼ データベースエラー
			redirect ( h( get_redirect_to() ) );
		} catch (PDOException $e) {
			// ▼ DBサーバーエラー
			$_SESSION['error'] = 'ただいま障害により大変ご迷惑をお掛け致しております。今しばらくお待ち下さい。';
			redirect('/error/error.php');
		} catch (Exception $e) {
			$_SESSION['error'] = 'エラーが発生しました。';
			redirect('/error/error.php');
		}
	}
}