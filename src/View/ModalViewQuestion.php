<?php

namespace App\View;

class ModalViewQuestion
{

    public function getName()
    {
        return 'view_question';
    }

    public function getHtml()
    {
        $sName = static::getName();
        $oData = (object) getParamPost('pergunta');
        return "<div id='modal_{$sName}_content'>
                    <div class='container container-sm'>
                        <div class='card align-middle' style='margin-top: 8%;'>
                            <div class='card-header fw-bold text-center'>
                                Pergunta
                            </div>
                            <div class='card-body'>
                                <div class='w-100'>
                                    <input class='input-group-text w-100 text-start' type='text' id='pergunta' value='{$oData->texto}' disabled/>
                                </div>
                                <hr/>
                                <div class='w-100'>
                                    <div class='w-100' onclick='defineCorreta(\"a\")'>
                                        <label>a) </label>
                                        <input class='input-group-text text-start w-100' type='text' value='{$oData->a}' id='alta' disabled/>
                                    </div>
                                    <div class='w-100' onclick='defineCorreta(\"b\")'>
                                        <label for='altb'>b) </label>
                                        <input class='input-group-text text-start w-100' type='text' value='{$oData->b}' id='altb' disabled/>
                                    </div>
                                    <div class='w-100' onclick='defineCorreta(\"c\")'>
                                        <label>c) </label>
                                        <input class='input-group-text text-start w-100' type='text' value='{$oData->c}' id='altc' disabled/>
                                    </div>
                                    <div class='w-100' onclick='defineCorreta(\"d\")'>
                                        <label>d) </label>
                                        <input class='input-group-text text-start w-100' type='text' value='{$oData->d}' id='altd' disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class='card-footer'>
                                <div class='text-start w-50 float-start mb-2'>
                                    <button onclick='Funcao.closeModal(\"{$sName}\");' class='btn btn-danger btn-outline-light'>Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type='text/javascript'>
                        function defineCorreta(sId)
                        {
                            if (sId == '{$oData->correta}') {
                                $('#alt'+sId).css('background-color', 'green');
                            } else {
                                $('#alt'+sId).css('background-color', 'red');
                            }
                            setTimeout(function () {
                                    Funcao.closeModal(\"{$sName}\");
                                }, 1200);
                        }
                    </script>
                </div>";
    }
    
}