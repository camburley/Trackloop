<?php
	require_once("../config.php");
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>

    <meta charset="utf-8">

    <title>TRACKLOOP.FM | Home</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap Stylesheets -->

    <link type="text/css" href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link type="text/css" href="css/flat.css" rel="stylesheet">

    <!-- After the final delivery activate these and remove the above links
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    -->

    <!-- Main Stylesheets -->
    <link type="text/css" href="css/styles.css" rel="stylesheet">

    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

    <!-- Favicon and Apple Icons -->
    <link rel="shortcut icon" href="img/icons/favicon.ico">
    <link rel="apple-touch-icon" href="img/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
</head>

<body id="main-home">

    <div class="home-wrapper">

        <header class="visible-desktop">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="logo">Trackloop<a href="mobile-menu.html"></a></h1>
						<div style="float:right; margin-top:20px; margin-right:30px;"> 
							<a href="<?php echo $loginPath; ?>" class="pull-right">Log In</a>
          				</div>
					</div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>

        <header class="mobile-header visible-phone">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="mobile-logo"><a href="mobile-menu.html"></a></h1>
                        <div class="mobile-heading text-center">Trackloop.fm</div>
                    </div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>

        <div class="contain">

            <h1>Grow Your Fan Base</h1>
            <p>The easiest way to spread your music</p>
            
        	<a href="<?php echo $accountPath; ?>">
        		<button type="submit" class="submitButton">
        			TRY IT NOW
        		</button>
        	</a>
        	<br/>
        	<a href="<?php echo $loginPath; ?>" class="visible-phone loginButton">
        		<button type="submit" id="loginButton" class="submitButton">
        			Log In
        		</button>
        	</a>
            

            <div class="browser-preview">
                <img src="images/browser-preview.png" alt="" />
            </div>

        </div>

        <div class="clouds">
            <img src="images/clouds.png" alt="" />
        </div>


    </div>
    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	if($('.visible-desktop').is(':visible')) {
    		$("#loginButtonForm").hide();
    	} else {
    		$("#loginButtonForm").show();
    	}
    </script>
</body>
</html>
