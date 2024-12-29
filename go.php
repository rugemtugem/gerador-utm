<?php
require 'db.php';

// Obter o código e validar
$code = isset($_GET['code']) ? trim($_GET['code']) : '';
if (!preg_match('/^[a-zA-Z0-9]{6}$/', $code)) {
    header("Location: index.php?error=invalid_code");
    exit;
}

// Buscar a URL longa associada
$stmt = $pdo->prepare("SELECT long_url FROM urls WHERE shortened_url = ?");
$stmt->execute([$code]);
$url = $stmt->fetch(PDO::FETCH_ASSOC);

if ($url) {
    // Incrementar cliques (se a coluna existir)
    $stmt = $pdo->prepare("UPDATE urls SET clicks = COALESCE(clicks, 0) + 1 WHERE shortened_url = ?");
    $stmt->execute([$code]);

    // Redirecionar para a URL longa preservando colchetes
    $redirect_url = $url['long_url'];
    $redirect_url = str_replace(['%5B', '%5D'], ['[', ']'], $redirect_url);

    header("Location: $redirect_url", true, 302);
    exit;
}

// Código não encontrado
header("Location: index.php?error=not_found");
exit;
