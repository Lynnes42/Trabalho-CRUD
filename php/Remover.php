<?php require_once 'banco.php';
<?php
    session_start();
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        header("Location: ../index.html");
        exit;
    }
?>

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM Produtos WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        header("Location: Crud.php?status=sucess_delete"); //Confirma remoção
    }else{
        header("Location: Crud.php?status=error");
    }
}else{
    header("Location: Crud.php");
}
?>
