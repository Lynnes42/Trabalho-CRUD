<?php

$conn = mysqli_connect( "localhost", "root", "ifsuldeminas", "Login");

if( !$conn){
    die("Conexão não pode ser estabelecida: " . mysqli_connect_error());
}else {
    echo "Conexão estabelecida com sucesso<br><br>";
}