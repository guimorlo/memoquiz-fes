var ViewIndex = function () {

    const doLogin = (sUser) => {
        $.ajax({
            type: "POST",
            url: window.location.protocol + '//' + window.location.host + '/funcao/login.php',
            data: {
                'name' : sUser,
                'ajax' : true
            },
            success: (oRes) => {
                if (oRes instanceof Object && oRes.hasOwnProperty('message')) {
                    alert(oRes.message);
                }
            }
        });
    };

    const doLogout = () => {
        $.ajax({
            type: "POST",
            async: false,
            url: window.location.protocol + '//' + window.location.host + '/funcao/logout.php',
            data: {
                'ajax' : true
            },
            success: (oRes) => {
                window.location.reload();
            }
        });
    };

    return {

        login: (sUser) => {
            doLogin(sUser);
        },

        logout: () => {
            doLogout();
        }

    };

}();