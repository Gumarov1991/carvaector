{if $hasFeatureLiveChat}
    {if $langId=='1'}
        <span id="phplive_btn_1569406958" class="phplive-btn" onclick="phplive_launch_chat_1(0)"></span>
    {literal}
        <script type="text/javascript">

					(function () {
						var phplive_e_1569406958 = document.createElement("script");
						phplive_e_1569406958.type = "text/javascript";
						phplive_e_1569406958.async = true;
						phplive_e_1569406958.src = "https://carvector.com/phplive/js/phplive_v2.js.php?v=1|1569406958|2|";
						document.getElementById("phplive_btn_1569406958").appendChild(phplive_e_1569406958);
					})();

        </script>
    {/literal}
    {elseif $langId='2'}
        <span id="phplive_btn_1569406944" class="phplive-btn" onclick="phplive_launch_chat_2(0)"></span>
    {literal}
        <script type="text/javascript">

					(function () {
						var phplive_e_1569406944 = document.createElement("script");
						phplive_e_1569406944.type = "text/javascript";
						phplive_e_1569406944.async = true;
						phplive_e_1569406944.src = "https://carvector.com/phplive/js/phplive_v2.js.php?v=2|1569406944|2|";
						document.getElementById("phplive_btn_1569406944").appendChild(phplive_e_1569406944);
					})();

        </script>
    {/literal}
    {else}
        <span id="phplive_btn_1569406832" class="phplive-btn" onclick="phplive_launch_chat_0(0)"></span>
    {literal}
        <script type="text/javascript">

					(function () {
						var phplive_e_1569406832 = document.createElement("script");
						phplive_e_1569406832.type = "text/javascript";
						phplive_e_1569406832.async = true;
						phplive_e_1569406832.src = "https://carvector.com/phplive/js/phplive_v2.js.php?v=0|1569406832|2|";
						document.getElementById("phplive_btn_1569406832").appendChild(phplive_e_1569406832);
					})();

        </script>
    {/literal}
    {/if}
{/if}