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
        $stmt = $pdo->prepare("INSERT INTO Categoria (Nome_Categoria) VALUES (?)");
        $stmt->execute([$_POST['Nome_Categoria']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Categoria SET Nome_Categoria = ? WHERE ID_Categoria = ?");
        $stmt->execute([$_POST['Nome_Categoria'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Categoria WHERE ID_Categoria = ?");
        $stmt->execute([$id]);
    }
    header("Location: editarcategorias.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Categoria WHERE ID_Categoria = ?");
    $stmt->execute([$id]);
    $categoria = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Categoria");
    $categorias = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categorias</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Categorias</h1>
    <?php if ($action === 'list'): ?>
        <a href="editarcategorias.php?action=add">Adicionar Categoria</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= htmlspecialchars($categoria['ID_Categoria']) ?></td>
                        <td><?= htmlspecialchars($categoria['Nome_Categoria']) ?></td>
                        <td>
                            <a href="editarcategorias.php?action=edit&id=<?= $categoria['ID_Categoria'] ?>">Editar</a>
                            <a href="editarcategorias.php?action=delete&id=<?= $categoria['ID_Categoria'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editarcategorias.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Nome_Categoria">Nome da Categoria:</label>
            <input type="text" id="Nome_Categoria" name="Nome_Categoria" value="<?= htmlspecialchars($categoria['Nome_Categoria'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>