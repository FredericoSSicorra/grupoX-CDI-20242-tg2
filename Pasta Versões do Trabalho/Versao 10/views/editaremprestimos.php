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
        $stmt = $pdo->prepare("INSERT INTO Emprestimo (Data_Emprestimo, Data_Devolucao, ID_Livro) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['Data_Emprestimo'], $_POST['Data_Devolucao'], $_POST['ID_Livro']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Emprestimo SET Data_Emprestimo = ?, Data_Devolucao = ?, ID_Livro = ? WHERE ID_Emprestimo = ?");
        $stmt->execute([$_POST['Data_Emprestimo'], $_POST['Data_Devolucao'], $_POST['ID_Livro'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Emprestimo WHERE ID_Emprestimo = ?");
        $stmt->execute([$id]);
    }
    header("Location: editaremprestimos.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Emprestimo WHERE ID_Emprestimo = ?");
    $stmt->execute([$id]);
    $emprestimo = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Emprestimo");
    $emprestimos = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empréstimos</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Empréstimos</h1>
    <?php if ($action === 'list'): ?>
        <a href="inseriremprestimos.html">Adicionar Empréstimo</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data de Empréstimo</th>
                    <th>Data de Devolução</th>
                    <th>ID Livro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprestimos as $emprestimo): ?>
                    <tr>
                        <td><?= htmlspecialchars($emprestimo['ID_Emprestimo']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['Data_Emprestimo']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['Data_Devolucao']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['ID_Livro']) ?></td>
                        <td>
                            <a href="editaremprestimos.php?action=edit&id=<?= $emprestimo['ID_Emprestimo'] ?>">Editar</a>
                            <a href="editaremprestimos.php?action=delete&id=<?= $emprestimo['ID_Emprestimo'] ?>" onclick="return confirm('Tem certeza que deseja excluir este empréstimo?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editaremprestimos.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Data_Emprestimo">Data de Empréstimo:</label>
            <input type="date" id="Data_Emprestimo" name="Data_Emprestimo" value="<?= htmlspecialchars($emprestimo['Data_Emprestimo'] ?? '') ?>" required>
            
            <label for="Data_Devolucao">Data de Devolução:</label>
            <input type="date" id="Data_Devolucao" name="Data_Devolucao" value="<?= htmlspecialchars($emprestimo['Data_Devolucao'] ?? '') ?>" required>
            
            <label for="ID_Livro">ID do Livro:</label>
            <input type="number" id="ID_Livro" name="ID_Livro" value="<?= htmlspecialchars($emprestimo['ID_Livro'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>