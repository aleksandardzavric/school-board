<?php

  class Database {

    private $conn;

    public function __construct(array $dbParams) {
      $this->conn = mysqli_connect($dbParams['host'],$dbParams['dbUser'],$dbParams['dbPass'],$dbParams['dbName'],$dbParams['dbPort']);
    }

    public function query(string $sql, ?string $types = null, ...$params) {
      $stmt = $this->conn->prepare($sql);
      if (!is_null($types)) {
        $stmt->bind_param($types,...$params);
      }
      $stmt->execute();
      $results = $stmt->get_result();
      $stmt->close();
      return $results;
    }

    public function __destruct() {
      mysqli_close($this->conn);
    }

  }
