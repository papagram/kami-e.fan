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
 * ▼ DB処理
 * ▼ user_idをキーにセレクトする
 */
$dbh = db_connect($dsn, $db_user, $db_password);
$sql = 'SELECT * FROM illustrations WHERE user_id = :user_id ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($rec); // 取得件数

?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo '管理ページ'; ?>
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
					<a href="upload_new_illustration.php">upload</a>
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
				<table class="table table-striped">
					<thead>
						<th>ID</th>
						<th>タイトル</th>
						<th>価格</th>
						<th>登録日時</th>
						<th>ユーザー</th>
						<th>編集</th>
						<th>削除</th>
					</thead>
					<tbody>
						<caption>一覧</caption>
						<?php for ($i=0; $i<$count; $i++): ?>
						<tr>
							<td><?php echo h($rec[$i]['id']); ?></td>
							<td><?php echo h($rec[$i]['title']); ?></td>
							<td><?php echo h($rec[$i]['price']); ?></td>
							<td><?php echo h($rec[$i]['created_at']); ?></td>
							<td><?php echo h($rec[$i]['user_id']); ?></td>
							<td><a href="./update_illustration.php?id=<?php echo h($rec[$i]['id']); ?>">編集</a></td>
							<td><a href="">削除</a></td>
						</tr>
						<?php endfor; ?>
					</tbody>
				</table>
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