<?php
// adicionar.php - Script para adicionar registros no banco de dados
include("config.php");

// Função para exibir o formulário com mensagem opcional
function exibirFormulario($mensagem = '', $tipo = 'erro') {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Adicionar Produto</title>
        <link rel="stylesheet" href="../css/adicionar.css">
    </head>
    <body>
    <div class="container">
        <h2>Adicionar Produto</h2>

        <?php if (!empty($mensagem)): ?>
            <p class="message <?= $tipo === 'sucesso' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($mensagem) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="adicionar.php" enctype="multipart/form-data">
            <label for="nome">Nome do produto:</label>
            <input type="text" name="nome" required>

            <label for="preco">Preço do produto:</label>
            <input type="number" step="0.01" name="preco" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" min="" required>

            <label for="descricao">Descrição (opcional):</label>
            <input type="text" name="descricao">

            <label for="imagem">Selecione uma imagem (máx. 2MB):</label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required>

            <input type="submit" value="Cadastrar Produto">
        </form>

        <form action="painel.php" method="get">
            <button type="submit">Voltar para Painel</button>
        </form>
    </div>
    </body>
    </html>
    <?php
}

// Lógica de envio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');
    $imagemNome = '';

    // Validação de campos
    if ($nome === '' || $preco <= 0 || $quantidade < 0) {
        exibirFormulario("Preencha os campos corretamente: nome, preço (> 0) e quantidade (>= 0).");
        exit;
    }

    // Validação do upload de imagem
    if (!isset($_FILES['imagem'])) {
        exibirFormulario("Nenhuma imagem foi enviada.");
        exit;
    }

    $imagem = $_FILES['imagem'];

    // Verifica erros no upload
    if ($imagem['error'] !== UPLOAD_ERR_OK) {
        $errosUpload = [
            UPLOAD_ERR_INI_SIZE   => "A imagem excede o tamanho máximo permitido pelo servidor.",
            UPLOAD_ERR_FORM_SIZE  => "A imagem excede o tamanho máximo permitido pelo formulário (2MB).",
            UPLOAD_ERR_PARTIAL    => "O upload foi feito apenas parcialmente.",
            UPLOAD_ERR_NO_FILE    => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente no servidor.",
            UPLOAD_ERR_CANT_WRITE => "Erro ao gravar o arquivo no disco.",
            UPLOAD_ERR_EXTENSION  => "Uma extensão do PHP interrompeu o upload.",
        ];
        $mensagemErro = $errosUpload[$imagem['error']] ?? "Erro desconhecido no upload.";
        exibirFormulario("Erro no envio da imagem: $mensagemErro");
        exit;
    }

    // Verifica tamanho da imagem
    if ($imagem['size'] > 2 * 1024 * 1024) {
        exibirFormulario("A imagem excede o limite de 2MB.");
        exit;
    }

    // Verifica tipo do arquivo
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($imagem['type'], $tiposPermitidos)) {
        exibirFormulario("Formato de imagem inválido. Aceitos: JPEG, PNG, GIF, WEBP.");
        exit;
    }

    // Processar imagem
    $pastaDestino = 'imagens/';
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    $imagemNome = uniqid('img_', true) . "_" . basename($imagem['name']);
    $caminhoCompleto = $pastaDestino . $imagemNome;

    if (!move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
        exibirFormulario("Erro ao mover a imagem para a pasta de destino.");
        exit;
    }

    // Inserção no banco de dados
    try {
        $sql = "INSERT INTO produtos (nome, preco, quantidade, descricao, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $preco, $quantidade, $descricao, $imagemNome]);

        exibirFormulario("Produto cadastrado com sucesso!", 'sucesso');
    } catch (PDOException $e) {
        exibirFormulario("Erro ao inserir no banco: " . $e->getMessage());
    }
} else {
    exibirFormulario();
}
?>
