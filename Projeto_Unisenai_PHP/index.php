<?php
include 'conexao.php';

//Variavel usada no <title> da pagina ( header.php)
$pageTitle = "Usuários Cadastrados";

//inclui no topo da pagina (HTML Inicial + navbar)
include 'includes/header.php';

$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
$search = trim($_GET['search'] ?? '');
$canManage = is_user_logged_in();
?>

<?php if ($msg !== ''): ?>
  <?php $isSuccess = $status === 'success'; ?>
  <div class="alert <?php echo $isSuccess ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
  </div>
<?php endif; ?>

<div class="d-flex align-items-center justify-content-between mb-3">
<h2 class="mb-0">Usuários</h2>

  <div class="d-flex gap-2">
    <a href="form.php" class="btn btn-success">
      <i class="bi bi-plus-circle me-1"></i>Novo
    </a>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#cadastroUsuarioModal">
      <i class="bi bi-window-plus me-1"></i>Novo (Modal)
    </button>
  </div>
</div>

<form method="GET" action="index.php" class="row g-2 mb-3">
  <div class="col-12 col-md-8 col-lg-6">
    <input
      id="searchInput"
      type="text"
      name="search"
      class="form-control"
      list="searchSuggestions"
      autocomplete="off"
      placeholder="Pesquisar por nome, email, telefone, idade, cidade ou curso"
      value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
    >
    <datalist id="searchSuggestions"></datalist>
  </div>
  <div class="col-auto d-flex align-items-center gap-2">
    <button type="submit" class="btn btn-primary">Buscar</button>
    <?php if ($search !== ''): ?>
      <a href="index.php" class="btn btn-outline-secondary">Limpar</a>
    <?php endif; ?>

    <div class="form-check form-switch ms-2">
      <input class="form-check-input" type="checkbox" id="ajaxToggle" checked>
      <label class="form-check-label" for="ajaxToggle">Usar AJAX</label>
    </div>
  </div>

  <div class="col-12">
    <small id="searchFeedback" class="text-muted"></small>
  </div>
</form>

<!-- <h2>Usuários</h2>

<a href="form.php">Novo</a><br><br> -->

<table class="table table-hover">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>Idade</th>
      <th>Cidade</th>
      <th>Curso</th>
      <th class="text-center">Ações</th>
    </tr>
  </thead>
  <tbody id="usuariosTableBody">

<?php
$sql = "SELECT * FROM usuarios";

if ($search !== '') {
  $sql .= " WHERE nome LIKE ? OR email LIKE ? OR telefone LIKE ? OR CAST(idade AS CHAR) LIKE ? OR cidade LIKE ? OR curso LIKE ?";
}

$sql .= " ORDER BY id DESC";

if ($search !== '') {
  $stmt = mysqli_prepare($conn, $sql);
  $likeSearch = "%{$search}%";

  mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $likeSearch,
    $likeSearch,
    $likeSearch,
    $likeSearch,
    $likeSearch,
    $likeSearch
  );

  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
} else {
  $res = mysqli_query($conn, $sql);
}

while ($r = mysqli_fetch_assoc($res)){
  $acoesHtml = "<span class='badge bg-secondary'>Somente leitura</span>";

  if ($canManage) {
    $id = (int) $r['id'];
    $acoesHtml = "
    
      <button type='button' class='btn btn-outline-success' data-bs-toggle='modal' id={$id} data-bs-target='#editarUsuarioModal'>
      <i class='bi bi-pen'></i>
      </button>|
      <a href='editar.php?id={$id}'><i class='bi bi-pencil'></i></a> |
      <a href='deletar.php?id={$id}' onclick='return confirm(\"Tem certeza que deseja excluir?\")'><i class='bi bi-trash3'></i></a>
    ";
  }

  echo "<tr>
    <td>" . htmlspecialchars($r['nome'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>" . htmlspecialchars($r['email'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>" . htmlspecialchars($r['telefone'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>" . htmlspecialchars((string) $r['idade'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>" . htmlspecialchars($r['cidade'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>" . htmlspecialchars($r['curso'], ENT_QUOTES, 'UTF-8') . "</td>
    <td class='text-center'>{$acoesHtml}</td>
  </tr>";
}

if (mysqli_num_rows($res) === 0) {
  echo "<tr><td colspan='7' class='text-center text-muted'>Nenhum usuário encontrado para a busca informada.</td></tr>";
}

if (isset($stmt)) {
  mysqli_stmt_close($stmt);
}
?>
  </tbody>

</table>

<!-- MODAL CADASTRAR -->
<div class="modal fade" id="cadastroUsuarioModal" tabindex="-1" aria-labelledby="cadastroUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cadastroUsuarioModalLabel">
          <i class="bi bi-person-plus me-1"></i>Novo usuário (modal)
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <form method="POST" action="salvar.php" id="cadastroUsuarioFormModal">
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


<!-- MODAL EDITAR -->

$res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
$dados = mysqli_fetch_assoc($res);
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel">
          <i class="bi bi-person-plus me-1"></i>Editar usuário (modal)
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <form method="POST" action="salvar.php" id="editarUsuarioFormModal">
        <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">

Nome: <br>
<input type="text" name="nome" value="<?php echo $dados['nome']; ?>"><br><br>

Email: <br>
<input type="email" name="email" value="<?php echo $dados['email']; ?>"><br><br>

Telefone: <br>
<input type="text" name="telefone" value="<?php echo $dados['telefone']; ?>"><br><br>

Idade: <br>
<input type="number" name="idade" value="<?php echo $dados['idade']; ?>"><br><br>

Cidade: <br>
<input type="text" name="cidade" value="<?php echo $dados['cidade']; ?>"><br><br>

Curso: <br>
<input type="text" name="curso" value="<?php echo $dados['curso']; ?>"><br><br>

<button type="submit">Atualizar</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2-circle me-1"></i>Editar usuário
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