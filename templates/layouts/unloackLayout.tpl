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
    <link type="text/css" href="public/css/audioplayer.css" rel="stylesheet">
    <link type="text/css" href="public/css/base/jquery.ui.all.css" rel="stylesheet">

    <!-- After the final delivery activate these and remove the above links
    <link href="bootstrap/public/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/public/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    -->

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
</head>

<body>
    <!-- Start Desktop View -->
    <div class="visible-desktop">
        <header>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="logo">Trackloop<a style="cursor:pointer;"></a></h1>
                    </div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>
        <h2 class="main-title">Want to download it? Unlock with a tweet</h2>
        <section class="contain">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span8 album-wrap">
                    	{block name=album}{/block}
                    </div>
                    <div class="span4 side-box">
                    	{block name=sideBox}{/block}
                    </div>
                </div>
                <!-- Tweet Modal -->
                <div id="tweet-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <div class="tweet-wrapper">
                        <div class="modal-header">
                            <h3 id="myModalLabel">
                                <div class="tweeter-headline tweet-header">
                                    <img src="public/img/twitter.png" alt="" /><span class="">Sign-in to your twitter account</span>
                                </div>
                            </h3>
                        </div>
                        <div class="modal-body">
                            <form>
                                <fieldset>
                                    <label class="tweet-username">Username</label>
                                    <input class="input-xxlarge" type="text" placeholder="">
                                    <label class="tweet-username">Password</label>
                                    <input class="input-xxlarge" type="password" placeholder="">
                                    <div class="tweet-button">
                                        <input class="btn btn-large btn-block btn-info btn-large" onclick="ShowPageLinkFun1()" id="signinbutton" type="button" value="Sign-In" />
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>


                    <div class="page-link" style="display: none;">
                        <div class="modal-header"></div>
                        <div class="popup-background">
                            <div class="modal-body ">
                                <img src="public/img/twitter.png" alt="" />
                                <div class="pagelink-wrapper">
                                   <form id="tweetform" name="tweetform">
                                        <fieldset>
                                            <div class="twitter-text">
                                                <label class="pagelink-username">Page Link</label>
                                                <label class="uneditable-input">{$tinyurl}</label><br />
                                                <label class="pagelink-username">Edit your tweet</label>
                                                
                                                <textarea class="pagelink-textarea" placeholder="Your Tweet Text" 
                                                	name="tweettext" id="tweettext">#NowPlaying #{$albumname|replace:' ':''} from@{$twitterid} on #Trackloop {$base}artist/album/{$artistuniqueid}/{$albumuniqueid}</textarea><br />
                                                <span class="pull-right pagelink-address">68/140 characters remaining</span><br />
                                                <div class="pagelink-button">
                                                    <input class="submit-tweet btn btn-large btn-block btn-info btn-large submit-button" onclick="sendTweet()" type="button" value="SUBMIT TWEET" />
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sending-tweet" style="display: none;">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body loading-tweet">
                            <div class="sending-tweet-img">
                                <img src="public/img/twitter.png" alt="" />
                            </div>
                            <div class="tweet-progressbar">
                                <div class="part-01">
                                    <img src="public/img/sending-tweet.png" alt="" />
                                </div>
                                <div class="progressbar">
                                    <div class="progress-label">Loading...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="success" style="display: none;">
                        <div class="modal-body">
                            <div class="confirmation">
                                <img src="public/img/success-icon.png" alt="" /><span class="confirm-header">Brilliant! Your tweet was a success.</span>
                            </div>
                            <div class="confirm-text">
                                <p>
                                    Your download should begin immediately.
                                    <br />
                                    If it doesn't...
                                </p>
                            </div>
                            <div class="confirm-button">
                                <input class="confirm-click btn btn-large btn-block btn-info btn-large" onclick="zipfunction()" type="button" value="Click to download tracks" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Tweet Modal -->

                <!-- Playlint -->
                <div class="row-fluid">
					{block name=otherAudio}{/block}
                </div>
                <!-- End Playlint -->
            </div>
        </section>

        <a href="#feed-form" class="feedback-btn btn btn-large btn-block btn-info" data-toggle="modal">feedback</a>

        <!-- Modal -->
        <div id="feed-form" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Give us feedback</h3>
            </div>
            <div class="modal-body">
            	<form id="feedbackform">
	                <div class="radio-btn">
	                    <label id="1" class="radio radio-button" onclick="setupLabel();">
	                    	<span class='icon'></span><span class='icon-to-fade'></span>
	                        <input type="radio" name="optionsRadios" value="1">
	                        REPORT A BUG
	                    </label>
	                    <label id="2" class="radio radio-button" onclick="setupLabel();">
	                    	<span class='icon'></span><span class='icon-to-fade'></span>
	                        <input type="radio" name="optionsRadios" value="2">
	                        SEND A COMMENT
	                    </label>
	                    <label id="3" class="radio radio-button" onclick="setupLabel();">
	                    	<span class='icon'></span><span class='icon-to-fade'></span>
	                        <input type="radio" name="optionsRadios" value="3" checked="checked">
	                        ASK A QUESTION
	                    </label>
	                </div>
	                <div>
	                    <textarea name="description" class="textarea-xxlarge"></textarea>
	                </div>
	                <div class="row-fluid input-basic">
	                    <div class="span5">
	                        <label>Name</label>
	                        <input name="sendername" class="input-xlarge" type="text" placeholder="">
	                    </div>
	                    <div class="span5 offset2">
	                        <label>Email Address</label>
	                        <input name="senderemail" class="input-xlarge" type="text" placeholder="">
	                    </div>
	                </div>
	                <div class="feedback-button-wrapper">
	                    <div class="tweet-button">
	                        <button type="button" class="btn btn-small btn-block btn-info btn-large submit-button" onclick="return feedbackfun();">SUBMIT</button>
	                    </div>
	                </div>
	            </form>
	         </div>
        </div>

        <footer>
            <h4>Powered by Trackloop</h4>
            <p>Get your music out there. </p>
        </footer>
    </div>
    <!-- end Desktop View -->

    <!-- Start Mobile View -->
    <div class="visible-phone">

        <header class="mobile-header">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <h1 class="mobile-logo"><a style="cursor:pointer;"></a></h1>
                        <div class="mobile-heading text-center">Trackloop.fm</div>
                    </div>
                </div>
                <!-- end row-fluid -->
            </div>
            <!-- end container-fluid -->
        </header>

        <h2 class="mobile-title text-center">Want to download it? Unlock with a tweet</h2>

        <section class="contain">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="album-wrap">
                        <div class="mobile-album-section">
                            <div class="mobile-album-cover">
                            	{block name=mobileAlbum}{/block}
                                <div class="mobile-tweet">
                                
                                    <a href="fan/connect/{$artistuniqueid}/{$albumuniqueid}" class="mobile-btn like-artist btn btn-large btn-block btn-info btn-reset" data-count="none" data-toggle="modal">
									    <span class="mobile-like"></span>
									    <span class="mobile-a-fan">Unlock</span>
									</a>

                                    <div id="mobile-tweet" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel" aria-hidden="true">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <div class="tweet-wrapper">
                                            <div class="modal-header">
                                                <h3 id="mobileModalLabel" class="tweet-header">
                                                    <img src="public/img/twitter-small.png" alt="" />Sign-in to your twitter account</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <fieldset>
                                                        <label class="tweet-username">Username</label>
                                                        <input class="input-xxlarge" type="text" placeholder="">
                                                        <label class="tweet-username">Password</label>
                                                        <input class="input-xxlarge" type="password" placeholder="">
                                                        <div class="tweet-button">
                                                            <input class="btn btn-large btn-block btn-info btn-large" onclick="ShowPageLinkFun1()" id="mobilesigninbutton" type="button" value="Sign-In" />
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="page-link" style="display: none;">
                                            <div class="modal-header">
                                            </div>
                                            <div class="popup-background">
                                                <div class="modal-body ">
                                                    <img src="public/img/twitter.png" alt="" />
                                                    <div class="pagelink-wrapper">
                                                        <form>
                                                            <fieldset>
                                                                <div class="twitter-text">
                                                                    <label class="pagelink-username">Page Link</label>
                                                                    <label class="uneditable-input">{$tinyurl}</label><br />
                                                                    <label class="pagelink-username">Edit your tweet</label>
                                                                    <input class="input-xxlarge" type="text" placeholder="" value="#NowPlaying #{$albumname|replace:' ':''} from@{$twitterid} on #Trackloop {$base}artist/album/{$artistuniqueid}/{$albumuniqueid}"><br />
                                                                    <span class="pull-right pagelink-address">68/140 characters remaining</span><br />
                                                                    <div class="pagelink-button">
                                                                        <img src="public/img/tauch-hand.png" alt="" /><input class="submit-tweet btn btn-large btn-block btn-info btn-large" onclick="sendTweet()" type="button" value="SUBMIT TWEET" />
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sending-tweet" style="display: none;">
                                            <div class="modal-header">
                                            </div>
                                            <div class="modal-body loading-tweet">
                                                <div class="sending-tweet-img">
                                                    <img src="public/img/twitter.png" alt="" />
                                                </div>
                                                <div class="tweet-progressbar">
                                                    <div class="part-01">
                                                        <img src="public/img/sending-tweet.png" alt="" />
                                                    </div>
                                                    <div class="progressbar">
                                                        <div class="progress-label">Loading...</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="success" style="display: none;">
                                            <div class="modal-body">
                                                <div class="confirmation">
                                                    <img src="public/img/success-icon.png" alt="" /><span class="confirm-header">Brilliant!
                                                        <br />
                                                        Your tweet was a success.</span>
                                                </div>
                                                <div class="confirm-text">
                                                    <p>
                                                       Now you can Enjoy the full Track 
                                                    </p>
                                                </div>
                                                <div class="confirm-button">
                                                    <img src="public/img/tauch-hand.png" alt="" />
                                                    <input class="confirm-click btn btn-large btn-block btn-info btn-large" onclick="closeWindow()" type="button" value="CLOSE" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="mobile-album-desc">
                            	{block name=mobileAlbumDesc}
                            	{/block}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid mobile-player">
                	{block name=mobilePlayer}{/block}
                </div>
            </div>
        </section>
        <footer class="mobile-footer">
            <p>Powered by Trackloop</p>
        </footer>
    </div>
    <!-- End Mobile View -->
	<div id="desktopTest" class="visible-sm visible-md visible-lg"></div>
    <!-- JavaScript -->
    <script type="text/javascript" src="public/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/js/widgets.js"></script>
    <script type="text/javascript" src="public/js/custom_checkbox_and_radio.js"></script>
    <script type="text/javascript" src="public/js/audioplayer.js"></script>
    <script type="text/javascript" src="public/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="public/js/jquery.ui.core.min.js"></script>
<script>
//Feedback
$(document).ready(function () {
	$('.radio-button').on('click', function() {
		$(this).find('input').attr('checked', true);
	});
});

function feedbackfun() {
	$.post("feedbackaction.php", $('#feedbackform').serialize())
	.done(function(data) {
		$("#crossid").trigger('click');
	});
	$('#feed-form').modal('hide');
	return false;
}
//Feedback end

function ShowPageLinkFun1() {
    $('.tweet-wrapper').hide();
    $('.page-link').show();
}

function closeWindow() {
	$('.success').hide();
	$('#mobile-tweet').modal('hide');
}

function ShowPageLinkFun2() {
    $('.tweet-wrapper').hide();
    $('.page-link').hide();
    $('.sending-tweet').show();
}

function ShowPageLinkFun3() {
    $('.tweet-wrapper').hide();
    $('.page-link').hide();
    $('.sending-tweet').hide();
    $('.success').show();
}

function ShowPageLinkFun4() {
	if($('.time-place').is(':visible')) {
		$('#twtform').trigger('click');
		$('#signinbutton').trigger('click');
	} else {
		$('#mobile-tweet').modal('show');
		$('#mobilesigninbutton').trigger('click');
	}
	
}
		
function sendTweet() {
	ShowPageLinkFun2();
	$.post("fan/unlock/{$artistuniqueid}/{$albumuniqueid}", $('#tweetform').serialize())
	.done(function(data) {
		$('#tweettext').val('');
		ShowPageLinkFun3();
		//zipfunction();
	});
}

function zipfunction() {
	window.location.href = "fan/download/{$artistuniqueid}/{$albumuniqueid}";
}


        $('.follow-btn').click(function () {
            $('.follow-btn').html('following<span></span>');
            $('.follow-btn').css('background-color', '#e56c69');
        });

       

        $('#tweet-form, #mobile-tweet').on('hidden', function () {
            $('.tweet-wrapper').show();
            $('.page-link').hide();
            $('.sending-tweet').hide();
            $('.success').hide();
        });

        /*$(function () {
            //$('audio').audioPlayer();
            $.each($('audio'), function () {
                $(this).siblings('.audioplayer-bar').children('.audioplayer-bar-loaded').text($(this).attr('title'));
            });

        });*/
		
        $('.submit-tweet').click(function () {
            var progressbar = $(".progressbar"),
                progressLabel = $(".progress-label");

            progressbar.progressbar({
                value: false,
                change: function () {
                    progressLabel.text("SENDING TWEET");
                },
                complete: function () {
                    progressLabel.text("Complete!");
                    ShowPageLinkFun3();
                    
                    if($('.time-place').is(':visible')) {
						setTimeout(zipfunction, 100);
					}
                   
                }
            });

            function progress() {
                var val = progressbar.progressbar("value") || 0;

                progressbar.progressbar("value", val + 1);

                if (val < 99) {
                    setTimeout(progress, 100);
                }
            }

            setTimeout(progress, 3000);
        });
        
        //Print the track name
        $(document).ready(function () {
			$('audio').audioPlayer();
			$.each($('audio'), function () {
				$(this).siblings('.audioplayer-bar').children('.audioplayer-bar-loaded').text($(this).attr('title'));
			});
		});

        function onPause(trackNo) {
            $('#track-' + trackNo).parent().addClass('audioplayer-paused');
        }
        function onPlay(trackNo) {
            $('#track-' + trackNo).parent().removeClass('audioplayer-paused');
        }
        
		(function($) {
			$.fn.extend( {
				limiter: function(limit, elem) {
					$(this).on("keyup focus", function() {
						setCount(this, elem);
					});
					
					function setCount(src, elem) {
						var chars = src.value.length;
						if (chars > limit) {
							src.value = src.value.substr(0, limit);
							chars = limit;
						}
						elem.html(limit - chars);
					}
					setCount($(this)[0], elem);
				}
			});
		})(jQuery);
		
		{if 'yes' eq $tweet}
			$(document).ready(function () {
				ShowPageLinkFun4();
			});
		{/if}
    </script>
</body>
</html>
