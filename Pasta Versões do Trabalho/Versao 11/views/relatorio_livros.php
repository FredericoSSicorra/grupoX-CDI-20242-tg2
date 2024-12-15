<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Livros por Categoria</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Relatório de Livros por Categoria</h1>

    <?php
    // Configuração de conexão com o banco de dados
    $host = 'localhost';
    $dbname = 'db_BibliotecaUFSM01';
    $username = 'root';
    $password = '';

    try {
        // Conectar ao banco de dados usando PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL para contar o número de livros por categoria
        $sql = "SELECT c.Nome_Categoria, COUNT(l.ID_Livro) AS Total_Livros
                FROM Categoria c
                LEFT JOIN Livro l ON c.ID_Categoria = l.ID_Categoria
                GROUP BY c.Nome_Categoria";

        // Executar a consulta
        $stmt = $pdo->query($sql);

        // Exibir os resultados em uma tabela
        echo "<table>";
        echo "<tr><th>Categoria</th><th>Total de Livros</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Nome_Categoria']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Total_Livros']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
    ?>

</body>
</html>
