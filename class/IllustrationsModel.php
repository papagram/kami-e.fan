<?php

// ▼ classファイルを読み込む
require_once(doc_root('/class/DbManager.php'));

class IllustrationsModel extends DbManager
{
	private $last_insert_id = 0;

	public function findById ($id)
	{
		$sql = 'SELECT i.id,
					i.title,
					i.price,
					i.created_at,
					i.user_id,
					i.filename,
					i.filename_thumb,
					i.mime,
					u.name,
					u.email
				FROM illustrations AS i 
					JOIN users AS u 
				ON i.user_id = u.id 
					WHERE i.id = :id';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $rec) {
			throw new NotFoundException('');
		}
		
		return $rec;
	}
	
	public function countMax ()
	{
		$sql = 'SELECT COUNT(id) AS max FROM illustrations';
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $count['max'];
	}
	
	/**
	 * ▼ 新着イラストを$per_pageの数だけ取得 降順
	 */
	public function findByPerPage ($per_page, $offset)
	{
		$sql = 'SELECT * FROM illustrations ORDER BY id DESC 
					LIMIT :per_page OFFSET :offset';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function findLimit ()
	{
		$limit = 5;
		
		$sql = 'SELECT * FROM illustrations ORDER BY id DESC limit :limit';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function findByUserId ($user_id)
	{
		$sql = 'SELECT * FROM illustrations WHERE user_id = :user_id ORDER BY id DESC';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function insert ($user_id, $original, $thumb, $finfotype)
	{
		 try {
		 	$this->dbh->beginTransaction();
		 	
			$sql = 'INSERT INTO illustrations 
						(created_at,
							user_id,
							filename,
							filename_thumb,
							mime) 
					VALUES(now(),
							:user_id,
							:filename,
							:filename_thumb,
							:mime)';
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':filename', $original, PDO::PARAM_STR);
			$stmt->bindValue(':filename_thumb', $thumb, PDO::PARAM_STR);
			$stmt->bindValue(':mime', $finfotype, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			if (! $count) {
				throw new PDOException('DB ERROR:もう一度やり直して下さい。');
			}
		 	
			$this->last_insert_id = $this->dbh->lastInsertId();
		 	$this->dbh->commit();
		 } catch (PDOException $e) {
		 	$this->dbh->rollBack();
			$_SESSION['upload_new_illust']['flg'] = false;
			$_SESSION['upload_new_illust']['err_msg'][] = $e->getMessage();
			redirect('/illustrations/admin/upload_new_illustration.php');
		 }
	}
	
	public function getLastInsertId ()
	{
		return $this->last_insert_id;
	}
	
	public function update ($posts, $user_id)
	{
		try {
			$this->dbh->beginTransaction();

			$sql = 'UPDATE illustrations 
						SET title = :title, price = :price 
					WHERE id = :id AND user_id = :user_id';
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':title', $posts['title'], PDO::PARAM_STR);
			$stmt->bindValue(':price', (int)$posts['price'], PDO::PARAM_INT);
			$stmt->bindValue(':id', (int)$posts['id'], PDO::PARAM_INT);
			$stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->rowCount();
			if (! $count) {
				throw new PDOException('DB ERROR:もう一度やり直して下さい。');
			}
			
			$this->dbh->commit();
		} catch (PDOException $e) {
		 	$this->dbh->rollBack();
			$_SESSION['update_illust']['flg'] = false;
			$_SESSION['update_illust']['err_msg'][] = $e->getMessage();
			$_SESSION['update_illust']['input_title'] = $_POST['title'];
			$_SESSION['update_illust']['input_price'] = $_POST['price'];
			redirect('/illustrations/admin/update_illustration.php?id=' . (int)$posts['id']);
		}
	}
	
	public function delete ($id, $user_id)
	{
		try {
			$this->dbh->beginTransaction();
			
			$sql = 'DELETE FROM illustrations WHERE id = :id AND user_id = :user_id';
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
			$stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->rowCount();
			if (! $count) {
				throw new PDOException('');
			}
			
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			redirect('/illustrations/admin/index.php');
		}
	}
}