<?php
// config.php
$host = 'localhost';
$dbname = 'db_BibliotecaUFSM01';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


// Tipo de tabela (Aluno, Visitante, Professor)
$tabela = $_GET['tabela'] ?? 'Aluno';

// Configuração das colunas e seus rótulos
$colunas = [
    'Aluno' => ['ID_Usuario', 'Curso', 'Matricula', 'Email', 'Telefone', 'Endereco', 'Nome'],
    'Visitante' => ['ID_Usuario', 'Data_Registro', 'Email', 'Telefone', 'Endereco', 'Nome'],
    'Professor' => ['ID_Usuario', 'Departamento', 'Data_Contratacao', 'Email', 'Telefone', 'Endereco', 'Nome'],
];

// Verificar se a tabela é válida
if (!array_key_exists($tabela, $colunas)) {
    die("Tabela inválida.");
}

// Obter as colunas da tabela selecionada
$campos = $colunas[$tabela];

// Determinar ação (list, add, edit, delete)
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = array_intersect_key($_POST, array_flip($campos));
    if ($action === 'add') {
        $placeholders = implode(',', array_fill(0, count($dados), '?'));
        $sql = "INSERT INTO $tabela (" . implode(',', array_keys($dados)) . ") VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($dados));
    } elseif ($action === 'edit' && $id) {
        $setClause = implode(',', array_map(fn($campo) => "$campo = ?", array_keys($dados)));
        $sql = "UPDATE $tabela SET $setClause WHERE ID_Usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([...array_values($dados), $id]);
    } elseif ($action === 'delete' && $id) {
        $sql = "DELETE FROM $tabela WHERE ID_Usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    header("Location: editarusuarios.php?tabela=$tabela");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM $tabela WHERE ID_Usuario = ?");
    $stmt->execute([$id]);
    $registro = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM $tabela");
    $registros = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar <?= htmlspecialchars($tabela) ?></title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Gerenciar <?= htmlspecialchars($tabela) ?></h1>
    <nav>
        <a href="?tabela=Aluno">Alunos</a> |
        <a href="?tabela=Visitante">Visitantes</a> |
        <a href="?tabela=Professor">Professores</a>
    </nav>
    <hr>

    <?php if ($action === 'list'): ?>
        <a href="?tabela=<?= $tabela ?>&action=add">Adicionar <?= $tabela ?></a>
        <table>
            <tr>
                <?php foreach ($campos as $campo): ?>
                    <th><?= htmlspecialchars($campo) ?></th>
                <?php endforeach; ?>
                <th>Ações</th>
            </tr>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <?php foreach ($campos as $campo): ?>
                        <td><?= htmlspecialchars($registro[$campo] ?? '') ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="?tabela=<?= $tabela ?>&action=edit&id=<?= $registro['ID_Usuario'] ?>">Editar</a>
                        <a href="?tabela=<?= $tabela ?>&action=delete&id=<?= $registro['ID_Usuario'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <form method="POST">
            <?php foreach ($campos as $campo): ?>
                <?php if ($campo === 'ID_Usuario' && $action === 'add') continue; ?>
                <label><?= htmlspecialchars($campo) ?>:</label>
                <input type="<?= $campo === 'Data_Registro' || $campo === 'Data_Contratacao' ? 'date' : 'text' ?>"
                       name="<?= $campo ?>"
                       value="<?= htmlspecialchars($registro[$campo] ?? '') ?>" <?= $campo === 'ID_Usuario' ? 'readonly' : 'required' ?>>
                <br>
            <?php endforeach; ?>
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>
