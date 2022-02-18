/* Cria método de remoção de Elemento nos Objetos da Página */
Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
};
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
};

/**
 * Métodos estruturais e gerais no JS.
 * @type Object
 * @return JSON
 */
var Funcao = (function () {

    /**
     * Abre uma nova View Modal.
     * @param sName
     * @param oParams
     */
    const openModal = (sName, oParams) => {
        oParams.modalName = sName;
        $.ajax({
            method : 'POST',
            url    : window.location.origin + '/funcao/modal.php',
            data   : oParams
        }).done( (sHtml) => {
            if (sHtml) {
                var oModal = document.createElement('div');
                oModal.id = `modal_${sName}`;
                oModal.style.top       = '0';
                oModal.style.minWidth  = '100%';
                oModal.style.minHeight = '100%';
                oModal.style.position  = 'fixed';
                oModal.innerHTML = sHtml;
                $('body').append(oModal);
                $('#page-content').css('filter', 'blur(10px)');
            }
        });
    };

    /**
     * Fecha uma View Modal aberta.
     * @param sName
     */
    const closeModal = (sName) => {
        let oModal = document.getElementById(`modal_${sName}`);
        if (oModal) {
            oModal.remove();
        }
        $('#page-content').css('filter', 'unset');
    };

    /**
     * Entra em uma sessão criada.
     * @param sHostName
     * @param bPass
     */
    const enterSession = (sHostName, bPass) => {
        if (bPass) {
            openModal('enter_session', { 'hostname' : sHostName })
        } else {
            window.location.href = window.location.origin + `/session.php?name=${sHostName}`;
        }
    };

    /**
     * Destroi uma sessão, valida o usuário antes disso.
     * @param sHostName
     */
    const destroySession = (sHostName) => {
        $.ajax({
            method : 'POST',
            url    : window.location.origin + '/funcao/session.php',
            data   : {
                'processo'    : 'destroySession',
                'sessionHost' : sHostName
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

        /** @see openModal */
        openModal: (sName, oParams = {}) => {
            openModal(sName, oParams);
        },

        /** @see closeModal */
        closeModal: (sName) => {
            closeModal(sName);
        },

        /** @see enterSession */
        enterSession: (sHostName, bPass) => {
            enterSession(sHostName, bPass);
        },

        /** @see destroySession */
        destroySession: (sHostName) => {
            destroySession(sHostName);
        }
    };

})();