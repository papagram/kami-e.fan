<?php

class Pager
{
	private $per_page = 5; // 1ページ当たりの表示件数
	private $first_page = 1;
	private $last_page = 0;
	private $current_page = 0;
	private $offset = 0; // select時にoffsetする数
	private $prev = 0;
	private $next = 0;
	private $active = 'active'; // Bootstrap 現在ページの数字に色をつけるためのクラス名
	
	public function __construct ($count_max)
	{
		// ▼ 最終ページを取得
		$this->last_page = ($count_max % $this->per_page === (int)0) ? $count_max / $this->per_page : floor($count_max / $this->per_page + 1);
		
		// ▼ URLパラメータをチェック 現在ページを特定 パラメータ無しは1ページ目とする
		if (isset($_GET['page'])) {
			if (ctype_digit($_GET['page']) && $_GET['page'] <= $this->last_page && $_GET['page'] > (int)0) {
				$this->current_page = (int)$_GET['page'];
			} else {
				throw new GetParamErrorException('');
			}
		} else {
			$this->current_page = 1;
		}
		
		// ▼ select時にoffsetする数を計算
		$this->offset = ($this->current_page - 1) * $this->per_page;
		
		// ▼ 前ページと次ページを計算
		$this->prev = ($this->current_page !== $this->first_page) ? $this->current_page - 1 : $this->first_page;
		$this->next = ($this->current_page !== $this->last_page) ? $this->current_page + 1 : $this->last_page;
	}
	
	public function getPerPage ()
	{
		return $this->per_page;
	}
	
	public function getFirstPage ()
	{
		return $this->first_page;
	}
	
	public function getLastPage ()
	{
		return $this->last_page;
	}
	
	public function getCurrentPage ()
	{
		return $this->current_page;
	}
	
	public function getOffset ()
	{
		return $this->offset;
	}
	
	public function getPrev ()
	{
		return $this->prev;
	}
	
	public function getNext ()
	{
		return $this->next;
	}
	
	public function getActive ()
	{
		return $this->active;
	}
}