<?php
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "id22216941_admin";
$password = "!Chapo24251916";
$dbname = "id22216941_barbearia2";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM agendamentos";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            display: absolute;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <a href="index.php" class="button-control"><i class="fas fa-arrow-left"></i> Voltar</a>
     <!-- Botão para a página de agendamentos -->
    <div class="container">
        <h1>Agendamentos</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>WhatsApp</th>
                <th>Data</th>
                <th>Horário</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $whatsapp_link = "https://wa.me/55" . preg_replace("/\D/", "", $row["whatsapp"]);
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nome"] . "</td>";
                    echo "<td><a href='$whatsapp_link' target='_blank'>" . $row["whatsapp"] . "</a></td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["data"])) . "</td>"; // Formatação da data
                    echo "<td>" . $row["horario"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum agendamento encontrado</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        
     <!-- Botão para a página de login do administrador -->
    </div>
</body>
</html>
