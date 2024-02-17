<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . "/" . "jakuba" . "/db.php");

/**
 * Создание таблиц, необходимых для работы системы
 */
class CreatorDBTables extends DB {

    public function __construct( $name,  $user, string $password, string $host = "localhost") { 
        parent::__construct( $name,  $user,  $password,  $host);
    }

    /**
     * Создание нужных таблиц
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     */
    public function createTables(string $name, string $login, string $password) {
        // создание массива с именами таблиц и их полями
        $tables = array (
            0 => array ("name" => "Blocks", "fields" => "id integer auto_increment primary key, content longtext, type integer not null"), // таблица блоков
            1 => array ("name" => "Users", "fields" => "id integer auto_increment primary key, name varchar(45), login varchar(45), password varchar(45)"), // таблица пользователей, которые могут авторизоваться
            2 => array ("name" => "MetaBlocks", "fields" => "id integer auto_increment primary key, content longtext, path varchar(100), name varchar(100), description longtext"), // таблица метаблоков
            3 => array ("name" => "Pages", "fields" => "id integer auto_increment primary key, title text, url varchar(45), blocks varchar(45)"), // таблица страниц
            4 => array ("name" => "TypesOfBlocks", "fields" => "id integer auto_increment primary key, name text, description text, type varchar(45), path text"), // таблица типов блоков
            //5 => array ("name" => "Media", "fields" => "id integer auto_increment primary key, title varchar(45), title_alt varchar(45), type varchar(45), url varchar(45), hyperlink varchar(45)"),
        );
        // запрос к базе данных для создания заданных таблиц
        foreach ($tables as $table) {
            $this->createTable($table["name"], $table["fields"]);
        }
        // добавить пользователя с правами администратора
        $passhash = md5($password);
        $this->insert("Users", ["name" =>  $name, "login" => $login, "password" => $passhash]);
    }

}