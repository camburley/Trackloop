<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>

    <meta charset="utf-8">
    <base href="{$base}"/>
    
    <title>TRACKLOOP.FM | {block name=title}Music Site{/block}</title>
    
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap Stylesheets -->

    <link type="text/css" href="public/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link type="text/css" href="public/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link type="text/css" href="public/css/flat.css" rel="stylesheet">
    <link type="text/css" href="public/css/select2.css" rel="stylesheet">

	{block name=styles}{/block}
	
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
    
    {block name=topScript}{/block}
    
    <script type="text/javascript">
		function displaymessage(errormsg, type) {
			//success
			if(type == 1) {
				return ('<div class="error-message"><div class="error-button"><a href="#"><img src="public/img/success-icon.png" alt="" /></a></div><div class="error-text"> '+errormsg+'</div></div>');
			}
			//failure
			else {
				return ('<div class="error-message"><div class="error-button"><a href="#"><img src="public/img/error-button.png" alt="" /></a></div><div class="error-text"> '+errormsg+'</div></div>');
			}
		}
    </script>
</head>
<body>
    <!-- Start Desktop View -->
    <div class="visible-desktop account">
    	<header>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="logo">Trackloop<a href="#"></a></h1>
			        	
			        	{if !empty($smarty.session.role)}
				        	<div class="dropdown tour-dropdown"> 
					        	<a href="#" data-toggle="dropdown" class="dropdown-toggle">
					        		<img src="public/img/message.png" alt="" class="dropdown-image" />
					        	</a>
						      	<ul aria-labelledby="dLabel" role="menu" class="dropdown-menu ul-dropdown-menu dropdown-ul-menu">
								    <li>
								    	<a href="#tour-dialog" id="getStartedTour"><img src="public/img/gift_icon.png" alt="" class="dropdown-li-image"/>&nbsp;&nbsp;Get Started Tour: Learning Trackloop</a>
								    </li>
						      	</ul>
				        	</div>
				        {/if}
			        </div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>
        
        <div class="row-fluid">
        	{block name=sidebar}{/block}
        		{if !empty($smarty.session.role)}
		        	<div class="span9 smallprofile-contain visible-desktop tour-dialog" id="tour-dialog" style="display: none !important;">
		        		<div class="music-upload-header"><span class="music-upload">Music i’ve Uploaded <a href="artist/upload"><span class="pull-right music-newrelease">Upload new release</span></a></span></div>
		        		<br/>
		        		<img src="public/img/welcome_bg.png" alt="" width="98%">
		        		<div align="center" class="back-button">
			        		<button class="btn btn-large btn-info" onclick="closeTourDialog()">
			    				<span>BACK</span>
							</button>
						</div>
		        	</div>
		        {/if}
        	{block name=content}content goes here{/block}
        </div>
         <footer>
            <h4>Powered by Trackloop</h4>
            <p>Get your music out there. </p>
        </footer>
    </div>
    <!-- End Desktop View -->
	
	{block name=visiblePhone}
    <!-- Start Mobile View -->
    <div class="visible-phone account">
    	<header class="mobile-header">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="mobile-logo">Trackloop<a class="mobile-menu-toggle" style="cursor: pointer;"></a></h1>
                        <div class="mobile-heading text-center">Trackloop.fm</div>
                    </div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>
        <!--contain -->
        <div class="row-fluid">
        	<div id="mobile-menu" class="mobile-menu" style="display: none;">
        		{sidebar}
        	</div>
            <div id="mobileViewContainer" class="span9 smallbuzz-contain" style="display: block;">
        		{block name=mobileViewContainer}{/block}
        	</div>
        </div>
        <footer class="mobile-footer">
            <p>Powered by Trackloop</p>
        </footer>
    </div>
    {/block}
    <!-- End Mobile View -->

    <!-- JavaScript -->
    <script type="text/javascript" src="public/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/js/select2.js"></script>

    <script>
        $(document).ready(function () {
        	if($("#e1").is(':visible')) {
            	$("#e1").select2({ maximumSelectionSize: 3 });
            }
        });

        $(document).ready(function () {
        	if($("#Select1").is(':visible')) {
            	$("#Select1").select2({ maximumSelectionSize: 3 });
            }
        });
        
         $(document).ready(function () {
         	$('#mobile-menu').hide();
			$('#mobileViewContainer').show();
            $(".mobile-menu-toggle").on('click', function() {
				if($('#mobileViewContainer').is(':visible')) {
					$('#mobileViewContainer').hide();
					$('#mobile-menu').show();
				} else {
					$('#mobileViewContainer').show();
					$('#mobile-menu').hide();
				}
            	var mobileMenu = $('#mobile-menu').find('.sidebar-title');
            	if(mobileMenu.length > 0) {
            		$(mobileMenu).addClass('mobile-menu-title');
            		$(mobileMenu).removeClass('sidebar-title');
            		$(mobileMenu).html('<h6>Choose A Destination</6>');
            	}
            	
            });
        });
        
        $('#getStartedTour').click(function() {
        	$('.trackloop-content').removeClass('visible-desktop').css('display', 'none').hide();
        	$('.trackloop-content').trigger('click');
        	$('.tour-dialog').removeAttr('style');
			$('.tour-dialog').show();
			return false;
		});
		
		function closeTourDialog() {
			$('.tour-dialog').attr('style', 'display: none !important');
			$('.trackloop-content').show();
		}
    </script>
    {block name=scripts}{/block}
</body>
</html>
