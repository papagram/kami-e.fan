<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="http://<?php echo h($_SERVER['HTTP_HOST']); ?>/index.php">
				<?php echo h(BRAND_NAME); ?>
			</a>
		</div>
		<ul class="nav navbar-nav pull-right">
			<li>
				<a href="http://<?php echo h($_SERVER['HTTP_HOST']); ?>/illustrations/admin/upload_new_illustration.php">upload</a>
			</li>
		</ul>
	</div>
</nav>