<!DOCTYPE html>
<html lang="ja">

<?php require (doc_root('/common_html/head.php')); ?>

<body>
	<?php require (doc_root('/common_html/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-10">
				<div>
					<img src="<?php echo $image[0]; ?>" width="<?php echo h($image[1]); ?>" height="<?php echo h($image[2]); ?>">
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<p>タイトル： <?php echo h($rec['title']); ?></p>
						<p>価格： <?php echo h($rec['price']); ?>円</p>
						<p>登録日： <?php echo h($rec['created_at']); ?></p>
					</div>
				</div>
			</div>
			<div class="col col-md-2">
				出品者： <?php echo h($rec['name']); ?>
			</div>
		</div>
	</div>

	<?php require (doc_root('/common_html/footer.php')); ?>

</body>
</html>