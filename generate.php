<?php
require 'db.php';

function generateShortCode() {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for($i = 0; $i < 6; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $code;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $website_url = trim($_POST['website_url']);
    $utm_campaign = trim($_POST['utm_campaign']);
    $utm_source = trim($_POST['utm_source']); 
    $utm_medium = trim($_POST['utm_medium']);
    $utm_term = trim($_POST['utm_term']);

    // Validar URL base
    if (!filter_var($website_url, FILTER_VALIDATE_URL)) {
        die("URL inválida. Por favor insira uma URL válida.");
    }

    // Construir a URL com UTM parameters
// Construir a URL com UTM
$utm_url = $website_url;
if (!empty($utm_campaign)) {
    $utm_url .= (strpos($utm_url, '?') === false ? '?' : '&') . "utm_campaign=" . $utm_campaign;
}
if (!empty($utm_source)) {
    $utm_url .= "&utm_source=" . $utm_source;
}
if (!empty($utm_medium)) {
    $utm_url .= "&utm_medium=" . $utm_medium;
}
if (!empty($utm_term)) {
    $utm_url .= "&utm_term=" . $utm_term;
}

// Substituir valores codificados por valores literais
$utm_url = str_replace(['%5B', '%5D'], ['[', ']'], $utm_url);
            
    try {
        // Criar tabela se não existir (removendo a coluna clicks por enquanto)
        $pdo->exec("CREATE TABLE IF NOT EXISTS urls (
            id INT AUTO_INCREMENT PRIMARY KEY,
            original_url TEXT NOT NULL,
            long_url TEXT NOT NULL,
            shortened_url VARCHAR(255) NOT NULL UNIQUE,
            generation_date DATE DEFAULT CURRENT_DATE
        )");
        
        // Criar arquivo .htaccess se não existir
        if (!file_exists('.htaccess')) {
            $htaccess = "RewriteEngine On\n";
            $htaccess .= "RewriteBase /r/\n";
            $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
            $htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
            $htaccess .= "RewriteRule ^([a-zA-Z0-9]+)$ go.php?code=$1 [L,QSA]\n";
            file_put_contents('.htaccess', $htaccess);
        }

        // Gerar código curto único
        do {
            $short_code = generateShortCode();
            $stmt = $pdo->prepare("SELECT id FROM urls WHERE shortened_url = ?");
            $stmt->execute([$short_code]);
        } while ($stmt->rowCount() > 0);

        // Inserir na base de dados
        $stmt = $pdo->prepare("INSERT INTO urls (original_url, long_url, shortened_url) VALUES (?, ?, ?)");
        if ($stmt->execute([$website_url, $utm_url, $short_code])) {
            // Redirecionar para a página principal com sucesso
            header("Location: index.php?success=1&code=" . $short_code);
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao processar URL: " . $e->getMessage());
    }
}
?>
