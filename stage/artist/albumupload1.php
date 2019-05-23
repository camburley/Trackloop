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
	}
}
?>
<!DOCTYPE HTML>
<div class="span9 upload-media">
  <div class="album-cover clearfix">
    <div class="title">ALBUM COVER PREVIEW</div>
    <div class="upload-cover">
      <div id="files" class="files"><img src="<?php echo $domain."/uploads/albums/".$artistuniqueid."/".$albumuniqueid."/coverimage/thumbnail/".$coverimage; ?>" width="100" height="100"  /></div>
      <span class="btn btn-success fileinput-button"> <span>UPLOAD ALBUM COVER</span> 
      <!-- The file input field used as target for the file upload widget -->
      <input id="albumCoverupload" type="file" name="albumCoverupload">
      </span>
     
    </div>
  </div>
  <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
  <input class="input-xlarge" name="releasename" type="text" placeholder="Release Name" value="<?php echo $albumname; ?>">
    <input class="input-xlarge" name="albumid" type="hidden" placeholder="Release Name" value="<?php echo $albumuniqueid; ?>">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript>
    <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
    </noscript>
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="track-upload span11">
        <div class="row fileupload-buttonbar">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <h1 class="total-stats">TRACKS UPLOADED</h1>
                <span class="btn btn-success fileinput-button">
                  <?php /*?>  <i class="icon-plus icon-white"></i><?php */?>
                    <span>UPLOAD NEW TRACK</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
               <?php /*?> <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle"><?php */?>
                <!-- The loading indicator is shown during file processing -->
                <span class="fileupload-loading"></span>
           
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
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
        <br />
        <div id="msg1" style="color:#F00"></div>
      </div>
    </div>
    </form>
 <?php /*?> <!-- The container for the uploaded files -->
  <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
    <input class="input-xlarge" name="releasename" type="text" placeholder="Release Name" value="<?php echo $albumname; ?>">
    <input class="input-xlarge" name="albumid" type="hidden" placeholder="Release Name" value="<?php echo $albumuniqueid; ?>">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript>
    <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
    </noscript>
    <div class="track-upload span11">
      <div class="fileupload-buttonbar">
        <h1 class="total-stats">TRACKS UPLOADED</h1>
        <button type="submit" class="btn btn-primary start"> <i class="icon-upload icon-white"></i> <span>Start upload</span> </button>
        <span class="btn btn-success fileinput-button"> <span>UPLOAD NEW TRACK</span>
        <input type="file" name="files[]"  multiple >
        </span> </div>
      
      
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
        <br />
        <div id="msg1" style="color:#F00"></div>
      </div>
    </div>
  </form><?php */?>
  <?php /*?><form id="fileupload" action="" method="POST" enctype="multipart/form-data">
    <input class="input-xlarge" name="releasename" type="text" placeholder="Release Name" value="<?php echo $albumname; ?>">
    <input class="input-xlarge" name="albumid" type="hidden" placeholder="Release Name" value="<?php echo $albumuniqueid; ?>">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript>
    <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
    </noscript>
    <div class="track-upload span11">
      <div class="fileupload-buttonbar">
        <h1 class="total-stats">TRACKS UPLOADED</h1>
        <button type="submit" class="btn btn-primary start"> <i class="icon-upload icon-white"></i> <span>Start upload</span> </button>
        <span class="btn btn-success fileinput-button"> <span>UPLOAD NEW TRACK</span>
        <input type="file" name="files[]"  multiple >
        </span> </div>
      
      
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
        <br />
        <div id="msg1" style="color:#F00"></div>
      </div>
    </div>
  </form><?php */?>
</div>
<?php
    require_once($path."/artist/footer.php");
?>
<!--
/*
 * jQuery File Upload Plugin Demo 8.6.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->

<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS Toolkit styles -->
<?php /*?><link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap.min.css">
<!-- Generic page styles -->
<?php /*?><link rel="stylesheet" href="blueimp/css/style.css"><?php ?>
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap-responsive.min.css"><?php */?>
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]>
<link rel="stylesheet" href="http://blueimp.github.io/cdn/css/bootstrap-ie6.min.css">
<![endif]-->
<!-- blueimp Gallery styles -->
<?php /*?><link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"><?php */?>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<?php /*?><link rel="stylesheet" href="blueimp/css/jquery.fileupload-ui.css"><?php */?>
<!-- CSS adjustments for browsers with JavaScript disabled -->
<?php /*?><noscript><link rel="stylesheet" href="blueimp/css/jquery.fileupload-ui-noscript.css"></noscript><?php */?>
</head>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel</span>
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
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="blueimp/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="http://blueimp.github.io/cdn/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="blueimp/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="blueimp/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="blueimp/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="blueimp/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="blueimp/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="blueimp/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="blueimp/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="blueimp/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="blueimp/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->