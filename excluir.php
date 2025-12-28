<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'protecao.php';
require 'conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); //pega o id da url

// modulo de segurança para verificar se o id existe

if (!empty( $id )) {
    //comando da morte
    $sql = "DELETE FROM movimentacoes WHERE id = :id";
    $stmt = $pdo->prepare( $sql );

    //executa o comando da morte
    $stmt -> execute([ ':id' => $id]);
}
//retorna para o index
header("Location: index.php");

exit; 