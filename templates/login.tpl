<div class="container min-h-500">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <script src="./jscripts/login.js" type="text/javascript"></script>
            <p style="font-size:14px;margin:10px 10px 0px 10px;">
                <span class=nav>{$content_12}</span>
            </p>
            <p style="margin:30px 10px 0px 80px;">
                <a href="./index.php?registr" style="font-size:14px;color:#000000;">{$content_256}</a></p>
            <p style="margin:30px 10px 0px 80px;">
                <a href="./index.php?forbidden_pass" style="font-size:14px;color:#000000;">{$content_257}</a></p>
            <form class="form-login" action="./index.php?login" method=post onsubmit="return check_in(this);">
                <h2>Login</h2>
                <input name="login-try-count" value="{$login_try_count}" type="hidden"/>
                <input id="#input-login" name=login type="text" placeholder="{$content_258}"/>
                <div><span id="validstr"></span></div>
                <input name=pass type="password" placeholder="{$content_259}"/>
                <input id="enter" type="submit" value="Sign in">
            </form>

            {if ($login_try_count > 1)}
                <div class="snackbar-container show" style="position: relative">
                    <div class="container">
                        <div class="snackbar-window">
                            <p>{$content_491}</p>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </div>

</div>