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
				<h2>こんにちは！<?php echo h($user['name']); ?>さん</h2>
				<hr>
				<div class="panel panel-default">
					<div class="panel-heading">最近の出品リスト</div>
					<div class="panel-body">
						<ul class="list-inline">
							<?php for ($i=0; $i<$count; $i++): ?>
							<li><div class="thumb">
								<a href="<?php echo h(root_url("/illustrations/display/display.php?id={$image[$i]->getId()}")); ?>">
									<img src="<?php echo h(root_url("/illustrations/display/image_view.php?filename={$image[$i]->getFilenameThumb()}&mime={$image[$i]->getMime()}&user_id={$image[$i]->getUserId()}")); ?>" width="<?php echo h($new_w[$i]); ?>" height="<?php echo h($new_h[$i]); ?>">
								</a></div>
							</li>
							<?php endfor; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/view/layout/footer.php')); ?>

</body>
</html>