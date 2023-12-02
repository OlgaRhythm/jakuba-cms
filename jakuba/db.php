<?php

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

    public function insert( string $tableName, array $params) {
        $columns = implode(', ', array_keys($params));
        $values = implode(', ', array_fill(0, count($params), '?'));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($params));
        return $this->pdo->lastInsertId();
    }

    public function update(string $tableName, array $params, array $conditions, string $conditionString="") {
        $setKeys = [];
        foreach ($params as $key => $value) {
            $setKeys[] = "$key = ?";
        }
        $setKeys = implode(', ', $setKeys);

        $sql = "UPDATE $tableName SET $setKeys" . $this->getConditionWhere($conditions, $conditionString);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete(string $tableName, array $conditions = [], string $conditionString="") {
        $sql = "DELETE FROM " . $tableName . $this->getConditionWhere($conditions, $conditionString);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function select(string $tableName, array $columns, array $conditions=[], string $conditionString="") {
        $columnsString = implode(', ', $columns);
       
        $sql = "SELECT $columnsString FROM $tableName" . $this->getConditionWhere($conditions, $conditionString);
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();  
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sqlExecute(string $sql, array $params=[]) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getConditionWhere(array $conditions=[], string $conditionString="") {
        foreach ($conditions as $key => $value) {
            $setConditions[] = "$key = \"$value\"";
        }
        $conditionsWhere = implode(' AND ', $setConditions);

        if ($conditionString) $conditionsWhere .= " " . $conditionString;

        if ($conditionsWhere == " ") {
           return "";
        }
        else {
           return " WHERE " . $conditionsWhere;
        }
    }

}