<?php
$host = "localhost";
$user = "root";
$password = ""; // Substitua pelo seu password do MySQL
$database = "db_BibliotecaUFSM01";

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "
    SELECT 
        Aluno.Nome AS Nome_Aluno,
        Livro.Titulo AS Titulo_Livro,
        Emprestimo.Data_Emprestimo,
        Emprestimo.Data_Devolucao
    FROM 
        Emprestimo
    JOIN 
        Livro ON Emprestimo.ID_Livro = Livro.ID_Livro
    JOIN 
        Reserva ON Reserva.ID_Livro = Livro.ID_Livro
    JOIN 
         Aluno ON Aluno.ID_Usuario = Reserva.ID_Usuario;
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            width: 100%;
            text-align: center;
            margin: 0;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Empréstimos Realizados</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nome do Aluno</th>
                <th>Título do Livro</th>
                <th>Data do Empréstimo</th>
                <th>Data da Devolução</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Nome_Aluno'] . "</td>";
                    echo "<td>" . $row['Titulo_Livro'] . "</td>";
                    echo "<td>" . $row['Data_Emprestimo'] . "</td>";
                    echo "<td>" . $row['Data_Devolucao'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum resultado encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
