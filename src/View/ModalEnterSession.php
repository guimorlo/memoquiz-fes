<?php

namespace App\View;

class ModalEnterSession
{

    public static function getName()
    {
        return 'enter_session';
    }

    public static function getHtml()
    {
        $sHostName = getParamPost('hostname');
        $sName = static::getName();
        return "<div id='modal_{$sName}_content'>
                    <div class='container container-sm'>
                        <div class='card align-middle' style='margin-top: 25%;'>
                            <form action='/session.php' method='get'>   
                                <input type='hidden' name='name' value=\"{$sHostName}\" >
                                <div class='card-header fw-bold text-center'>
                                    Entrar na Sessão de {$sHostName}
                                </div>
                                <div class='card-body'>
                                    <table class='w-100'>
                                        <tr>
                                            <td class='text-start'>*Senha de Acesso: </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class='input-group-text form-text' type='password' name='pass' id='sessionPass' required/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='card-footer'>
                                    <div class='text-start w-50 float-start'>
                                        <button onclick='Funcao.closeModal(\"{$sName}\");' class='btn btn-danger btn-outline-light'>Cancelar</button>
                                    </div>
                                    <div class='text-end w-50 float-start'>
                                        <button class='btn btn-primary'>Entrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
    }
    
}