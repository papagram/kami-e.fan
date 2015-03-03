<?php

class Image
{
	private $id = 0;
	private $title = '';
	private $price = 0;
	private $created_at = '';
	private $user_id = 0;
	private $filename = '';
	private $filename_thumb = '';
	private $mime = '';
	private $name = '';
	private $email = '';
	
	public function __construct($rec)
	{
		$this->id = (int)$rec['id'];
		$this->title = $rec['title'];
		$this->price = (int)$rec['price'];
		$this->created_at = $rec['created_at'];
		$this->user_id = (int)$rec['user_id'];
		$this->filename = $rec['filename'];
		$this->filename_thumb = $rec['filename_thumb'];
		$this->mime = $rec['mime'];
		$this->name = (isset($rec['name'])) ? $rec['name'] : '';
		$this->email = (isset($rec['email'])) ? $rec['email'] : '';
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getPrice()
	{
		return $this->price;
	}
	
	public function getCreatedAt()
	{
		return $this->created_at;
	}
	
	public function getUserId()
	{
		return $this->user_id;
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
	
	public function getFilenameThumb()
	{
		if (!$this->filename_thumb) {
			return $this->filename;
		}
		
		return $this->filename_thumb;
	}
	
	public function getMime()
	{
		return $this->mime;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getImageSize($filename)
	{
		// ▼ 画像ファイルんパスを特定
		if (mb_strpos($filename, '_s.') === false) {
			$image =  doc_root("/../images/{$this->user_id}/illustrations/original/{$this->filename}");
		} else {
			$image =  doc_root("/../images/{$this->user_id}/illustrations/thumb/{$this->filename_thumb}");
		}
		
		// ▼ 画像ファイルが存在しなければ・・・
		if (!file_exists($image)) {
			$image = doc_root('/../images/common/no_image.gif');
		}

		return getimagesize($image);
	}
	
	public function getNewImageSize($w, $h, $max_w, $max_h)
	{
		$new_w = $w;
		$new_h = $h;
		
		// ▼ 原寸幅が最大幅より大きい　かつ　原寸高さよりも原寸幅が大きい
		if ($w > $max_w && $w > $h)
		{
			$new_w = $max_w;
			$new_h = round($h * $max_w / $w);
		}
		
		// ▼ 原寸高さが最大高さより大きい　かつ　原寸幅よりも原寸高さが大きい
		if ($h > $max_h && $h >= $w)
		{
			$new_h = $max_h;
			$new_w = round($w * $max_h / $h);
		}
		
		return array($new_w, $new_h);
	}
	
	public function getImagePath($type)
	{
		if (!isset($type)) {
			echo '引数エラー';
			exit;
		}
		
		if ($type === 'original') {
			$path = doc_root("/../images/{$this->user_id}/illustrations/original/{$this->filename}");
		}
		
		if ($type === 'thumb') {
			$path = doc_root("/../images/{$this->user_id}/illustrations/thumb/{$this->filename_thumb}");
		}
		
		return $path;
	}
}