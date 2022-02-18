<?php
include_once '../src/Infra/bootstrap.php';

/** @var $User \App\Model\User */
global $User;
$oControllerSession = new \App\Controller\ControllerSession();
$oControllerSession->validaSessionCheckin();
$oControllerSession->iniciaServidor();