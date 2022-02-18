<?php
include_once '../../src/Infra/bootstrap.php';

if (isset($_FILES['file'])) {
    newCard($_FILES['file']);
} else {
    $sProcesso = getParamPost('processo');
    echo json_encode($sProcesso());
}

function newCard($aFile)
{
    $aNomeArquivo = explode('.', $aFile['name']);
    $sExtensao = array_pop($aNomeArquivo);
    if ($sExtensao == 'png' || $sExtensao == 'jpeg' || $sExtensao == 'jpg') {
        $sConteudoArquivo = file_get_contents($aFile['tmp_name']);
        file_put_contents("../cartas/".getFileName().".$sExtensao", $sConteudoArquivo);
        @unlink($aFile['tmp_name']);
    }
    header('Location: /admin/cadastro.php');
}

function getFileName()
{
    $oDiretorio = dir('../cartas/');
    $iRetorno = '0';
    while ($sArquivo = $oDiretorio->read()) {
        $aNome     = explode('.', $sArquivo);
        $sExtensao = array_pop($aNome);
        $iArquivo  = str_replace(".$sExtensao", '', $sArquivo);
        if (is_numeric($iArquivo) && intval($iArquivo) >= $iRetorno) {
            $iRetorno = $iArquivo;
        }
    }
    return ++$iRetorno;
}

function destroyCard()
{
    $sArquivo = '../cartas/'.getParamPost('cardFile');
    if (file_exists($sArquivo)) {
        @unlink($sArquivo);
    }
    return true;
}