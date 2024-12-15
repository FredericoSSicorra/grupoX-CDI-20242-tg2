<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidação de Informações - Biblioteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Visões Consolidadas - Biblioteca</h1>

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

        // Visão 1: Contagem de livros por autor
        echo "<h2>Total de Livros por Autor</h2>";
        $sql1 = "SELECT * FROM vw_total_livros_por_autor"; // Usando a View
        $stmt1 = $pdo->query($sql1);
        echo "<table>";
        echo "<tr><th>Autor</th><th>Total de Livros</th></tr>";
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Nome_Autor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Total_Livros']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Visão 2: Empréstimos por mês
        echo "<h2>Empréstimos por Mês</h2>";
        $sql2 = "SELECT * FROM vw_emprestimos_por_mes"; // Usando a View
        $stmt2 = $pdo->query($sql2);
        echo "<table>";
        echo "<tr><th>Mês</th><th>Total de Empréstimos</th></tr>";
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Mes']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Total_Emprestimos']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
    ?>

</body>
</html>
