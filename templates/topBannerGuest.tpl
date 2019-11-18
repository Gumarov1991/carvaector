<section class="first">
    <div class="container">
        <div class="first-relative">
            <div class="row">
                <div class="instruction hide-for-signed"
                     style="background: url(./pics/content/{$content_454}) center center no-repeat; background-size: contain;"></div>
                <div class="sale-block">
                    <img src="/carvector-bootstrap/img/oil-derrick.png">
                    <p>{$content_503}</p>
                </div>
                <div class="feedback-arrow hide-for-signed"></div>
                <div class="feedback-photo hide-for-signed"></div>
                <div class="col-7">
                    {$content_17}
                    <div class="button-new hide-for-signed">
                        <a href="https://carvector.com/index.php?registr">{$content_15}</a>
                    </div>
                    <!--<div class="button-new1">
                        <a href="#">Contact us</a>
                    </div> -->
                </div>
                <div class="col-4 offset-1">
{*                    <div class="first-form" hidden>*}
{*                        <h2 class="first-form-header p-0">{$content_458}</h2>*}
{*                        <form action="https://carvector.com/index.php?search_3" method="POST">*}
{*                            <input type="hidden" name="ssearch" value="SEARCH">*}
{*                            <input type="hidden" name="marka_id" value="1">*}
{*                            <select class="first-form-select" id="select_mark_form" onchange="select_value(this);">*}
{*                                <option selected value="All makes">(All makes)</option>*}
{*                                {foreach item = row from = $marka}*}
{*                                    <option value="{$row.MARKA_ID}"{if $row.MARKA_ID == $selmarka_id}{/if}>{$row.MARKA_NAME}</option>*}
{*                                {/foreach}*}
{*                            </select>*}
{*                            <button class="first-form-btn" type="submit">{$content_455}</button>*}
{*                        </form>*}
{*                    </div>*}
                </div>
            </div>
        </div>
    </div>
</section>