<?php
include("config.php");

$id = $_GET['id'] ?? null;
$erroId = false;

if ($id === null) {
    $erroId = true;
}

$nome = '';
$preco = '';
$quantidade = '';
$descricao = '';
$mensagem = '';
$tipoMensagem = 'erro';
$imagemAtual = '';

if (!$erroId) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $quantidade = intval($_POST['quantidade'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');

        // Buscar imagem atual do banco
        $stmt = $pdo->prepare("SELECT imagem FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagemAtual = $produto['imagem'] ?? '';
        $novaImagemNome = $imagemAtual;

        // Se nova imagem foi enviada
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = $_FILES['imagem'];

            if ($imagem['size'] > 2 * 1024 * 1024) {
                $mensagem = "A imagem excede o limite de 2MB.";
            } else {
                $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($imagem['type'], $tiposPermitidos)) {
                    $mensagem = "Formato de imagem inválido. Use JPEG, PNG, GIF ou WEBP.";
                } else {
                    $pastaDestino = 'imagens/';
                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0777, true);
                    }

                    $novaImagemNome = uniqid('img_', true) . '_' . basename($imagem['name']);
                    $caminhoFinal = $pastaDestino . $novaImagemNome;

                    if (move_uploaded_file($imagem['tmp_name'], $caminhoFinal)) {
                        // Excluir imagem antiga se existir
                        $caminhoAntigo = $pastaDestino . $imagemAtual;
                        if (!empty($imagemAtual) && file_exists($caminhoAntigo)) {
                            unlink($caminhoAntigo);
                        }
                    } else {
                        $mensagem = "Erro ao mover a nova imagem.";
                    }
                }
            }
        }

        // Validação final
        if ($nome === '' || $preco <= 0 || !isset($_POST['quantidade']) || $_POST['quantidade'] === '' || $quantidade < 0) {
            $mensagem = "Preencha os campos corretamente: nome, preço (> 0) e quantidade (>= 0).";
        } elseif (empty($mensagem)) {
            try {
                $sql = "UPDATE produtos SET nome = ?, preco = ?, quantidade = ?, descricao = ?, imagem = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $preco, $quantidade, $descricao, $novaImagemNome, $id]);
                $mensagem = "Produto atualizado com sucesso!";
                $tipoMensagem = 'sucesso';
                $imagemAtual = $novaImagemNome;
            } catch (PDOException $e) {
                $mensagem = "Erro ao atualizar no banco: " . $e->getMessage();
            }
        }
    } else {
        // Buscar dados do produto
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
                $imagemAtual = $produto['imagem'];
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

            <form method="POST" action="editar.php?id=<?= htmlspecialchars($id) ?>" enctype="multipart/form-data">
                <label for="nome">Nome do produto:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required />

                <label for="preco">Preço do produto:</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?= htmlspecialchars($preco) ?>" required />

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" value="<?= htmlspecialchars($quantidade) ?>" required />

                <label for="descricao">Descrição (opcional):</label>
                <textarea id="descricao" name="descricao"><?= htmlspecialchars($descricao) ?></textarea>

                <?php if (!empty($imagemAtual)): ?>
                    <div>
                        <img src="imagens/<?= htmlspecialchars($imagemAtual) ?>" width="150">
                        <br>
                        <small>Imagem atual: <?= htmlspecialchars($imagemAtual) ?></small>
                    </div>
                <?php endif; ?>

                <label for="imagem">Nova imagem (opcional, até 2MB):</label>
                <input type="file" id="imagem" name="imagem" accept=".jpg, .jpeg, .png, .webp, .gif">
                <small>Formatos aceitos: JPG, PNG, GIF, WEBP</small>

                <input type="submit" value="Atualizar" />
            </form>

            <form action="painel.php" method="get" style="margin-top:15px;">
                <button type="submit">Voltar para Painel</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
