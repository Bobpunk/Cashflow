<?php

declare(strict_types= 1);
date_default_timezone_set("America/Recife");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'protecao.php';
require 'conexao.php';


session_start();


if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header('Location: index.php'); 
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - CashFlow</title>
    <link rel="stylesheet" href="style.css"> <style>
    
        body { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box; }
        .erro { color: red; text-align: center; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2 style="text-align: center; color: #333;">🔐 Acesso</h2>
        
        <?php if (isset($erro)): ?>
            <div class="erro"><?= $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>E-mail</label>
            <input type="email" name="email" required placeholder="admin@email.com">

            <label>Senha</label>
            <input type="password" name="senha" required placeholder="******">

            <button type="submit" class="btn-novo" style="width: 100%; border:none; cursor:pointer;">Entrar</button>
        </form>
    </div>

</body>
</html>