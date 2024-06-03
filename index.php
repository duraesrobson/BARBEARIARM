<?php 
require_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title><?php echo $nome_sistema ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    

</head>
<body>

    <a href="../login.php" class="button-control"><i class="fas fa-cog"></i> ADM</a>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="img/logoshadow.png" width="250px" class="logoshadow">
            </div>
            <div class="card">
                <div class="card-body">
                    <h1>Agende seu corte</h1>
                    <form accept-charset="UTF-8" role="form" action="agendar.php" method="post">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input class="form-control" placeholder="Digite seu nome" name="nome" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="whatsapp">WhatsApp:</label>
                            <input class="form-control" placeholder="Digite seu WhatsApp" name="whatsapp" type="tel" pattern="[0-9]*" maxlength="12" required oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                        <div class="form-group">
                            <label for="data">Data:</label>
                            <input type="date" id="data" name="data" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="horario">Horário:</label>
                            <select id="horario" name="horario" class="form-control" required>
                                <option value="">Selecione a data primeiro</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Agendar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    //script para carregar horarios
        document.addEventListener('DOMContentLoaded', function() {
            const dataInput = document.getElementById('data');
            const horarioSelect = document.getElementById('horario');

            function carregarHorariosDisponiveis() {
                const data = dataInput.value;
                if (!data) return;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'horarios_disponiveis.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        horarioSelect.innerHTML = xhr.responseText;
                    }
                };
                xhr.send('data=' + encodeURIComponent(data));
            }

            dataInput.addEventListener('change', carregarHorariosDisponiveis);
            dataInput.setAttribute('min', new Date().toISOString().split('T')[0]);

//script para slides
            const imagens = [
                'img/fundo1.jpg',
                'img/fundo2.jpg',
                'img/fundo3.jpg',
                'img/fundo4.jpg',
                'img/fundo5.jpg',
            ];

            let imagemIndex = 0;

            function mudarImagemFundo() {
                imagemIndex = (imagemIndex + 1) % imagens.length;
                document.body.style.backgroundImage = `url('${imagens[imagemIndex]}')`;
            }

            setInterval(mudarImagemFundo, 5000);
            document.body.style.backgroundImage = `url('${imagens[imagemIndex]}')`;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
