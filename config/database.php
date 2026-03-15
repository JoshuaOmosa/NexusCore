<?php


$host = 'localhost';
$db   = 'nexus_core';
$user = 'root';
$pass = ''; 

try {
    // We define $pdo here
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // This makes sure the variable is available globally
    $GLOBALS['pdo'] = $pdo; 
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}