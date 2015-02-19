<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo h(root_url()); ?>">
				<?php echo h(BRAND_NAME); ?>
			</a>
		</div>
		<ul class="nav navbar-nav pull-right">
			<?php if (isset($_SESSION['user'])): ?>
			<li>
				<a href="<?php echo h(root_url('/illustrations/admin/upload_index.php')); ?>">アップロード</a>
			</li>
			<li>
				<a href="<?php echo h(root_url('/users/user_index.php')); ?>"><?php echo h($user['name']); ?>さん</a>
			</li>
			<li>
				<a href="<?php echo h(root_url('/auth/logout_action.php')); ?>">ログアウト</a>
			</li>
			<?php else: ?>
			<li>
				<a href="<?php echo h(root_url('/auth/login_index.php')); ?>">ログイン</a>
			</li>
			<li>
				<a href="<?php echo h(root_url('/auth/signup_index.php')); ?>">ユーザー登録</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</nav>