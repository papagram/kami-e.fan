<!DOCTYPE html>
<html lang="ja">

<?php require_once (doc_root('/view/layout/head.php')); ?>

<body>
	<?php require_once (doc_root('/view/layout/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-offset-3 col-md-6 col-md-offset-3">
				<div class="alert alert-success">
					<h2 class="text-center">ようこそ！<?php echo h(BRAND_NAME); ?>へ！</h2>
					<p class="text-center"><a href="<?php echo h(root_url('/auth/login_index.php')); ?>" class="alert-link">ログインはこちらから</a></p>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">登録内容</div>
					<div class="panel-body">
						<table class="table">
							<tr>
								<td>ユーザーID</td>
								<td><?php echo h($user['id']); ?></td>
							</tr>
							<tr>
								<td>お名前</td>
								<td><?php echo h($user['name']); ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo h($user['email']); ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/view/layout/footer.php')); ?>

</body>
</html>