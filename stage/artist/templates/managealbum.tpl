<script type="text/javascript" src="jquery.js"></script>

<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
	appId: '475466765877229', status: true, cookie: true,
xfbml: true});
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol +
'//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());
</script> 

<script type="text/javascript" src="ZeroClipboard.js"></script> 
<script type="text/javascript">
function fbshare(albumuniqueid)
{
FB.ui({
      method: 'feed',
      app_id: '475466765877229',
      link: 'http://facebook.com/roseland88',
      picture: '',
      name: '{$domain}/artist/album.php?artistid={$artistuniqueid}&albumid='+albumuniqueid
    },
    function(response){
      if(response && response.post_id) {
		  var shareon	=	1;
        $.post("shareaction.php", {
				'albumuniqueid':albumuniqueid,'shareon':shareon }, function(data) 
				{
					
				})
      }
      else {
       // self.location.href = 'http://www.google.com/'
      }
    });
}
</script> 
<script type="text/javascript">
function fbshares(albumuniqueid)
{
	
	var w1	=	window.open(
	"http://www.facebook.com/sharer.php?u=http://facebook.com/"+albumuniqueid,
	'fb-share-dialog',
	 'width=626,height=436'
	 );
	var timer = setInterval(function() 
	{   
		if(w1.closed) 
		{  
			
			clearInterval(timer);  
			
			/*$.post("shareaction.php", {
				'albumuniqueid':albumuniqueid }, function(data) 
				{
					
				})*/
		}  
	}, 1000);  
	
		/*
		w1.afterOpen
	if (window.focus) 
	{
		w1.focus()
		alert(w1.returnValue);
	}
	else
	{
		alert("a");
	}
	//return false;
	/*
		$.post("shareaction.php", {
				'albumuniqueid':albumuniqueid }, function(data) 
				{
					
				})*/
}
</script> 
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 
<script type="text/javascript">
     twttr.events.bind('tweet', function(event) {
		 var albumuniqueid	=	$("#twitterid").val();
		 var shareon	=	2;
	 $.post("shareaction.php", {
				'albumuniqueid':albumuniqueid,'shareon':shareon }, function(data) 
				{
					
				})
       });
</script> 
<script type="text/javascript">
/****************copy link******************************/
 /*$(function() {
				
				setTimeout(function() {
				//set path
				ZeroClipboard.setMoviePath('http://davidwalsh.name/dw-content/ZeroClipboard.swf');
				//create client
				var clip = new ZeroClipboard.Client();
				//event
				clip.addEventListener('mousedown',function() {
				clip.setText(document.getElementById('box-content').value);
				});
				clip.addEventListener('complete',function(client,text) {
					alert('copied: ' + text);
				});
				//glue it to the button
				clip.glue('copy');
			}, 2000);
				
		});*/
/**********************************************/
   /* function debugEvent(intent_event) {

      console.log(intent_event);
var abcs	=	intent_event.target;
var vr	=	abcs.baseurl;
alert(vr);
    }

 */

    //twttr.events.bind('click',    debugEvent);

   // twttr.events.bind('tweet',    debugEvent);

   // twttr.events.bind('retweet',  debugEvent);

   // twttr.events.bind('favorite', debugEvent);

    //twttr.events.bind('follow',   debugEvent);
	function checkvalue(ids)
	{
		$("#twitterid").val(ids);
		//$("#box-content").val("http://www.tl.fm/"+ids);
		//abc(ids);
		
	}
	

  </script>
  <input class="input-xlarge" type="hidden" placeholder="" id="twitterid">
  <!--<input type="button" id="copy" name="copys" value="Copy to Clipboard"  />
      <input type="text" name="box-content" class="input-xlarge" id="box-content">-->
<div class="span9 smallprofile-contain">
  <div class="music-upload-header"><span class="music-upload">Music i’ve Uploaded <a href="albumupload.php"><span class="pull-right music-newrelease">Upload new release</span></a></span></div>
  {if $albumuniqueid[0] eq ''}
  <div class="row-fluid  buzz-no-data">
    <div class="span12 no-data">There are not any releases yet.</div>
  </div>
 {else}
      {section name=outer loop=$albumuniqueid}
      {if $albumuniqueid[outer]}
      <div class="row-fluid music-uploadbg">
        <div class="span4 music-albembg"> <img src="{if $coverimage[outer] }{$domain}/uploads/albums/{$artistuniqueid}/{$albumuniqueid[outer]}/coverimage/thumbnail/{$coverimage[outer]} {else} {$domain}/uploads/album-cover.PNG {/if}" alt="" />
          <p class="music-uploadbg-text">{$albumname[outer]}</p>
        </div>
        <div class="span5">
          <div class="time-place">
            <p><i class="time-icon"></i>Added {$albumdate[outer]}</p>
            <h1>{$albumname[outer]}</h1>
          </div>
          {if $counttrack[outer]>0}
          <div>
          
            <p class="track-number">{$counttrack[outer]}</p>
            <p class="text">Tracks</p>
          </div>
          {/if}
        </div>
        <div class="span3 track-option"> <a href="albumupload.php?albumid={$albumuniqueid[outer]}">
          <p class="music-edittracks">Edit Tracks</p>
          </a><a href="#album{$albumuniqueid[outer]}" onclick="checkvalue('{$albumuniqueid[outer]}');" data-toggle="modal">
          <p class="music-edittracks">Share</p>
          </a> </div>
      </div>
      {/if}
      {/section}
  {/if}
   </div>
 
  {section name=outer loop=$albumuniqueid}
  <div id="album{$albumuniqueid[outer]}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 #3F464E;">
                    <div class="share-wrapper">

                        <div class="modal-header">
                            <h3 id="myModalLabel" class="share-link">SHARE LINK</h3>
                        </div>

                        <div class="modal-body modal-sharelink">
							<div class="sharelink-desktop">
								<div class="desktop-envelope"><img src="images/envelope.png" alt="" /></div>
								<div class="desktop-uneditable"><label class="uneditable-input copylink desktop-copy">{$domain}/artist/album.php?albumid={$albumuniqueid[outer]} </label></div>
								<div class="desktop-copylink"><a href="#">COPY LINK</a></div>
							</div>
							
                            <div class="sharelink-or">OR</div>
								<div class="sharelink-resize">
									<div class="twitter-facebook">
                                        <a href="http://twitter.com/share"  id="{$albumuniqueid[outer]}" class="twitter-share-button"

          data-url="{$domain}/artist/album.php?artistid={$artistuniqueid}&albumid={$albumuniqueid[outer]}"

          data-text="{$domain}/artist/album.php?artistid={$artistuniqueid}&albumid={$albumuniqueid[outer]}" title="{$albumuniqueid[outer]}" name="{$albumuniqueid[outer]}"

          data-count="none" > <img src="images/twitter-small.png" alt=""  />
          <input class="btn btn-large btn-block btn-info btn-large share-twitter" type="button" value="share on twitter" /></a>
										<div id = "share_button" onClick="fbshare('{$albumuniqueid[outer]}')"><input class="btn btn-large btn-block btn-info btn-large share-facebook" type="button" value="share on facebook" /></div>
                                    </div>
								</div>
                           
                        </div>
                    </div>
                </div>

{/section}


    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>