<?php

namespace App;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class GameServer implements MessageComponentInterface
{
    private array $sessions = [];

    public function __construct()
    {
        $_ENV['isWebSocket'] = true;
        echo "Server started" . ENTER;
    }

    public function getSession($sHostName): GameSession
    {
        if (!isset($this->sessions[$sHostName])) {
            $this->sessions[$sHostName] = new GameSession($sHostName);
        }
        return $this->sessions[$sHostName];
    }

    function onOpen(ConnectionInterface $conn)
    {
        $oUrlParams = $this->getUriParams($conn);
        $oSession = $this->getSession($oUrlParams->hostName);
        $oSession->addPlayer($conn, $oUrlParams);
        echo "onOpen:
        \"New Connection\" => {
            playerName : {$oUrlParams->playerName},
            hostName   : {$oUrlParams->hostName  }
        };
        ";
    }

    function onClose(ConnectionInterface $conn)
    {
        $oUrlParams = $this->getUriParams($conn);
        $oSession = $this->getSession($oUrlParams->hostName);
        if ($oSession->removePlayer($conn, $oUrlParams)) {
            $oSession->getSession()->delete();
            unset($this->sessions[$oUrlParams->hostName]);
            echo "Session destroyed".ENTER;
        }
        echo "Disconnected".ENTER;
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: " . $e->getMessage() . " - " .  "{$e->getFile()}:{$e->getLine()}" . ENTER;
//        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $oUrlParams = $this->getUriParams($from);
        $oMensagem  = json_decode($msg);
        $oSession   = $this->getSession($oUrlParams->hostName);
        if (isset($oMensagem->processo)) {
            switch ($oMensagem->processo) {
                case 'MontaBaralho':
                    $this->enviaToPlayers($oSession, json_encode($oSession->clientMontaBaralho()));
                    break;
                case 'ViraCarta':
                    $bRecarrega = $oSession->viraCarta($oMensagem->params->carta, $oUrlParams->playerName);
                    $this->enviaToPlayers($oSession, json_encode($oSession->clientMontaBaralho(false, $bRecarrega)));
                    $bRecarrega && $oSession->clientMontaBaralho(true);
                    break;
            }
        }
    }

    private function enviaToPlayers(GameSession $oSession, $sMsg) {
        foreach ($oSession->getPlayers() as $oPlayer) {
            $oPlayer->conn->send($sMsg);
        }
    }

    private function getUriParams(ConnectionInterface $conn)
    {
        $aUrlParams = [];
        $aUrlComponents = parse_url($conn->httpRequest->getUri());
        parse_str($aUrlComponents['query'], $aUrlParams);
        return (object) $aUrlParams;
    }

}