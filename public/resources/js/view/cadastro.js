var ViewCadastro = function () {

    const excluirCarta = (sImagem) => {
        $.ajax({
            method : 'POST',
            url    : window.location.origin + '/admin/card.php',
            data   : {
                'processo' : 'destroyCard',
                'cardFile' : sImagem
            }
        }).done( (oRes) => {
            if (JSON.parse(oRes) === true) {
                window.location.reload();
            } else {
                console.error(oRes);
            }
        });
    };

    const excluirPergunta = (iPergunta) => {
        $.ajax({
            method : 'POST',
            url    : window.location.origin + '/admin/question.php',
            data   : {
                'processo' : 'destroyQuestion',
                'codigo'   : iPergunta
            }
        }).done( (oRes) => {
            if (JSON.parse(oRes) === true) {
                window.location.reload();
            } else {
                console.error(oRes);
            }
        });
    };

    return {

        excluirCarta: (sImagem) => {
            excluirCarta(sImagem);
        },

        excluirPergunta: (iPergunta) => {
            excluirPergunta(iPergunta);
        }

    };

}();