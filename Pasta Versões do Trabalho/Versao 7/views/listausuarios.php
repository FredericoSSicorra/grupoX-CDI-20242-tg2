<?php
// Configurações do banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "db_bibliotecaufsm01";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultas SQL para cada tipo de usuário
// Consultas SQL para cada tipo de usuário
$sqlAluno = "SELECT 'Aluno' AS Tipo, ID_Usuario, Nome, Email, Telefone, Endereco, Curso, Matricula, NULL AS Info1, NULL AS Info2 FROM Aluno";
$sqlProfessor = "SELECT 'Professor' AS Tipo, ID_Usuario, Nome, Email, Telefone, Endereco, NULL AS Curso, NULL AS Matricula, Departamento AS Info1, Data_Contratacao AS Info2 FROM Professor";
$sqlVisitante = "SELECT 'Visitante' AS Tipo, ID_Usuario, Nome, Email, Telefone, Endereco, NULL AS Curso, NULL AS Matricula, NULL AS Info1, NULL AS Info2 FROM Visitante";

// União das consultas
$sqlUsuarios = "
    ($sqlAluno)
    UNION ALL
    ($sqlProfessor)
    UNION ALL
    ($sqlVisitante)
    ORDER BY Tipo, Nome
";

$result = $conn->query($sqlUsuarios);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Lista de Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Informações Adicionais</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe os dados se existirem resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Tipo"] . "</td>";
                    echo "<td>" . $row["ID_Usuario"] . "</td>";
                    echo "<td>" . $row["Nome"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Telefone"] . "</td>";
                    echo "<td>" . $row["Endereco"] . "</td>";
                    // Mostra informações adicionais com base no tipo
                    if ($row["Tipo"] == "Aluno") {
                        echo "<td>Curso: " . $row["Curso"] . ", Matrícula: " . $row["Matricula"] . "</td>";
                    } elseif ($row["Tipo"] == "Professor") {
                        echo "<td>Departamento: " . $row["Info1"] . ", Contratação: " . $row["Info2"] . "</td>";
                    } elseif ($row["Tipo"] == "Visitante") {
                        echo "<td>Registro: " . $row["Info1"] . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum usuário encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
