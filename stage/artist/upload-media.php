<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();
$artistuniqueid	=	$_SESSION['artistuniqueid'];
/********************artistname***********************/
$req		=	array(
						'controller' 	=>	'User',
						'action'		=>	'readartist',
						'uniqueid' 		=>	$artistuniqueid
						);
$artists = $apicaller->sendRequest($req);
//$apicaller->dump($artists);
foreach($artists as $artist)
{
	$firstname	=	ucfirst($artist->firstname);
	$lastname	=	ucfirst($artist->lastname);
}
require_once($path."/artist/leftmenu.php");
$albumuniqueid	=	$_GET['albumid'];
$_SESSION['filehandlealbumid']	= $_GET['albumid'];
if($_GET['albumid'])
{
	$req		=	array(
							'controller' 	=>	'Track',
							'action'		=>	'readartistalbum',
							'albumuniqueid' =>	$albumuniqueid,
							'artistuniqueid'=>	$artistuniqueid
							);
	$artistalbums = $apicaller->sendRequest($req);
	$req		=	array(
						'controller' 	=>	'Track',
						'action'		=>	'readtrack',
						'uniqueid' 		=>	$albumuniqueid,
						'artistuniqueid'=>	$artistuniqueid
						);
	$tracks = $apicaller->sendRequest($req);

//$apicaller->dump($artistalbums);
foreach($artistalbums as $artistalbum)
{
	$albumdate			=	date("m/d/y",strtotime($artistalbum->albumdate));
	$coverimage			=	$artistalbum->coverimage;
	$albumname			=	$artistalbum->albumname;
	$albumdescription	=	$artistalbum->albumdescription;
	$location			=	$artistalbum->location;
	$genresname			=	$artistalbum->genresname;
	$_SESSION['covename']	=	$artistalbum->coverimage;
}
}

//$apicaller->dump($tracks);
if($_GET['albumid'])
{
	
	
	foreach($tracks as $track)
	{
		$_SESSION['trackfiles'][]	=	array($track->trackfile,$track->tracklength);
		$trakfiles_db[]				=	$track->trackfile;
	}
	$directory			=	$path."/uploads/albums/".$artistuniqueid."/".$albumuniqueid;
	$scanned_directory	=	array_diff(scandir($directory), array('..', '.',''));
	$extra_files		=	array_diff($scanned_directory,$trakfiles_db);
	//echo "<pre>";
	//print_r($trakfiles_db);
	//print_r($scanned_directory);
	//print_r($extra_files);
	if(sizeof($extra_files))
	{
		//echo "EXTRA FILES ARE ";
		foreach ($extra_files as $ef)	
		{
			if(!is_dir($directory.'/'.$ef))
			{
				@unlink($directory.'/'.$ef);
				//echo $ef."<br>";
				//$d++;
			}
			
		}
//		echo "$d";
	}
}
?>
<script type="text/javascript">
function albumuploadaction()
{
	//var location			=	document.getElementById('searchval').value
	$.post("albumuploadaction.php", $("#fileupload").serialize(),function(data){
	if(data)
	{
		//$("#msg1").html(data);
		$(".successmsg").html(displaymessage(data,0));
		
	}
	else
	{
		$(".successmsg").html(displaymessage("You have saved album data successfully.",1));
		//$("#fileupload").submit();
		<?php
		if(!$albumuniqueid)
		{
		?>
			window.location.href	=	"managealbum.php";
		<?php
		}
		?>
	}
	});
}
function callme()
{
	//alert('called me???');
	//setTimeout(call2(),3000);
	//$('#btnupload').trigger('click');
	setTimeout(function(){$('#btnupload').trigger('click');},500)
}
</script>

        

        <div class="span9 upload-media">
		<form class="fileupload" action="server/php/file2.php" method="POST" enctype="multipart/form-data">
            <div class="album-cover">
                <div class="title">ALBUM COVER PREVIEW</div>
                <div class="fileupload fileupload-new upload-cover" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 249px; height: 152px;">
                        <?php 
							if(file_exists($domain."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/coverimage/thumbnail/".$coverimage))
							{
								$src	=	$domain."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/coverimage/thumbnail/".$coverimage;
							}
							else
							{
								$src	=	"images/album-cover.png";
							}
							?>	
						   
						  <img src="<?php echo $src;?>"  />
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="width: 249px; height: 152px;"></div>
                    <span class="btn-file"><span class="fileupload-new">UPLOAD ALBUM COVER</span><input type="file" /><span class="fileupload-exists change">Change</span></span>
                    <a href="#" class="fileupload-exists remove" data-dismiss="fileupload">Remove</a>
                </div>
            </div>
	</form>
	<form class="fileupload" action="" method="POST" enctype="multipart/form-data">
    <input class="input-xlarge" name="releasename" type="text" placeholder="Release Name" value="<?php echo $albumname; ?>">
    <input class="input-xlarge" name="albumid" type="hidden" placeholder="Release Name" value="<?php echo $albumuniqueid; ?>">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript>
    <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
    </noscript>
    <div class="track-upload span11">
      <div class="fileupload-buttonbar">
        <h1 class="total-stats">TRACKS UPLOADED</h1>
        <button id="btnupload" type="submit" class="btn btn-primary start" style="display:none"> <i class="icon-upload icon-white"></i> <span>Start upload</span> </button>
        <span class="btn btn-success fileinput-button"> <span>UPLOAD NEW TRACK</span>
        <input type="file" name="files[]"  multiple onchange="callme()">
        </span> </div>
       <?php /*?> <?php
        if($_GET['albumid'])
		{
			?>
         <table class="table table-striped" role="presentation">
        <tbody class="files">

        <?php
		
        foreach($tracks as $track)
		{
			if($track->uniqueid)
			{
				$_SESSION['trackfiles'][]	=	array($track->trackfile,$track->tracklength);
		?>
          <tr class="template-download fade in">
            <td><span class="preview"> <a data-gallery="" download="<?php echo  $track->trackfile; ?>" title="<?php echo  $track->trackfile; ?>" href="<?php echo $domain."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/".$track->trackfile; ?>"><?php echo $track->trackfile; ?></a> </span></td>
            <td><p class="name"> <a data-gallery="" download="<?php echo  $track->trackfile; ?>" title="<?php echo  $track->trackfile; ?>" href="<?php echo $domain."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/".$track->trackfile; ?>"><?php echo $track->trackfile; ?></a> </p></td>
            <td><span class="size">64.48 KB</span></td>
            <td><button data-url="http://localhost/gumption/trackloop/artist/server/php/?file=<?php echo  $track->trackfile; ?>" data-type="DELETE" class="btn btn-danger delete"> <i class="icon-trash icon-white"></i> <span>X</span> </button>
              <input type="checkbox" class="toggle" value="1" name="delete"></td>
          </tr>
          <?php
		}
		}
		?>
        </tbody>
      </table>
      <?php
		}
		?><?php */?>
      <!-- The table listing the files available for upload/download -->
      <table role="presentation" class="table table-striped">
        <tbody class="files">
        </tbody>
      </table>
      <?php
      if(!$_GET['albumid'])
	  {
		?>
      <div class="no-data">You have not yet uploaded any track</div>
	  <?php
	  }
      ?>
      <div>
        <label>TRACKS DESCRIPTION</label>
        <textarea name="description" class="span5 textarea-xxlarge" placeholder="blurb about this release"><?php echo $albumdescription; ?></textarea>
      </div>
      <div class="track-info">
        <label>ADD GENRES</label>
        <textarea name="tagsinput" id="tagsinput" class="span5 textarea-xlarge tagsinput" placeholder="ex. Hip-Hop, Indie Rock etc"><?php echo $genresname; ?></textarea>
      </div>
      <div class="submit">
        <button type="button" class="btn btn-info btn-large submit-button start" onclick="albumuploadaction()">SUBMIT</button>
      </div>
      <div  class="successmsg"></div>
    </div>
  </form>

</div>



    <!--end contain -->

    <?php
    require_once($path."/artist/footer.php");
	?>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
    <script type="text/javascript" src="js/audioplayer.js"></script>
    <script type="text/javascript" src="js/bootstrap-select.js"></script>
    <script type="text/javascript" src="js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="js/jquery.tagsinput.js"></script>
    <script type="text/javascript" src="js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="js/application.js"></script>
    <script>
        $(function () {

            $('audio').audioPlayer();
            $.each($('audio'), function () {
                $(this).siblings('.audioplayer-bar').children('.audioplayer-bar-loaded').text($(this).attr('title'));
            });

        });
    </script>
    <!-- The template to display files available for upload --> 
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
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included --> 
<script src="js/fileupload/vendor/jquery.ui.widget.js"></script> 
<!-- The Templates plugin is included to render the upload/download listings --> 
<script src="js/fileupload/tmpl.min.js"></script> 
<!-- The Load Image plugin is included for the preview images and image resizing functionality --> 
<script src="js/fileupload/load-image.min.js"></script> 
<!-- The Canvas to Blob plugin is included for image resizing functionality --> 
<script src="js/fileupload/canvas-to-blob.min.js"></script> 
<!-- blueimp Gallery script --> 
<script src="js/fileupload/jquery.blueimp-gallery.min.js"></script> 
<!-- The Iframe Transport is required for browsers without support for XHR file uploads --> 
<script src="js/fileupload/jquery.iframe-transport.js"></script> 
<!-- The basic File Upload plugin --> 
<script src="js/fileupload/jquery.fileupload.js"></script> 
<!-- The File Upload processing plugin --> 
<script src="js/fileupload/jquery.fileupload-process.js"></script> 
<!-- The File Upload image preview & resize plugin --> 
<script src="js/fileupload/jquery.fileupload-image.js"></script> 
<!-- The File Upload audio preview plugin --> 
<script src="js/fileupload/jquery.fileupload-audio.js"></script> 
<!-- The File Upload video preview plugin --> 
<script src="js/fileupload/jquery.fileupload-video.js"></script> 
<!-- The File Upload validation plugin --> 
<script src="js/fileupload/jquery.fileupload-validate.js"></script> 
<!-- The File Upload user interface plugin --> 
<script src="js/fileupload/jquery.fileupload-ui.js"></script> 
<!-- The main application script --> 
<script src="js/fileupload/main.js"></script> 
<script>
        /*jslint unparam: true, regexp: true */
        /*global window, $ */
       <?php /*?>
	    $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = window.location.hostname === 'blueimp.github.io' ?
                        '//jquery-file-upload.appspot.com/' : 'server/php/file2.php',
                uploadButton = $('')
                    .addClass('btn')
                    .prop('disabled', true)
                    .on('click', function () {
                        var $this = $(this),
                            data = $this.data();
                        $this
                            .off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                        data.submit().always(function () {
                            $this.remove();
                        });
                    });
            $('#albumCoverupload').fileupload({
                url: url,
                dataType: 'json',
                autoUpload: true,
                acceptFileTypes: /(\.|\/)(gif|jpe|png)$/i,
                maxFileSize: 5000000, // 5 MB
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {
                data.context = $('<div/>').appendTo('#files');
                $.each(data.files, function (index, file) {
                    var node = $('<p/>')
                            .append($('<span/>'));
                    if (!index) {
                        node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                    }
                    node.appendTo(data.context);
                });
            }).on('fileuploadprocessalways', function (e, data) {
                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {
                    node
                        .prepend('')
                        .html(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append(file.error);
                }

            });<?php */?>
        });
    </script> 
</body>
</html>
