<?php

  class Database {

    private $conn;

    public function __construct(array $dbParams) {
      $this->conn = mysqli_connect($dbParams['host'],$dbParams['dbUser'],$dbParams['dbPass'],$dbParams['dbName'],$dbParams['dbPort']);
    }

    public function query(string $sql) {
      return $this->conn->query($sql);
    }

    public function __destruct() {
      mysqli_close($this->conn);
    }

  }
