<?php

namespace App\View;

class ModalNewSession
{

    public static function getName()
    {
        return 'new_session';
    }

    public static function getHtml()
    {
        $sName = static::getName();
        return "<div id='modal_{$sName}_content'>
                    <div class='container container-sm'>
                        <div class='card align-middle' style='margin-top: 25%;'>
                            <form onsubmit='sendCreateSession()' action='funcao/session.php' method='post'>
                                <div class='card-header fw-bold text-center'>
                                    Criar Nova Sessão
                                </div>
                                <div class='card-body'>
                                    <table class='w-100'>
                                        <tr>
                                            <td class='text-start'>*Nome da Sessão: </td>
                                            <td class='text-start'>Senha de Acesso: </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class='input-group-text form-text' type='text' name='sessionName' id='sessionName' required/>
                                            </td>
                                            <td>
                                                <input class='input-group-text form-text' type='password' name='sessionPass' id='sessionPass'/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='card-footer'>
                                    <div class='text-start w-50 float-start'>
                                        <button onclick='Funcao.closeModal(\"{$sName}\");' class='btn mb-2 btn-danger btn-outline-light'>Fechar</button>
                                    </div>
                                    <div class='text-end w-50 float-start'>
                                        <button class='btn mb-2 btn-primary'>Criar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script type='application/javascript'>
                        function sendCreateSession() 
                        {
                            var sSessionName = $('#sessionName').val(),
                                sSessionPass = $('#sessionPass').val();
                            $.ajax({
                                method : 'POST',
                                url    : window.location.origin + '/funcao/session.php',
                                data   : {
                                    'sessionName' : sSessionName,
                                    'sessionPass' : sSessionPass,
                                    'processo'    : 'newSession'
                                }
                            }).done( (xRes) => {
                                if (JSON.parse(xRes) == true) {
                                    window.location.href = window.location.origin + '/session.php?name=' + sSessionName + '&pass=' + sSessionPass;
                                } else {
                                    window.location.href = window.location.origin;
                                }
                            });
                        }
                    </script>
                </div>";
    }
    
}