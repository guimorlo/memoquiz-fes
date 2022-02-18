<?php

namespace App\Controller;
use App\GameServer;
use App\Model\Session;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class ControllerSession
{
    private Session  $Session;
    private IoServer $GameServer;

    /** @return Session */
    public function getSession(): Session
    {
        if (!isset($this->Session)) {
            $this->Session = new Session();
        }
        return $this->Session;
    }

    /**
     * Valida o acesso do usuário na sessão.
     */
    public function validaSessionCheckin()
    {
        $this->getSession()->firstEquals([ 'hostname' => getParamGet('name', '', false) ]);
        if (!$this->getSession()->getHostname() || $this->getSession()->getPlayername() || !$this->validaPass()) {
            header("Location: http://{$_SERVER['HTTP_HOST']}");
            die();
        }
    }

    /** @return bool */
    private function validaPass() {
        return !(is_string($this->getSession()->getPass()) &&
               !isBlank($this->getSession()->getPass())) ||
               $this->getSession()->getPass() == getParamGet('pass', false, false);
    }

    public function iniciaServidor()
    {
        $this->GameServer = IoServer::factory( new HttpServer( new WsServer( new GameServer() ) ), 8080);
        $this->GameServer->run();
    }

}