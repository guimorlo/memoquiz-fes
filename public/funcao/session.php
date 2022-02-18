<?php

include_once('../../src/Infra/bootstrap.php');

$sProcesso = getParamPost('processo');
echo json_encode($sProcesso());

function newSession() {
    global $User;
    $oSession = new \App\Model\Session();
    $oSession->setHost($User);
    $oSession->setName(getParamPost('sessionName'));
    $sPass = getParamPost('sessionPass');
    if (!isBlank($sPass)) {
        $oSession->setPass($sPass);
    }
    if ($oSession->create()) {
        header("Location: /session.php?name={$oSession->getName()}&pass={$sPass}");
        return true;
    }
    return false;
}

function destroySession() {
    /* @var \App\Model\User $User */
    global $User;
    if ($User->isAdmin()) {
        $oSession = new \App\Model\Session();
        $oSession->setHostname(getParamPost('sessionHost'));
        return boolval($oSession->delete());
    }
    return false;
}