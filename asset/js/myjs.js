// モーダル起動
$ (function() {
	$ ('#modal-start').on ('click', function() {
		$ ('#modal').modal();
		return false;
	});
});