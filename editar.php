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

//logs para detectar erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// pega o id da url

$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT); // Garante que puxe o int id

if (!$id){
    header ('Location:index.php');
    exit;
}

// busca os dados antigos

$sqlBusca = "SELECT * FROM movimentacoes WHERE id=:id";
$stmt = $pdo->prepare($sqlBusca);
$stmt->execute([':id' =>$id]);
$dados = $stmt -> fetch (PDO::FETCH_ASSOC);

//se os dados não existirem retornara para o index
if (!$dados){
    header ('Location: index.php');
    exit;
}

// trexo do codigo para atualizar para os valores salvos abaixo
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];


// puxa os dados das movientações para serem alteradas substituindo apelidos ao inves de valores fixo
$sql =
   /*Atualize movimentações*/
    "UPDATE movimentacoes 
    /*Atribua a nova descrição,v*/ 
     SET    descricao =:descricao, 
            valor = :valor,
            tipo = :tipo
    /*Aonde? no id!*/         
     WHERE id = :id";

$stmt = $pdo->prepare($sql);

//aqui ele executa trocando os apelidos pelos valores digitados do usuario

$stmt->execute([
   ':descricao' => $_POST['descricao'],
        ':valor'     => $_POST['valor'],
        ':tipo'      => $_POST['tipo'],
        ':id'        => $id

]);

header ('Location:index.php');
exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar</title>
</head>
<body>
    <h1>✏️ Editar Movimentação</h1>

    <form method="POST">
        <label>Descrição:</label>
        <input type="text" name="descricao" value="<?= $dados['descricao']; ?>" required>
        <br><br>

        <label>Valor:</label>
        <input type="number" name="valor" step="0.01" value="<?= $dados['valor']; ?>" required>
        <br><br>

        <label>Tipo:</label>
        <select name="tipo">
            <option value="receita" <?= ($dados['tipo'] == 'receita') ? 'selected' : ''; ?>>Receita</option>
            <option value="despesa" <?= ($dados['tipo'] == 'despesa') ? 'selected' : ''; ?>>Despesa</option>
        </select>
        <br><br>

        <button type="submit">Salvar Alterações</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>