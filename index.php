<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de UTM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css?v2" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="script.js?v1"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="p-3 fixed-top" style="z-index: 0!important;">
        <div id="themeSwitch" class="theme-switch-container light-active">
            <div class="theme-switch-bg"></div> <!-- Adicionando a camada para a animação -->
            <div class="theme-switch-option light-option active">
                <i class="bi bi-sun"></i>
                <span>Light</span>
            </div>
            <div class="theme-switch-option dark-option">
                <i class="bi bi-moon-stars-fill"></i>
                <span>Dark</span>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="row">
            <h1 class="text-center">Gerador de UTM</h1>
        </div>
        <!-- Formulário para desktop -->
        <div class="container mt-2 d-none d-md-block">
            <form id="utmForm" action="generate.php" method="POST" class="mt-4">
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="website_url"><i class="bi bi-link me-1"></i> URL do site:</span>
                    <input type="text" class="form-control theme-input" placeholder="Insira sua url válida" aria-label="website_url" aria-describedby="website_url" id="website_url" name="website_url" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="utm_campaign"><i class="bi bi-megaphone me-1"></i> UTM Campaing:</span>
                    <input type="text" class="form-control theme-input" placeholder="Exemplo de UTM Campaing: [Time][Evento][Nome_Do_Evento][Mes][In/Outbound][Perfil][Periodo]" aria-label="utm_campaign" aria-describedby="utm_campaign" id="utm_campaign" name="utm_campaign" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="utm_source"><i class="bi bi-menu-up me-1"></i> UTM Source:</span>
                    <input type="text" class="form-control theme-input" placeholder="Define a fonte de tráfego" aria-label="utm_source" aria-describedby="utm_source" id="utm_source" name="utm_source" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="utm_medium"><i class="bi bi-link-45deg me-1"></i> UTM Medium:</span>
                    <input type="text" class="form-control theme-input" placeholder="Por exemplo, uma postagem de blog, um vídeo, uma postagem de mídia social, etc" aria-label="utm_medium" aria-describedby="utm_medium" id="utm_medium" name="utm_medium" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="utm_term"><i class="bi bi-key me-1"></i> UTM Term:</span>
                    <input type="text" class="form-control theme-input" placeholder="Significa a palavra-chave usada para a promoção, gerando tráfego" aria-label="utm_term" aria-describedby="utm_term" id="utm_term" name="utm_term" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text p5" id="custom_name"><i class="bi bi-pencil me-1"></i> Nome Personalizado:</span>
                    <input type="text" class="form-control theme-input" placeholder="Nome Personalizado da url encurtada (opcional)" aria-label="custom_name" aria-describedby="custom_name" id="custom_name" name="custom_name">
                </div>
                <button type="submit" class="btn btn-dark border-light">Gerar UTM</button>
            </form>
        </div>

        <!-- Formulário para mobile -->
        <div class="container mt-5 d-md-none">
            <form action="generate.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="website_url_mobile" name="website_url" placeholder="" required>
                    <label for="website_url_mobile">URL do site:</label>
                    <p class="help-text">O endereço completo da URL <strong>(ex. https://www.example.com)</strong></p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="utm_campaign_mobile" name="utm_campaign" placeholder="" required>
                    <label for="utm_campaign_mobile">UTM Campaing:</label>
                    <p class="help-text">UTM Campaing: [Time][Evento][Nome_Do_Evento][Mes][In/Outbound][Perfil][Periodo]</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="utm_source_mobile" name="utm_source" placeholder="" required>
                    <label for="utm_source_mobile">UTM Source:</label>
                    <p class="help-text">Define a fonte de tráfego</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="utm_medium_mobile" name="utm_medium" placeholder="" required>
                    <label for="utm_medium_mobile">UTM Medium:</label>
                    <p class="help-text">Por exemplo, uma postagem de blog, um vídeo, uma postagem de mídia social, etc</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="utm_term_mobile" name="utm_term" placeholder="" required>
                    <label for="utm_term_mobile">UTM Term:</label>
                    <p class="help-text">Significa a palavra-chave usada para a promoção, gerando tráfego</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control theme-input" id="custom_name_mobile" placeholder="" name="custom_name">
                    <label for="custom_name_mobile">Nome Personalizado:</label>
                    <p class="help-text">Nome Personalizado da URL encurtada (opcional)</p>
                </div>
                <button type="submit" class="btn btn-dark border-light">Gerar UTM</button>
            </form>
        </div>
        <h2 class="mt-5">Histórico de URLs</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-light">
                <thead>
                    <tr>
                        <th><i class="bi bi-qr-code"></i> QR Code</th>
                        <th><i class="bi bi-link"></i> Link Original com UTM</th>
                        <th><i class="bi bi-link-45deg"></i> Link Encurtado</th>
                        <th><i class="bi bi-hand-index"></i> Clicks</th>
                        <th><i class="bi bi-trash"></i> Excluir</th>
                        <th><i class="bi bi-calendar2-check"></i> Data de Geração</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'db.php';

                    $query = $pdo->query("SELECT * FROM urls ORDER BY generation_date DESC");
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode("https://rugemtugem.com.br/r/" . $row['shortened_url']);

                        // Formatar a data para o formato dia-mês-ano hora:minutos
                        $formattedDate = date('d-m-Y H:i', strtotime($row['generation_date']));

                        echo "<tr>
<td data-label='QR Code' class='text-center align-middle'>
    <span data-bs-toggle='tooltip' title='Clique para abrir o QRCode'>
        <img src='" . $qrCodeUrl . "' alt='QR Code' style='width: 50px; height: 50px; cursor: pointer;' data-bs-toggle='modal' data-bs-target='#qrModal" . $row['shortened_url'] . "'>
    </span>
    <a href='" . $qrCodeUrl . "' download='" . $row['shortened_url'] . ".png' class='ms-2 theme-link' data-bs-toggle='tooltip' title='Baixar QRCode'>
        <i class='bi bi-download' aria-hidden='true'></i>
    </a>
    <div class='modal fade' id='qrModal" . $row['shortened_url'] . "' tabindex='-1' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>QR Code</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body text-center'>
                    <img src='" . $qrCodeUrl . "' alt='QR Code' style='width: 300px; height: 300px;'>
                    <div class='mt-3'>
                        <a href='" . $qrCodeUrl . "' download='" . $row['shortened_url'] . ".png' class='btn btn-dark border-light'>
                            <i class='bi bi-download' aria-hidden='true'></i> Baixar QRCode
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</td>
           <td data-label='Link Original com UTM' class='col-lg-5'>
                <a href='" . htmlspecialchars($row['long_url']) . "' target='_blank' class='theme-link' data-bs-toggle='tooltip' title='Copiar'>
                    " . htmlspecialchars($row['long_url']) . "
                </a>
                <i class='bi bi-clipboard copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"" . htmlspecialchars($row['long_url']) . "\")'></i>
            </td>
            <td data-label='Link Encurtado' class='align-middle'>
                <a href='/r/" . $row['shortened_url'] . "' target='_blank' class='theme-link' data-bs-toggle='tooltip' title='Copiar'>
                    https://rugemtugem.com.br/r/" . $row['shortened_url'] . "
                </a>
                <i class='bi bi-clipboard copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"https://rugemtugem.com.br/r/" . $row['shortened_url'] . "\")'></i>
            </td>
            <td data-label='Clicks' class='text-center align-middle'>" . ($row['clicks'] ?? 0) . "</td>
            <td data-label='Excluir' class='text-center align-middle'>
                <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>
                    <i class='bi bi-trash'></i>
                </button>
            </td>
            <td data-label='Data da UTM' class='text-center align-middle'>" . $formattedDate . "</td>
          </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>