<?php

require_once (doc_root('/class/exception/IllegalPostAccessException.php'));
require_once (doc_root('/class/exception/AlreadyExistsException.php'));
require_once (doc_root('/class/exception/CsrfException.php'));

class Controller
{
	public function run($obj)
	{
		try {
			$obj->actionIndex();
		} catch (AlreadyExistsException $e) {
			echo h($e->getMessage());
			exit;
		} catch (CsrfException $e) {
			echo h($e->getMessage());
			exit;
		} catch (IllegalPostAccessException $e) {
			echo h($e->getMessage());
			exit;
		} catch (Exception $e) {
			echo h($e->getMessage());
			exit;
		}
	}
}