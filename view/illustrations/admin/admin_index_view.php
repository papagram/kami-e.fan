<!DOCTYPE html>
<html lang="ja">

<?php require_once (doc_root('/view/layout/head.php')); ?>

<body>
	<?php require_once (doc_root('/view/layout/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-3">
				<?php require_once (doc_root('/view/layout/left_nav.php')); ?>
			</div>
			<div class="col col-md-9">
				<?php if ($count > 0): ?>
				
				<h1><?php echo h($user['name']); ?>さんのイラスト一覧</h1>
				<hr>
				<div class="list-group">
					<?php for ($i=0; $i<$count; $i++): ?>
					<div class="list-group-item">
						<div class="admin-list-box">
							<div class="admin-list-image thumb">
								<a href="<?php echo h(root_url('/illustrations/display/display.php?id=' . $rec[$i]['id'])); ?>">
									<img src="<?php echo h($images[$i])?>">
								</a>
							</div>
							<div class="admin-list-text">
								<ul class="list-unstyled">
									<li>ID: <?php echo h($rec[$i]['id']); ?></li>
									<li>Title: <a href="<?php echo h(root_url('/illustrations/display/display.php?id=' . $rec[$i]['id'])); ?>"><?php echo h($rec[$i]['title']); ?></a></li>
									<li>Price: <?php echo h($rec[$i]['price']); ?>円</li>
									<li>Date: <?php echo h($rec[$i]['created_at']); ?></li>
									<li>
										<a href="<?php echo h(root_url('/illustrations/admin/update_index.php?id=' . $rec[$i]['id'])); ?>">編集</a>
										<a href="<?php echo h(root_url('/illustrations/admin/delete_action.php?id=' . $rec[$i]['id'])); ?>">削除</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php endfor; ?>
				</div>
				
				<?php else: ?>
				
				<p>イラストはまだ投稿されておりません。</p>
				
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/view/layout/footer.php')); ?>

</body>
</html>