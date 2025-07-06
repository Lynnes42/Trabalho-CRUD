<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $email = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
    $senha = $_POST["senha"] ?? '';

    if (empty($email) || empty($senha)) {
        echo "preencha todos os campos";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        echo "login bem sucedido!";
        header("Location: painel.php");
        exit;
    }
    else
        echo"Email ou senha incorretos!";
}
else {
    echo "Acesso inválido";
}