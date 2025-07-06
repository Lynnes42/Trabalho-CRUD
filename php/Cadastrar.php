<?php require_once 'banco.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar produtos</title>
</head>
<body>
    <h1>Cadastrar novo produto</h1>
    <form action="salvar.php" method="post">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div>
            <label for="preco">Preco:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>
        </div>

        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
        </div>

        <div>
            <label for="imagem">Imagem (URL):</label>
            <input type="text" id="imagem" name="imagem">
        </div>

        <button type="submit">Salvar</button>
        <a href="Crud.php">Cancelar</a>
    </form>
</body>
</html>