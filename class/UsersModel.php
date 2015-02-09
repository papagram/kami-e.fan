<?php

// ▼ classファイルを読み込む
require_once(doc_root() . '/class/DbManager.php');

class UsersModel extends DbManager
{
	public function Authenticate ($posts)
	{
		try {
			$sql = 'SELECT * FROM users WHERE email = :email';
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':email', $posts['email'], PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (! $user) {
				throw new UserNotFoundException('ログインに失敗しました。');
			}
			
			// ▼ POSTで渡されたパスワードを照合
			if (! password_verify($posts['password'], $user['password'])) {
				throw new UserNotFoundException('ログインに失敗しました。');
			}
			redirect('/illustrations/admin/index.php');
		} catch (UserNotFoundException $e) {
			$_SESSION['login']['flg'] = false;
			$_SESSION['login']['err_msg'][] = $e->getMessage();
			$_SESSION['login']['input_email'] = $_POST['email'];
			redirect('/auth/login.php');
		}
	}
}