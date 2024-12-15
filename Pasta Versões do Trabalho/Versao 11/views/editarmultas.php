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
        $stmt = $pdo->prepare("INSERT INTO Multa (Valor, Data_Multa, ID_Emprestimo) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['Valor'], $_POST['Data_Multa'], $_POST['ID_Emprestimo']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Multa SET Valor = ?, Data_Multa = ?, ID_Emprestimo = ? WHERE ID_Multa = ?");
        $stmt->execute([$_POST['Valor'], $_POST['Data_Multa'], $_POST['ID_Emprestimo'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Multa WHERE ID_Multa = ?");
        $stmt->execute([$id]);
    }
    header("Location: editarmultas.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Multa WHERE ID_Multa = ?");
    $stmt->execute([$id]);
    $multa = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Multa");
    $multas = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Multas</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Multas</h1>
    <?php if ($action === 'list'): ?>
        <a href="inserirmultas.html">Adicionar Multa</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th>Data da Multa</th>
                    <th>ID Empréstimo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($multas as $multa): ?>
                    <tr>
                        <td><?= htmlspecialchars($multa['ID_Multa']) ?></td>
                        <td><?= htmlspecialchars($multa['Valor']) ?></td>
                        <td><?= htmlspecialchars($multa['Data_Multa']) ?></td>
                        <td><?= htmlspecialchars($multa['ID_Emprestimo']) ?></td>
                        <td>
                            <a href="editarmultas.php?action=edit&id=<?= $multa['ID_Multa'] ?>">Editar</a>
                            <a href="editarmultas.php?action=delete&id=<?= $multa['ID_Multa'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta multa?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editarmultas.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="Valor">Valor:</label>
            <input type="number" step="0.01" id="Valor" name="Valor" value="<?= htmlspecialchars($multa['Valor'] ?? '') ?>" required>
            
            <label for="Data_Multa">Data da Multa:</label>
            <input type="date" id="Data_Multa" name="Data_Multa" value="<?= htmlspecialchars($multa['Data_Multa'] ?? '') ?>" required>
            
            <label for="ID_Emprestimo">ID do Empréstimo:</label>
            <input type="number" id="ID_Emprestimo" name="ID_Emprestimo" value="<?= htmlspecialchars($multa['ID_Emprestimo'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>