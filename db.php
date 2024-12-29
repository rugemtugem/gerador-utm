<?php
// Configuração do banco de dados
$host = "mysql.rugemtugem.com.br";
$dbname = "rugemtugem16"; 
$user = "rugemtugem16"; // Alterado de $username para $user para corresponder à linha 9
$password = "m7f8g7n9"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
