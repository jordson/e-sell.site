<?php

$db_name = 'mysql:host=localhost;dbname=e_sell';
$user_name = 'e-sell';
$user_password = '6Haxb]ZN';

$conn = new PDO($db_name, $user_name, $user_password);

// Verificar erros de conexão
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . $conn->errorInfo());
}


?>