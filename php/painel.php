<?php

session_start();
if (!isset($_SESSION['usuario_nome']) || !isset($_SESSION['usuario_id'])){
    header('../index.html') ;
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="../css/painel.css">
</head>
<body>
    <div class="container">
        <h1>Painel de <?php echo $_SESSION['usuario_nome']?></h1>
        <!-- Opçóes básicas do CRUD -->
        <input type="button" value="Adicionar produto" id="adicionarbtn" class="button-link">
        <input type="button" value="Buscar produto" id="buscarbtn" class="button-link">

        <!-- Opção de logout pelo usuario -->
        <input type="button" value="Sair" id="sairbtn" class="button-link">

        <!-- Uma tabela para mostrar os produtos de ordenados -->
    </div>
</body>
<script src="../js/painel.js"></script>
</html>
