{if $login_user}
    {include file='topBannerSigned.tpl'}
{else}
    {include file='topBannerGuest.tpl'}
{/if}

{include file="main_hotpr.tpl"}

<section class="car-by-makes">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search-car-by-makes">
                    <h2>{$content_14}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="car-logo">
                <div class="col-1 offset-1">
                    <a href="https://carvector.com/auc/aj_neo#24:Any">
                        <div class="car-logo-1">
                            <button class="img-submit mb"></button>
                            <span class="brand-search-submit">Mercedes</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/14:Any">
                        <div class="car-logo-1">
                            <button class="img-submit bmw"></button>
                            <span class="brand-search-submit">BMW</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/13:Any">
                        <div class="car-logo-1">
                            <button class="img-submit audi"></button>
                            <span class="brand-search-submit">Audi</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/148:Any">
                        <div class="car-logo-1">
                            <button class="img-submit porsche"></button>
                            <span class="brand-search-submit">Porsche</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/1:Any">
                        <div class="car-logo-1">
                            <button class="img-submit toyota"></button>
                            <span class="brand-search-submit">Toyota</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/3:Any">
                        <div class="car-logo-1">
                            <button class="img-submit mazda"></button>
                            <span class="brand-search-submit">Mazda</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/2:Any">
                        <div class="car-logo-1">
                            <button class="img-submit nissan"></button>
                            <span class="brand-search-submit">Nissan</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/5:Any">
                        <div class="car-logo-1">
                            <button class="img-submit honda"></button>
                            <span class="brand-search-submit">Honda</span>
                        </div>
                    </a>
                </div>

                <div class="col-1">
                    <a href="https://carvector.com/car-search/model/7:Any">
                        <div class="car-logo-1">
                            <button class="img-submit subaru"></button>
                            <span class="brand-search-submit">Subaru</span>
                        </div>
                    </a>
                </div>

                <div class="col-1 mr-auto">
                    <a href="https://carvector.com/car-search/model/4:Any">
                        <div class="car-logo-1">
                            <button class="img-submit mitsubishi"></button>
                            <span class="brand-search-submit">Mitsubishi</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

<section class="voice">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{$content_16}</h2>
            </div>
        </div>

        <div class="row rel-z-index">
            {foreach item = row from = $responses key=i name=review}
                {if $smarty.foreach.review.iteration lte 3}
                    <div class="col-3">
                        <div class="voice-blocks"
                             onClick='location.href="./index.php?response&language={$lang_id}&fid={$row.id}"'>
                            <p>{$row.messages}...&nbsp;
                                <a href="./index.php?response&language={$lang_id}&fid={$row.id}">
                                    {$content_317}
                                </a>
                            </p>
                        </div>
                    </div>
                    {{/if}}
            {/foreach}
        </div>

        <div class="row">
            <div class="col-12">
                <h3>{$content_18}</h3>
            </div>
        </div>

        <div class="foot-container">
            <div class="foot">
                <img src="./carvector-bootstrap/img/Foot.png" alt="">
            </div>
        </div>

    </div>
</section>
