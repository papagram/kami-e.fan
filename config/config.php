<?php

// ▼ セッションを開始
session_start();
session_regenerate_id(true);

// ▼ 外部ファイルを読み込む
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php'); // 明示的に$_SERVER['DOCUMENT_ROOT']で読む
require_once(doc_root('/config/constants.php'));

// ▼ 仮のuser_idとユーザー名
$user_id = 1;
$user_name = 'SHINYA';

// ▼ 現日時を取得
$date = new DateTime();

// ▼ Exceptionクラスを拡張
class NotPostException extends Exception {};
class CsrfErrorException extends Exception {};
class ValidateErrorException extends Exception {};
class UploadImageErrorException extends Exception {};
class GetParamErrorException extends Exception {};
class NotFoundException extends Exception {};