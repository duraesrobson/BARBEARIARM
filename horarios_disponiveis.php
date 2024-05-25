<?php
$servername = "localhost";
$username = "id22216941_admin";
$password = "!Chapo24251916";
$dbname = "id22216941_barbearia2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $conn->real_escape_string($_POST['data']);
    $diaDaSemana = date('w', strtotime($data));

    $horariosDisponiveis = [];
    if ($diaDaSemana >= 1 && $diaDaSemana <= 6) { // Segunda a Sábado
        $horariosDisponiveis = gerarHorarios('09:00', '21:00');
    } else if ($diaDaSemana == 0) { // Domingo
        $horariosDisponiveis = gerarHorarios('09:00', '13:30');
    }

    // Verificar horários já ocupados
    $sql_ocupados = "SELECT horario FROM agendamentos WHERE data='$data'";
    $result_ocupados = $conn->query($sql_ocupados);
    $horariosOcupados = [];
    while ($row = $result_ocupados->fetch_assoc()) {
        $horariosOcupados[] = $row['horario'];
    }

    // Depuração: Imprimir horários ocupados
    error_log("Horários ocupados: " . implode(", ", $horariosOcupados));

    // Filtrar horários disponíveis removendo os horários ocupados
    $horariosDisponiveisFiltrados = array_diff($horariosDisponiveis, $horariosOcupados);

    // Depuração: Imprimir horários disponíveis filtrados
    error_log("Horários disponíveis filtrados: " . implode(", ", $horariosDisponiveisFiltrados));

    if (count($horariosDisponiveisFiltrados) > 0) {
        foreach ($horariosDisponiveisFiltrados as $horario) {
            echo "<option value='$horario'>$horario</option>";
        }
    } else {
        echo "<option value=''>Nenhum horário disponível</option>";
    }
}

function gerarHorarios($inicio, $fim) {
    $horarios = [];
    $horaInicio = explode(':', $inicio);
    $horaFim = explode(':', $fim);

    $horaAtual = (int)$horaInicio[0];
    $minutoAtual = (int)$horaInicio[1];

    while ($horaAtual < (int)$horaFim[0] || ($horaAtual == (int)$horaFim[0] && $minutoAtual <= (int)$horaFim[1])) {
        $horarios[] = sprintf('%02d:%02d', $horaAtual, $minutoAtual);
        $minutoAtual += 30;
        if ($minutoAtual >= 60) {
            $minutoAtual -= 60;
            $horaAtual++;
        }
    }

    return $horarios;
}

$conn->close();
?>
