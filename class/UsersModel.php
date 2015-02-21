<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/DbManager.php'));

class UsersModel extends DbManager
{
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
						created_at) 
				VALUES(:name,
						:email,
						:password,
						now())';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':password', $password, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if (!$count) {
			return false;
		}
		
		return array('id' => $this->dbh->lastInsertId(), 'name' => $name, 'email' => $email);
	}
	
	public function exsistEmail ($email)
	{
		$sql = 'SELECT count(*) AS count FROM users WHERE email = :email';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->fetchColumn();
		if (!is_int($count)) {
			$count = (int)$count;
		}
		
		return ($count === 0) ? true : false;
	}
}