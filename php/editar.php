<?php
include("config.php");

$id = $_GET['id'] ?? null;
$erroId = false;

if ($id === null) {
    $erroId = true;
}

// Inicializa variáveis do formulário
$nome = '';
$preco = '';
$quantidade = '';
$descricao = '';
$mensagem = '';
$tipoMensagem = 'erro';

if (!$erroId) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recebe dados do form
        $nome = trim($_POST['nome'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $quantidade = intval($_POST['quantidade'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');

        // Validação simples
        if ($nome === '' || $preco <= 0 || $quantidade < 0) {
            $mensagem = "Preencha os campos corretamente: nome, preço (> 0) e quantidade (>= 0).";
        } else {
            try {
                $sql = "UPDATE produtos SET nome = ?, preco = ?, quantidade = ?, descricao = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $preco, $quantidade, $descricao, $id]);
                $mensagem = "Produto atualizado com sucesso!";
                $tipoMensagem = 'sucesso';
            } catch (PDOException $e) {
                $mensagem = "Erro ao atualizar no banco: " . $e->getMessage();
            }
        }
    } else {
        // Busca produto para preencher formulário
        try {
            $sql = "SELECT * FROM produtos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produto) {
                $nome = $produto['nome'];
                $preco = $produto['preco'];
                $quantidade = $produto['quantidade'];
                $descricao = $produto['descricao'];
            } else {
                $erroId = true;
                $mensagem = "Produto não encontrado.";
            }
        } catch (PDOException $e) {
            $erroId = true;
            $mensagem = "Erro ao buscar produto: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/editar.css" />
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>

        <?php if ($erroId): ?>
            <p class="message error"><?= htmlspecialchars($mensagem ?: 'ID do produto não especificado.') ?></p>
            <form action="painel.php" method="get">
                <button type="submit">Voltar para Painel</button>
            </form>
        <?php else: ?>
            <?php if ($mensagem): ?>
                <p class="message <?= $tipoMensagem === 'sucesso' ? 'success' : 'error' ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="editar.php?id=<?= htmlspecialchars($id) ?>">
                <label for="nome">Nome do produto:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required />

                <label for="preco">Preço do produto:</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?= htmlspecialchars($preco) ?>" required />

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" value="<?= htmlspecialchars($quantidade) ?>" required />

                <label for="descricao">Descrição (opcional):</label>
                <textarea id="descricao" name="descricao"><?= htmlspecialchars($descricao) ?></textarea>

                <input type="submit" value="Atualizar" />
            </form>

            <form action="painel.php" method="get" style="margin-top:15px;">
                <button type="submit">Voltar para Painel</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
