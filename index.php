<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("America/Recife");


require 'protecao.php';
require 'conexao.php';

$mesFiltro = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m');

// Receitas
$sqlReceita = "SELECT SUM(valor) FROM movimentacoes WHERE tipo = 'receita' AND DATE_FORMAT(data, '%Y-%m') = :mes";
$stmt = $pdo->prepare($sqlReceita);
$stmt->execute([':mes' => $mesFiltro]);
$totalReceitas = $stmt->fetchColumn() ?: 0;

// Despesas
$sqlDespesa = "SELECT SUM(valor) FROM movimentacoes WHERE tipo = 'despesa' AND DATE_FORMAT(data, '%Y-%m') = :mes";
$stmt = $pdo->prepare($sqlDespesa);
$stmt->execute([':mes' => $mesFiltro]);
$totalDespesas = $stmt->fetchColumn() ?: 0;

$saldo = $totalReceitas - $totalDespesas;

//listagem por data
$sqlLista = "SELECT * FROM movimentacoes 
             WHERE DATE_FORMAT(data, '%Y-%m') = :mes 
             ORDER BY data DESC, id DESC";
$stmtLista = $pdo->prepare($sqlLista);
$stmtLista->execute([':mes' => $mesFiltro]);
$lista = $stmtLista->fetchAll(PDO::FETCH_ASSOC);

//função para gerar o menu de meses
function gerarMeses() {
    $meses = [];
    for ($i = 0; $i <= 11; $i++) {
        $meses[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
    }
    return $meses;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CashFlow Simples</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="text-align: right; margin-bottom: 20px;">
    Olá, <strong><?= $_SESSION['usuario_nome']; ?></strong> | 
    <a href="logout.php" style="color: red; text-decoration: none;">Sair ❌</a>
</div>
<div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd;">
        <form method="GET" action="index.php">
            <label style="font-weight: bold;">📅 Período:</label>
            <select name="mes" onchange="this.form.submit()">
                <?php foreach (gerarMeses() as $mes): ?>
                    <option value="<?= $mes; ?>" <?= ($mes === $mesFiltro) ? 'selected' : ''; ?>>
                        <?= date('m/Y', strtotime($mes . '-01')); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    


  <div class="resumo">
        <div>
            💰 <strong>Saldo:</strong> 
            <span class="saldo-valor">R$ <?= number_format((float)$saldo, 2, ',', '.'); ?></span>
        </div>
        
        <span class="detalhes-texto">
            (Entrou: <span class="texto-receita"><?= number_format((float)$totalReceitas, 2, ',', '.'); ?></span> | 
             Saiu: <span class="texto-despesa"><?= number_format((float)$totalDespesas, 2, ',', '.'); ?></span>)
        </span>
    </div>

    <div style="margin-bottom: 15px;">
        <a href="cadastrar.php" class="btn-novo">+ Novo Lançamento</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $item): ?>
            <tr>
                <td>
                    <?= date('d/m/Y', strtotime($item['data'])); ?>
                </td>
                <td><?= $item['id']; ?></td>
                <td><?= htmlspecialchars($item['descricao']); ?></td>
                <td>R$ <?= number_format((float)$item['valor'], 2, ',', '.'); ?></td>
                
                <td class="<?= htmlspecialchars($item['tipo']); ?>">
                    <?= htmlspecialchars($item['tipo']); ?>
                </td>
                
                <td>
                    <a href="editar.php?id=<?= $item['id']; ?>" class="btn-editar">✏️ Editar</a>
                    <a href="excluir.php?id=<?= $item['id']; ?>" class="btn-excluir" onclick="return confirm('Apagar?');">🗑️ Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>