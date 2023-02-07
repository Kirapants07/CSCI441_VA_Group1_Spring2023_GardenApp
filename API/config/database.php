<?php 

  if(!defined('MyConst')) {
      die('Direct access not permitted');
  }

  class Database {
    
    /// When creating a new instance of this class. Always provide the name of the database
    /// For this project, two options exist: userAdmin, plantData

    public $conn;
    private $dbName;

    //constructor with $db as database connection
    public function __construct($databaseName = null) {
        $this->dbName = $databaseName; // <- should have passed in the ADMIN db connection
    }

    // DB Connect
    public function connect() {

        $host = 'localhost';
        $username = 'TestUser';
        $password = '123456';

        $this->conn = null;

        try { 
            $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $this->dbName, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

      return $this->conn;
    }

    // DB Connect
    public function createDatabase() {

        $host = 'localhost';
        $username = 'TestUser';
        $password = '123456';

        $this->conn = null;

        try { 
            $this->conn = new PDO('mysql:host=' . $host, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

      return $this->conn;
    }
  }