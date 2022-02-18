<?php

namespace App\View;

class ModalNewCard
{

    public function getName()
    {
        return 'new_card';
    }

    public function getHtml()
    {
        $sName = static::getName();
        return "<div id='modal_{$sName}_content'>
                    <div class='container container-sm'>
                        <div class='card align-middle' style='margin-top: 25%;'>
                            <form action='card.php' method='post' enctype='multipart/form-data'>   
                                <div class='card-header fw-bold text-center'>
                                    Cadastro de Carta
                                </div>
                                <div class='card-body'>
                                    <div class='w-100'>
                                        <label for='file'>Imagem da carta: </label>
                                        <input class='input-group' type='file' name='file' id='file'/>
                                    </div>
                                </div>
                                <div class='card-footer'>
                                    <div class='text-start w-50 float-start mb-2'>
                                        <button onclick='Funcao.closeModal(\"{$sName}\");' class='btn btn-danger btn-outline-light'>Cancelar</button>
                                    </div>
                                    <div class='text-end w-50 float-start mb-2'>
                                        <button class='btn btn-primary'>Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
    }
    
}