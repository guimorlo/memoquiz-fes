<?php

const ENTER = "
";

function openScript()
{
    global $inScript;
    if (!(isset($inScript) && $inScript)) {
        $inScript = true;
        echo '<script>';
    } else {
        $inScript = false;
    }
}

function closeScript()
{
    global $inScript;
    if (isset($inScript) && $inScript) {
        $inScript = false;
        echo '</script>';
    }
}

function isAjax()
{
    $bReturn = false;
    if (isset($_POST['ajax'])) {
        $bReturn = boolval(json_decode($_POST['ajax'])) || isset($_POST['processo']);
    }
    if (isset($_GET['ajax']) && !$bReturn) {
        $bReturn = boolval(json_decode($_GET['ajax'])) || isset($_GET['processo']);
    }
    return $bReturn;
}

function isDev()
{
    return true;
}

function debugVar($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function isBlank(string $sString)
{
    return trim($sString) == '';
}

function getParamPost(string $sName, mixed $xDefault = null, bool $bThrow = true)
{
    if (isset($_POST[$sName])) {
        return $_POST[$sName];
    }
    if ($bThrow){
        throw new Exception('Parametros inválidos');
    }
    return $xDefault;
}

function getParamGet(string $sName, mixed $xDefault = null, bool $bThrow = true)
{
    if (isset($_GET[$sName])) {
        return $_GET[$sName];
    }
    if ($bThrow){
        throw new Exception('Parametros inválidos');
    }
    return $xDefault;
}

function toCamelCase(string $sString)
{
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $sString)));
}

function catchException($Exception)
{
    global $oUser;
    if (isset($_ENV['isWebSocket']) && $_ENV['isWebSocket']) {
//        file_put_contents('../log/log_'.microtime().'.txt', $Exception->getMessage() . ENTER . $Exception->getTraceAsString());
        echo "{$Exception->getMessage()} - {$Exception->getFile()}:{$Exception->getLine()}" . ENTER;
        return;
    }
    if ((isset($oUser) && in_array($oUser->getName(), \App\Controller\ControllerLogin::ADMIN_USERS)) || isDev()) {
        if (isAjax()){
            $oRes = new stdClass();
            $oRes->message = print_r($Exception, true);
            echo json_encode($oRes);
        } else {
            openScript();
            echo "console.error(\"". str_replace([ '"', ENTER ], [ '\"', '\n' ], print_r($Exception, true)) . "\")";
            closeScript();
        }
    } else {
        if (isAjax()){
            echo json_encode('Erro interno não esperado!');
        } else {
            openScript();
            echo "console.error('Erro interno não esperado!')";
            closeScript();
        }
    }
}
set_exception_handler('catchException');