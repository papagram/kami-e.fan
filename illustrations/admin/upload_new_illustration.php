<?php

/**
 * ▼ $_SERVER['DOCUMENT_ROOT'] === 'C:/xampp/htdocs/kami-e.fan';
 * ▼ 外部ファイルをインクルード
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/constants.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

$date = new DateTime();

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
				<div>
					<button id="modal-start" class="btn btn-primary">upload</button>
				</div>
			</div>
		</div>
	</div>

<!-- ▼ モーダル -->
	<div class="modal" id="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Upload Your Illustration!!</h4>
				</div>
				<div class="modal-body">
					<form action="./upload/upload_new_illustration.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="upload">
						<fieldset>
							<div class="input-file-padding">
								<input type="file" name="new_illust" value="">
							</div>
							<button type="submit" class="btn btn-primary btn-block">upload</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- ▲ モーダルここまで -->

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