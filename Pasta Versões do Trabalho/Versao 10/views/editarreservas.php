<?php
$host = 'localhost';
$dbname = 'db_BibliotecaUFSM01';
$user = 'root';
$password = '';

// Conexão com o Banco de Dados
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
        $stmt = $pdo->prepare("INSERT INTO Reserva (ID_Usuario, ID_Livro) VALUES (?, ?)");
        $stmt->execute([$_POST['ID_Usuario'], $_POST['ID_Livro']]);
    } elseif ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE Reserva SET ID_Usuario = ?, ID_Livro = ? WHERE ID_Reserva = ?");
        $stmt->execute([$_POST['ID_Usuario'], $_POST['ID_Livro'], $id]);
    } elseif ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM Reserva WHERE ID_Reserva = ?");
        $stmt->execute([$id]);
    }
    header("Location: editarreservas.php");
    exit;
}

// Obter registro para edição
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM Reserva WHERE ID_Reserva = ?");
    $stmt->execute([$id]);
    $reserva = $stmt->fetch();
}

// Listar registros
if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM Reserva");
    $reservas = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reservas</title>
    <link rel="stylesheet" href="styleEdicao.css">
</head>
<body>
    <h1>Editar Reservas</h1>
    <?php if ($action === 'list'): ?>
        <a href="inserirreservas.html">Adicionar Reserva</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Usuário</th>
                    <th>ID Livro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['ID_Reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['ID_Usuario']) ?></td>
                        <td><?= htmlspecialchars($reserva['ID_Livro']) ?></td>
                        <td>
                            <a href="editarreservas.php?action=edit&id=<?= $reserva['ID_Reserva'] ?>">Editar</a>
                            <a href="editarreservas.php?action=delete&id=<?= $reserva['ID_Reserva'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($action === 'add' || $action === 'edit'): ?>
        <form action="editarreservas.php?action=<?= $action ?>&id=<?= $id ?>" method="post">
            <label for="ID_Usuario">ID do Usuário:</label>
            <input type="number" id="ID_Usuario" name="ID_Usuario" value="<?= htmlspecialchars($reserva['ID_Usuario'] ?? '') ?>" required>
            
            <label for="ID_Livro">ID do Livro:</label>
            <input type="number" id="ID_Livro" name="ID_Livro" value="<?= htmlspecialchars($reserva['ID_Livro'] ?? '') ?>" required>
            
            <button type="submit">Salvar</button>
        </form>
    <?php endif; ?>
</body>
</html>