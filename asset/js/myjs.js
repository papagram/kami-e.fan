// モーダル起動
$ (function() {
	$ ('#modal-start').on ('click', function() {
		$ ('#modal').modal();
		return false;
	});
});

// イラストタイトル　文字数カウント
$(function(){
	var countmax = 30;
	$('#title').bind('keydown keyup keypress change', function(){
		var thisValueLength = $(this).val().length;
		var countdown = (countmax) - (thisValueLength);
		$('#title_conut').text("あと" + countdown + "文字");
		
		if (countdown < 0)
		{
			$('#title_conut').css({
				"color" : "#ff0000",
				"fontweight" : "bold"
			}).text("文字数オーバー");
		}
	});
	$(window).load(function(){
		$('#title_conut').text(countmax + "文字まで");
	});
});

// 必須項目チェック
$(function(){
	$('.required-check').bind('keydown keyup keypress change', function(){
		var index = $('.required-check').index(this);
		if ($(this).val() != '') {
			$('.required-msg').eq(index).text('');
		}
	}).blur(function(){
		var index = $('.required-check').index(this);
		if ($(this).val() == '') {
			$('.required-msg').eq(index).css({
				"color" : "#ff0000",
				"fontweight" : "bold"
			}).text("必須項目です");
		}
	});
});

// ファイルアップロードチェック
$(function(){
	$('#file-upload').click(function(){
		$('.required-msg').text('');
		if ($('.required-file').val() == '') {
			$('.required-msg').css({
				"color" : "#ff6347",
				"fontweight" : "bold"
			}).text('ファイルを選択して下さい。');
			return false;
		}
	});
});