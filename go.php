<?php
require 'db.php';

// Obter o código e validar
$code = isset($_GET['code']) ? trim($_GET['code']) : '';
if (!preg_match('/^[a-zA-Z0-9]+$/', $code)) {
    header("Location: index.php?error=invalid_code");
    exit;
}

// Recuperar a URL longa e incrementar o contador de cliques
$stmt = $pdo->prepare("SELECT long_url, clicks FROM urls WHERE shortened_url = ?");
$stmt->execute([$code]);
$url = $stmt->fetch(PDO::FETCH_ASSOC);

if ($url) {
    // Incrementar o contador de cliques
    $stmt = $pdo->prepare("UPDATE urls SET clicks = clicks + 1 WHERE shortened_url = ?");
    $stmt->execute([$code]);

    // Redirecionar para a URL longa armazenada
    header("Location: " . $url['long_url'], true, 302);
    exit;
}

// Código não encontrado
header("Location: index.php?error=not_found");
exit;
?>