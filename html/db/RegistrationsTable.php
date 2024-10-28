<?php

namespace db;

use mysqli;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Registration.php';

class RegistrationsTable
{
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }
}