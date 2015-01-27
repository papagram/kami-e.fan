<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

// 変数初期化
$input_title = (isset($_SESSION['upload_new_illust_data']['input_title'])) ? $_SESSION['upload_new_illust_data']['input_title'] : '';
$input_price = (isset($_SESSION['upload_new_illust_data']['input_price'])) ? $_SESSION['upload_new_illust_data']['input_price'] : '';
$err_msg = (isset($_SESSION['upload_new_illust_data']['err_msg'])) ? $_SESSION['upload_new_illust_data']['err_msg'] : array();

// tokenをセット
$token = set_token();


require ('./view/upload_new_illustration.php');