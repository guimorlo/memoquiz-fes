<?php

namespace App\View;

class ModalNewQuestion
{

    public function getName()
    {
        return 'new_question';
    }

    public function getHtml()
    {
        $sName = static::getName();
        return "<div id='modal_{$sName}_content'>
                    <div class='container container-sm'>
                        <div class='card align-middle' style='margin-top: 10%;'>
                            <form action='question.php' method='post'>  
                                <input type='hidden' name='processo' value='newQuestion'/>
                                <div class='card-header fw-bold text-center'>
                                    Cadastro de Pergunta
                                </div>
                                <div class='card-body'>
                                    <div class='w-100'>
                                        <label for='pergunta'>Pergunta: </label>
                                        <input class='input-group-text w-100 text-start' type='text' name='pergunta' id='pergunta' required/>
                                    </div>
                                    <hr/>
                                    <div class='w-100'>
                                        <div class='float-start'>
                                            <label for='alta'>a) </label>
                                            <input class='input-group-text text-start' type='text' name='alta' id='alta' required/>
                                        </div>
                                        <div class='float-start ms-3'>
                                            <label for='altb'>b) </label>
                                            <input class='input-group-text text-start' type='text' name='altb' id='altb' required/>
                                        </div>
                                        <div class='float-start ms-3'>
                                            <label for='altc'>c) </label>
                                            <input class='input-group-text text-start' type='text' name='altc' id='altc' required/>
                                        </div>
                                        <div class='float-start ms-3'>
                                            <label for='altd'>d) </label>
                                            <input class='input-group-text text-start' type='text' name='altd' id='altd' required/>
                                        </div>
                                    </div>
                                    <div class='clearfix'></div>
                                    <div class='w-100 my-2'>
                                        <label for='correta'>Alternativa Correta: </label>
                                        <select class='form-select w-25' name='correta' id='correta'>
                                            <option value='a'>a)</option>
                                            <option value='b'>b)</option>
                                            <option value='c'>c)</option>
                                            <option value='d'>d)</option>
                                        </select>
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