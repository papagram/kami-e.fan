<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

/**
 * ▼ classファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/class/IllustrationsModel.php');


/**
 * ▼ ページタイトルは必ず定義
 */
$page_title = '編集'; 

// イラストIDをURLパラメータから取得
if (! ctype_digit($_GET['id'])) {
	header('Location: ./index.php');
	exit;
}
$id= h($_GET['id']);

/**
 * ▼ DB処理 IDをキーにイラストを絞り込む
 */
$model = new IllustrationsModel($dsn, $db_user, $db_password);
$rec = $model->findById($id);


/**
 * ▼ 画像データを取得 パス、幅、高さを取得
 * ▼ 第3引数にモード指定で表示サイズ変更 引数無しの場合オリジナルサイズ
 */
$image = image_thumb($rec, $user_id);

// 変数初期化
$input_title = (isset($_SESSION['update_illust']['input_title'])) ? $_SESSION['update_illust']['input_title'] : $rec['title'];
$input_price = (isset($_SESSION['update_illust']['input_price'])) ? $_SESSION['update_illust']['input_price'] : $rec['price'];
$err_msg = (isset($_SESSION['update_illust']['err_msg'])) ? $_SESSION['update_illust']['err_msg'] : array();

// tokenをセット
$token = set_token();


require ('./view/update_illustration.php');