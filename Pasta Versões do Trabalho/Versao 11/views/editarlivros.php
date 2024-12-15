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
        $stmt = $pdo->prepare("INSERT INTO Livro (Titulo, Data_Publicacao, Numero_Copias, ID_Autor, ID_Categoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['Titulo'], $_POST['Data_Publicacao'], $_POST['Numero_Copias'], $_POST['ID_Autor'], $_POST['ID_Categoria']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Livro SET Titulo = ?, Data_Publicacao = ?, Numero_Copias = ?, ID_Autor = ?, ID_Categoria = ? WHERE ID_Livro = ?");
        $stmt->execute([$_POST['Titulo'], $_POST['Data_Publicacao'], $_POST['Numero_Copias'], $_POST['ID_Autor'], $_POST['ID_Categoria'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Livro WHERE ID_Livro = ?");
        $stmt->execute([$id]);
    }
    header("Location: editarlivros.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Livro WHERE ID_Livro = ?");
    $stmt->execute([$id]);
    $livro = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Livro");
    $livros = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livros</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Livros</h1>
    <?php if ($action === 'list'): ?>
        <a href="inserirlivros.html">Adicionar Livro</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Data de Publicação</th>
                    <th>Número de Cópias</th>
                    <th>ID Autor</th>
                    <th>ID Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?= htmlspecialchars($livro['ID_Livro']) ?></td>
                        <td><?= htmlspecialchars($livro['Titulo']) ?></td>
                        <td><?= htmlspecialchars($livro['Data_Publicacao']) ?></td>
                        <td><?= htmlspecialchars($livro['Numero_Copias']) ?></td>
                        <td><?= htmlspecialchars($livro['ID_Autor']) ?></td>
                        <td><?= htmlspecialchars($livro['ID_Categoria']) ?></td>
                        <td>
                            <a href="editarlivros.php?action=edit&id=<?= $livro['ID_Livro'] ?>">Editar</a>
                            <a href="editarlivros.php?action=delete&id=<?= $livro['ID_Livro'] ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editarlivros.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Titulo">Título:</label>
            <input type="text" id="Titulo" name="Titulo" value="<?= htmlspecialchars($livro['Titulo'] ?? '') ?>" required>
            
            <label for="Data_Publicacao">Data de Publicação:</label>
            <input type="date" id="Data_Publicacao" name="Data_Publicacao" value="<?= htmlspecialchars($livro['Data_Publicacao'] ?? '') ?>" required>
            
            <label for="Numero_Copias">Número de Cópias:</label>
            <input type="number" id="Numero_Copias" name="Numero_Copias" value="<?= htmlspecialchars($livro['Numero_Copias'] ?? '') ?>" required>
            
            <label for="ID_Autor">ID do Autor:</label>
            <input type="number" id="ID_Autor" name="ID_Autor" value="<?= htmlspecialchars($livro['ID_Autor'] ?? '') ?>" required>
            
            <label for="ID_Categoria">ID da Categoria:</label>
            <input type="number" id="ID_Categoria" name="ID_Categoria" value="<?= htmlspecialchars($livro['ID_Categoria'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>
