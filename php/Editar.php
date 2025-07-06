<?php require_once 'banco.php';

if(!isset($_GET['id'])) {
    header("Location: Crud.php?status=error"); // Bloqueia acesso sem ID
    exit;
}

$id = $_GET["id"];
$sql = "SELECT * FROM Produtos WHERE id = $id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {
    header("Location: Crud.php?status=error");
    exit;
}

$produto = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto</title>
</head>
<body>
    <h1>Edição de produtos</h1>
    <form action="salvar.php" method="post">
        <input type="hidden" name="id" value="<?= $produto['id']?>">

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= $produto ['nome'] ?>" required>
        </div>

        <div>
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" value="<?= $produto['preco'] ?>"required>
        </div>

        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="<?= $produto['quantidade'] ?>" required>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= $produto['descricao'] ?></textarea>
        </div>

        <div>
            <label for="imagem">Imagem (URL):</label>
            <input type="text" id="imagem" name="imagem" value="<?= $produto['imagem']?>">
        </div>

        <button type="submit">Atualizar</button>
        <a href="Crud.php">Cancelar</a>
    </form>
</body>
</html>