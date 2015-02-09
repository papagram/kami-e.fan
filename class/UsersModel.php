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
		$user = $stmt->fetch(PDO::FETCH_ASSOC);ß
		if (! $user) {
			throw new UserNotFoundException('ログインに失敗しました。');
		}
		
		return $user;
	}
}