<?php
include_once '../src/Infra/bootstrap.php';

/** @var $User \App\Model\User */
global $User;
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
    <script type="text/javascript" src="resources/js/view/index.js"></script>
    <script type="text/javascript" src="resources/js/Funcao.js"></script>
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
            <?php
                if (!isset($User)) {
            ?>
            <div class="container bg-light p-2 border rounded-1 text-center w-50">
                <form class="row row-cols-2" action="funcao/login.php" method="post">
                    <div class="col-9">
                        <input class="form-control-plaintext bg-secondary bg-opacity-25 rounded-3 text-center" placeholder="Informe o nome de Usuário" type="text" name="name" id="user">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success btn-outline-light w-100">Entrar</button>
                    </div>
                </form>
            </div>
            <?php
                } else {
            ?>
            <div class="container bg-light p-2 border rounded-1 w-100 mt-2" >
                <div class="card">
                    <div class="card-header text-center">
                        <button onclick="Funcao.openModal('new_session')" class="btn btn-primary">Novo Jogo</button>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-3">
                      <?php
                            $oModelSession = new \App\Model\Session();
                            foreach ($oModelSession->getAllModels() as $oSession) { ?>
                            <div class="col text-center">
                                <div class="card">
                                    <div class="card-header">
                                        <?= $oSession->getName() ?>
                                    </div>
                                    <div class="card-body">
                                        <?= isBlank($oSession->getPlayername()) ? "<p class='text-success'>Disponível</p>" : "<p class='text-danger'>Lotada</p>" ?>
                                        <p>Dono: <?= $oSession->getHostname() ?></p>
                                        <?php if (isBlank($oSession->getPlayername())) { ?>
                                            <button onclick="Funcao.enterSession('<?= $oSession->getHostname() ?>', <?= json_encode(!isBlank($oSession->getPass())) ?>)" class="btn btn-success p-2 w-100 ">
                                                Entrar
                                            </button>
                                        <?php }
                                        if ($User->isAdmin()) { ?>
                                            <button onclick="Funcao.destroySession('<?= $oSession->getHostname() ?>')" class="mt-2 btn btn-danger p-2 w-100 ">
                                                Destruir
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                      <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>
