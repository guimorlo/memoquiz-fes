<?php
include_once '../src/Infra/bootstrap.php';

/** @var $User \App\Model\User */
global $User;
$oControllerSession = new \App\Controller\ControllerSession();
$oControllerSession->validaSessionCheckin();
?>
<!doctype html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <script type="text/javascript" src="resources/js/jquery.min.js"></script>
    <script type="text/javascript"> var __playerName      = <?= json_encode($User->getName()); ?>,
                                        __sessionHostName = <?= json_encode($oControllerSession->getSession()->getHostname()); ?>; </script>
    <script type="text/javascript" src="resources/js/view/session.js"></script>
    <script type="text/javascript" src="resources/js/Funcao.js"></script>
    <title>MemoQuiz</title>
</head>
<body>
<div id="page-content">
    <div class="container-fluid text-center text-black-50 font-monospace">
        <h2 class="my-3">MemoQuiz</h2>
        <div class="m-auto" >
            <div class="row row-cols-2">
                <div class="col-6 text-end">
                    <h6 class="my-0">Logado como: <?= $User->getName() ?></h6>
                </div>
                <div class="col-6 text-start">
                    <button class="btn btn-danger" onclick="window.location.href = window.location.origin">Sair</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-5 py-1 bg-opacity-50 bg-primary">
            <div class="container bg-light p-2 border rounded-1 w-100 mt-2" >
                <div class="card">
                    <div class="card-header text-center">
                        Jogando na Sessão <?= $oControllerSession->getSession()->getName() ?> de <?= $oControllerSession->getSession()->getHostname() ?>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-6" id="box-cartas">

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</body>
</html>
