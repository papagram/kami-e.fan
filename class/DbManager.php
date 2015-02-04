<?php

class DbManager
{
	protected $dbh = null;

	public function __construct($dsn, $db_user, $db_password)
	{
		try{
			$dbh = new PDO($dsn, $db_user, $db_password);
			$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $this->dbh = $dbh;
		} catch (PDOException $e){
			echo 'ただいま障害により大変ご迷惑をお掛け致しております。';
			exit;
		}
	}
	
	public function __destruct()
	{
		$this->dbh = null;
	}
}