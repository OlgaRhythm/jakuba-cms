<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . DIR_CORE . "/db.php");

class DBEdit extends DB {

    public function authentication($login, $password) {
        $passhash = md5($password);
        if (isset($this->select("Users", ["id"], ["login" => $login, "password" => $passhash])[0]["id"])) {
            return true;
        }
    }

}