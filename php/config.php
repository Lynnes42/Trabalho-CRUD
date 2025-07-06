<?php
// Tem que lembrar de esconder esses atributos depois quando for colocar no github
// Atributos para conectar no banco de dados
/*$host = 'sql204.infinityfree.com ';
$db = 'if0_39388163_teste ';
$user = 'if0_39388163';
$pass = 'ehMuitoFoda';
$charset = 'utf8mb4';
*/

$host = 'localhost';
$db = 'Crud';
$user = 'root';
$pass ='Luis18.EC';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " .$e->getMessage());
}
?>