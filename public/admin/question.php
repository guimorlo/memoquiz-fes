<?php
include_once '../../src/Infra/bootstrap.php';

$sProcesso = getParamPost('processo');
if ($sProcesso && !isBlank($sProcesso)) {
    echo json_encode($sProcesso());
}

function newQuestion()
{
    $oQuestion = new \App\Model\Question();
    $oQuestion->setPergunta(getParamPost('pergunta'));
    $oQuestion->setCorreta(getParamPost('correta'));
    $oQuestion->setAlta(getParamPost('alta'));
    $oQuestion->setAltb(getParamPost('altb'));
    $oQuestion->setAltc(getParamPost('altc'));
    $oQuestion->setAltd(getParamPost('altd'));
    $oQuestion->create();
    header('Location: /admin/cadastro.php');
    exit();
}

function destroyQuestion()
{
    $oQuestion = new \App\Model\Question();
    $oQuestion->setCodigo(getParamPost('codigo'));
    return boolval($oQuestion->delete());
}