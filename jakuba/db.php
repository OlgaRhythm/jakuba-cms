<?php
/**
 * Соединение с базой данной и работа с запросами
 */
class DB {
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbHost;
    private $pdo;

    public function getPDO() {
        return $this->pdo;
    }

    public function test() {
        return "Ok";
    }

    public function __construct(string $name, string $user, string $password, string $host = "localhost") {
        $this->dbName = $name;
        $this->dbUser = $user;
        $this->dbPassword = $password;
        $this->dbHost = $host;

        $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName}";
        $this->pdo = new PDO($dsn, $this->dbUser, $this->dbPassword);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Добавление записи в базу данных.
     * Принимает имя таблицы и параметры, которые представляют собой массив, 
     * где ключ - название столбца, а значение по ключу - содержимое поля.
     */
    public function insert( string $tableName, array $params) {
        $columns = implode(', ', array_keys($params));
        $values = implode(', ', array_fill(0, count($params), '?'));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($params));
        return $this->pdo->lastInsertId();
    }

     /**
     * Обновление записи в базе данных.
     * Принимает имя таблицы, параметры (массив, где ключ - название столбца, значение - содержимое), 
     * условия (массив, где ключ - название столбца, значение - содержимое, объединяются с помощью AND) и
     * условия в виде строки (составленного по правилам SQL).
     */
    public function update(string $tableName, array $params, array $conditions, string $conditionString="") {
        if (count($conditions) < 1 && $conditionString=="") {
            return "";
        }
        $setKeys = [];
        foreach ($params as $key => $value) {
            $setKeys[] = "$key = ?";
        }
        $setKeys = implode(', ', $setKeys);

        $sql = "UPDATE $tableName SET $setKeys" . $this->getConditionWhere($conditions, $conditionString);
     
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array_values($params));
        
        return $stmt->rowCount();
    }

    /**
     * Удаление записи в базе данных.
     * Принимает имя таблицы,
     * условия (массив, где ключ - название столбца, значение - содержимое, объединяются с помощью AND) и
     * условия в виде строки (составленного по правилам SQL).
     */
    public function delete(string $tableName, array $conditions = [], string $conditionString="") {
        $sql = "DELETE FROM " . $tableName . $this->getConditionWhere($conditions, $conditionString);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    } 

     /**
     * Вывод записей из базы данных.
     * Принимает имя таблицы,
     * название столбцов,
     * условия (массив, где ключ - название столбца, значение - содержимое, объединяются с помощью AND) и
     * условия в виде строки (составленного по правилам SQL).
     */
    public function select(string $tableName, array $columns, array $conditions=[], string $conditionString="") {
        $columnsString = implode(', ', $columns);
       
        $sql = "SELECT $columnsString FROM $tableName" . $this->getConditionWhere($conditions, $conditionString);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();  
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Вывод записей из базы данных.
     * Позволяет получать содержимое базы данных с помощью запроса, написанного по правилам SQL, 
     * и параметров.
     */
    public function sqlExecute(string $sql, array $params=[]) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConditionWhere(array $conditions=[], string $conditionString="") {
        if (count($conditions) < 1 && $conditionString=="") {
            return "";
        }
        $setConditions = [];
        foreach ($conditions as $key => $value) {
            if (is_int($value)) {
                $setConditions[] = "$key = $value";
            } else {
                $setConditions[] = "$key = \"$value\"";
            }
        }
        $conditionsWhere = implode(' AND ', $setConditions);

        if ($conditionString != "") $conditionsWhere .= " " . $conditionString;

        if ($conditionsWhere == " ") {
           return "";
        }
        else {
           return " WHERE " . $conditionsWhere;
        }
    }

}