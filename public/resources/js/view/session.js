var ViewSession = function () {

    // const oSocket = new WebSocket(`ws://${window.location.host}:8080/?hostName=${__sessionHostName}&playerName=${__playerName}`);
    const oSocket = new WebSocket(`ws://memoquiz-socket.loca.lt/?hostName=${__sessionHostName}&playerName=${__playerName}`);

    var sJogadorVez = '';

    oSocket.onmessage = (oMessage) => {
        var oMensagem = JSON.parse(oMessage.data);
        console.log(oMensagem);
        switch (oMensagem.processo) {
            case 'montaBaralho':
                sJogadorVez = oMensagem.jogadorVez;
                montaBaralho(oMensagem.params);
                if (oMensagem.aguarda) {
                    setTimeout(function () {
                        oSocket.send(JSON.stringify({ 'processo' : 'MontaBaralho', 'params' : [] }));
                    }, 1500);
                }
                break;
            case 'criaPergunta':
                montaPergunta(oMensagem.pergunta);
                console.log(oMensagem);
                break
            case 'apresentaGanhador':
                if (oMensagem.ganhador == 0) {
                    alert("O jogo empatou!")
                } else {
                    alert("O ganhador foi: " + oMensagem.ganhador);
                }
                window.location.href = window.location.origin;
                break
        };
    };

    oSocket.onopen = (oMessage) => {
        oSocket.send(JSON.stringify({ 'processo' : 'MontaBaralho', 'params' : [] }));
    };

    const montaPergunta = (oPergunta) => {
        Funcao.openModal('view_question', { 'pergunta' : oPergunta });
    };

    const montaBaralho = (aCartas) => {
        $('#box-cartas').html('');
        aCartas.forEach( (oCarta, iIndex) => {
            var oDivCarta = document.createElement("div");
            oDivCarta.id = `carta-${iIndex}`;
            if (!oCarta.encontrada) {
                oDivCarta.onclick = () => {
                    ViewSession.viraCarta(iIndex);
                };
            } else {
                oDivCarta.style.opacity = '0%';
            }
            oDivCarta.innerHTML = "<div class=\"col mt-3 text-center\">\n" +
                "                                <div class=\"card\">\n" +
                "                                    <div class=\"card-body\" style=\"background-image: url('" + getBackgroundCarta(oCarta) + "');height: 200px;background-position: center;background-size: cover;\">\n" +
                "\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                            </div>";
            $('#box-cartas').append(oDivCarta);
        });
    };

    const getBackgroundCarta = (oCarta) => {
        if (oCarta.virada) {
            return `/cartas/${oCarta.arquivo}`;
        }
        return '/resources/img/carta_default.jpg';
    };

    return {

        viraCarta: (iIndex) => {
            oSocket.send(JSON.stringify({ 'processo' : 'ViraCarta', 'params' : { 'carta' : iIndex } }));
        }

    };

}();