{block name=sidebar}{sidebar}{/block}

{block name=content}
<style>
.file-upload1{ position:relative;overflow:hidden;margin:10px }
.file-upload1 input.upload{ position:absolute;top:0;right:0;margin:0;padding:0;font-size:20px;cursor:pointer;opacity:0;filter:alpha(opacity=0) }
#tagsinput_tag { width: 50px; }
</style>
<div class="span9 upload-media">
  <div class="album-cover clearfix">
  	<div  class="successmsg"></div>
    <div class="title">ALBUM COVER PREVIEW</div>
    <div class="upload-cover">
          <span id="t1">
	     	 <img src="{$coverimage}"  />
          </span>
          <span class="file-upload1 btn btn-success fileinput-button">
             <span>UPLOAD ALBUM COVER</span> 
              <input class="upload" type="file" action='artist/uploadcover' name="coverimage" into="t1">
          </span>
     
    </div>
  </div>
  <!-- The container for the uploaded files -->
  <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
    <input class="input-xlarge" name="releasename" type="text" placeholder="Release Name" value="{$album->albumname}">
    <input class="input-xlarge" name="albumid" type="hidden" placeholder="Release Name" value="{$albumuniqueid}">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript>
		<input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
    </noscript>
    <div class="track-upload span11">
      <div class="fileupload-buttonbar">
        <h1 class="total-stats">TRACKS UPLOADED</h1>
        <button id="btnupload" type="submit" class="btn btn-primary start" style="display:none"> <i class="icon-upload icon-white"></i> <span>Start upload</span> </button>
		<!-- The global progress bar -->
		<div id="progress" class="progress progress-success progress-striped" style="display: none;">
		  <div class="bar"></div>
		</div>
        <span class="btn btn-success fileinput-button"> <span>UPLOAD NEW TRACK</span>
        <input type="file" name="files[]"  multiple onchange="uploadtrack()">
        </span> </div>
      <!-- The table listing the files available for upload/download -->
      <table role="presentation" class="table table-striped">
        <tbody class="files">
        	{if isset($trackList)}
        		{assign var="trackNumber" value="1"}
				{foreach from=$trackList item=track}
        			{if !empty($track.uniqueid)}
						<tr class="template-download fade in" id="{$track.uniqueid}" artistuniqueid="{$artistuniqueid}" albumuniqueid="{$albumuniqueid}">
							<td><span class="preview">&nbsp;</span></td>
							<td>
							    <p class="name">
								<a id="trackfile_{$track.uniqueid}" download="{$track.trackfile}" title="{$track.trackfile}" href="uploads/{$artistuniqueid}/{$albumuniqueid}/{$track.trackfile}">{$track.trackfile}</a>
							    </p>
							</td>
							<td><span class="size">{math equation="x/y" x=$track.tracklength y="1020" format="%.2f"} KB</span></td>
							<td>
								<button  class="btn btn-primary" onclick="viewEditTrack('{$track.uniqueid}', '{$track.sequence}');">
								<i class="icon-white"></i>
								<span>EDIT</span>
							</button>
							{assign var=trackNumber value=$trackNumber + 1}
				
									<button  data-type="DELETE" class="btn btn-danger delete" onclick="deleteTrack('{$track.uniqueid}');">
								<i class="icon-white"></i>
								<span>X</span>
							</button>
							<input type="checkbox" style="display:none !important" class="toggle" value="1" name="delete">
							</td>
						</tr>
					{/if}
        		{/foreach}
        	{/if}    
        </tbody>
      </table>
	  {if !$album->uniqueid}
      	<div class="no-data">You have not yet uploaded any track</div>
	  {/if}

      <div>
        <label>TRACKS DESCRIPTION</label>
        <textarea name="description" class="span5 textarea-xxlarge" placeholder="blurb about this release">{$album->albumdescription}</textarea>
      </div>
      <div class="track-info">
        <label>ADD GENRES</label>
        <textarea name="tagsinput" id="tagsinput" class="span5 textarea-xlarge tagsinput" placeholder="ex. Hip-Hop, Indie Rock etc">{$album->genresname}</textarea>
      </div>
      <div class="submit">
        <input type="hidden" name="operation" value=""/>
		<button type="button" class="btn btn-info btn-large submit-button start" onclick="albumuploadaction()">SUBMIT</button>
      </div>
      <div  class="successmsg"></div>
    </div>
  </form>
</div>
<form id="deleteTrackForm" action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="operation" value="deleteTrack"/>
	<input type="hidden" id="deleteTrackId" name="track" value="-1"/>
	<input type="hidden" id="artistuniqueid" name="artistuniqueid" value="-1"/>
	<input type="hidden" id="albumuniqueid" name="albumuniqueid" value="-1"/>
</form>

<form id="editTrackForm" action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="operation" value="editTrackName"/>
	<input type="hidden" id="editTrackId" name="trackUniqueId" value="-1"/>
	<input type="hidden" id="editArtistUniqueId" name="artistUniqueId" value="-1"/>
	<input type="hidden" id="editAlbumUniqueId" name="albumUniqueId" value="-1"/>
	<input type="hidden" id="oldTrackName" name="oldTrackName" value="-1"/>
	<input type="hidden" id="newTrackName" name="newTrackName" value="-1"/>
	<input type="hidden" id="newSequenceId" name="newSequenceId" value="-1"/>
	<input type="hidden" id="oldSequenceId" name="oldSequenceId" value="-1"/>
</form>

<!-- Show the dialog for Getting Started Tuor: Learning Trackloop -->
<div id="editTrackModel" class="modal hide fade edit-track-name" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 #3F464E;">
	<div class="page-link">
		<button class="close close-button" aria-hidden="true" data-dismiss="modal" type="button">x</button>
	    <div class="modal-header"><h3>EDIT TRACK</h3></div>
		<div class="popup-background">
		    <div class="modal-body ">
		    	<div class="pagelink-wrapper">
			    	<form id="tweetform" name="tweetform">
				        <fieldset>
				        	<div class="twitter-text">
				            	<label class="pagelink-username">EDIT TRACK</label>
								<label><input class="input-xlarge span12" id="trackName" name="trackName" type="text" value="" placeholder=""></label><br />
								<label class="pagelink-username">Sequence</label>
								<label>
									{if isset($trackList)}
										{assign var="trackNumber" value="1"}
										<select name="sequence" id="sequence">
											{foreach from=$trackList item=track}
									 			<option value="{$track.sequence}">{$trackNumber}</option>
									 			{assign var=trackNumber value=$trackNumber + 1}
											{/foreach}
										</select>
									{/if}
								</label>
								<div class="pagelink-button">
									<input class="submit-tweet btn btn-large btn-block btn-info btn-large submit-button" onclick="editTrackName()" type="button" value="SUBMIT" />
				      			</div>
				  			</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>                  

<!-- end tour dialog -->
{/block}

{block name=scripts}
<script type="text/javascript">
function albumuploadaction()
{
	//var location			=	document.getElementById('searchval').value
	$("#fileupload input[name=operation]").val('saveAlbum');
	$.post("artist/upload", $("#fileupload").serialize(),function(data){
		if(data) {
			$(".successmsg").html(displaymessage(data,0));
		} else {
			$(".successmsg").html(displaymessage("You have saved album data successfully.",1));
			{if !$album->uniqueid}
				window.location.href = "artist/releases";
			{/if}
		}
	});
	$("#fileupload input[name=operation]").val('');
}
function uploadtrack()
{
	$('.no-data').hide();
	setTimeout(function(){ $('#btnupload').trigger('click'); },500)
}
function removeimage()
{
	$('#t1').html('');
}

function deleteTrack(uId)
{
	$('#deleteTrackId').val(uId);
	$('#artistuniqueid').val($('#'+uId).attr('artistuniqueid'));	
	$('#albumuniqueid').val($('#'+uId).attr('albumuniqueid'));
	
	$.post("artist/upload", $("#deleteTrackForm").serialize(),function(data){
		if(data) {
			$(".successmsg").html(displaymessage(data,0));
		} else {
			$(".successmsg").html(displaymessage("You have delete track successfully.",1));
		}
	});
	$('#'+uId).hide();
	$('#deleteTrackId').val(-1);
	$('#artistuniqueid').val(-1);	
	$('#albumuniqueid').val(-1);
}

function viewEditTrack(trackUniqueId, trackNumber) {
	$('#trackName').val($('#trackfile_' + trackUniqueId).text());
	$('#oldSequenceId').val(trackNumber);
	$('#sequence').val(trackNumber);
	$('#editTrackModel').modal('show');
	
	$('#editTrackId').val(trackUniqueId);
	$('#editArtistUniqueId').val($('#' + trackUniqueId).attr('artistuniqueid'));	
	$('#editAlbumUniqueId').val($('#' + trackUniqueId).attr('albumuniqueid'));
	$('#oldTrackName').val($('#trackfile_' + trackUniqueId).text());
}

function closeEditTrackDialog() {
	$('#editTrackModel').modal('hide');
}

function editTrackName() {
	$('#newTrackName').val($('#trackName').val());
	$('#newSequenceId').val($('#sequence').val());
   	$.post("artist/upload", $("#editTrackForm").serialize(),function(data) {
   		$('#editTrackModel').modal('hide');
		if(data) {
			$(".successmsg").html(displaymessage(data, 0));
		} else {
			$(".successmsg").html(displaymessage("You have change track name successfully.", 1));
			location.reload();
		}
	});
}
</script>

<script type="text/javascript" src="public/js/ajaxml/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="public/js/ajaxml/jquery.hashchange.js"></script>
<script type="text/javascript" src="public/js/ajaxml/ajaxml.js"></script>

<script type="text/javascript" src="public/js/audioplayer.js"></script> 
<script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="public/js/bootstrap-select.js"></script> 
<script type="text/javascript" src="public/js/bootstrap-switch.js"></script> 
<script type="text/javascript" src="public/js/jquery.tagsinput.js"></script> 
<script type="text/javascript" src="public/js/jquery.placeholder.js"></script> 
<script type="text/javascript" src="public/js/application.js"></script> 
<!-- The template to display files available for upload --> 
{literal}
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade" style='display:none !important'>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
		 <td>
            {% if (!o.files.error) { %}
                <div style='display:none !important' class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            {% } %}
        </td>
		 <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" style='display:none !important'>
                    <i class="icon-upload icon-white" style='display:none !important'></i>
                    <span style='display:none !important'>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white" style='display:none !important'></i>
                    <span>X</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script> 
<!-- The template to display files available for download --> 
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-white"></i>
                <span>X</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle" style='display:none !important'>
        </td>
    </tr>
{% } %}
</script>
{/literal}

<script src="public/js/fileupload/vendor/jquery.ui.widget.js"></script> 
<script src="public/js/fileupload/tmpl.min.js"></script> 
<script src="public/js/fileupload/load-image.min.js"></script> 
<script src="public/js/fileupload/canvas-to-blob.min.js"></script> 
<script src="public/js/fileupload/jquery.blueimp-gallery.min.js"></script> 
<script src="public/js/fileupload/jquery.iframe-transport.js"></script> 
<script src="public/js/fileupload/jquery.fileupload.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-process.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-image.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-audio.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-video.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-validate.js"></script> 
<script src="public/js/fileupload/jquery.fileupload-ui.js"></script> 
<script src="public/js/fileupload/main.js"></script> 

{/block}