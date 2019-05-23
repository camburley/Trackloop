{block name=title}ARTIST LOGIN{/block}

{block name=content}
<style type="text/css">
	.error-message { width: 100%; margin-bottom: 20px; }
	.error-text { margin-top: 12px; }
</style>
{if !empty($error)}
<div id="error" class="login-error"><span class="error-icon"><span class="error-icon"><img src="public/img/cross-red.png" /></span><span class="error-msg">{$error}</span></div>
{/if}
<div class="content-fm">
	<div class="fm-head"></div>
	<h2>TRACKLOOP.FM</h2>
	<div class="signintop"><span class="plus"></span><span class="txtsignin">Artist Sign In</span></div>
	<div id="respmsg"></div>
	<form id="frmartistuser" name="frmadminuser" action="login" method="post">
		<div class="signin">
			<p style="margin:0; padding:0">
				<input type="text" class="fm-user" name="username" id="username" placeholder="Username" value="{$cusername}" onBlur="validateusername()" />
			</p>
			<p style="margin:0; padding:0;">
				<input type="password" name="password" id="password" class="fm-pw" placeholder="Password" value="{$cpassword}" onBlur="validatepassword()" />
			</p>
			<div class="btn-group" data-toggle="buttons-checkbox">
				<p style="margin-top:15px; height:60px; width:360px;">
					<button class="tl-chk" style="margin-top:20px;"  name="remember" type="button" id="remember" value="remember"></button>
					<span><label style="padding-top:20px;">Remember Passsword</label></span>
					<button style="float:right; margin-top:-35px;" class="btn-signin" type="button"></button>
				</p>
			</div>
		</div>
	</form>
</div>
</div>

<script src="public/js/jquery.js" type="text/javascript"></script>
<script src="public/js/bootstrap.js" type="text/javascript"></script>
<script src="public/js/customer-check.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$(".btn-signin").click(function() {
			$("#frmartistuser").submit();
		});
	})
</script>
{/block}
{block name=styles}
<link type="text/css" href="public/css/bootstrap.css" rel="stylesheet" media="screen">
{/block}