<?php
    include 'banco.php'

    if($_SERVER["request_method"] == "Post"){
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], password_default);
        $email = $_POST['email'];
        

        $stmt = $conn -> prepare("insert into usuarios (nome, email, senha) values (?, ?, ?, ?)");
        $stmt -> bind_param("ss", $username, $password, $email);

        if($stmt -> execute()){
            echo "Usuário registrado com sucesso. <a href='login.php'>Login</a>";
        }else{
            echo "Erro ao registrar: " . $conn ->error; 
        }
    }
    ?>

    <h2>Registrar</h2>
<form method = "Post">
        Usuario: <input type = "text" name = "username" required><br>
        Senha: <input type = "password" name= "password" required><br>
        Email: <input type = "email" name = "email" required><br>
        <button type = "submit">Registrar</button>
</form>