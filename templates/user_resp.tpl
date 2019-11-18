<div class="container min-h-500">
        <div class="row">
                <div clas="col-xl-12 col-lg-12">

{literal}
	<script type="text/javascript">
		function check_in(t) {
			if (!t.response.value) {
				alert ('Please enter the text.');
				return false;
			}
			return true;	
		}
	</script>
{/literal}

<p style="font-size:14px;margin:10px 10px 0px 10px;">
	<a href="./index.php?account" class=nav>{$content_261}</a>
	&nbsp;&#187;&nbsp;
	<span class=nav>{$content_266}</span>
</p>
<table cellspacing=0 cellpadding=0 width=815 style="margin:30px 80px 10px 80px;">
	<form method="post" action="./index.php?resp" onsubmit="return check_in(this);">
		<input type=hidden name=save value=yes>
		<tr><td><textarea name=response style="width:800px;height:300px; resize:none;"></textarea></td></tr>
		<tr><td><input type=submit value="Go" style="margin:3px 0px 20px 0px;"></td></tr>
	</form>
</table>

</div>
</div>
</div>
