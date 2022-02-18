<?php
include_once '../../src/Infra/bootstrap.php';

/** @var $User \App\Model\User */
global $User;
if ($User->isAdmin()) {
?>
<!doctype html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../resources/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../resources/css/bootstrap.min.css">
    <script type="text/javascript" src="../resources/js/jquery.min.js"></script>
    <script type="text/javascript" src="../resources/js/Funcao.js"></script>
    <script type="text/javascript" src="../resources/js/view/cadastro.js"></script>
    <title>MemoQuiz</title>
</head>
<body>
<div id="page-content">
    <div class="container-fluid text-center text-black-50 font-monospace">
        <h2 class="my-3">MemoQuiz</h2>
        <?php if (isset($User)) { ?>
            <div class="m-auto" >
                <div class="row row-cols-2">
                    <div class="col-6 text-end">
                        <h6 class="my-0">Logado como: <?= $User->getName() ?></h6>
                    </div>
                    <div class="col-6 text-start">
                        <button class="btn btn-danger" onclick="ViewIndex.logout();">Sair</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="container-fluid px-5 py-1 bg-opacity-50 bg-primary">
        <div class="container bg-light p-2 border rounded-1 w-100 mt-2" >
            <div class="card">
                <div class="card-header text-center">
                    <button onclick="Funcao.openModal('new_question')" class="btn btn-primary">Nova Pergunta</button>
                    <button onclick="Funcao.openModal('new_card')" class="btn btn-primary">Nova Carta</button>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Cartas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-4">
                                <?php
                                $oDiretorio = dir('../cartas/');
                                while ($sArquivo = $oDiretorio->read()) {
                                    if (!in_array($sArquivo, ['...', '..', '.'])) { ?>
                                        <div class="col text-center">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="border border-1 border-dark rounded"
                                                         style="background-image: url('<?="/cartas/$sArquivo"?>');
                                                                background-position: center;
                                                                background-repeat: no-repeat;
                                                                background-size: contain;
                                                                height: 160px"></div>
                                                    <button onclick="ViewCadastro.excluirCarta('<?= $sArquivo ?>')" class="mt-2 btn btn-danger p-2 w-100 ">
                                                        Excluir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-1">
                        <div class="card-header text-center">
                            <h4>Perguntas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-1">
                                <?php
                                $aPerguntas = (new \App\Model\Question())->getAllModels();
                                foreach ($aPerguntas as $oPergunta) { ?>
                                    <div class="col text-center">
                                        <div class="card">
                                            <div class="card-header text-start py-2">
                                                <?= $oPergunta->getPergunta() ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="border border-1 rounded border-dark text-start p-1 my-1 <?= ($oPergunta->getCorreta() == 'a') ? 'bg-success' : '' ?>">
                                                    a) <?= $oPergunta->getAlta() ?>
                                                </div>
                                                <div class="border border-1 rounded border-dark text-start p-1 my-1 <?= ($oPergunta->getCorreta() == 'b') ? 'bg-success' : '' ?>">
                                                    b) <?= $oPergunta->getAltb() ?>
                                                </div>
                                                <div class="border border-1 rounded border-dark text-start p-1 my-1 <?= ($oPergunta->getCorreta() == 'c') ? 'bg-success' : '' ?>">
                                                    c) <?= $oPergunta->getAltc() ?>
                                                </div>
                                                <div class="border border-1 rounded border-dark text-start p-1 my-1 <?= ($oPergunta->getCorreta() == 'd') ? 'bg-success' : '' ?>">
                                                    d) <?= $oPergunta->getAltd() ?>
                                                </div>
                                                <button onclick="ViewCadastro.excluirPergunta('<?= $oPergunta->getCodigo() ?>')" class="mt-2 btn btn-danger py-1 w-100 ">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php }