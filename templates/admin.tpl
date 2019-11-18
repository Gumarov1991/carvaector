<html>
	<head>
		<title>Административная страница</title>
		<link rel="icon" href="./pics/logo.ico" type="image/x-icon">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel = "stylesheet" href = "./css/styles.css" type = "text/css" media = "all" />
		<script type = "text/javascript" src = "./jscripts/jquery-1.10.1.min.js"></script>
	</head>
	<body style="margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;" align=center bgColor=#FFFFFF>
		<table border=0 width=100% cellpadding=0 cellspacing=0>
			<tr height=2><td></td></tr>
			<tr height=25>
				<td>
					<table border=0 width=100% height=25 cellpadding=0 cellspacing=0 align=center>
						<tr>
							<td nowrap bgColor=#99FF66 style="text-align:center;">
								<a href="./phplive/" class=menu style="display: block;" target="_blank">
									<div style="margin: 0px 10px; padding: 4px;">Live Chat</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							<td bgColor=#99FF66 style="text-align:center;">
								<a href="./admin.php?users&menu" class=menu{if $part=="admin_users"}-sel{/if} style="display: block;">
									<div style="margin: 0px 10px; padding: 4px;">Customers</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							<td bgColor=#99FF66 style="text-align:center;">
								<a href="./admin.php?finans&menu" class=menu{if $part=="admin_finans"}-sel{/if} style="display: block;">
									<div style="margin: 0px 10px; padding: 4px;">Balances</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							<td bgColor=#99FF66 style="text-align:center;">
								<a href="./admin.php?orders&menu" class=menu{if $part=="admin_orders"}-sel{/if} style="display: block;">
									<div style="margin: 0px 10px; padding: 4px;">Orders</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							{if $login_admin=="admin"}
								<td bgColor=#99FF66 style="text-align:center;">
									<a href="./admin.php?content&menu" class=menu{if $part=="admin_content"}-sel{/if} style="display: block;">
										<div style="margin: 0px 10px; padding: 4px;">Content{if $cresp}&nbsp;({$cresp}){/if}</div>
									</a>
								</td>
								<td><div style="width:2px; background: #FFF;"></div></td>
								<td bgColor=#99FF66 style="text-align:center;">
									<a href="./admin.php?admins&menu" class=menu{if $part=="admin_administrations"}-sel{/if} style="display: block;">
										<div style="margin: 0px 10px; padding: 4px;">Managers</div>
									</a>
								</td>
								<td><div style="width:2px; background: #FFF;"></div></td>
								<td bgColor=#99FF66 style="text-align:center;">
									<a href="./admin.php?partners&menu" class=menu{if $part=="admin_partners"}-sel{/if} style="display: block;">
										<div style="margin: 0px 10px; padding: 4px;">Partners</div>
									</a>
								</td>
								<td><div style="width:2px; background: #FFF;"></div></td>
								<td bgColor=#99FF66 style="text-align:center;">
									<a href="./admin.php?languages&menu" class=menu{if $part=="admin_languages"}-sel{/if} style="display: block;">
										<div style="margin: 0px 10px; padding: 4px;">Langs</div>
									</a>
								</td>
								<td><div style="width:2px; background: #FFF;"></div></td>
							{/if}
							<td bgColor=#99FF66 style="text-align:center;">
								<a href="./admin.php?help&menu" class=menu{if $part=="admin_help"}-sel{/if} style="display: block;">
									<div style="margin: 0px 10px; padding: 4px;">Help</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							<td bgColor=#99FF66 style="text-align:center;">
								<a href="./admin.php?quit&menu" class=menu style="display: block;">
									<div style="margin: 0px 10px; padding: 4px;">Quit</div>
								</a>
							</td>
							<td><div style="width:2px; background: #FFF;"></div></td>
							<td nowrap bgColor=#99FF66 style="width: 100%; text-align:right;padding:0px 10px 0px 10px;">
								{$men_name} <span title="IP: {$a_ip}">({$sgeoinfo})</span> {$smarty.now|date_format:"%d-%b-%Y %H:%M:%S"}
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align=center>
					{if $part}{include file="$part.tpl"}{/if}
				</td>
			</tr>
		</table>
	</body>
</html>
