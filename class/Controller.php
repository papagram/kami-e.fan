<?php

require_once (doc_root('/class/exception/IllegalPostAccessException.php'));
require_once (doc_root('/class/exception/CsrfException.php'));
require_once (doc_root('/class/exception/AlreadyExistsException.php'));
require_once (doc_root('/class/exception/InvalidValueException.php'));
require_once (doc_root('/class/exception/UserNotFoundException.php'));
require_once (doc_root('/class/exception/UserAuthenticatedException.php'));


class Controller
{
	public function execute($obj)
	{
		try {
			$obj->execute();
		} catch (UserNotFoundException $e) {
			// ▼ ログイン失敗
			echo h($e->getMessage());
			exit;
		} catch (InvalidValueException $e) {
			// ▼ POSTされた値が不正な時
			echo h($e->getMessage());
			exit;
		} catch (AlreadyExistsException $e) {
			// ▼ 新規登録時にEmailが重複した時
			echo h($e->getMessage());
			exit;
		} catch (CsrfException $e) {
			echo h($e->getMessage());
			exit;
		} catch (IllegalPostAccessException $e) {
			echo h($e->getMessage());
			exit;
		} catch (UserAuthenticatedException $e) {
			// ▼ 認証が必要なページに来た時
			redirect('/auth/login_index.php');
		} catch (Exception $e) {
			echo h($e->getMessage());
			exit;
		}
	}
}