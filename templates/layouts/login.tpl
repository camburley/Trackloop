<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>

    <meta charset="utf-8">
	<base href="http://trackloop.dev/"/>

    <title>TRACKLOOP.FM | {block name=title}Music Site{/block}</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap Stylesheets -->

    <link type="text/css" href="public/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link type="text/css" href="public/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link type="text/css" href="public/css/flat.css" rel="stylesheet">
    <link type="text/css" href="public/css/bootstrap.css" rel="stylesheet" media="screen">
    <link type="text/css" href="public/css/bootstrap-fileupload.min.css" rel="stylesheet">

    <!-- Main Stylesheets -->
    <link type="text/css" href="public/css/styles.css" rel="stylesheet">

    <!-- Plugin Stylesheets -->


    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

    <!-- Favicon and Apple Icons -->
    <link rel="shortcut icon" href="img/icons/favicon.ico">
    <link rel="apple-touch-icon" href="img/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
    <script type="text/javascript">
		function displaymessage(errormsg,t)
		{
			if(t==1)//success
			{
				return ('<div class="error-message"><div class="error-button"><a href="#"><img src="images/success-icon.png" alt="" /></a></div><div class="error-text"> '+errormsg+'</div></div>');
			}
			else//failure
			{
				return ('<div class="error-message"><div class="error-button"><a href="#"><img src="images/error-button.png" alt="" /></a></div><div class="error-text"> '+errormsg+'</div></div>');
			}
			
		}
    </script>
    </head>
    <body>
		<header>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<h1 class="logo">Trackloop<a href="index.php"></a></h1>
					</div>
				</div>
				<!-- end row-fluid -->
			</div>
			<!-- end container-fluid -->
		</header>
		{block name=content}content goes here{/block}
		<footer>
			<h4>Powered by Trackloop</h4>
			<p>Get your music out there. </p>
		</footer>
	</body>
</html>