<?php
    $sql = "SELECT * FROM Produtos ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Erro ao buscar os produtos" . mysqli_error($conn));
    }

    $produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $registros = count($produtos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem dos produtos</title>
</head>
<body>
    <h2>Produtos</h2>

    <?php if(isset($_GET['sucesso']) && $_GET['sucesso'] == 1):
        ?>
        <p style="color: green;">Produto registrado com sucesso.</p>
        <?php elseif($_GET['sucesso'] == 2) : ?>
            <p style="color: green;">Produto atualizado com sucesso.</p>
        <?php elseif($_GET['sucesso'] == 3) : ?>
            <p style="color: green;">Produto removido com sucesso.</p>
    <?php endif; ?>
    

    <h2>Lista dos produtos</h2>
    <?php if($registros > 0): ?>
        <?php foreach($produtos as $produto): ?>
            <strong>Id:</strong> <?php echo $produto['id']; ?><br>
            <strong>Nome:</strong> <?php echo $produto['nome']; ?><br>
            <strong>Preco:</strong> <?php echo $produto['preco']; ?><br>
            <strong>Quantidade:</strong> <?php echo $produto['quantidade']; ?><br>
            <strong>Descricao:</strong> <?php echo $produto['descricao']; ?><br>
            <strong>Imagem:</strong> <?php echo $produto['iamgem']; ?><br>

            <!--Botões de ação-->
            <a href="Editar.php?id=<?php echo $produto['id']; ?>">Editar</a>
            <a href="Remover.php?id=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>

                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum produto registrado ainda.</p>
            <?php endif; ?>

            <a href="Cadastrar.php">Cadastrar novo produto</a>
            <a href="Pesquisa.php">Buscar produtos que deseja.</a>

    
</body>
</html>
