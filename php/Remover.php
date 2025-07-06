<?php require_once 'banco.php';

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