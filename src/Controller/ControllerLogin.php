<?php

namespace App\Controller;
use App\Model\User;

class ControllerLogin
{
    const ADMIN_USERS = [ 'morlo', 'parro' ];

    private ?User $User;

    public function __construct(User $oUser = null)
    {
        $this->User = $oUser;
    }

    public function processaLogin()
    {
        $this->validaUsuarioLogado();
        $this->iniciaNovaSessao();
    }

    private function validaUsuarioLogado()
    {
        if ($this->User->refresh()) {
            if (!empty(session_id())) {
                if (session_id() != $this->User->getSession()) {
                    session_destroy();
                    throw new \Exception('Sessão inválida!');
                }
            } else {
                throw new \Exception('Nome de Usuário já está sendo utilizado');
            }
        }
    }

    private function iniciaNovaSessao()
    {
        session_start();
        $this->User->setExpire(date('Y/m/d H:i:s', strtotime(date('H:i:s')) + 7200));
        $this->User->setSession(session_id());
        $this->User->create();

        header("Location: {$_SERVER['HTTP_ORIGIN']}");
        exit();
    }

    public function recuperaSessao()
    {
        session_start();
        if (!empty(session_id())) {
            $oUser = new User();
            $oUser->setSession(session_id());
            $oUser->firstEquals(['session']);
            if (!isBlank($oUser->getName())) {
                $oUser->setExpire(date('Y/m/d H:i:s', strtotime(date('H:i:s')) + 7200));
                $oUser->update();
                global $User;
                $User = $oUser;
            }
        }
    }

    public function destroiSessao()
    {
        header("Location: {$_SERVER['HTTP_ORIGIN']}");
        session_destroy();
        $this->User->delete();
        exit();
    }
    
}