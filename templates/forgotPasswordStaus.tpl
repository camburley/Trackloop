{block name=title}FORGOT PASSWORD{/block}

{block name=content}
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<a class="nav-brand" href="index.php">trackloop.fm</a>
	<div class="row m-n">
   		<div class="col-md-4 col-md-offset-4 m-t-lg forgot-password">
   		{if isset($loginPath)}
     		<h1><b>We've sent password to your email address.</b></h1>
			<h4>
				<p>If you don't receive a new password within a few minutes, check your email's spam and junk filters.</p>
				<p>To login your account, 
					<a href="{$loginPath}" class="login-link">Click here</a>
				</p>
			</h4>
		{else}
			<h1>Please check your email address.</h1>
			<h4>
				<p>Click here to
					<a href="{$forgotPasswordPath}" class="login-link">Forgot password?</a>
				</p>
			</h4>
		{/if}
		</div>
	</div>
</section>
{/block}