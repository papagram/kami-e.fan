<!DOCTYPE html>
<html lang="ja">

<?php require_once (doc_root('/common_html/head.php')); ?>

<body>
	<?php require_once (doc_root('/common_html/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<span>メニュー</span>
				<ul>
					<li><a href="<?php echo h(root_url('/illustrations/admin/admin_index.php')); ?>">イラスト一覧</a></li>
				</ul>
			</div>
			<div class="col col-md-10">
				<h1>こんにちは！<?php echo h($user['name']); ?>さん</h1>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/common_html/footer.php')); ?>

</body>
</html>