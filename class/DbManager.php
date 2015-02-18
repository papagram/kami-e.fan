<?php

// ▼ DBの設定ファイルを読み込む
require_once(doc_root('/config/db_config.php'));

class DbManager
{
	protected $dbh = null;

	public function __construct($dsn, $db_user, $db_password)
	{
		$dbh = new PDO($dsn, $db_user, $db_password);
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $this->dbh = $dbh;
	}
	
	public function __destruct()
	{
		$this->dbh = null;
	}
}