<?php

/**
 * ▼ classファイルを読み込む
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/class/DbManager.php');

class IllustrationsModel extends DbManager
{
	public function findById($id)
	{
		$sql = 'SELECT * FROM illustrations WHERE id = :id';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if (! $rec) {
			throw new NotFoundException('');
		}
		
		return $rec;
	}
}