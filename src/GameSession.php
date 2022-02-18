<?php

namespace App;

use App\Model\Question;
use App\Model\Session;
use App\Model\User;
use Ratchet\ConnectionInterface;

class GameSession
{
    private array   $players = [];
    private Session $Session;
    private array   $cartas;
    private string  $jogadorVez = '';

    public function __construct($sHostName)
    {
        $this->cartas = $this->getCartasAleatorias();
        $this->validaSession($sHostName);
    }

    /** @return array */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /** @return Session */
    public function getSession(): Session
    {
        return $this->Session;
    }

    /** @return array */
    public function getCartas()
    {
        return $this->cartas;
    }

    public function clientMontaBaralho($bRecarrega = false, $bAguarda = false)
    {
        $aRetorno = $this->cartas;
        if ($bRecarrega) {
            $aViradas = [];
            $iEncontradas = 0;
            foreach ($this->cartas as $iIndex => $oCarta) {
                if ($oCarta->virada) {
                    $aViradas[] = $iIndex;
                    if (sizeof($aViradas) == 2) {
                        if ($this->cartas[$aViradas[0]]->arquivo == $this->cartas[$aViradas[1]]->arquivo) {
                            $this->cartas[$aViradas[0]]->encontrada = true;
                            $this->cartas[$aViradas[1]]->encontrada = true;
                        }
                        $this->cartas[$aViradas[0]]->virada = false;
                        $this->cartas[$aViradas[1]]->virada = false;
                    }
                }
                $oCarta->encontrada && $iEncontradas++;
            }
            echo $iEncontradas . ENTER;
            if ($iEncontradas == 11) {
                $this->enviaToPlayers((object) [ 'processo' => 'apresentaGanhador',
                                                 'ganhador' => $this->getGanhador() ]);
            }
        }
        return (object) [ 'processo'   => 'montaBaralho',
                          'params'     => $aRetorno,
                          'jogadorVez' => $this->jogadorVez,
                          'aguarda'    => $bAguarda];
    }

    private function enviaToPlayers($sMsg) {
        foreach ($this->getPlayers() as $oPlayer) {
            $oPlayer->conn->send(json_encode($sMsg));
        }
    }

    private function getGanhador() {
        $iPontuacaoUm   = $this->players[0]->pontuacao;
        $iPontuacaoDois = $this->players[1]->pontuacao;
        if ($iPontuacaoDois == $iPontuacaoUm) {
            return 0;
        }
        if ($iPontuacaoUm > $iPontuacaoDois) {
            return $this->players[0]->user->getName();
        }
        return $this->players[1]->user->getName();
    }

    private function validaSession($sHostName)
    {
        $this->Session = new Session();
        $this->Session->setHostname($sHostName);
        $this->Session->firstEquals([ 'hostname' ]);
        if (isBlank($this->Session->getName())) {
            throw new \Exception('Sessão inválida');
        }
    }

    public function addPlayer(ConnectionInterface $oConnection, \stdClass $oParams)
    {
        if (sizeof($this->players) < 2) {
            $oUser = new User();
            $oUser->setName($oParams->playerName);
            $oUser->setConectado(true);
            $this->players[] = (object) [ 'user'      => $oUser,
                                          'conn'      => $oConnection,
                                          'pontuacao' => 0 ];
            if (isBlank($this->jogadorVez)) {
                $this->jogadorVez = $oParams->playerName;
            }
        }
    }

    public function removePlayer(ConnectionInterface $oConnection, \stdClass $oParams)
    {
        $iCount = sizeof($this->players);
        foreach ($this->players as $oPlayer) {
            if ($oPlayer->user->getName() == $oParams->playerName) {
                $oPlayer->user->setConectado(false);
            }
            $oPlayer->user->isConectado() || $iCount--;
        }
        return $iCount <= 0;
    }

    public function viraCarta($iCarta, $sPlayerName)
    {
        if ($this->jogadorVez == $sPlayerName) {
            $aViradas = [];
            $this->cartas[$iCarta]->virada = true;
            foreach ($this->cartas as $iIndex => $oCarta) {
                if ($oCarta->virada) {
                    $aViradas[] = $iIndex;
                    if (sizeof($aViradas) == 2) {
                        if ($this->cartas[$aViradas[0]]->arquivo != $this->cartas[$aViradas[1]]->arquivo) {
                            foreach ($this->players as $oPlayer) {
                                if ($oPlayer->user->getName() != $sPlayerName) {
                                    $this->jogadorVez = $oPlayer->user->getName();
                                    break;
                                }
                            }
                        } else {
                            foreach ($this->players as $oPlayer) {
                                if ($oPlayer->user->getName() == $sPlayerName) {
                                    $oPlayer->pontuacao++;
                                    $oPlayer->conn->send(json_encode((object) [ 'processo' => 'criaPergunta',
                                                                                'pergunta' =>  $this->getPerguntaAleatoria()]));
                                }
                            }
                        }
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function getCartasAleatorias()
    {
        $oDiretorio = dir('../../public/cartas/');
        $aArquivos = [];
        while ($sArquivo = $oDiretorio->read()) {
            if (strpos($sArquivo, '.jpg') || strpos($sArquivo, '.jpeg') || strpos($sArquivo, '.png')) {
                $aArquivos[] = $sArquivo;
            }
        }
        $aArquivos = array_slice($aArquivos, 0, 6);
        $aCartas = array_merge($aArquivos, $aArquivos);
        $aRetorno = [];
        foreach (array_rand($aCartas, 12) as $sIndex) {
            $aRetorno[] = (object) [ 'arquivo'    => $aCartas[$sIndex],
                                     'virada'     => false,
                                     'encontrada' => false];
        }
        shuffle($aRetorno);
        return $aRetorno;
    }

    private function getPerguntaAleatoria()
    {
        $aQuestion = (new Question())->getAllModels();
        $oQuestion = $aQuestion[random_int(0, sizeof($aQuestion) - 1)];
        return (object) [ 'texto'   => $oQuestion->getPergunta(),
                          'a'       => $oQuestion->getAlta(),
                          'b'       => $oQuestion->getAltb(),
                          'c'       => $oQuestion->getAltc(),
                          'd'       => $oQuestion->getAltd(),
                          'correta' => $oQuestion->getCorreta() ];
    }

}