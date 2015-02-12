<!DOCTYPE html>
<html lang="ja">

<?php require_once (doc_root('/common_html/head.php')); ?>

<body>
	<?php require_once (doc_root('/common_html/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<?php require_once (doc_root('/common_html/left_nav.php')); ?>
			</div>
			<div class="col col-md-10">
				<h1><?php echo h($user['name']); ?>さんのイラスト一覧です。</h1>
				<hr>
				<table class="table table-striped">
					<thead>
						<th>ID</th>
						<th>イラスト</th>
						<th>タイトル</th>
						<th>価格</th>
						<th>登録日</th>
						<th>編集</th>
						<th>削除</th>
					</thead>
					<tbody>
						<?php for ($i=0; $i<$count; $i++): ?>
						<tr>
							<td><?php echo h($rec[$i]['id']); ?></td>
							<td><a href="<?php echo h(root_url('/illustrations/show_illustration.php?id=' . $rec[$i]['id'])); ?>"><img src="<?php echo h($images[$i])?>"></a></td>
							<td><a href="<?php echo h(root_url('/illustrations/show_illustration.php?id=' . $rec[$i]['id'])); ?>"><?php echo h($rec[$i]['title']); ?></a></td>
							<td><?php echo h($rec[$i]['price']); ?>円</td>
							<td><?php echo h($rec[$i]['created_at']); ?></td>
							<td><a href="<?php echo h(root_url('/illustrations/admin/update_illustration.php?id=' . $rec[$i]['id'])); ?>">編集</a></td>
							<td><a href="<?php echo h(root_url('/illustrations/admin/delete/delete_illustration.php?id=' . $rec[$i]['id'])); ?>">削除</a></td>
						</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/common_html/footer.php')); ?>

</body>
</html>