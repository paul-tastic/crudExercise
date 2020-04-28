<?php

class User {

    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $modified_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $sql = "SELECT * FROM {$this->table} WHERE id=? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->modified_at = $row['modified_at'];
    }

    public function create() {
        $sql = "INSERT INTO {$this->table}
                SET username = :username,
                    password = :password,
                    first_name = :first_name,
                    last_name = :last_name
                ";
        $stmt = $this->conn->prepare($sql);
        //clean and sanitize data
        $this->username = htmlspecialchars(strip_tags(($this->username)));
        $this->password = htmlspecialchars(strip_tags(($this->password)));
        $this->first_name = htmlspecialchars(strip_tags(($this->first_name)));
        $this->last_name = htmlspecialchars(strip_tags(($this->last_name)));
        $stmt->bindParam('username', $this->username);
        $stmt->bindParam('password', $this->password);
        $stmt->bindParam('first_name', $this->first_name);
        $stmt->bindParam('last_name', $this->last_name);

        if($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update() {
        $sql = "UPDATE {$this->table}
                SET username = :username,
                    password = :password,
                    first_name = :first_name,
                    last_name = :last_name
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        //sanitize data
        $this->username = htmlspecialchars(strip_tags(($this->username)));
        $this->password = htmlspecialchars(strip_tags(($this->password)));
        $this->first_name = htmlspecialchars(strip_tags(($this->first_name)));
        $this->last_name = htmlspecialchars(strip_tags(($this->last_name)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $stmt->bindParam('username', $this->username);
        $stmt->bindParam('password', $this->password);
        $stmt->bindParam('first_name', $this->first_name);
        $stmt->bindParam('last_name', $this->last_name);
        $stmt->bindParam('id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $stmt->bindParam('id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}