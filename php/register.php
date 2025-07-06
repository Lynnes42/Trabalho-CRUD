<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitização e validação de entrada
    $nome = trim($_POST["nome"] ?? "");
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $senha = $_POST["senha"] ?? "";

    // Verificar se os campos estão preenchidos
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Verificar se o email é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email inválido.";
        exit;
    }

    // Verificar se o email já está cadastrado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "Este email já está cadastrado.";
        exit;
    }

    // Criptografar a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir o novo usuário no banco de dados
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senhaHash]);
        // Set session variables to log the user in automatically
        session_start();
        $_SESSION['usuario_id'] = $pdo->lastInsertId();
        $_SESSION['usuario_nome'] = $nome;

        // Redirect to painel.php properly
        header("Location: painel.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao registrar usuário: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Acesso inválido";
}
?>
