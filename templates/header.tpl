<div id="cvr-header" class="main cvr-design">
    <div class="container">
        <div class="row">

            <div class="col-2">
                <div class="main-logo">
                    <a href="{$siteRoot}/index.php{$auc_lang_arg_start}{$fromSuffix}"><img src="{$siteRoot}/carvector-bootstrap/img/logo.png" alt="logo"></a>
                </div>
            </div>


            <div class="col-7">
                <div class="row">

                    <div class="col-4">
                        <div class="main-info">
                            <a href="mailto:info@carvector.com"><i class="fa fa-envelope" alt=""></i>info@carvector.com</a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="main-info">
                            <a href="tel:81345209342"><i class="fa fa-phone" alt=""></i>{$content_400}</a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="main-info">
                            <a href="https://wa.me/818024331000"><i class="fab fa-whatsapp-square"></i>+81-802-433-1000</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="main-btn">
                    <div id="lang_id" style="display: none;">{$lang_id}</div>
                    <div id="login_user" style="display: none;">{if !$login_user}none{else}{$login_user}{/if}</div>
                    <div id="part" style="display: none;">{$part}</div>
                    {if !$login_user}
                        <a id="ppage" href="{$siteRoot}/index.php?login{$auc_lang_arg_next}{$fromSuffix}">{$content_495}</a>
                    {else}
                        {if $part=="account"}
                            <a id="ppage" href="{$siteRoot}/index.php?quit{$auc_lang_arg_next}{$fromSuffix}">{$content_496}</a>
                        {else}
                            <a id="ppage" href="{$siteRoot}/index.php?account{$auc_lang_arg_next}{$fromSuffix}">{$content_497}</a>
                        {/if}
                    {/if}
                    {include file="language_selector.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
