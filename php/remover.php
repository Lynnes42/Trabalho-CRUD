<?php
// remover.php - Script para remover registros no banco de dados

include("config.php");

function exibirMensagem($mensagem, $tipo = 'erro') {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Remover Produto</title>
        <link rel="stylesheet" href="../css/remover.css">
    </head>
    <body>
    <div class="container">
        <h2>Remover Produto</h2>
        <p class="message <?= $tipo === 'sucesso' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($mensagem) ?>
        </p>
        <form action="painel.php" method="get">
            <button type="submit">Voltar para Painel</button>
        </form>
    </div>
    </body>
    </html>
    <?php
}

if (!isset($_GET['id'])) {
    exibirMensagem("ID do registro não especificado.");
    exit;
}

$id = $_GET['id'];

try {
    // 1. Buscar nome do arquivo de imagem
    $stmt = $pdo->prepare("SELECT imagem FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        exibirMensagem("Produto não encontrado.");
        exit;
    }

    $imagem = $produto['imagem'];
    $caminhoImagem = __DIR__ . "/imagens/" . $imagem;

    // 2. Excluir a imagem se existir
    if (!empty($imagem) && file_exists($caminhoImagem)) {
        unlink($caminhoImagem);
    }

    // 3. Excluir o registro do banco
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);

    exibirMensagem("Registro removido com sucesso!", 'sucesso');
} catch (PDOException $e) {
    exibirMensagem("Erro ao remover registro: " . $e->getMessage());
}
?>
