<?php

class UsersModel extends Model {

	public function getAllUsers() {
		$st = $this->db->query('SELECT name FROM users');
		$st->setFetchMode(PDO::FETCH_OBJ);
		$users = array();
		while($row = $st->fetch()) {
			array_push($users, $row->name);
		}

		return $users;
	}

}