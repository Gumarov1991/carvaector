<div class="container min-h-500 w">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="main-flex">
                <p class="breadcrumbs">
                    <a href="./index.php?login" class=nav>{$content_12}</a>
                    &nbsp;&#187;&nbsp;
                    <span class=nav>{$content_242}</span>
                </p>
                {if $reg_confirm_code}
                    <p style="font-size:14px; padding: 24px 48px;">{if $err}{$content_311}{else}{$content_254}{/if}</p>
                {else}
                    {if $reg_success}
                        <p style="font-size:14px; padding: 24px 48px;">{$content_253}</p>
                    {else}
                        <form class="form-registration" method="post" action="./index.php?registr"
                              onSubmit="return check_reg(this,'{$content_250}','{$content_251}');">
                            <input type=hidden name=reg value=yes>

                            <p class="help-block" {if !$message}hidden{/if}
                               style="color:red; font-size: 12px">
                                {if $message == "no_filled"}
                                    {$content_250}
                                {elseif $message == "pass_error"}
                                    {$content_251}
                                {elseif $message == "email_error"}
                                    {$content_448}
                                {elseif $message == "email_exist"}
                                    {$content_310}
                                {/if}
                            </p>

                            <div class="registration-title"><h2>{$content_242}</h2></div>

                            <!-- Gender -->
                            <div class="controls">
                                <label for="input-r01">{$content_443}*</label>
                                <select id="input-r01" name="r01">
                                    <option value="0" {if $r01 != 1 || $r01 != 2} selected{/if}></option>
                                    <option value="1" {if $r01 == 1} selected{/if}>{$content_441}</option>
                                    <option value="2" {if $r01 == 2} selected{/if}>{$content_442}</option>
                                </select>
                                <input name="fio" value="" maxlength="255" class="prima">{*catching*}
                            </div>

                            <!-- Username -->
                            <div class="controls">
                                <label for="input-r02">{$content_243}*</label>
                                <input id="input-r02" class="asterisk prima2" type="text" name="r02" value="{$r02}">
                                <input name="pass" value="" maxlength="20" class="prima">{*catching*}
                                <p class="help-block">{$content_490}</p>
                            </div>

                            <!-- E-mail -->
                            <div class="controls">
                                <label>{$content_245}*</label>
                                <input class="prima2" type="text" name="r03" maxlength="255" value="{$r03}">
                                <input name="name" value="" maxlength="255" class="prima">{*catching*}
                                <p id="validstr"></p>
                                <p class="help-block">{$content_246}</p>
                            </div>

                            <!-- Password -->
                            <div class="controls">
                                <label>{$content_247}*</label>
                                <input class="asterisk prima2" type="password" name="r04" maxlength="20" value="{$r04}">
                                <input name="email" value="" maxlength="255" class="prima">{*catching*}
                                <p class="help-block">{$content_248}</p>
                            </div>

                            <!-- Phone (International) -->
                            <div class="controls">
                                <label>{$content_244}</label>
                                <input class="prima2" name="r05" value="{$r05}" maxlength="50">
                                <input name="password" value="" maxlength="20" class="prima">{*catching*}
                            </div>

                            <!-- Mobile Phone -->
                            <div class="controls">
                                <label>{$content_446}</label>
                                <input class="prima2" name="r06" value="{$r06}" maxlength="50">
                                <input name="e_mail" value="" maxlength=255 class="prima">{*catching*}
                            </div>

                            <!-- Skype -->
                            <div class="controls">
                                <label>{$content_447}</label>
                                <input class="prima2" name="r07" value="{$r07}" maxlength="50">
                                <input name="phone" value="" maxlength=50 class="prima">{*catching*}
                            </div>

                            <!-- Other Info -->
                            <div class="controls">
                                <label>{$content_284}</label>
                                <textarea name="r08" rows="2" maxlength="255">{$r08}</textarea>
                            </div>

                            {if $hasFeatureChbTermAgree}
                                <div class="controls" style="display: flex;flex-direction: row;align-items: center;">
                                    <input type="checkbox" name="chb_term_agree" style="cursor: pointer !important;">
                                    <label style="margin-left: 8px">{$content_499}</label>
                                </div>
                            {/if}

                            <div class="controls">
                                <input id="registration" type="submit" value="Sign up">
                            </div>
                        </form>
                        <div class="registration-info">{$content_249}</div>
                    {/if}
                {/if}
            </div>
        </div>
    </div>
    {include file="popup.register_term_agree.tpl"}
</div>
