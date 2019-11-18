{**
 * uses vars:
 * $login_user
**}
<script>
    const popupId = "#snackbar-popup-new-auth";

    function popupToggle(isVisible) {
        const $popup = $(popupId);
        const classShow = "show";
        if (isVisible) {
            $popup.addClass(classShow);
        } else {
            $popup.removeClass(classShow);
        }
    }

    function doNotShowInFuture() {
        document.cookie = "hasReadPopupNewAuth=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    }

    function popupClose() {
        popupToggle(false);
        doNotShowInFuture();
    }

    $(
        function () {
            setTimeout(
                () => popupToggle(true), 1000
            );
            $(popupId + ` a`).click(
                function () {
                    doNotShowInFuture();
                }
            );
        }
    )
</script>
<div id="snackbar-popup-new-auth" class="snackbar-container">
    <div class="container">
        <div class="snackbar-window">
            <h3 class="snackbar-title">{$content_484}</h3>
            <p>{$content_485}</p>
            <p>
                {if !$login_user}
                    <a class="btn" data-i18n-tag="login" href="./index.php?login"></a>
                {/if}
            </p>
            {if $login_user}
                <p>{$content_487}</p>
                <a class="btn" data-i18n-tag="logout" href="./index.php?quit"></a>
            {/if}
            <p>{$content_488}<a href="mailto:support@carvector.com">support@carvector.com</a></p>
            <p>{$content_489}</p>
            <div class="btn" onclick="popupClose()">OK</div>
        </div>
    </div>
</div>