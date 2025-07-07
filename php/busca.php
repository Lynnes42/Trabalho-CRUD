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
        
        <!-- Formulário de busca -->
        <form method="GET" action="busca.php">
            <label for="termo">Termo de busca:</label>
            <input type="text" name="termo" id="termo" value="<?= htmlspecialchars($termo) ?>" required>
            <input type="submit" value="Buscar">
        </form>

        <!-- Resultados da busca -->
        <?php if (!empty($resultados)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $produto): ?>
                        <tr>
                            <td>
                                <img src="imagens/<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem do produto" style="max-width: 80px; max-height: 80px;">
                            </td>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                            <td><?= htmlspecialchars($produto['descricao']) ?></td>
                            <td>
                                <form action="editar.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button type="submit">Editar</button>
                                </form>
                                <form action="remover.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover este produto?');">
                                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                    <button type="submit" style="background-color:rgb(204, 69, 69); color: white;">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_GET['termo'])): ?>
            <p>Nenhum produto encontrado para o termo "<?= htmlspecialchars($termo) ?>"</p>
        <?php endif; ?>

        <!-- Botão para voltar -->
        <form action="painel.php" method="get">
            <button type="submit">Voltar para Painel</button>
        </form>
    </div>
    </body>
    <script src="../js/busca.js"></script>
    </html>
    <?php
}

// Captura o termo da busca
$termo = $_GET['termo'] ?? '';

if ($termo !== '') {
    try {
        $sql = "SELECT * FROM produtos WHERE nome LIKE ? OR descricao LIKE ? ORDER BY data_criacao DESC";
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
