{block name=title}Upload Media{/block}
{block name=sidebar}
<div class="visible-desktop">{sidebar}</div>
{/block}
{block name=content}
<div class="span9 smallprofile-contain visible-desktop trackloop-content">
  <div class="music-upload-header"><span class="music-upload">Music i’ve Uploaded <a href="artist/upload"><span class="pull-right music-newrelease">Upload new release</span></a></span></div>
  {if $albumuniqueid[0] eq ''}
  <div class="row-fluid  buzz-no-data">
    <div class="span12 no-data"></div>
  </div>
 {else}
      {section name=outer loop=$albumuniqueid}
      {if $albumuniqueid[outer]}
      <div class="row-fluid music-uploadbg">
	{assign var="albumImage" value="public/img/album-cover-release.png"}
	{if $coverimage[outer] }
		{assign var="imageFile" value="`$smarty.const.TL_PATH`uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"} 
		   	
    		{if file_exists($imageFile)}
			{assign var="albumImage" value="uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"}
		{/if}
	{/if}
        <div class="span4 music-albembg"> <img src="{$albumImage}" alt="" />
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
        <div class="span3 track-option"> <a href="artist/edit/{$albumuniqueid[outer]}">
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
				<div class="desktop-envelope"><img src="public/img/envelope.png" alt="" /></div>
				<div class="desktop-uneditable"><label class="uneditable-input copylink desktop-copy">{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}</label></div>
				<div class="desktop-copylink"><a href="#" id="copylink-{$albumuniqueid[outer]}" data-clipboard-text="{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}">COPY LINK</a></div>
			</div>
			<div class="sharelink-or">OR</div>
				<div class="sharelink-resize">
					<div class="twitter-facebook">
						<a href="http://twitter.com/share"  id="{$albumuniqueid[outer]}" class="twitter-share-button" data-url="{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}" data-text="#NowPlaying #{$albumname[outer]|replace:' ':''} from @{$smarty.session.twitterid} on #TrackLoop.fm " title="{$albumname[outer]}" name="{$albumname[outer]}" data-count="none" > <img src="public/img/twitter-small.png" alt=""  />
							<input class="btn btn-large btn-block btn-info btn-large share-twitter" type="button" value="share on twitter" />
						</a>
						
						{* Task - Hide facebook button. For hide facebook button on pop up window
							<div id = "share_button" onClick="fbshare('{$albumuniqueid[outer]}')"><input class="btn btn-large btn-block btn-info btn-large share-facebook" type="button" value="share on facebook" /></div>
						*}
					</div>
				</div>
		</div>
	</div>
</div>
{/section}

<input class="input-xlarge" type="hidden" placeholder="" id="twitterid">
{/block}

{block name=mobileViewContainer}
{if $albumuniqueid[0] eq ''}
	<div class="row-fluid  buzz-no-data">
    	 <div class="span12 no-data"><a data-toggle="modal" href="#tourModel" class="trackloopTour"/></div>
  	</div>
{else}
	{section name=outer loop=$albumuniqueid}
		{if $albumuniqueid[outer]}
			<div class="mobile-album-section">
			    <div class="mobile-album-cover">
			        <div class="mobile-album">
			        	{assign var="albumImage" value="public/img/album-cover.png"}
						{if $coverimage[outer] }
							{assign var="imageFile" value="`$smarty.const.TL_PATH`uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"} 
							   	
					    		{if file_exists($imageFile)}
								{assign var="albumImage" value="uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"}
							{/if}
						{/if}
			            <img src="{$albumImage}" alt="" width="95%">
			        </div>
			        <div class="mobile-tweet">
			            <a href="#mobAlbum{$albumuniqueid[outer]}" onclick="checkvalue('{$albumuniqueid[outer]}');" class="mobile-btn like-artist btn btn-large btn-block btn-info btn-reset" data-toggle="modal">
			                <span class="mobile-share"></span><span class="mobile-a-fan">Share</span>
			            </a>
			        </div>
			    </div>
			    <div class="mobile-album-desc">
			        <div class="mobile-track-info">
			            <h4>{$albumname[outer]}</h4>
			            <p class="artist">{$smarty.session.firstname} {$smarty.session.lastname}</p>
			            <div class="clearfix"></div>
			        </div>
			        <div class="mobile-track-history">
			            <div class="mobile-time-zone">
			                <p><i class="time-icon"></i>Added {$albumdate[outer]}</p>
			            </div>
			            <div class="track-count">
			                <span class="circle-number">{$counttrack[outer]}</span><span class="track">Tracks</span>
			            </div>
			        </div>
			    </div>
			</div>
		{/if}
	{/section}
	
	{section name=outer loop=$albumuniqueid}
		<div id="mobAlbum{$albumuniqueid[outer]}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 #3F464E;">
            <button type="button" class="close pull-left" data-dismiss="modal" aria-hidden="true">
                <h1 class="back">Trackloop<a href="mobile-buzz.html"></a></h1>
            </button>
            <div class="share-wrapper">
                <div class="modal-header">
                    <h3 id="myModalLabel" class="share-link">SHARE LINK</h3>
                </div>

                <div class="modal-body modal-sharelink">
                    <div class="sharelink-desktop">
				<div class="desktop-envelope"><img src="public/img/envelope.png" alt="" /></div>
				<div class="desktop-uneditable"><label class="uneditable-input copylink desktop-copy">{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}</label></div>
				<div class="desktop-copylink"><a href="#" id="mob-copylink-{$albumuniqueid[outer]}" data-clipboard-text="{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}">COPY LINK</a></div>
			</div>
                    
                    <div class="sharelink-or">OR</div>
                   
					<div class="twitter-facebook">
						<a href="http://twitter.com/share"  id="{$albumuniqueid[outer]}" class="twitter-share-button" data-url="{$base}artist/album/{$artistuniqueid}/{$albumuniqueid[outer]}" data-text="#NowPlaying #{$albumname[outer]|replace:' ':''} from @{$smarty.session.twitterid} on #TrackLoop.fm " title="{$albumname[outer]}" name="{$albumname[outer]}" data-count="none" > <img src="public/img/twitter-small.png" alt=""  />
							<input class="btn btn-large btn-block btn-info btn-large share-twitter" type="button" value="share on twitter" />
						</a>
                        
						{* Task - Hide facebook button. For hide facebook button on pop up window
                        	<div id = "share_button" onClick="fbshare('{$albumuniqueid[outer]}')"><input class="btn btn-large btn-block btn-info btn-large share-facebook" type="button" value="share on facebook" /></div>
                        *}
                    </div>
                    
                    {*<div class="sharelink-nevermind"><a href="mobile-profile.html">NEVERMIND</a></div>*}
                </div>
			</div>
		</div>
	{/section}
{/if}
{/block}

{block name=scripts}
<div id="fb-root"></div>
<script>
	{* Task - Hide facebook button. For hide facebook button on pop up window
		window.fbAsyncInit = function() {
			FB.init({ appId: '{Registry::get("config")->read("fb.app_id")}', status: true, cookie: true, xfbml: true });
		};
	
		(function() {
			var e = document.createElement('script');
			e.async = true;
			e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
			document.getElementById('fb-root').appendChild(e);
		}());
	*}
</script> 

<script type="text/javascript" src="public/js/ZeroClipboard.min.js"></script>
<script type="text/javascript">
	(function() {
		$('.desktop-copylink a').each(function() {
			var clip = new ZeroClipboard( document.getElementById($(this).attr('id')), {
				moviePath: "public/js/ZeroClipboard.swf"
			});
			clip.on( 'complete', function(client, args) {
				//this.style.display = 'none';
				$(this).html('COPIED');
			});
		});
	})();
	
	{* Task - Hide facebook button. For hide facebook button on pop up window
		function fbshare(albumuniqueid) {
			FB.ui({
				method: 'feed',
				app_id: '{Registry::get("config")->read("fb.app_id")}',
				link: '{$base}artist/album/{$artistuniqueid}/' + albumuniqueid,
				picture: '',
				//name: '{$base}artist/album/{$artistuniqueid}/' + albumuniqueid
			},
			function(response){
				if(response && response.post_id) {
					var shareon	= 1;
					$.post("shareaction.php", { 'albumuniqueid':albumuniqueid,'shareon':shareon }, function(data) {});
				}
			});
		}
	*}
</script> 
<script type="text/javascript">
	{* Task - Hide facebook button. For hide facebook button on pop up window
		function fbshares(albumuniqueid) {
			var w1	=	window.open(
				"http://www.facebook.com/sharer.php?u=http://facebook.com/" + albumuniqueid,
				'fb-share-dialog',
				'width=626,height=436'
			);
			
			var timer = setInterval(function() {
				if(w1.closed) {
					clearInterval(timer);
				}  
			}, 1000);
		}
	*}
</script> 
<script type="text/javascript" src="public/js/widgets.js"></script> 
<script type="text/javascript">
    twttr.events.bind('tweet', function(event) {
		var albumuniqueid = $("#twitterid").val();
		var shareon	= 2;
		$.post("shareaction.php", { 'albumuniqueid':albumuniqueid,'shareon':shareon }, function(data) {})
	});
</script> 
<script type="text/javascript">
	function checkvalue(ids) {
		$("#twitterid").val(ids);
	}
</script>
<script>
	{if $albumuniqueid[0] eq ''}
		$(document).ready(function () {
			$('#getStartedTour').trigger('click');
			$('.back-button').hide();			
		});
	{/if}
</script>
{/block}