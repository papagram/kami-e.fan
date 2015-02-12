<div>
	<p><?php echo h($user['name']); ?></p>
	<a href="<?php echo h(root_url('/users/setting/profile_index.php')); ?>">プロフィール編集</a>
</div>
<hr>
<div>
	<p>イラスト一覧</p>
<ul>
	<li><a href="<?php echo h(root_url('/illustrations/admin/admin_index.php')); ?>">イラスト一覧</a></li>
</ul>
</div>
