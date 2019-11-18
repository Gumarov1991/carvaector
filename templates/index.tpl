<html>
<head>
    <base href="https://carvector.com/"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="{$content_381}"/>

    <title>{$content_380}</title>

    {include file="head_links.tpl"}
    <link rel="stylesheet" href="{$siteRoot}/carvector-bootstrap/css/bt-fonts.css" type="text/css" media="all"/>

    <noscript>
        <span>Javascript is disabled in your browser. To properly view this site Javascript must be enabled.<br></span>
    </noscript>

    <script type="text/javascript" src="{$siteRoot}/jscripts/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{$siteRoot}/jscripts/buttons.js"></script>
    <script src="{$siteRoot}/carvector-bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    {if $part=="direct"}
        <script src="./jscripts/direct.js" type="text/javascript"></script>
    {/if}
    {if $part=="calc"}
        <script src="./jscripts/calc.js" type="text/javascript"></script>
    {/if}
    {if $part=="registr"}
        <script src="./jscripts/jquery.textchange.js" type="text/javascript"></script>
        <script src="./jscripts/registr.js" type="text/javascript"></script>
    {/if}
    {if $login_user}
        <link rel="stylesheet" href="{$siteRoot}/css/forSigned.css">
    {/if}
    <script>
			function select_value(e) {
				$('[name="marka_id"]').val(e.value);
			}
    </script>
    {literal}
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
						w[l] = w[l] || [];
						w[l].push({
							'gtm.start':
								new Date().getTime(), event: 'gtm.js'
						});
						var f = d.getElementsByTagName(s)[0],
							j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
						j.async = true;
						j.src =
							'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
						f.parentNode.insertBefore(j, f);
					})(window, document, 'script', 'dataLayer', 'GTM-MC2HNLD');</script>
        <!-- End Google Tag Manager -->
    {/literal}
</head>

<body{if $onload} onLoad='{$onload}'{/if} style="margin:0px; padding:0px;" align=center bgColor=#EAEAEA>
{literal}
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MC2HNLD"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
{/literal}

<header>
    {include file="header.tpl"}
    {include file="topMenu.tpl"}
</header>
{include file="$part_content.tpl"}
{include file="footer.tpl"}
{if $has_popup_new_auth}
    {include file="popup.new_auth_system.tpl"}
{/if}
{include file="widget.livechat.tpl"}
</body>
</html>