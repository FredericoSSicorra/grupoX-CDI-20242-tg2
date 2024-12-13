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
        $stmt = $pdo->prepare("INSERT INTO Autor (Nome_Autor, Nacionalidade, Data_Nascimento, ID_Editora) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['Nome_Autor'], $_POST['Nacionalidade'], $_POST['Data_Nascimento'], $_POST['ID_Editora']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Autor SET Nome_Autor = ?, Nacionalidade = ?, Data_Nascimento = ?, ID_Editora = ? WHERE ID_Autor = ?");
        $stmt->execute([$_POST['Nome_Autor'], $_POST['Nacionalidade'], $_POST['Data_Nascimento'], $_POST['ID_Editora'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Autor WHERE ID_Autor = ?");
        $stmt->execute([$id]);
    }
    header("Location: editarautores.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Autor WHERE ID_Autor = ?");
    $stmt->execute([$id]);
    $autor = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Autor");
    $autores = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autores</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Autores</h1>
    <?php if ($action === 'list'): ?>
        <a href="inserirautores.html">Adicionar Autor</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Nacionalidade</th>
                    <th>Data de Nascimento</th>
                    <th>ID Editora</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores as $autor): ?>
                    <tr>
                        <td><?= htmlspecialchars($autor['ID_Autor']) ?></td>
                        <td><?= htmlspecialchars($autor['Nome_Autor']) ?></td>
                        <td><?= htmlspecialchars($autor['Nacionalidade']) ?></td>
                        <td><?= htmlspecialchars($autor['Data_Nascimento']) ?></td>
                        <td><?= htmlspecialchars($autor['ID_Editora']) ?></td>
                        <td>
                            <a href="editarautores.php?action=edit&id=<?= $autor['ID_Autor'] ?>">Editar</a>
                            <a href="editarautores.php?action=delete&id=<?= $autor['ID_Autor'] ?>" onclick="return confirm('Tem certeza que deseja excluir este autor?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editarautores.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Nome_Autor">Nome do Autor:</label>
            <input type="text" id="Nome_Autor" name="Nome_Autor" value="<?= htmlspecialchars($autor['Nome_Autor'] ?? '') ?>" required>
            
            <label for="Nacionalidade">Nacionalidade:</label>
            <input type="text" id="Nacionalidade" name="Nacionalidade" value="<?= htmlspecialchars($autor['Nacionalidade'] ?? '') ?>" required>
            
            <label for="Data_Nascimento">Data de Nascimento:</label>
            <input type="date" id="Data_Nascimento" name="Data_Nascimento" value="<?= htmlspecialchars($autor['Data_Nascimento'] ?? '') ?>" required>
            
            <label for="ID_Editora">ID da Editora:</label>
            <input type="number" id="ID_Editora" name="ID_Editora" value="<?= htmlspecialchars($autor['ID_Editora'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>