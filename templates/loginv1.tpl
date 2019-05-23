{block name=title}ARTIST LOGIN{/block}

{block name=content}
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<a class="nav-brand" href="index.php">trackloop.fm</a>
	<div class="row m-n">
   		<div class="col-md-4 col-md-offset-4 m-t-lg">
     		<section class="panel">
     			<header class="panel-heading text-center">
            		Sign in
          		</header>
	       		<form action="login" method="post" class="panel-body">
	         		<div class="form-group">
			           <label class="control-label">Username</label>
			           <input type="text" id="username" name="username" placeholder="Username" class="form-control">
	         		</div>
	         		<div class="form-group">
			           <label class="control-label">Password</label>
			           <input type="password" id="password" name="password" placeholder="Password" class="form-control">
	         		</div>
	         		<div class="checkbox">
			           <label>
			             <input type="checkbox" id="remember" value="remember" name="remember"> Keep me logged in
			           </label>
		         	</div>
	         		<a href="{$forgotPasswordPath}" class="pull-right m-t-xs"><small>Forgot password?</small></a>
	            	<button type="submit" class="btn btn-info">Sign in</button>
	            	<div class="line line-dashed"></div>
		            <a href="{$facebookUrl}" class="btn btn-facebook btn-block m-b-sm"><i class="icon-facebook pull-left"></i>Sign in with Facebook</a>
		            <a href="{$twitterUrl}" class="btn btn-twitter btn-block"><i class="icon-twitter pull-left"></i>Sign in with Twitter</a>
		            <div class="line line-dashed"></div>
		            <p class="text-muted text-center"><small>Do not have an account?</small></p>
		            <a href="{$createAccountPath}" class="btn btn-white btn-block">Create an account</a>
	          	</form>
        	</section>
		</div>
	</div>
</section>
{/block}