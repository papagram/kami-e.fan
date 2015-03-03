<!DOCTYPE html>
<html lang="ja">

<?php require (doc_root('/view/layout/head.php')); ?>

<body>
	<?php require (doc_root('/view/layout/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-5">
				<div class="display">
					<img src="<?php echo h(root_url("/illustrations/display/image_view.php?filename={$image->getFilename()}&mime={$image->getMime()}&user_id={$image->getUserId()}")); ?>" width="<?php echo h($new_w); ?>" height="<?php echo h($new_h); ?>">
				</div>
			</div>
			<div class="col col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">イラスト情報</div>
					<div class="panel-body">
						<p>タイトル： <?php echo h($image->getTitle()); ?></p>
						<p>価格： <?php echo h($image->getPrice()); ?>円</p>
						<p>登録日： <?php echo h($image->getCreatedAt()); ?></p>
					</div>
				</div>
			</div>
			<div class="col col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">出品者</div>
					<div class="panel-body">
						<p><?php echo h($image->getName()); ?></p>
						<p><?php echo h($image->getEmail()); ?></p>
						<p>購入希望、イラストに関する質問等は上記のアドレスまでお問い合わせ下さい。</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require (doc_root('/view/layout/footer.php')); ?>

</body>
</html>