<?php

namespace db;

use config\DBConfig;
use mysqli;

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
        $this->connection = new mysqli(DBConfig::HOST, DBConfig::USER, DBConfig::PASSWORD, DBConfig::DBNAME);
        $this->connection->set_charset(DBConfig::CHARSET);
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