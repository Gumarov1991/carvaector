// FIXME костыль!
function run_buttons_js() {
    const lang_id = $('.cvr-design #lang_id').text() * 1;

    const registration = $("#registration");
    registration.attr("width", "124").attr("height", "34");
    switch (lang_id) {
        case 1:
            registration.val("Регистрация");
            break;
        case 2:
            registration.val("Registration");
            break;
        case 3:
            registration.val("Registration");
            break;
        case 4:
            registration.val("Registrierung");
            break;
    }
    registration.hover(
        function () {
            $(this).css({
                'box-shadow': 'none',
                'background-color': '#5ac916'
            });
        },
        function () {
            $(this).css({
                'box-shadow': 'none',
                'background-color': '#43B100'
            });
        }
    ).mousedown(function () {
        $(this).css({'box-shadow': 'inset 2px 2px 5px rgba(154, 147, 140, 0.5), 1px 1px 5px rgba(255, 255, 255, 1)'});
    }).mouseup(function () {
        $(this).css({'box-shadow': 'none'});
    });

    const enter = $("#enter");
    enter.attr("width", "124").attr("height", "34");
    switch (lang_id) {
        case 1:
            enter.val("Войти");
            break;
        case 2:
            enter.val("Sign in");
            break;
        case 3:
            enter.val("Login");
            break;
        case 4:
            enter.val("Anmeldung");
            break;
    }
    enter.hover(
        function () {
            $(this).css({
                'box-shadow': 'none',
                'background-color': '#5ac916'
            });
        },
        function () {
            $(this).css({
                'box-shadow': 'none',
                'background-color': '#43B100'
            });
        }
    ).mousedown(function () {
        $(this).css({'box-shadow': 'inset 2px 2px 5px rgba(154, 147, 140, 0.5), 1px 1px 5px rgba(255, 255, 255, 1)'});
    }).mouseup(function () {
        $(this).css({'box-shadow': 'none'});
    });

    const ppage = $(".cvr-design #ppage");
    const login_user = $('.cvr-design #login_user').text();
    const part = $('.cvr-design #part').text();
    ppage.html('');

    function _ppage_text($textSignUp, $textLogout, $textProfilePage) {
        if (String(login_user) === 'none') {
            ppage.text($textSignUp);
        } else {
            if (String(part) === 'account') {
                ppage.text($textLogout);
            } else {
                ppage.text($textProfilePage);
            }
        }
    }

    const locale_login_elements = [
        $('a[data-i18n-tag="login"]'),
    ];
    const locale_logout_elements = [
        $('a[data-i18n-tag="logout"]'),
    ];

    let locale_login = '';
    let locale_logout = '';
    switch (lang_id) {
        case 1:
            locale_login = "Вход / Регистрация";
            locale_logout = "Выход";
            break;
        case 2:
        case 3:
            locale_login = "Login / Sign up";
            locale_logout = "Logout";
            break;
        case 4:
            locale_login = "Anmelden / Registrieren";
            locale_logout = "Ausloggen";
            break;
    }

    locale_login_elements.forEach(
        (selector) => {
            selector.text(locale_login)
        }
    );
    locale_logout_elements.forEach(
        (selector) => {
            selector.text(locale_logout)
        }
    );

    switch (lang_id) {
        case 1:
            _ppage_text(locale_login, "Выход", "Личный кабинет");
            break;
        case 2:
        case 3:
            _ppage_text(locale_login, "Logout", "My account");
            break;
        case 4:
            _ppage_text(locale_login, "Ausloggen", "Mein Konto");
            break;
    }
    ppage.css({
        'width': 'auto',
        'display': 'block'
    });
}

$(run_buttons_js);
