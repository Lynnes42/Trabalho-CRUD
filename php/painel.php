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
</head>
<body>
    <h1>Painel</h1>
    <!-- Opçóes básicas do CRUD -->
    <input type="button" value="Adicionar produto" id="adicionarbtn">
    <input type="button" value="Buscar produto" id="buscarbtn">
    <input type="button" value="Editar produto" id="editarbtn">
    <input type="button" value="Remover produto" id="removerbtn">


    <!-- Opção de logout pelo usuario -->
     <input type="button" value="Sair" id="sairbtn">
</body>
<script src="../js/painel.js"></script>
</html>
