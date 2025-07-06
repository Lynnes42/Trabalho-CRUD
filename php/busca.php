<?php
// busca.php - Página para buscar produtos no banco de dados

include("config.php");

function exibirFormulario($termo = '', $resultados = []) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Buscar Produtos</title>
        <link rel="stylesheet" href="../css/busca.css">
    </head>
    <body>
    <div class="container">
        <h2>Buscar Produtos</h2>
        <form method="GET" action="busca.php">
            <label for="termo">Termo de busca:</label>
            <input type="text" name="termo" id="termo" value="<?= htmlspecialchars($termo) ?>" required>
            <input type="submit" value="Buscar">
        </form>

        <?php if (!empty($resultados)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                            <td><?= htmlspecialchars($produto['descricao']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_GET['termo'])): ?>
            <p>Nenhum produto encontrado para o termo "<?= htmlspecialchars($termo) ?>"</p>
        <?php endif; ?>

        <form action="painel.php" method="get">
            <button type="submit">Voltar para Painel</button>
        </form>
    </div>
    </body>
    </html>
    <?php
}

$termo = $_GET['termo'] ?? '';

if ($termo !== '') {
    try {
        $sql = "SELECT * FROM produtos WHERE nome LIKE ? OR descricao LIKE ?";
        $stmt = $pdo->prepare($sql);
        $likeTermo = "%$termo%";
        $stmt->execute([$likeTermo, $likeTermo]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        exibirFormulario($termo, $resultados);
    } catch (PDOException $e) {
        echo "Erro na busca: " . $e->getMessage();
    }
} else {
    exibirFormulario();
}
?>
