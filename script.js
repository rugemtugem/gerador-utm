// Script para mudar tema
document.addEventListener("DOMContentLoaded", function () {
  const themeSwitch = document.getElementById("themeSwitch");
  const body = document.body;
  const table = document.querySelector("table"); // Seleciona a tabela
  const tableRows = document.querySelectorAll("table tbody tr"); // Seleciona as linhas da tabela
  const links = document.querySelectorAll(".theme-link");
  const modals = document.querySelectorAll(".modal-content"); // Seleciona todos os modais

  // Inicializa o tooltip
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Obter as opções
  const lightOption = themeSwitch.querySelector(".light-option");
  const darkOption = themeSwitch.querySelector(".dark-option");
  const inputs = document.querySelectorAll(".theme-input");

  // Verifica o estado inicial do tema
  if (localStorage.getItem("darkMode") === "true") {
    darkOption.classList.add("active");
    lightOption.classList.remove("active");
    themeSwitch.classList.add("dark-active");
    body.classList.add("bg-dark", "text-light");
    table.classList.add("table-dark"); // Adiciona classe para tabela escura
    tableRows.forEach((row) => {
      row.classList.add("text-light"); // Altera a cor do texto das linhas
    });
    inputs.forEach((input) => {
      input.classList.add("dark-input");
      input.classList.add("dark-placeholder");
      input.classList.remove("light-input", "light-placeholder");
    });
    links.forEach((link) => {
      link.classList.add("dark-link");
      link.classList.remove("light-link");
    });
    modals.forEach((modal) => {
      modal.classList.add("bg-dark", "text-light"); // Altera o estilo do modal para escuro
    });
  } else {
    lightOption.classList.add("active");
    darkOption.classList.remove("active");
    themeSwitch.classList.add("light-active");
    body.classList.remove("bg-dark", "text-light");
    table.classList.remove("table-dark"); // Remove classe para tabela escura
    tableRows.forEach((row) => {
      row.classList.remove("text-light"); // Restaura a cor do texto das linhas
    });
    inputs.forEach((input) => {
      input.classList.add("light-input");
      input.classList.add("light-placeholder");
      input.classList.remove("dark-input", "dark-placeholder");
    });
    links.forEach((link) => {
      link.classList.add("light-link");
      link.classList.remove("dark-link");
    });
    modals.forEach((modal) => {
      modal.classList.remove("bg-dark", "text-light"); // Restaura o estilo do modal para claro
    });
  }

  // Alternar para Light Theme
  lightOption.addEventListener("click", function () {
    themeSwitch.classList.add("light-active");
    themeSwitch.classList.remove("dark-active");
    lightOption.classList.add("active");
    darkOption.classList.remove("active");
    body.classList.remove("bg-dark", "text-light");
    table.classList.remove("table-dark"); // Remove classe para tabela escura
    tableRows.forEach((row) => {
      row.classList.remove("text-light"); // Restaura a cor do texto das linhas
    });
    inputs.forEach((input) => {
      input.classList.add("light-input");
      input.classList.add("light-placeholder");
      input.classList.remove("dark-input", "dark-placeholder");
    });
    links.forEach((link) => {
      link.classList.add("light-link");
      link.classList.remove("dark-link");
    });
    modals.forEach((modal) => {
      modal.classList.remove("bg-dark", "text-light"); // Restaura o estilo do modal para claro
    });

    // Salvar no localStorage
    localStorage.setItem("darkMode", "false");
  });

  // Alternar para Dark Theme
  darkOption.addEventListener("click", function () {
    themeSwitch.classList.add("dark-active");
    themeSwitch.classList.remove("light-active");
    darkOption.classList.add("active");
    lightOption.classList.remove("active");
    body.classList.add("bg-dark", "text-light");
    table.classList.add("table-dark"); // Adiciona classe para tabela escura
    tableRows.forEach((row) => {
      row.classList.add("text-light"); // Altera a cor do texto das linhas
    });
    inputs.forEach((input) => {
      input.classList.add("dark-input");
      input.classList.add("dark-placeholder");
      input.classList.remove("light-input", "light-placeholder");
    });
    links.forEach((link) => {
      link.classList.add("dark-link");
      link.classList.remove("light-link");
    });

    // Salvar no localStorage
    localStorage.setItem("darkMode", "true");
  });
});

function copyToClipboard(icon, text) {
  navigator.clipboard.writeText(text).then(
    function () {
      // Show tooltip
      var tooltip = bootstrap.Tooltip.getInstance(icon);
      tooltip.setContent({
        ".tooltip-inner": "Copiado!",
      });
      tooltip.show();

      // Change icon to clipboard-check
      icon.classList.remove("bi-clipboard");
      icon.classList.add("bi-clipboard-check");

      // Hide tooltip after 2 seconds and revert icon and tooltip
      setTimeout(function () {
        tooltip.setContent({
          ".tooltip-inner": "Copiar",
        });
        tooltip.hide();
        // Change icon back to clipboard
        icon.classList.remove("bi-clipboard-check");
        icon.classList.add("bi-clipboard");
      }, 2000);
    },
    function (err) {
      console.error("Erro ao copiar o link: ", err);
    }
  );
}

// Modal excluir UTM
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      var id = this.getAttribute("data-id");

      // Create the modal HTML if it doesn't exist
      if (!document.getElementById("confirmDeleteModal")) {
        var modalHtml = `
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-danger-subtle border-0">
                                <div class="modal-header text-dark border-danger">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger border-0 m-0 h5 text-center" role="alert">
                                        Tem certeza que deseja excluir esta UTM? <br><strong class="lh-lg text-danger">Esta ação é irreversível!</strong>
                                    </div>
                                </div>
                                <div class="modal-footer border-danger">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        // Append modal to body
        document.body.insertAdjacentHTML("beforeend", modalHtml);
      }

      var modal = new bootstrap.Modal(
        document.getElementById("confirmDeleteModal")
      );
      modal.show();

      // Handle confirm delete
      document.getElementById("confirmDelete").addEventListener(
        "click",
        function confirmDeleteHandler() {
          fetch("delete.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: id }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                document
                  .querySelector(`button[data-id='${id}']`)
                  .closest("tr")
                  .remove();
              } else {
                alert("Erro ao excluir a entrada.");
              }
              modal.hide();
              modal.dispose(); // Properly dispose of the modal
              document.getElementById("confirmDeleteModal").remove(); // Remove modal from DOM
              location.reload(); // Refresh the page to reflect the deletion
            });

          // Remove the event listener to prevent multiple bindings
          document
            .getElementById("confirmDelete")
            .removeEventListener("click", confirmDeleteHandler);
        },
        { once: true }
      ); // Ensure the event is only fired once
    });
  });
});
