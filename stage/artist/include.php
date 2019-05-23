<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>

    <meta charset="utf-8">

    <title>TRACKLOOP.FM | <?php echo !empty($title) ? $title : 'Upload Media'; ?></title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap Stylesheets -->

    <link type="text/css" href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link type="text/css" href="css/flat.css" rel="stylesheet">
    <link type="text/css" href="css/bootstrap-fileupload.min.css" rel="stylesheet">
    <link type="text/css" href="css/autoSuggest.css" rel="stylesheet">

    <!-- After the final delivery activate these and remove the above links
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    -->

    <!-- Main Stylesheets -->
    <link type="text/css" href="css/styles.css" rel="stylesheet">

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
    <?php
require_once($path."/artist/header.php")
?>
