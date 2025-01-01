<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de UTM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css?v10" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    <div class="container mt-5">
        <div class="row">
            <h1 class="text-center">Gerador de UTM</h1>
        </div>
        <form id="utmForm" action="generate.php" method="POST" class="mt-4">
            <div class="input-group mb-3">
                <span class="input-group-text" id="website_url"><i class="bi bi-link me-1"></i> https://rugemtugem.com.br</span>
                <input type="text" class="form-control theme-input" placeholder="Insira sua url válida" aria-label="website_url" aria-describedby="website_url" id="website_url" name="website_url" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="utm_campaign"><i class="bi bi-megaphone me-1"></i> UTM Campaing:</span>
                <input type="text" class="form-control theme-input" placeholder="Exemplo de UTM Campaing: [Time][Evento][Nome_Do_Evento][Mes][In/Outbound][Perfil][Periodo]" aria-label="utm_campaign" aria-describedby="utm_campaign" id="utm_campaign" name="utm_campaign" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="utm_source"><i class="bi bi-menu-up me-1"></i> UTM Source:</span>
                <input type="text" class="form-control theme-input" placeholder="Define a fonte de tráfego" aria-label="utm_source" aria-describedby="utm_source" id="utm_source" name="utm_source" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="utm_medium"><i class="bi bi-link-45deg me-1"></i> UTM Medium:</span>
                <input type="text" class="form-control theme-input" placeholder="Por exemplo, uma postagem de blog, um vídeo, uma postagem de mídia social, etc" aria-label="utm_medium" aria-describedby="utm_medium" id="utm_medium" name="utm_medium" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="utm_term"><i class="bi bi-key me-1"></i> UTM Term:</span>
                <input type="text" class="form-control theme-input" placeholder="Significa a palavra-chave usada para a promoção, gerando tráfego" aria-label="utm_term" aria-describedby="utm_term" id="utm_term" name="utm_term" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="custom_name"><i class="bi bi-pencil me-1"></i> Nome Personalizado</span>
                <input type="text" class="form-control theme-input" placeholder="Nome Personalizado da url encurtada (opcional)" aria-label="custom_name" aria-describedby="custom_name" id="custom_name" name="custom_name">
            </div>
            <button type="submit" class="btn btn-dark border-light">Gerar UTM</button>
        </form>

        <h2 class="mt-5">Histórico de URLs</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-light">
                <thead>
                    <tr>
                        <th><i class="bi bi-qr-code"></i> QR Code</th>
                        <th><i class="bi bi-link"></i> Link Original com UTM</th>
                        <th><i class="bi bi-link-45deg"></i> Link Encurtado</th>
                        <th><i class="bi bi-hand-index"></i> Clicks</th>
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
            <td class='text-center align-middle'>
                <img src='" . $qrCodeUrl . "' alt='QR Code' style='width: 30px; height: 30px; cursor: pointer;' data-bs-toggle='modal' data-bs-target='#qrModal" . $row['shortened_url'] . "'>
                <div class='modal fade' id='qrModal" . $row['shortened_url'] . "' tabindex='-1' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>QR Code</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body text-center'>
                                <img src='" . $qrCodeUrl . "' alt='QR Code' style='width: 300px; height: 300px;'>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class='col-lg-6'>
                <a href='" . htmlspecialchars($row['long_url']) . "' target='_blank' class='theme-link' data-bs-toggle='tooltip' title='Copiar'>
                    " . htmlspecialchars($row['long_url']) . "
                </a>
                <i class='bi bi-clipboard copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"" . htmlspecialchars($row['long_url']) . "\")'></i>
            </td>
            <td class='align-middle'>
                <a href='/r/" . $row['shortened_url'] . "' target='_blank' class='theme-link' data-bs-toggle='tooltip' title='Copiar'>
                    https://rugemtugem.com.br/r/" . $row['shortened_url'] . "
                </a>
                <i class='bi bi-clipboard copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"https://rugemtugem.com.br/r/" . $row['shortened_url'] . "\")'></i>
            </td>
            <td class='text-center align-middle'>" . ($row['clicks'] ?? 0) . "</td>
            <td class='text-center align-middle'>" . $formattedDate . "</td>
          </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeSwitch = document.getElementById('themeSwitch');
            const body = document.body;
            const table = document.querySelector('table'); // Seleciona a tabela
            const tableRows = document.querySelectorAll('table tbody tr'); // Seleciona as linhas da tabela
            const links = document.querySelectorAll('.theme-link');
            const modals = document.querySelectorAll('.modal-content'); // Seleciona todos os modais

            // Inicializa o tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Obter as opções
            const lightOption = themeSwitch.querySelector('.light-option');
            const darkOption = themeSwitch.querySelector('.dark-option');
            const inputs = document.querySelectorAll('.theme-input');

            // Verifica o estado inicial do tema
            if (localStorage.getItem('darkMode') === 'true') {
                darkOption.classList.add('active');
                lightOption.classList.remove('active');
                themeSwitch.classList.add('dark-active');
                body.classList.add('bg-dark', 'text-light');
                table.classList.add('table-dark'); // Adiciona classe para tabela escura
                tableRows.forEach(row => {
                    row.classList.add('text-light'); // Altera a cor do texto das linhas
                });
                inputs.forEach(input => {
                    input.classList.add('dark-input');
                    input.classList.add('dark-placeholder');
                    input.classList.remove('light-input', 'light-placeholder');
                });
                links.forEach(link => {
                    link.classList.add('dark-link');
                    link.classList.remove('light-link');
                });
                modals.forEach(modal => {
                    modal.classList.add('bg-dark', 'text-light'); // Altera o estilo do modal para escuro
                });
            } else {
                lightOption.classList.add('active');
                darkOption.classList.remove('active');
                themeSwitch.classList.add('light-active');
                body.classList.remove('bg-dark', 'text-light');
                table.classList.remove('table-dark'); // Remove classe para tabela escura
                tableRows.forEach(row => {
                    row.classList.remove('text-light'); // Restaura a cor do texto das linhas
                });
                inputs.forEach(input => {
                    input.classList.add('light-input');
                    input.classList.add('light-placeholder');
                    input.classList.remove('dark-input', 'dark-placeholder');
                });
                links.forEach(link => {
                    link.classList.add('light-link');
                    link.classList.remove('dark-link');
                });
                modals.forEach(modal => {
                    modal.classList.remove('bg-dark', 'text-light'); // Restaura o estilo do modal para claro
                });
            }

            // Alternar para Light Theme
            lightOption.addEventListener('click', function() {
                themeSwitch.classList.add('light-active');
                themeSwitch.classList.remove('dark-active');
                lightOption.classList.add('active');
                darkOption.classList.remove('active');
                body.classList.remove('bg-dark', 'text-light');
                table.classList.remove('table-dark'); // Remove classe para tabela escura
                tableRows.forEach(row => {
                    row.classList.remove('text-light'); // Restaura a cor do texto das linhas
                });
                inputs.forEach(input => {
                    input.classList.add('light-input');
                    input.classList.add('light-placeholder');
                    input.classList.remove('dark-input', 'dark-placeholder');
                });
                links.forEach(link => {
                    link.classList.add('light-link');
                    link.classList.remove('dark-link');
                });
                modals.forEach(modal => {
                    modal.classList.remove('bg-dark', 'text-light'); // Restaura o estilo do modal para claro
                });

                // Salvar no localStorage
                localStorage.setItem('darkMode', 'false');
            });

            // Alternar para Dark Theme
            darkOption.addEventListener('click', function() {
                themeSwitch.classList.add('dark-active');
                themeSwitch.classList.remove('light-active');
                darkOption.classList.add('active');
                lightOption.classList.remove('active');
                body.classList.add('bg-dark', 'text-light');
                table.classList.add('table-dark'); // Adiciona classe para tabela escura
                tableRows.forEach(row => {
                    row.classList.add('text-light'); // Altera a cor do texto das linhas
                });
                inputs.forEach(input => {
                    input.classList.add('dark-input');
                    input.classList.add('dark-placeholder');
                    input.classList.remove('light-input', 'light-placeholder');
                });
                links.forEach(link => {
                    link.classList.add('dark-link');
                    link.classList.remove('light-link');
                });

                // Salvar no localStorage
                localStorage.setItem('darkMode', 'true');
            });
        });

        function copyToClipboard(icon, text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show tooltip
                var tooltip = bootstrap.Tooltip.getInstance(icon);
                tooltip.setContent({
                    '.tooltip-inner': 'Copiado!'
                });
                tooltip.show();

                // Change icon to clipboard-check
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-clipboard-check');

                // Hide tooltip after 2 seconds and revert icon and tooltip
                setTimeout(function() {
                    tooltip.setContent({
                        '.tooltip-inner': 'Copiar'
                    });
                    tooltip.hide();
                    // Change icon back to clipboard
                    icon.classList.remove('bi-clipboard-check');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }, function(err) {
                console.error('Erro ao copiar o link: ', err);
            });
        }
    </script>

</body>

</html>