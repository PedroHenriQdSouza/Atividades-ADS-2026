<?php
include 'conexao.php';
include_once 'auth.php';
//Variavel usada no <title> da pagina ( header.php)
$pageTitle = "Usuários Cadastrados";

//inclui no topo da pagina (HTML Inicial + navbar)
include 'includes/header.php';

$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
$search = trim($_GET['search'] ?? '');
$canManage = is_user_logged_in();


$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
$dados = mysqli_fetch_assoc($res);

?>

<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
      <i class="bi bi-window-plus me-1"></i>Novo (Modal)
    </button>

<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel">
          <i class="bi bi-person-plus me-1"></i>Novo usuário (modal)
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <form method="POST" action="salvar.php" id="editarUsuarioFormModal">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label for="modal_nome" class="form-label">Nome</label>
              <input type="text" id="modal_nome" name="nome" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
              <label for="modal_email" class="form-label">Email</label>
              <input type="email" id="modal_email" name="email" class="form-control" required>
            </div>
            <div class="col-12 col-md-6">
              <label for="modal_telefone" class="form-label">Telefone</label>
              <input type="text" id="modal_telefone" name="telefone" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
              <label for="modal_idade" class="form-label">Idade</label>
              <input type="number" id="modal_idade" name="idade" class="form-control" min="1" required>
            </div>
            <div class="col-12 col-md-4">
              <label for="modal_cidade" class="form-label">Cidade</label>
              <input type="text" id="modal_cidade" name="cidade" class="form-control" required>
            </div>
            <div class="col-12 col-md-4">
              <label for="modal_curso" class="form-label">Curso</label>
              <input type="text" id="modal_curso" name="curso" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2-circle me-1"></i>Salvar usuário
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  (function () {
    const form = document.querySelector('form[action="index.php"]');
    const input = document.getElementById('searchInput');
    const toggle = document.getElementById('ajaxToggle');
    const tableBody = document.getElementById('usuariosTableBody');
    const datalist = document.getElementById('searchSuggestions');
    const feedback = document.getElementById('searchFeedback');

    if (!form || !input || !toggle || !tableBody || !datalist || !feedback) {
      return;
    }

    let debounceTimer;
    let activeController = null;

    function setFeedback(message) {
      feedback.textContent = message;
    }

    async function fetchUsers(term) {
      if (!toggle.checked) {
        return;
      }

      if (activeController) {
        activeController.abort();
      }

      activeController = new AbortController();

      try {
        const response = await fetch('buscar_usuarios_ajax.php?search=' + encodeURIComponent(term), {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          signal: activeController.signal
        });

        if (!response.ok) {
          throw new Error('Falha ao buscar usuários.');
        }

        const data = await response.json();

        tableBody.innerHTML = data.rowsHtml;

        datalist.innerHTML = '';
        (data.suggestions || []).forEach(function (item) {
          const option = document.createElement('option');
          option.value = item;
          datalist.appendChild(option);
        });

        const total = Number(data.total || 0);
        setFeedback(total + (total === 1 ? ' resultado encontrado (AJAX).' : ' resultados encontrados (AJAX).'));
      } catch (error) {
        if (error.name !== 'AbortError') {
          setFeedback('Nao foi possivel carregar os resultados via AJAX.');
        }
      }
    }

    input.addEventListener('input', function () {
      if (!toggle.checked) {
        return;
      }

      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function () {
        fetchUsers(input.value.trim());
      }, 250);
    });

    form.addEventListener('submit', function (event) {
      if (!toggle.checked) {
        return;
      }

      event.preventDefault();
      fetchUsers(input.value.trim());
    });

    toggle.addEventListener('change', function () {
      if (toggle.checked) {
        fetchUsers(input.value.trim());
      } else {
        setFeedback('Busca AJAX desativada. A pesquisa sera feita ao clicar em Buscar.');
      }
    });
  })();
</script>

<?php include 'includes/footer.php' ?>