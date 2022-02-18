<?php

include_once('../../src/Infra/bootstrap.php');

global $User;
if (isset($User)) {
    $oControllerLogin = new \App\Controller\ControllerLogin($User);
    $oControllerLogin->destroiSessao();
}