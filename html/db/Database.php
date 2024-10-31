<?php

namespace db;

use config\DBConfig;
use mysqli;
use mysqli_sql_exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/DBConfig.php';

class Database {
    private static $instance;
    private mysqli $connection;

    /**
     * Get instance of `Database` object.
     * @return self
     */
    public static function getInstance() : Database {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->connection = new mysqli(DBConfig::HOST, DBConfig::USER, DBConfig::PASSWORD, DBConfig::DBNAME);
            $this->connection->set_charset(DBConfig::CHARSET);
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    private function __clone() {}

    /**
     * Get a connection to the database for custom use.
     * @return mysqli
     */
    public function getConnection() : mysqli {
        return $this->connection;
    }
}