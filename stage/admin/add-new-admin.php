<?php
$currentsection	=	"5";
require_once("classes.php");
require_once("include.php");
$userid		=	$_GET['userid'];
if($userid)
{
	$query		=	"SELECT * FROM tbladminuser WHERE pkadminuserid = $userid";
	$users		=	$db->query($query);
	$user		=	$users[0];
	$username	=	$user['username'];
	$password	=	$user['password'];
	/**********************************************MySections********************************/
	$myquery	=	"SELECT * FROM tblsection, tbladminusersection WHERE fkadminuserid = '$userid' AND pksectionid = fksectionid";
	$mysections	=	$db->query($myquery);
	$mysectionsarray	=	array();
	foreach($mysections as $mysection)
	{
		$mysectionsarray[]	=	$mysection['pksectionid'];
		$selectedsections	.=	$mysection['pksectionid'].",";
	}
	$selectedsections	=	trim($selectedsections,',');

}
$query		=	"SELECT * FROM tblsection";
$sections	=	$db->query($query);
?>
<script type="text/javascript" >
	function submitform()
	{
		/*validateusername();
		if(error==1)
		{
			alert('Please correct the notified errors.');
			return;
		}
		validatepassword();
		if(error==1)
		{
			alert('Please correct the notified errors.');
			return;
		}
		*/
		var password	=	$("#password").val();
		var verify_password	=	$("#verify-password").val();
		if(password==verify_password)
		{
		}
		else
		{
			alert("Verify password should be match.");
			return false; 
		}
		$('#btnsave').hide();
		var uname	=	$('#username').val();
		if(uname=="")
		{
			$('#btnsave').show();
			displayerror('msg1','not provided.');
			return;
		}
		var selectedsections = new Array();
		var chvalue	=	document.getElementsByClassName('tl-chk active');
		for(var i=0; i<chvalue.length; i++)
		{
			selectedsections[i]	=	chvalue[i].value;
		}
		/*for(var i=0; i<mycars.length; i++)
		{
			alert(mycars[i]);
		}*/
		$.post("validateusername.php", { userid: <?php  if($userid) {echo $userid;} else{ echo "0";}?>, username: uname }, function(data)
		{
			if(data)
			{
				$('#btnsave').show();
				alert('User Name already taken.');
				return false;
			}
			else
			{
				$.post("actions/add-newadminaction.php?selectedsections="+selectedsections, $("#frmadminuser").serialize(),function(data){
				if(data)
				{
					alert(data);
					$('#btnsave').show();
				}
				else
				{
					window.location.href	=	"view-admin.php";
				}
			
				});
			}
		});	
	}
	function validateusername()
	{
		var uname	=	$('#username').val();
		if(uname=="")
		{
			displayerror('msg1','not provided.');
			return;
		}
		$.post("validateusername.php", { userid: <?php if($userid) {echo $userid;} else{ echo "0";}?>, username: uname }, function(data)
		{
			if(data)
			{
				
				displayerror('msg1','User Name already taken.');
				return;
			}
			else
			{
				
				displaysuccess('msg1');
			}
		});
	}
	function validatepassword()
	{
		if($('#password').val().length < 8)
		{
			displayerror('msg2','must be 8 characters.');
			return;
		}
		else
		{
			displaysuccess('msg2');
		}
	}
</script>
<?php
if(!$_GET['userid'])
{
?>
<title>Add New Admin</title>
<?php
}
else
{
	?>
  <title>Edit Admin</title>
    <?php
}
?>
<form id="frmadminuser" name="frmadminuser" method="post">
<input type="hidden" name="userid" value="<?php echo $userid;?>" />
<h1 class="title">Add New Admin</h1>
<div class="content-admin2 clearfix"> <span class="new-admin2">
  <label class="lbluser">Username</label>
  <input class="pw" name="username" id="username" placeholder="User Name" value="<?php echo $username;?>" type="text" />
  </span><!-- end new-admin --> 
  
  <span class="new-admin2">
  <label class="lblpw">Password</label>
  <input class="pw" name="password" id="password"  placeholder="Password" type="password" value="<?php echo $password;?>" />
  </span><!-- end new-admin --> 
  
  <span class="new-admin2">
  <label class="lblverpw">Verify Password</label>
  <input class="ver-pw" name="verify-password" id="verify-password"  type="password" value="<?php echo $password;?>" />
  </span><!-- end new-admin --> 
  
</div>
<!-- end content-admin -->

<div class="content">
  <h2>Grant Access to These Pages</h2>
  <div class="btn-group" data-toggle="buttons-checkbox">
  <?php
  foreach($sections as $section)
	{
		if(@in_array($section['pksectionid'],$mysectionsarray))
		{
			$classval	=	"tl-chk active";
			//echo $section['pksectionid'],$mysectionsarray;
		}
		else
		{
			$classval	=	"tl-chk";
			//echo $section['pksectionid'],$mysectionsarray;
		}
	
	?>
    <p>
      <button type="button" class="<?php echo $classval; ?>" value="<?php echo $section['pksectionid']; ?>" name="selectedsections[]" >
     
      </button>
       <span>
      <label><?php echo $section['sectionname'];?></label>
      </span>
      
    </p>
   <?php
	}
	?>
  </div>
 <!-- <h2>Can this admin edit permissions?</h2>
  <div class="btn-group" data-toggle="buttons-radio">
    <p>
      <button type="button" class="btn tl-radio">
      <span>
      <label>Yes</label>
      </span>
      </button>
    </p>
    <p>
      <button type="button" class="btn tl-radio">
      <span>
      <label>No</label>
      </span>
      </button>
    </p>
  </div>-->
  <p>
    <button class="btn-submit" style="margin-right:10px;" type="button" onclick="submitform();">Submit</button>
  </p>
</div>
</form>
<!-- end content -->
<?php
require_once("footer.php");
?>