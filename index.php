<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de UTM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            font-size: 0.8rem;
        }
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 65px;
            height: 30px;
        }
        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e3e1e1;
            border: 2px solid;
            transition: .4s;
            border-radius: 30px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #2196F3;
            border: 2px solid;
        }
        input:checked + .slider:before {
            transform: translateX(35px);
        }
        .slider .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            transition: opacity 0.4s;
        }
        .slider .icon.sun {
            left: 6px;
        }
        .slider .icon.moon {
            right: 5px;
            opacity: 0;
            color: #000;
        }
        input:checked + .slider .icon.sun {
            opacity: 0;
        }
        input:checked + .slider .icon.moon {
            opacity: 1;
        }
        .dark-mode .bg-dark, .dark-mode .table, .dark-mode .form-control, .dark-mode .btn {
            background-color: #343a40 !important;
            color: #ffffff !important;
        }
        .dark-mode .table th, .dark-mode .table td {
            border-color: #454d55 !important;
        }
        .dark-mode .form-control {
            border-color: #454d55;
        }
        .dark-mode .btn-primary {
            background-color: #1d6bbd !important;
            border-color: #1d6bbd !important;
        }
        .link-light a:hover{
            color: #ccc!important;
        }
        a{
            font-size: 0.8rem;
            /* These are technically the same, but use both */
            overflow-wrap: break-word;
            word-wrap: break-word;

            -ms-word-break: break-all;
            /* This is the dangerous one in WebKit, as it breaks things wherever */
            word-break: break-all;
            /* Instead use this non-standard one: */
            word-break: break-word;

            /* Adds a hyphen where the word breaks, if supported (No Blink) */
            -ms-hyphens: auto;
            -moz-hyphens: auto;
            -webkit-hyphens: auto;
            hyphens: auto;
        }
        .copy-icon {
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="custom-switch">
        <input type="checkbox" id="themeSwitch">
        <label class="slider" for="themeSwitch">
            <i class="bi bi-brightness-high icon sun"></i>
            <i class="bi bi-moon-stars-fill icon moon"></i>
        </label>
    </div>
    <h1 class="text-center">Gerador de UTM</h1>
    <form action="generate.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="website_url" class="form-label">Website URL</label>
            <input type="url" class="form-control" id="website_url" name="website_url" required>
        </div>
        <div class="mb-3">
            <label for="utm_campaign" class="form-label">UTM Campaign</label>
            <input type="text" class="form-control" id="utm_campaign" name="utm_campaign">
        </div>
        <div class="mb-3">
            <label for="utm_source" class="form-label">UTM Source</label>
            <input type="text" class="form-control" id="utm_source" name="utm_source">
        </div>
        <div class="mb-3">
            <label for="utm_medium" class="form-label">UTM Medium</label>
            <input type="text" class="form-control" id="utm_medium" name="utm_medium">
        </div>
        <div class="mb-3">
            <label for="utm_term" class="form-label">UTM Term</label>
            <input type="text" class="form-control" id="utm_term" name="utm_term">
        </div>
        <button type="submit" class="btn btn-dark">Gerar UTM</button>
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
    
    // Formatar a data para o formato dia-mês-ano
    $formattedDate = date('d-m-Y', strtotime($row['generation_date']));
    
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
                <a href='" . htmlspecialchars($row['long_url']) . "' target='_blank' class='link-dark'>
                    " . htmlspecialchars($row['long_url']) . "
                </a>
                <i class='bi bi-copy copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"" . htmlspecialchars($row['long_url']) . "\")'></i>
            </td>
            <td class='align-middle'>
                <a href='/r/" . $row['shortened_url'] . "' target='_blank' class='link-dark'>
                    https://rugemtugem.com.br/r/" . $row['shortened_url'] . "
                </a>
                <i class='bi bi-copy copy-icon' data-bs-toggle='tooltip' title='Copiar' onclick='copyToClipboard(this, \"https://rugemtugem.com.br/r/" . $row['shortened_url'] . "\")'></i>
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
        const switchInput = document.getElementById('themeSwitch');
        const body = document.body;

        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        switchInput.addEventListener('change', function() {
            body.classList.toggle('bg-dark', switchInput.checked);
            body.classList.toggle('text-light', switchInput.checked);

            // Toggle dark mode for inputs, buttons, table
            document.querySelectorAll('.form-control, .btn, .table, .link-dark').forEach(element => {
                element.classList.toggle('bg-dark', switchInput.checked);
                element.classList.toggle('text-light', switchInput.checked);
                element.classList.toggle('table-dark', switchInput.checked);
                element.classList.toggle('border-light', switchInput.checked);
                element.classList.toggle('link-light', switchInput.checked);
            });
        });
    });

    function copyToClipboard(icon, text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show tooltip
            var tooltip = bootstrap.Tooltip.getInstance(icon);
            tooltip.setContent({ '.tooltip-inner': 'Copiado!' });
            tooltip.show();

            // Hide tooltip after 2 seconds
            setTimeout(function() {
                tooltip.hide();
            }, 2000);
        }, function(err) {
            console.error('Erro ao copiar o link: ', err);
        });
    }
</script>

</body>
</html>