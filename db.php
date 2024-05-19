<?php
$host = 'localhost';
$db = 'phptest';
$user = 'amir';
$pass = '1234';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

function init($pdo) {
    $userssql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $actionssql = "
    CREATE TABLE IF NOT EXISTS useractions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        description VARCHAR(50) NULL
    );";
    $servicessql = "
    CREATE TABLE IF NOT EXISTS userservices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        description VARCHAR(50) NULL,
        service_name VARCHAR(50),
        service_cred VARCHAR(100)

    );";
    $requestssql = "
    CREATE TABLE IF NOT EXISTS requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        description VARCHAR(50) NULL,
        size INT
    );";
    $invoicessql = "
    CREATE TABLE IF NOT EXISTS invoice (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        description VARCHAR(50) NULL,
        size INT
    );";
    $servicesql="
     CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(50),
        description VARCHAR(50) NULL,
        price INT
    );";
    try {
        $pdo->exec($userssql);
        $pdo->exec($actionssql);
        $pdo->exec($servicessql);
        $pdo->exec($requestssql);
        echo "Database initialized successfully!";
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {

init($pdo);
}