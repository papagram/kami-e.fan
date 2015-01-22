<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');


// イラストIDをURLパラメータから取得
if (! ctype_digit($_GET['id'])) {
	header('Location: ./index.php');
	exit;
}
$id= h($_GET['id']);

/**
 * ▼ DB処理
 * ▼ idをキーにセレクトする
 */
$dbh = db_connect($dsn, $db_user, $db_password);
$sql = 'SELECT * FROM illustrations WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

// 変数初期化
$input_title = (isset($_SESSION['update_illust']['input_title'])) ? $_SESSION['update_illust']['input_title'] : $rec['title'];
$input_price = (isset($_SESSION['update_illust']['input_price'])) ? $_SESSION['update_illust']['input_price'] : $rec['price'];
$err_msg = (isset($_SESSION['update_illust']['err_msg'])) ? $_SESSION['update_illust']['err_msg'] : array();

// tokenをセット
$token = set_token();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo '編集'; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="http://kami-e.fan/asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="http://kami-e.fan/asset/css/style.css" rel="stylesheet" media="screen">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://kami-e.fan/asset/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://kami-e.fan/asset/js/myjs.js"></script>
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://kami-e.fan/index.php">
					<?php echo h(BRAND_NAME); ?>
				</a>
			</div>
			<ul class="nav navbar-nav pull-right">
				<li>
					<a href="./upload_new_illustration.php">upload</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<span>メニュー</span>
			</div>
			<div class="col col-md-10">
				<div>
					<form action="./update/update_illustration.php" method="post" class="form-horizontal">
						<fieldset>
							<legend>編集</legend>
							<div class="form-group">
								<label for="title">タイトル</label>
								<input id="title" type="text" name="title" value="<?php echo h($input_title); ?>" class="form-control required-check">
								<span class="required-msg"></span>
								<span id="title_conut" class="pull-right"></span>
							</div>
							<div class="form-group">
								<label for="price">販売価格</label>
								<div class="input-group">
									<input id="price" type="text" name="price" value="<?php echo h($input_price); ?>" class="form-control required-check">
									<span class="input-group-addon">円</span>
								</div>
								<span class="required-msg"></span>
							</div>
							<ul>
								<?php foreach ($err_msg as $msg): ?>
									<li><?php echo h($msg); ?></li>
								<?php endforeach; ?>
							</ul>
							<input type="hidden" value="<?php echo h($token); ?>" name="token">
							<input type="hidden" value="<?php echo h($id); ?>" name="id">
							<button type="submit" class="btn btn-primary btn-block">更新</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="row">
			<div class="col col-md-12">
				<p class="copyright">
					<small>Copyright &copy; <?php echo $date->format('Y')?> <?php echo h(BRAND_NAME); ?>. All rights reserved.</small>
				</p>
			</div>
		</div>
	</div>
</body>
</html>
