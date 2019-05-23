{block name=sidebar}
{sidebar}
{/block}

{block name=content}
<link rel="stylesheet" href="public/css/jquery.qtip.css"/>
<div class="span9 smallbuzz-contain trackloop-content">
  <div class="sidebar-title">
    <h3>My Buzz</h3>
  </div>
  {if $albumuniqueid[0] eq ''}
	<div class="row-fluid  buzz-no-data">
	  	<div class="span12 no-data">There are not any total stats yet.</div>
	</div>
  {else}
  <div class="row-fluid">
    <div class="span5">
      <h1 class="total-stats">Total Stats</h1>
      <div class="row-fluid graph-desktop">
        <div class="span8">
          <div class="circle-graph">
            <div class="circle-big">
              <map name="large-circle">
                <area class="circle-map" data-toggle="tooltip" title="{$totalimpression}" shape="circle" coords="132, 133, 133" alt="" href="#" />
              </map>
              <img src="public/img/large-circle.png" height="265" width="265" alt="" usemap="#large-circle" /> </div>
            <div class="circle-middle">
              <map name="medium-circle">
                <area class="circle-map" data-toggle="tooltip" title="{$agrfollowers}" shape="circle" coords="100, 100, 100" alt="" href="#" />
              </map>
              <img src="public/img/medium-circle.png" alt="" usemap="#medium-circle" /> </div>
            <div class="circle-small">
              <map name="small-circle">
                <area class="circle-map" data-toggle="tooltip" title="{$agrdownload}" shape="circle" coords="25, 25, 26" alt="" href="#" />
              </map>
              <img src="public/img/small-circle.png" alt="" usemap="#small-circle" /> </div>
          </div>
        </div>
        <div class="span4 circle-graph-color">
          <div class="graph-color">
            <div class="graph-color-1"></div>
            Impressions </div>
          <div class="graph-color">
            <div class="graph-color-2"></div>
            Reach </div>
          <div class="graph-color">
            <div class="graph-color-3"></div>
            Unlocks </div>
        </div>
      </div>
    </div>
    <div class="span5 offset1">
      <h1 class="total-stats">Top Locations</h1>
      <ul class="location">
        {section name=inner loop=$countloactionbyartist}
        	<li>{$downloadlocationbyartist[inner]} <span class="pull-right location-number">{$countloactionbyartist[inner]}</span></li>
        {/section}
      </ul>
    </div>
  </div>
  
  <div class="row-fluid ">
    <div class="span12">
      <table class="otherpice">
        <tr>
          <th>Release Name</th>
          <th>Status</th>
          <th>Tracks</th>
          <th>Reach</th>
          <th>Downloads</th>
        </tr>
        {section name=outer loop=$albumuniqueid}
        {if $albumuniqueid[outer]}
        <tr>
          <td class="table-list-style">{$albumname[outer]}</td>
          {if $albumstatus[outer]==1}
          <td>Active</td>
          {else}
          <td>InActive</td>
          {/if}
          <td>{$counttrackalbum[outer]}</td>
          <td>{$totalfollowers[outer]}</td>
          <td>{$totaldownload[outer]}</td>
        </tr>
        <tr>
          <td colspan="5"><div class="raw-fluid">
			{assign var="albumImage" value="public/img/album-cover.png"}
			{if $coverimage[outer] }
				{assign var="imageFile" value="`$smarty.const.TL_PATH`uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"} 
				{if file_exists($imageFile)}
						{assign var="albumImage" value="uploads/albums/`$artistuniqueid`/`$albumuniqueid[outer]`/coverimage/thumbnail/`$coverimage[outer]`"}
				{/if}
			{/if}
			
              <div class="span4"> <img src="{$albumImage}" alt="" /> </div>
              <div class="span4">
                <h4 class="buzz-download">TOP DOWNLOADS</h4>
                <ul class="location">
                  {section name=abc loop=$downloadlocation}
                  {if $albumuniqueid[outer]==$countuniqueid[abc]}
                  <li>{$downloadlocation[abc]}</li>
                  {/if}
                  {/section}
                </ul>
              </div>
              <div class="span4 buzz-circle">
                <h4 class="buzz-download">BUZZ</h4>
                <div class="circle-big01"> <a href="#" data-toggle="tooltip" title="{$totalimpressions[outer]}"><img src="public/img/big-circle01.png" alt="" /></a> </div>
                <div class="circle-middle02"> <a href="#" data-toggle="tooltip" title="{$totalfollowers[outer]}"><img src="public/img/middle-circle02.png" alt="" /></a> </div>
                <div class="circle-small03"> <a href="#" data-toggle="tooltip" title="{$totaldownload[outer]}"><img src="public/img/small-circle03.png" alt="" /></a> </div>
              </div>
            </div></td>
        </tr>
        {/if}
        {/section}
      </table>
      {if !$albumuniqueid}
      <div class="row-fluid buzz-no-data">
        <div class="span12 no-data">There are not any stats for your releases</div>
      </div>
      {/if}
    </div>
  </div>
  {/if}
</div>
<!-- end Desktop View --> 
{/block}

{block name=mobileViewContainer}
<div class="sidebar-title">
    <h3>My Buzz</h3>
</div>
{if $albumuniqueid[0] eq ''}
	<div class="row-fluid  buzz-no-data">
    	<div class="span12 no-data">There are not any total stats yet.</div>
  	</div>
{else}   
	<div class="row-fluid">
		<div class="span5">
			<h1 class="total-stats">Total Stats</h1>
			<div class="mobile-stats">
	            <div class="impressions">
	                <div class="numder">{$totalimpression}</div>
	                <div class="mobile-stats-text">Impressions</div>
	            </div>
	
	            <div class="reach">
	                <div class="numder">{$agrfollowers}</div>
	                <div class="mobile-stats-text">Reach</div>
	            </div>
	
	            <div class="unlocks">
	                <div class="numder">{$agrdownload}</div>
	                <div class="mobile-stats-text">Unlocks</div>
	            </div>
	        </div>
	    </div>
	    
	    {section name=outer loop=$albumuniqueid}
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
		                <img src="{$albumImage}" alt="">
		            </div>
		            <div class="mobile-tweet">
		                <a href="mobile-buzz-view.html" class="mobile-btn like-artist btn btn-large btn-block btn-info btn-reset">
		                    <span class="mobile-view"></span><span class="mobile-a-fan">View</span>
		                </a>
		            </div>
	        	</div>
	        	<div class="mobile-album-desc">
		            <div class="mobile-track-info">
		                <h4>{$albumname[outer]}</h4>
		                <p class="artist">Phil Street</p>
		                <div class="clearfix"></div>
		            </div>
		            <div class="mobile-track-history">
		                <div class="mobile-time-zone">
		                    <p><i class="time-icon"></i>Added {$albumdate[outer]}</p>
		                </div>
		                <div class="track-count">
		                    <span class="circle-number">{$counttrackalbum[outer]}</span><span class="track">Tracks</span>
		                </div>
		            </div>
	        	</div>
			</div>
		{/section}
	</div>
{/if}
{/block}

{block name=scripts}
<script type="text/javascript" src="public/js/jquery.qtip.min.js"></script> 
<script type="text/javascript">

$(document).ready(function () {
	$(".otherpice tr:odd").addClass("odd");
	$(".otherpice tr:not(.odd)").hide();
	$(".otherpice tr:first-child").show();

	$(".otherpice tr.odd").click(function () {
		$(this).next("tr").toggle();
		if ($(this).hasClass("expanded")) {
			$(this).removeClass("expanded");
		}
		else {
			$(this).addClass("expanded");
		}
	});
	
	$(".otherpice tr:odd").first().trigger('click');
});

javascript:
// Create the tooltips only when document ready
	$(document).ready(function () {

		$('.circle-map').qtip({
			position: {
				my: 'bottom center',
				at: 'top center'
			},
			style: {
				classes: 'qtip-bootstrap'
			}
		});
	});


javascript:
	  // Create the tooltips only when document ready
	$(document).ready(function () {

		$('.buzz-circle a').qtip({
			position: {
				my: 'left center',
				at: 'right center'
			},
			style: {
				classes: 'qtip-bootstrap'
			}
		});
	});

</script>
{/block}