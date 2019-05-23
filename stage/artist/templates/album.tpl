<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="{$domain}/artist/js/widgets.js"></script>
<script type="text/javascript">
function debugEvent(intent_event) 
{
//var x=$('.btn').title;
      console.log(intent_event);
	 // alert(intent_event.region);
	 if(intent_event.type=='follow')
	  {
		 	var artistuniqueid	=	'{$artistuniqueid}';
		 	$.post("followaction.php", {
			'artistuniqueid':artistuniqueid }, function(data) 
			{
					
			})
	  }
	  else
	  {
		  	var artistuniqueid	=	'{$artistuniqueid}';
			$.post("unfollowaction.php", {
			'artistuniqueid':artistuniqueid }, function(data) 
			{
					
			})
	  }
    }
//twttr.events.bind('click',    debugEvent);
// twttr.events.bind('tweet',    debugEvent);
// twttr.events.bind('retweet',  debugEvent);
// twttr.events.bind('favorite', debugEvent);
    twttr.events.bind('follow',   debugEvent);
	twttr.events.bind('unfollow',   debugEvent);
	 //set path

  </script>
<script type="text/javascript">	
twttr.ready(function (twttr) {
	/*$.getJSON("https://api.twitter.com/1/followers/ids.json?cursor=-1&user_id=74096219" , function(data) 
{ 
	console.log(data); 
	alert(data);
});*/
	//######## trigger when the user publishes his tweet 
	twttr.events.bind('tweet', function(event) {
		console.log(event); 

		/*
		To make locked items little more private, let's send our base64 encoded session key
		which will work as key in send_resources.php to acquire locked items.
		*/
		var albumuniqueid	=	'{$albumuniqueid}';
		
		//Load data from the server using a HTTP POST request.
		$.post("tweetaction.php", {
			'albumuniqueid':albumuniqueid }, function(data) 
		{
			//Append unlocked content into div element
			$('#tweet_content').html(data);
		
		}).error(function(xhr, ajaxOptions, thrownError) { 
			//Output any errors from server.
			alert( thrownError); 
		});
	});
	
});

</script>
<h2 class="main-title">Want to download it? Unlock with a tweet</h2>
<section class="contain">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span8 albem-wrap">
        <div class="albem"> <img src="{$domain}/uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$coverimage}" alt="">
          <div class="albem-desc">
            <div class="time-place">
              <p><i class="time-icon"></i>Added {$albumdate}</p>
              <p><i class="place-icon"></i>{$location}</p>
              <div class="clearfix"></div>
            </div>
            <h4>{$albumname}</h4>
            <p class="artist">{$firstname} {$lastname}</p>
            <a href="https://twitter.com/{$twitterid}" class="twitter-follow-button" data-count="none" >Follow @twitterid</a> 
            <div class="clearfix"></div>
            <p class="descrip"> {$albumdescription} </p>
            <div class="player">
              <div class="main-audio">
                <audio title="Preview This Track" preload="auto" controls>
                  <source src="{$domain}/uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfiletitle}">
                </audio>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="span4 side-box">
        <div class="white-box"> <img src="images/eqelizers.png" alt="">
          <h3 class="nowrap download">320 kbps mp3</h3>
          <div class="clearfix"></div>
        </div>
        <div class="white-box">
          <div class="white-block">
            <h3>{$totaldownload}</h3>
            <p>Downloads</p>
          </div>
          <div class="white-block">
            <h3>{$totalfollow}</h3>
            <p>Follows</p>
          </div>
          <div class="white-block no-border">
            <h3>{$totalshares}</h3>
            <p>Shares</p>
          </div>
          <div class="clearfix"></div>
        </div>
        
        	
           <span style="display:none">
                <a  href="#tweet-form"  id="twtform" class="like-artist btn btn-large btn-block btn-info btn-reset" data-toggle="modal"><span class="like"></span><span class="a-fan nowrap">Click to Unlock with Tweet</span>
                            <div class="clearfix"></div>
                </a>
			</span>                
                   <a href="../abrahm/redirect.php" class="like-artist btn btn-large btn-block btn-info btn-reset" data-count="none" data-toggle="modal">
                        <span class="like"></span>
                        <span class="a-fan nowrap">Click to Unlock with Tweet</span>
                        <div class="clearfix"></div>
                    </a>
           
        </div>
    </div>
   <!-- Tweet Modal -->
                <div id="tweet-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <div class="tweet-wrapper">
                        <div class="modal-header">
                            <h3 id="myModalLabel">
                                <div class="tweeter-headline tweet-header">
                                    <img src="images/twitter.png" alt="" /><span class="">Sign-in to your twitter account</span>
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
                        <div class="modal-header">
                        </div>
                        <div class="popup-background">
                            <div class="modal-body ">

                                <img src="images/twitter.png" alt="" />
                                <div class="pagelink-wrapper">

                                    <form id="tweetform" name="tweetform">
                                        <fieldset>
                                            <div class="twitter-text">

                                                <label class="pagelink-username">Page Link</label>
                                                <label class="uneditable-input">{$albumurl}</label><br />
                                                <label class="pagelink-username">Edit your tweet</label>
                                                <textarea class="pagelink-textarea" placeholder="Your Tweet Text" name="tweettext" id="tweettext">#NowPlaying #New [@{$twitterid}] tracks at #Trackloop</textarea><br />
                                                <span class="pull-right pagelink-address"><span id="chars">100</span>/100 characters remaining</span><br />
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
                                <img src="images/twitter.png" alt="" />
                            </div>
                            <div class="tweet-progressbar">
                                <div class="part-01">
                                    <img src="images/sending-tweet.png" alt="" />
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
                                <img src="images/success-icon.png" alt="" /><span class="confirm-header">Brilliant! Your tweet was a success.</span>
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
      {section name=outer loop=$trackuniqueid}
      <div class="other-audio">
        <audio id="{$trackuniqueid[outer]}" onplay="onPlay('1')" onpause="onPause('1')" title="{$trackname[outer]}" preload="auto" controls>
          <source src="{$domain}/uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[outer]}">
        </audio>
      </div>
      {/section}
    </div>
    <!-- End Playlint --> 
    
  </div>
</section>
<a href="#feed-form" class="feedback-btn btn btn-large btn-block btn-info" data-toggle="modal">feedback</a> 

<!-- Modal -->
<div id="feed-form" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="crossid">×</button>
    <h3>Give us feedback</h3>
  </div>
 <form id="feedbackform" >
  <div class="modal-body">
    <div class="radio-btn">
      <label class="radio radio-button"> <span class="icon"></span><span class="icon-to-fade"></span>
        <input type="radio" name="optionsRadios" value="1">
        REPORT A BUG </label>
      <label class="radio radio-button"> <span class="icon"></span><span class="icon-to-fade"></span>
        <input type="radio" name="optionsRadios" value="2">
        SEND A COMMENT </label>
      <label class="radio radio-button"> <span class="icon"></span><span class="icon-to-fade"></span>
        <input type="radio" name="optionsRadios" value="3">
        ASK A QUESTION </label>
    </div>
    <div>
      <textarea class="textarea-xxlarge" name="description"></textarea>
    </div>
    <div class="row-fluid input-basic">
      <div class="span5">
        <label>Name</label>
        <input class="input-xlarge" type="text" placeholder="" name="sendername">
      </div>
      <div class="span5 offset2">
        <label>Email Address</label>
        <input class="input-xlarge" type="text" placeholder="" name="senderemail">
      </div>
    </div>
    <div class="feedback-button-wrapper">
      <div class="tweet-button">
        <button type="button" onclick="feedbackfun();" class="btn btn-small btn-block btn-info btn-large submit-button">SUBMIT</button>
      </div>
    </div>
  </div>
  </form>
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
        <h1 class="mobile-logo"><a href="mobile-menu.html"></a></h1>
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
      <div class="albem-wrap">
        <div class="mobile-album-section">
          <div class="mobile-album-cover">
            <div class="mobile-album"> <img src="images/albem-art.png" alt=""> </div>
            <div class="mobile-tweet"> <a href="#mobile-tweet" class="mobile-btn like-artist btn btn-large btn-block btn-info btn-reset" data-toggle="modal"> <span class="mobile-like"></span><span class="mobile-a-fan">Unlock</span> </a>
              <div id="mobile-tweet" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mobileModalLabel" aria-hidden="true">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="tweet-wrapper">
                  <div class="modal-header">
                    <h3 id="mobileModalLabel" class="tweet-header"> <img src="images/twitter-small.png" alt="" />Sign-in to your twitter account</h3>
                  </div>
                  <div class="modal-body">
                    <form>
                      <fieldset>
                        <label class="tweet-username">Username</label>
                        <input class="input-xxlarge" type="text" placeholder="">
                        <label class="tweet-username">Password</label>
                        <input class="input-xxlarge" type="password" placeholder="">
                        <div class="tweet-button">
                          <input class="btn btn-large btn-block btn-info btn-large" onclick="ShowPageLinkFun1()" type="button" value="Sign-In" />
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>
                <div class="page-link" style="display: none;">
                  <div class="modal-header"> </div>
                  <div class="popup-background">
                    <div class="modal-body "> <img src="images/twitter.png" alt="" />
                      <div class="pagelink-wrapper">
                        <form>
                          <fieldset>
                            <div class="twitter-text">
                              <label class="pagelink-username">Page Link</label>
                              <label class="uneditable-input">http://tiny.cc/hje32hhas4y</label>
                              <br />
                              <label class="pagelink-username">Edit your tweet</label>
                              <input class="input-xxlarge" type="text" placeholder="">
                              <br />
                              <span class="pull-right pagelink-address">68/140 characters remaining</span><br />
                              <div class="pagelink-button"> <img src="images/tauch-hand.png" alt="" />
                                <input class="submit-tweet btn btn-large btn-block btn-info btn-large" onclick="ShowPageLinkFun2()" type="button" value="SUBMIT TWEET" />
                              </div>
                            </div>
                          </fieldset>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="sending-tweet" style="display: none;">
                  <div class="modal-header"> </div>
                  <div class="modal-body loading-tweet">
                    <div class="sending-tweet-img"> <img src="images/twitter.png" alt="" /> </div>
                    <div class="tweet-progressbar">
                      <div class="part-01"> <img src="images/sending-tweet.png" alt="" /> </div>
                      <div class="progressbar">
                        <div class="progress-label">Loading...</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="success" style="display: none;">
                  <div class="modal-body">
                    <div class="confirmation"> <img src="images/success-icon.png" alt="" /><span class="confirm-header">Brilliant! <br />
                      Your tweet was a success.</span> </div>
                    <div class="confirm-text">
                      <p> Your download should begin immediately. <br />
                        If it doesn’t... </p>
                    </div>
                    <div class="confirm-button"> <img src="images/tauch-hand.png" alt="" />
                      <input class="confirm-click btn btn-large btn-block btn-info btn-large" onclick="ShowPageLinkFun3()" type="button" value="TAP TO DOWNLOAD" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mobile-album-desc">
            <div class="mobile-track-info">
              <h4>No Guns Allowed </h4>
              <p class="artist">Phil Street</p>
              <div class="clearfix"></div>
            </div>
            <div class="mobile-track-history">
              <div class="mobile-time-zone">
                <p><i class="time-icon"></i>Added 2/17/13</p>
              </div>
              <div class="track-count"> <span class="circle-number">5</span><span class="track">Tracks</span> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid mobile-player">
      <div class="mobile-preview">
        <div class="other-audio">
          <audio title="PREVIEW TRACKS" preload="auto" controls>
            <source src="audio/BlueDucks_FourFlossFiveSix.mp3">
            <source src="audio/BlueDucks_FourFlossFiveSix.ogg">
            <source src="audio/BlueDucks_FourFlossFiveSix.wav">
          </audio>
        </div>
      </div>
      <div class="mobile-playlist">
        <ol>
          <li><a class="nowrap" href="#">No Guns Allowed</a> <span class="pull-right">00:30</span></li>
          <li><a class="nowrap" href="#">Lend me your ears</a><span class="pull-right">00:30</span></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- End Mobile View --> 

<!-- JavaScript --> 
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script> 
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/custom_checkbox_and_radio.js"></script> 
<script type="text/javascript" src="js/audioplayer.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script> 
<script type="text/javascript" src="js/jquery.ui.core.min.js"></script> 
<script>
    
	    $('.follow-btn').click(function () {
            $('.follow-btn').html('following<span></span>');
            $('.follow-btn').css('background-color', '#e56c69');
        });

		
        function ShowPageLinkFun1() {
			//alert('hello');
            $('.tweet-wrapper').hide();
            $('.page-link').show();
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
			//alert('hello');
			$('#twtform').trigger('click');
			$('#signinbutton').trigger('click');
        }
		function sendTweet()
		{
			ShowPageLinkFun2();
			$.post("sendtweet.php", $('#tweetform').serialize())
			.done(function(data) {
				$('#tweettext').val('');
				ShowPageLinkFun3();
				window.location.href	=	"zipfileaction.php";
			//alert("Data Loaded: " + data);
			});
			
		}
		function zipfunction()
		{
			window.location.href	=	"zipfileaction.php";
		}
		function feedbackfun()
		{
			
			$.post("feedbackaction.php", $('#feedbackform').serialize())
			.done(function(data) {
				$("#crossid").trigger('click');
				
			//alert("Data Loaded: " + data);
			});
			
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
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);
var elem = $("#chars");
$("#tweettext").limiter(100, elem);

        $('#tweet-form, #mobile-tweet').on('hidden', function () {
            $('.tweet-wrapper').show();
            $('.page-link').hide();
            $('.sending-tweet').hide();
            $('.success').hide();
        });

        $(function () {

            $('audio').audioPlayer();
            $.each($('audio'), function () {
                $(this).siblings('.audioplayer-bar').children('.audioplayer-bar-loaded').text($(this).attr('title'));
            });

        });

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
        function onPause(trackNo) {
            $('#track-' + trackNo).parent().addClass('audioplayer-paused');
        }
        function onPlay(trackNo) {
            $('#track-' + trackNo).parent().removeClass('audioplayer-paused');
        }

    </script>
{* User is authenticated so show him the Tweet Box *}
{if $show eq '1'}    
     <script type="text/javascript">
    $(document).ready(function (){
			
			//alert('calling function for showing...');
			ShowPageLinkFun4();
			
		})
	</script>
{/if}