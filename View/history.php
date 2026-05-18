<?php
require_once '../vendor/autoload.php';
session_start();

use Controller\UserController;
use Controller\ImcController;

$userController = new UserController();
$imcController = new ImcController();

if(!$userController->isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['id'];
$userInfo = $userController->getUserData($user_id);
$imcs = $imcController->getImcHistory($user_id);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $imcController->deleteImc($_POST['id']);
    header('Location: history.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitCalc | Histórico de IMC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../templates/css/history.css">
    <link rel="shortcut icon" href="../templates/assets/img/favicon.svg" type="image/x-icon">

</head>

<body>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>

    <header class="bgLinearGradient">
        <nav class="d-flex justify-content-between flex-md-row flex-column-reverse gap-2">
            <div class="user_info d-flex justify-content-center align-items-center gap-3">
                <?php if ($userInfo['profile_photo']): ?>
                    <figure class="rounded-circle d-flex justify-content-center align-items-center m-0"
                        style="background-color: #fff3; width: 40px; height: 40px; border-radius: 50%;">
                        <img src="/storage/uploads/images/<?= htmlspecialchars($userInfo['profile_photo']) ?>"
                            alt="Foto de Perfil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    </figure>
                <?php else: ?>
                    <figure class="rounded-circle d-flex justify-content-center align-items-center m-0"
                        style="background-color: #fff3; width: 40px; height: 40px; border-radius: 50%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" class="bi bi-person"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    </figure>
                <?php endif; ?>
                <!-- INFORMAÇÃO DO USUÁRIO -->
                <?php if ($userInfo): ?>
                    <div class="user_info_details d-flex flex-column">
                        <p class="text-white m-0">
                            <?= htmlspecialchars($userInfo['user_fullname']); ?>
                        </p>
                        <p>
                            <?= htmlspecialchars($userInfo['email']); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-4">
                <button class="bg-button rounded-3 border-0 d-flex flex-row justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-calculator"
                        viewBox="0 0 16 16">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path
                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <a href="home.php">Calculadora</a>
                </button>

                <button class="bg-button rounded-3 border-0 d-flex flex-row justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-calculator"
                        viewBox="0 0 16 16">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path
                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <a href="history.php">Histórico</a>
                </button>
            </div>

            <button class="bg-button rounded-3 border-0 d-flex flex-row justify-content-center align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                    class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd"
                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
                <a href="../index.php">Sair</a>
            </button>
        </nav>
    </header>


    <div class="container my-5">
        <h1 class="text-center fw-bold">Histórico de Cálculos</h1>
        <p class="text-center text-muted mb-4">
            Acompanhe a evolução dos seus cálculos de IMC
        </p>

        <div class="container-box">

            <h5 class="section-title">Resumo: <?= count($imcs["imcHistory"]); ?> cálculos salvos</h5>

            <div class="row g-4">

                <!-- Card -->
                <!-- INICIAR LOOP PARA TODOS OS IMCS DO USUÁRIO ATUAL AQUI -->

                <?php foreach ($imcs["imcHistory"] as $imc): ?>
                    <?php
                    $date = new DateTime($imc["created_at"]);
                    $imcResult = $imcController->getImc($imc["weight"], $imc["height"]);
                    ?>

                    <div class="col-md-4">
                        <div class="card-custom">
                            <small>📅 <?= $date->format("d/m/Y"); ?></small>
                            <h2><?= $imc["result"]; ?></h2>

                            <div class="status sobrepeso"><?= $imcResult["BMIrange"]; ?></div>

                            <div class="icon-text">⚖️ Peso: <?= $imc["weight"]; ?> kg</div>
                            <div class="icon-text">📏 Altura: <?= $imc["height"]; ?> m</div>
                            <form method="POST" action="history.php" class="d-flex justify-content-end align-items-center">
                                <input type="hidden" name="id" value="<?= $imc["id"]; ?>">
                                <button class="border border-0 btn-delete text-right"
                                    onclick=" return confirm('Tem certeza de que deseja excluir esse registro')"><i
                                        class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </div>

                <?php endforeach; ?>
                <?php if (isset($imcs["message"])): ?>
                    <div class="alert alert-warning">
                        <?= $imcs['message']; ?>
                    </div>

                <?php else: ?>
                    <!-- Evolução -->
                    <div class="evolution-box mt-4">
                        <h5 class="section-title">Evolução</h5>

                        <p>IMC mais recente: <strong> <?= $imcs["recentImc"]; ?></strong></p>
                        <p>IMC anterior: <strong><?= $imcs["previousImc"]; ?></strong></p>
                        <p>Variação: <span class="variation"><?= $imcs["variation"]; ?></span></p>
                        <p class="text-warning fw-bold"><i>A visualização dos IMCs limita-se em até 6 resultados no
                                histórico. Para ver os atuais, exclua os anteriores.</i>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>