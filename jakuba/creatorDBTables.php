<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . "jakuba" . "/db.php");

class CreatorDBTables extends DB {

public function __construct( $name,  $user, string $password, string $host = "localhost") { 
    parent::__construct( $name,  $user,  $password,  $host);
}

    /**
     * Проверка, существуют ли нужные таблицы в базе данных
     */
    /*
    public function is_tables_exist() {
        $tables = array ("Blocks", "Media", "MetaBlocks", "Pages", "TypesOfBlocks", "Users"); // список таблиц
        $sql = "SHOW TABLES LIKE '%" . implode("','", $tables) . "%'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) > 0;
    }*/

    /**
     * Создание нужных таблиц
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     */
    public function createTables(string $login, string $password) {

        // создание массива с именами таблиц и их полями
        $tables = array (
            0 => array ("name" => "Test", "fields" => "id integer auto_increment primary key, name varchar(30), age integer")
            /*
            0 => array ("name" => "Blocks"),
            1 => array ("name" => "Media"),
            2 => array ("name" => "MetaBlocks"),
            3 => array ("name" => "Pages"),
            4 => array ("name" => "TypesOfBlocks"),
            5 => array ("name" => "Users"),*/
        );
        // запрос к базе данных для создания заданных таблиц
        foreach ($tables as $table) {
            $this->createTable($table["name"], $table["fields"]);
        }
        
    }

}