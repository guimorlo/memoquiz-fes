<?php

include_once('../../src/Infra/bootstrap.php');

$sModalName = getParamPost('modalName', '');
if (!isBlank($sModalName)) {
    $sModalClass = "\App\View\Modal". toCamelCase($sModalName);
    $oModal = new $sModalClass();
    echo $oModal->getHtml();
    die();
}
echo json_encode(false);
die();