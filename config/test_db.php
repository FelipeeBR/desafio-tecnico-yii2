<?php
$db = require __DIR__ . '/db.php';
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=db_gerencia',
    'username' => 'admin',
    'password' => 'admin123',
    'charset' => 'utf8',
];

