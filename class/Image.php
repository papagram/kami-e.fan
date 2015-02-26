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
}