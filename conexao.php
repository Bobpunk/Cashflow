<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$arquivoConfig ='database.ini';

if (!file_exists($arquivoConfig)) {
    die("Erro Critico: O arquivo de condiguração '$arquivoConfig' não foi encontrado");
}

$config = parse_ini_file($arquivoConfig);

try{
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";    


$pdo = new PDO ($dsn,$config["user"], $config["password"]);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die ("Erro de conexão". $e->getMessage());
}