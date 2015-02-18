<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/DbManager.php'));

class UsersModel extends DbManager
{
	private $last_insert_id = 0;

	public function findUserByEmail ($email)
	{
		$sql = 'SELECT * FROM users WHERE email = :email';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetch(PDO::FETCH_ASSOC);;
	}
	
	public function registUser ($name, $email, $password, $regist_flg, $activation_key)
	{
		$sql = 'INSERT INTO users 
					(name,
						email,
						password,
						regist_flg,
						activation_key,
						created_at) 
				VALUES(:name,
						:email,
						:password,
						:regist_flg,
						:activation_key,
						now())';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':password', $password, PDO::PARAM_STR);
		$stmt->bindValue(':regist_flg', $regist_flg, PDO::PARAM_INT);
		$stmt->bindValue(':activation_key', $activation_key, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if (! $count) {
			return false;
		}
		
		$this->last_insert_id = $this->dbh->lastInsertId();
	}

	public function getLastInsertId ()
	{
		return $this->last_insert_id;
	}
	
	public function exsistEmail ($email)
	{
		$sql = 'SELECT count(*) AS count FROM users WHERE email = :email';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->fetchColumn();
		
		return ($count === '0') ? true : false;
	}
}