<!DOCTYPE html>
<html lang="ja">

<?php require (doc_root('/view/layout/head.php')); ?>

<body>
	<?php require (doc_root('/view/layout/header.php')); ?>

	<div class="container">
		<div class="row">
			<div class="col col-md-5">
				<div>
					<img src="<?php echo $image[0]; ?>" width="<?php echo h($image[1]); ?>" height="<?php echo h($image[2]); ?>">
				</div>
			</div>
			<div class="col col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">イラスト情報</div>
					<div class="panel-body">
						<p>タイトル： <?php echo h($rec['title']); ?></p>
						<p>価格： <?php echo h($rec['price']); ?>円</p>
						<p>登録日： <?php echo h($rec['created_at']); ?></p>
					</div>
				</div>
			</div>
			<div class="col col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">出品者</div>
					<div class="panel-body">
						<p>名　前： <?php echo h($rec['name']); ?></p>
						<p>メール： <?php echo h($rec['email']); ?></p>
						<p>このイラストが欲しいという方は上記のアドレスにメールして下さい。</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require (doc_root('/view/layout/footer.php')); ?>

</body>
</html>