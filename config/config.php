<?php

/**
 * ▼ セッションを開始
 */
	session_start();
	session_regenerate_id(true);

// 仮のuser_id
	$user_id = 1;

// ▼ Exceptionクラスを拡張
	class NotPostException extends Exception {};
	class CsrfErrorException extends Exception {};