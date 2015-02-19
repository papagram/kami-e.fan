<div class="panel panel-default">
	<div class="panel-heading">プロフィール</div>
	<div class="panel-body">
		<p><?php echo h($user['name']); ?></p>
		<p><?php echo h($user['email']); ?></p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">メニュー</div>
	<div class="panel-body">
		<ul>
			<li><a href="<?php echo h(root_url('/illustrations/admin/admin_index.php')); ?>">イラスト一覧</a></li>
			<li><a href="<?php echo h(root_url('/illustrations/admin/upload_index.php')); ?>">アップロード</a></li>
		</ul>
	</div>
</div>
