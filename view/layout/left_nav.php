<div class="panel panel-default">
	<div class="panel-heading">ユーザー情報</div>
	<div class="panel-body">
		<p>名　前： <?php echo h($user['name']); ?></p>
		<p>メール： <?php echo h($user['email']); ?></p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">メニュー</div>
	<div class="panel-body">
		<ul>
			<li><a href="<?php echo h(root_url('/illustrations/admin/admin_index.php')); ?>">イラスト一覧を見る</a></li>
			<li><a href="<?php echo h(root_url('/illustrations/admin/upload_index.php')); ?>">アップロード</a></li>
		</ul>
	</div>
</div>
