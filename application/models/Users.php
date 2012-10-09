<?php

class UsersModel extends Model {

    public function getAllUsers() {
        $this->st = $this->db->query('SELECT name FROM users');
        $this->st->setFetchMode(PDO::FETCH_OBJ);
        $users = array();
        while($row = $this->st->fetch()) {
            array_push($users, $row->name);
        }

        return $users;
    }

}