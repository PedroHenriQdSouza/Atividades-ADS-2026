<?php
include 'conexao.php';
include_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=UTF-8');

$search = trim($_GET['search'] ?? '');
$canManage = is_user_logged_in();

$sql = "SELECT * FROM usuarios";

if ($search !== '') {
    $sql .= " WHERE nome LIKE ? OR email LIKE ? OR telefone LIKE ? OR CAST(idade AS CHAR) LIKE ? OR cidade LIKE ? OR curso LIKE ?";
}

$sql .= " ORDER BY id DESC";

$stmt = null;
if ($search !== '') {
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'rowsHtml' => "<tr><td colspan='7' class='text-center text-danger'>Erro ao preparar a consulta.</td></tr>",
            'total' => 0,
            'suggestions' => []
        ]);
        exit;
    }

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

$rowsHtml = '';
$total = 0;
$suggestions = [];

while ($r = mysqli_fetch_assoc($res)) {
    $total++;

    $nome = htmlspecialchars($r['nome'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($r['email'], ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars($r['telefone'], ENT_QUOTES, 'UTF-8');
    $idade = htmlspecialchars((string) $r['idade'], ENT_QUOTES, 'UTF-8');
    $cidade = htmlspecialchars($r['cidade'], ENT_QUOTES, 'UTF-8');
    $curso = htmlspecialchars($r['curso'], ENT_QUOTES, 'UTF-8');

    $acoesHtml = "<span class='badge bg-secondary'>Somente leitura</span>";

    if ($canManage) {
        $id = (int) $r['id'];
        $acoesHtml = "
      <a href='editar.php?id={$id}'><i class='bi bi-pencil'></i></a> |
      <a href='deletar.php?id={$id}' onclick='return confirm(\"Tem certeza que deseja excluir?\")'><i class='bi bi-trash3'></i></a>
    ";
    }

    $rowsHtml .= "<tr>
      <td>{$nome}</td>
      <td>{$email}</td>
      <td>{$telefone}</td>
      <td>{$idade}</td>
      <td>{$cidade}</td>
      <td>{$curso}</td>
      <td class='text-center'>{$acoesHtml}</td>
    </tr>";

    $candidateSuggestions = [$r['nome'], $r['email'], $r['telefone'], (string) $r['idade'], $r['cidade'], $r['curso']];

    foreach ($candidateSuggestions as $candidate) {
        $value = trim((string) $candidate);
        if ($value === '') {
            continue;
        }

        if ($search !== '' && stripos($value, $search) === false) {
            continue;
        }

        if (!in_array($value, $suggestions, true)) {
            $suggestions[] = $value;
        }

        if (count($suggestions) >= 8) {
            break;
        }
    }

    if (count($suggestions) >= 8) {
        continue;
    }
}

if ($total === 0) {
    $rowsHtml = "<tr><td colspan='7' class='text-center text-muted'>Nenhum usuário encontrado para a busca informada.</td></tr>";
}

if ($stmt) {
    mysqli_stmt_close($stmt);
}

echo json_encode([
    'rowsHtml' => $rowsHtml,
    'total' => $total,
    'suggestions' => $suggestions
], JSON_UNESCAPED_UNICODE);
