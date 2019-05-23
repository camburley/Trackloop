{block name=title}FORGOT PASSWORD{/block}

{block name=content}
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
	<a class="nav-brand" href="index.php">trackloop.fm</a>
	<div class="row m-n">
   		<div class="col-md-4 col-md-offset-4 m-t-lg">
     		<section class="panel">
     			<header class="panel-heading text-center">
            		Forgot Password
          		</header>
	       		<form action="forgot-password" method="post" class="panel-body">
	         		<div class="form-group">
			           <label class="control-label">Username</label>
			           <input type="text" id="username" name="username" placeholder="Username" class="form-control">
	         		</div>
	            	<button type="submit" class="btn btn-info">Submit</button>
	          	</form>
        	</section>
		</div>
	</div>
</section>
{/block}