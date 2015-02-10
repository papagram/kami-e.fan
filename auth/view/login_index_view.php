<!DOCTYPE html>
<html lang="ja">

<?php require_once (doc_root('/common_html/head.php')); ?>

<body>
	<?php require_once (doc_root('/common_html/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<span>メニュー</span>
			</div>
			<div class="col col-md-10">
				<form action="<?php echo h(root_url('/auth/login_action.php')); ?>" method="post" class="form-horizontal">
					<fieldset>
						<legend>Login</legend>
						<div class="form-group">
							<label for="email">Email</label>
							<input id="email" type="text" name="email" value="<?php echo h($input_email); ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input id="password" type="password" name="password" class="form-control">
						</div>
						<ul>
							<?php foreach ($err_msg as $msg): ?>
								<li><?php echo h($msg); ?></li>
							<?php endforeach; ?>
						</ul>
						<input type="hidden" value="<?php echo h($token); ?>" name="token">
						<button type="submit" class="btn btn-primary btn-block">login</button>
					</fieldset>
				</form>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/common_html/footer.php')); ?>

</body>
</html>