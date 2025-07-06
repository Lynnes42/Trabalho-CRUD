<?php require_once 'Crud.php'; ?>
<?php
    session_start();
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        header("Location: ../index.html");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de produtos</title>
    <style>
        table {border-collapse: collapse; width: 100%;}
        th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}
        th{background-color: #f2f2f2;}
        .search-box{margin: 20px 0; padding: 15px; background: #f5f5f5;}
        /*passar para o css, talvez*/
    </style>
</head>
<body>
    <h1>Busca dos produtos</h1>
    <a href="Crud.php">Retornar a lista completa</a>

    <div class="search-box">
        <form method="get" action="Pesquisa.php">
            <div>
                <label for="termo">Termo de busca:</label>
                <input type="text" id="termo" name="termo" value="<?= isset($_GET['termo']) ? htmlspecialchars($_GET['termo']) : '' ?>">
            </div>

            <div>
                <label for="preco_min">Preço mínimo:</label>
                <input type="number" id="preco_min" name="preco_min" step="0.01" value="<?=$_GET['preco_min'] ?? '' ?>">

                <label for="preco_max">Preço máximo:</label>
                <input type="number" id="preco_max" name="preco_max" step="0.01" value="<?=$_GET['preco_max'] ?? ''?>">
            </div>

            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <?php
    $sql = "SELECT * FROM Produtos WHERE 1=1";
    $params = [];

    if(!empty($_GET['termo'])){
        $termo = mysqli_real_escape_string($conn, $_GET['termo']);
        $sql .= "AND (nome LIKE '%$termo%' OR descricao LIKE '%$termo%')";
    }

    if(!empty($_GET['preco_min'])){
        $preco_min = floatval($_GET['preco_min']);
        $sql .= "AND preco >= $preco_min";
    }

    if(!empty($_GET['preco_max'])){
        $preco_max = floatval($_GET['preco_max']);
        $sql .= "AND preco <= $preco_max";
    }

    $sql .= "ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    ?>

    <h2>Resultado da busca</h2>
    <?php if(mysqli_num_rows($result) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while($produto = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $produto['id'] ?></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td><?=$produto['quantidade'] ?></td>
                        <td>
                            <a href="Editar.php?id=<?$produto['id'] ?>">Editar</a>
                            <a href="Remover.php?id=<?= $produto['id']?>" onclick="return confirm('Tem certeza?')">Remover</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum produto foi encontrado!</p>
    <?php endif; ?>
</body>
</html>
