<?php

// ▼ classファイルを読み込む
require_once(doc_root() . '/class/DbManager.php');

class UsersModel extends DbManager
{
	public function findUserByEmail ($posts)
	{
		try {
			// emailでユーザーをfetch　その処理を書く
			$sql = 'SELECT * FROM users WHERE email = :email';
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':email', $posts['email'], PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (! $user) {
				throw new UserNotFoundException();
			}
			
			if ($this->validatePassword($posts['password'], $user['password'])) {
				// ./illustrations/admin/index.phpへ
			}
		} catch (UserNotFoundException $e) {
			// 失敗したらログインページへ戻す
		}
	}
	
	private function validatePassword ($post_password, $db_password)
	{
		try {
			$crypt_password = crypt_password($post_password); // 関数作る
			if ($crypt_password !== $db_password) {
				throw new InvalidPasswordException();
			}
			
			return true;
		} catch (InvalidPasswordException $e) {
			// 失敗したらログインページへ戻す
		}
	}
}