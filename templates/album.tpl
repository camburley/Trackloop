{block name=album}
<div class="span12 album">
	{assign var="albumImage" value="public/img/album-cover-unlock.png"}
	{if $coverimage }
		{assign var="imageFile" value="`$smarty.const.TL_PATH`uploads/albums/`$artistuniqueid`/`$albumuniqueid`/coverimage/thumbnail/`$coverimage`"} 
		{if file_exists($imageFile)}
				{assign var="albumImage" value="uploads/albums/`$artistuniqueid`/`$albumuniqueid`/coverimage/thumbnail/`$coverimage`"}
		{/if}
	{/if}
	
	<div class="span5">
		<div class="album-image">
			<img src="{$albumImage}" alt="">
		</div>
	</div>
    <div class="span7">
        <div class="time-place">
            <p><i class="time-icon"></i>Added {$albumdate}</p>
            <p><i class="place-icon"></i>{$location}</p>
            <div class="clearfix"></div>
        </div>
        <h4>{$albumname}</h4>
        <p class="artist">{$firstname} {$lastname}</p>
        <a href="https://twitter.com/{$twitterid}" class="twitter-follow-button" data-count="none" >Follow @{$twitterid}</a>
        <div class="clearfix"></div>
        <p class="descrip">{$albumdescription}</p>
        <div class="player">
            <div class="main-audio">
                <audio title="Preview This Track" preload="none" controls>
                	{if 'yes' eq $tweet && $isMobile == 'true'}
						<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[0]}">
						<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[0]}">
					{else}
						<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}mp3.mp3">
			          	<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}ogg.ogg">
					{/if}
          			Your browser does not support this audio format.
                </audio>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
{/block}

{block name=otherAudio}
{if !empty($trackuniqueid[0])}
	{section name=outer loop=$trackuniqueid}
	  <div class="other-audio">
		<audio id="track-{$trackuniqueid[outer]}" onplay="onPlay('{$trackuniqueid[outer]}')" onpause="onPause('{$trackuniqueid[outer]}')" title="{$trackname[outer]}" preload="none" controls>
		  	{if 'yes' eq $tweet && $isMobile == 'true'}
				<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[outer]}">
				<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[outer]}">
		 	{else}
				<source src="uploads/temp/{$trackfile[outer]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}mp3.mp3">
          		<source src="uploads/temp/{$trackfile[outer]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}ogg.ogg">
			{/if}
          	Your browser does not support this audio format.
		</audio>
	  </div>
  	{/section}
{/if} 
{/block}

{block name=sideBox}
<div class="white-box">
	<img src="public/img/eqelizers.png" alt="">
	<h3 class="nowrap download">{$audioquality}</h3>
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
    <a  href="#tweet-form"  id="twtform" class="like-artist btn btn-large btn-block btn-info btn-reset" data-toggle="modal">
    	<span class="like"></span>
    	<span class="a-fan nowrap">Click to Unlock with Tweet</span>
        <div class="clearfix"></div>
    </a>
</span>
			
<a href="fan/connect/{$artistuniqueid}/{$albumuniqueid}" class="like-artist btn btn-large btn-block btn-info btn-reset" data-count="none" data-toggle="modal">
    <span class="like"></span>
    <span class="a-fan nowrap">Click to Unlock with Tweet</span>
    <div class="clearfix"></div>
</a>
{/block}

{block name=mobileAlbum}
<div class="mobile-album"  style="margin-right: 2px;">
	{assign var="albumImage" value="public/img/album-cover.png"}
	{if $coverimage }
		{assign var="imageFile" value="`$smarty.const.TL_PATH`uploads/albums/`$artistuniqueid`/`$albumuniqueid`/coverimage/thumbnail/`$coverimage`"} 
		{if file_exists($imageFile)}
				{assign var="albumImage" value="uploads/albums/`$artistuniqueid`/`$albumuniqueid`/coverimage/thumbnail/`$coverimage`"}
		{/if}
	{/if}
    <img src="{$albumImage}" alt="">
</div>
{/block}

{block name=mobileAlbumDesc}
<div class="mobile-track-info">
	<h4>{$albumname}</h4>
	<p class="artist">{$firstname} {$lastname}</p>
	<div class="clearfix"></div>
</div>

<div class="mobile-track-history">
	<div class="mobile-time-zone">
		<p><i class="time-icon"></i>Added {$albumdate}</p>
	</div>

	<div class="track-count">
		<span class="circle-number">{$noOfTrack}</span><span class="track">Tracks</span>
	</div>
</div>
{/block}

{block name=mobilePlayer}
<div class="mobile-preview">
    <div class="other-audio">
        <audio title="PREVIEW TRACKS" preload="none" controls>
	        {if 'yes' eq $tweet && $isMobile == 'true'}
				<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[0]}">
				<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[0]}">
			{else}
				<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}mp3.mp3">
	          	<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}ogg.ogg">
			{/if}
        	Your browser does not support this audio format.
        </audio>
    </div>
</div>

<div class="mobile-playlist">
	{*if !empty($trackuniqueid[0])}
		<ol>
			{section name=outer loop=$trackuniqueid}
				<li><a class="nowrap" href="#">{$trackname[outer]}</a> <span class="pull-right">{$tracklength[outer]}</span></li>
		  	{/section}
		</ol>
	{/if*} 
	
	{if !empty($trackuniqueid[0])}
		{section name=outer loop=$trackuniqueid}
			<div class="other-audio otherAudio">
				<audio id="track-{$trackuniqueid[outer]}" onplay="onPlay('{$trackuniqueid[outer]}')" onpause="onPause('{$trackuniqueid[outer]}')" title="{$trackname[outer]}" preload="none" controls>
				   {if 'yes' eq $tweet && $isMobile == 'true'}
						<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[outer]}">
						<source src="uploads/albums/{$artistuniqueid}/{$albumuniqueid}/{$trackfile[outer]}">
				 	{else}
						<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}mp3.mp3">
			          	<source src="uploads/temp/{$trackfile[0]|replace:' ':'%20'|replace:'.mp3':''|replace:'.ogg':''}ogg.ogg">
					{/if}
					Your browser does not support this audio format.
				</audio>
			  </div>
	  	{/section}
	{/if}
</div>
{/block}