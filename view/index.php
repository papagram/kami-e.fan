<!DOCTYPE html>
<html lang="ja">

<?php require ($_SERVER['DOCUMENT_ROOT'] . '/common_html/head.php'); ?>

<body>
	<?php require ($_SERVER['DOCUMENT_ROOT'] . '/common_html/header.php'); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-2">
				<span>メニュー</span>
			</div>
			<div class="col col-md-10">
				<?php for ($i=0; $i<$count; $i++): ?>
					<img src="data: <?php echo h($rec[$i]['mime'])?>; base64, <?php echo $images[$i]; ?>">
				<?php endfor; ?>
			</div>
		</div>
	</div>

	<?php require ($_SERVER['DOCUMENT_ROOT'] . '/common_html/footer.php'); ?>

</body>
</html>