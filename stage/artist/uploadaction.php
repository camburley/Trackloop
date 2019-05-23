<?php
require_once("../classes/resize.php");
@session_start();
if(!empty($_FILES['coverimage']['name']))
{
	$artistuniqueid	=	$_SESSION['artistuniqueid'];
	if(!$_SESSION['filehandlealbumid'])
	{
		$albumsessionid	=	session_id();
	}
	else
	{
		$albumsessionid	=	$_SESSION['filehandlealbumid'];
	}
	if(!file_exists('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid))
	{
		mkdir('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid);
	}
	if(!file_exists('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage'))
	{
		mkdir('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage');
	}
	if(!file_exists('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage/thumbnail'))
	{
		mkdir('../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage/thumbnail');
	}
	$uploaddir 			=	'../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage/';
	$uploaddir_thumb	=	'../uploads/albums/'.$artistuniqueid.'/'.$albumsessionid.'/coverimage/thumbnail/';
	$basefilename		=	basename($_FILES['coverimage']['name']);
	$rand				=	rand(11111111,9999999);
	$filename			=	$_FILES['coverimage']['name'];
	$uploadfile			=	$uploaddir.$filename;
	$thumbsizes			=	array(199=>182,101=>92,166=>153,172=>168,90=>83);
	foreach($thumbsizes as $width=>$height)
	{
		$thumbfiles[$width]	=	$uploaddir_thumb.$width.'x'.$height.$filename;
	}
	$accept 			=	array('jpeg','jpg','png','gif');
	$extension			=	pathinfo($_FILES['coverimage']['name'], PATHINFO_EXTENSION);
	if(!in_array(strtolower($extension),$accept))
	{
	  // If the extension is not allowed show an error, else, the file type is valid
	  echo '<span style="color:#F00">Only image files are allowed.</span>';
	  exit;
	}
	else
	{
		if (move_uploaded_file($_FILES['coverimage']['tmp_name'], $uploadfile)) 
		{	
			$_SESSION['coverimage']	=	$filename;
			foreach($thumbsizes as $width=>$height)
			{
				$thumbfile	=	$thumbfiles[$width];
				copy($uploadfile,$thumbfile);
				smart_resize_image($thumbfile,$width,$height);
			}
		?>
        	<br>
			<img title="Click to change your image" src="<?php echo $thumbfile;?>" />
		<?php
			
		}
		else
		{
			echo "Possible file upload attack!\n";
			echo 'Here is some more debugging info:';
			print_r($_FILES);
			print "</pre>";
		}
	}
}
?>