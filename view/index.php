<!DOCTYPE html>
<html lang="ja">

<?php require (doc_root() . '/common_html/head.php'); ?>

<body>
	<?php require (doc_root() . '/common_html/header.php'); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<span>メニュー</span>
			</div>
			<div class="col col-md-10">
				<?php for ($i=0; $i<$count; $i++): ?>
					<a href="./illustrations/show_illustration.php?id=<?php echo h($rec[$i]['id']); ?>">
						<img src="<?php echo h($images[$i]); ?>">
					</a>
				<?php endfor; ?>
				<div>
					<a href="./illustrations/new_arrival.php" class="pull-right">more</a>
				</div>
			</div>
		</div>
	</div>

	<?php require (doc_root() . '/common_html/footer.php'); ?>

</body>
</html>