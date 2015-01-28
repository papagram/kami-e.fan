<?php

/**
 * ▼ セッションを開始
 */
	session_start();
	session_regenerate_id(true);

// 仮のuser_id
	$user_id = 1;

// 現日時を取得
	$date = new DateTime();

// ▼ Exceptionクラスを拡張
	class NotPostException extends Exception {};
	class CsrfErrorException extends Exception {};
	class ValidateErrorException extends Exception {};
	class UploadImageErrorException extends Exception {};
	class SqlErrorException extends Exception {};