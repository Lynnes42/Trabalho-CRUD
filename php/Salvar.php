<?php require_once 'banco.php';
<?php
    session_start();
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        header("Location: ../index.html");
        exit;
    }
?>

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];

    //Atualizar produto já existente
    if($id){
        $sql = "UPDATE Produtos SET
                nome = '$nome',
                preco = $preco,
                quantidade = $quantidade,
                descricao = '$descricao',
                imagem = '$imagem'
                WHERE id = $id";
    }else{
        //inserir novo produto
        $sql = "INSERT INTO Produtos (nome, preco, quantidade, descricao, imagem)
            VALUES('$nome', $preco, $quantidade, '$descricao', '$imagem')";
    }

    if(mysqli_query($conn, $sql)){
        $status = $id ? 'sucess_edit' : 'sucess_add';
        header("Location: Crud.php?status=$status"); // Volta para a listagem
    }else{
        header("Location: Crud.php?status=error"); // Mostra erro
    }   
}else{
    header("Location: Crud.php");
}

?>
