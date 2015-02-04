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
					<a href="./show_illustration.php?id=<?php echo h($rec[$i]['id']); ?>">
						<img src="<?php echo $images[$i]; ?>">
					</a>
				<?php endfor; ?>
				<div>
				<ul class="pagination pagination-sm">
					<li>
						<a href="<?php echo h($_SERVER['SCRIPT_NAME']) . '?page=' . h($prev); ?>">&laquo;</a>
					</li>
					<?php for ($i=$first_page; $i<=$last_page; $i++): ?>
						<li class="<?php echo ($current_page === $i) ? h($active) : ''; ?>">
							<a href="<?php echo h($_SERVER['SCRIPT_NAME']) . '?page=' . h($i); ?>"><?php echo h($i); ?></a>
						</li>
					<?php endfor; ?>
					<li>
						<a href="<?php echo h($_SERVER['SCRIPT_NAME']) . '?page=' . h($next); ?>">&raquo;</a>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</div>

	<?php require ($_SERVER['DOCUMENT_ROOT'] . '/common_html/footer.php'); ?>

</body>
</html>