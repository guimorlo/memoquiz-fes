<?php

include_once('../../src/Infra/bootstrap.php');

$sName = getParamPost('name');
if (isBlank($sName)) {
    throw new Exception('Nome de usuário inválido');
}

$oUser = new \App\Model\User($sName);
$oControllerLogin = new \App\Controller\ControllerLogin($oUser);
$oControllerLogin->processaLogin();