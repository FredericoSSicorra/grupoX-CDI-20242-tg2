<?php
$host = 'localhost';
$dbname = 'db_BibliotecaUFSM01';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Ação (add, edit, delete)
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO Editora (Nome_Editora) VALUES (?)");
        $stmt->execute([$_POST['Nome_Editora']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Editora SET Nome_Editora = ? WHERE ID_Editora = ?");
        $stmt->execute([$_POST['Nome_Editora'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Editora WHERE ID_Editora = ?");
        $stmt->execute([$id]);
    }
    header("Location: editareditoras.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Editora WHERE ID_Editora = ?");
    $stmt->execute([$id]);
    $editora = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Editora");
    $editoras = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Editoras</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Editoras</h1>
    <?php if ($action === 'list'): ?>
        <a href="inserireditoras.html">Adicionar Editora</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($editoras as $editora): ?>
                    <tr>
                        <td><?= htmlspecialchars($editora['ID_Editora']) ?></td>
                        <td><?= htmlspecialchars($editora['Nome_Editora']) ?></td>
                        <td>
                            <a href="editareditoras.php?action=edit&id=<?= $editora['ID_Editora'] ?>">Editar</a>
                            <a href="editareditoras.php?action=delete&id=<?= $editora['ID_Editora'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta editora?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editareditoras.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Nome_Editora">Nome da Editora:</label>
            <input type="text" id="Nome_Editora" name="Nome_Editora" value="<?= htmlspecialchars($editora['Nome_Editora'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>