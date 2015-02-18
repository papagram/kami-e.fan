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
				<h1><?php echo h($err_msg); ?></h1>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/view/layout/footer.php')); ?>

</body>
</html>