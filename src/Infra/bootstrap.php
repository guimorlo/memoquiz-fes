<?php

include_once 'include/funcao.php';
require_once dirname(__DIR__) . '/../vendor/autoload.php';

validaSessao();

function conecta()
{
    global $oConnection;
    if (!isset($oConnection)) {
        $oConnection = new \App\Infra\Connection();
    }
}

function validaSessao()
{
    $oControllerLogin = new \App\Controller\ControllerLogin();
    $oControllerLogin->recuperaSessao();
}
