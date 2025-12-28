<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'protecao.php';
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $descricao = $_POST['descricao'];
    $valor = str_replace(',', '.', $_POST['valor']); 
    $tipo = $_POST['tipo'];
    $data = $_POST['data']; 

    
    $sql = "INSERT INTO movimentacoes (descricao, valor, tipo, data) 
            VALUES (:descricao, :valor, :tipo, :data)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':descricao' => $descricao,
        ':valor' => $valor,
        ':tipo' => $tipo,
        ':data' => $data 
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Lançamento</title>
    <link rel="stylesheet" href="style.css">
    <style>
     
        .card { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: 20px auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-salvar { width: 100%; margin-top: 20px; background-color: #28a745; color: white; border: none; padding: 15px; font-size: 16px; border-radius: 5px; cursor: pointer; }
        .btn-salvar:hover { background-color: #218838; }
        .voltar { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <div class="card">
        <h2 style="text-align: center;">💸 Nova Movimentação</h2>
        
        <form method="POST">
            <label>Descrição</label>
            <input type="text" name="descricao" required placeholder="Ex: Conta de Luz">

            <label>Valor (R$)</label>
            <input type="number" name="valor" step="0.01" required placeholder="0,00">

            <label>Data</label>
            <input type="date" name="data" required value="<?= date('Y-m-d'); ?>">

            <label>Tipo</label>
            <select name="tipo" required>
                <option value="receita">Receita (Entrada 💰)</option>
                <option value="despesa">Despesa (Saída 💸)</option>
            </select>

            <button type="submit" class="btn-salvar">Salvar Lançamento</button>
            <a href="index.php" class="voltar">Cancelar e Voltar</a>
        </form>
    </div>

</body>
</html>