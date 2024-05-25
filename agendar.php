<!DOCTYPE html>
<html>
<head>
    <title>Agendamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agendamento Concluído</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Agendamento realizado com sucesso! <br>
                <?php
                    // Recupera a data e o horário do POST
                    $data = $_POST['data'];
                    $horario = $_POST['horario'];

                    // Formata a data para o formato dd/mm/aaaa
                    $data_formatada = date("d/m/Y", strtotime($data));

                    // Formata o horário para o formato hh:mm
                    $horario_formatado = date("H:i", strtotime($horario));

                    // Monta o texto para o link do WhatsApp
                    $texto_whatsapp = "Olá! Eu gostaria de confirmar meu agendamento para o dia $data_formatada às $horario_formatado.";

                    // Exibe o link com o texto formatado
                    echo "<a href='https://wa.me/5521973875245?text=" . urlencode($texto_whatsapp) . "' target='_blank'>Clique aqui para confirmar pelo WhatsApp</a>";
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php
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

$showModal = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $whatsapp = $conn->real_escape_string($_POST['whatsapp']);
    $data = $conn->real_escape_string($_POST['data']);
    $horario = $conn->real_escape_string($_POST['horario']);

    // Verificar se o horário já está ocupado
    $sql_check = "SELECT * FROM agendamentos WHERE data='$data' AND horario='$horario'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger' role='alert'>Horário já ocupado! Por favor, escolha outro horário.</div>";
         echo '<a href="index.php" class="button-control"><i class="fas fa-arrow-left"></i> Voltar</a>';
    } else {
        $sql = "INSERT INTO agendamentos (nome, whatsapp, data, horario) VALUES ('$nome', '$whatsapp', '$data', '$horario')";

        if ($conn->query($sql) === TRUE) {
            $showModal = true;
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<script>
<?php if ($showModal): ?>
    $(document).ready(function(){
        $("#successModal").modal('show');
        $("#successModal").on('hidden.bs.modal', function () {
            window.location.href = 'index.php';
        });
    });
<?php endif; ?>
</script>

</body>
</html>

