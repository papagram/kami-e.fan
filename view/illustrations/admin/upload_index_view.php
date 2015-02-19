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
			<div class="col col-md-5">
				<div>
					<form action="<?php echo h(root_url('/illustrations/admin/upload_action.php')); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
						<legend>アップロード</legend>
						<fieldset>
							<span class="required-msg"></span>
							<div class="input-file-padding">
								<input type="file" name="new_illust" value="" class="required-file">
							</div>
							<?php foreach ($err_msg as $msg): ?>
								<li><?php echo h($msg); ?></li>
							<?php endforeach; ?>
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h($max_file_size); ?>">
							<input type="hidden" value="<?php echo h($token); ?>" name="token">
							<button type="submit" class="btn btn-primary" id="file-upload">アップロードする</button>
						</fieldset>
					</form>
				</div>
				<div class="col col-md-4"></div>
			</div>
		</div>
	</div>

	<?php require_once (doc_root('/view/layout/footer.php')); ?>

</body>
</html>