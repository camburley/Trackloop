<?php
@session_start();
require_once("../config.php");
require_once($path."/securityartist.php");
require_once($path."/artist/include.php");
$apicaller->filterRequest();
extract($_POST);
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
/*************************edit***********/
$memberid	=	$_GET['pkmemberid'];

if($_GET['pkmemberid'])
{
	$req		=	array(
							'controller' =>	'Permission',
							'action'	=>	'readememberpermission',
							'memberid' 	=>	$memberid
							);
	$ememberpermissions = $apicaller->sendRequest($req);
	//$apicaller->dump($ememberpermissions);
	foreach($ememberpermissions as $ememberpermission)
	{
		echo $epkmemberid		=	$ememberpermission->pkmemberid;
		$ememberusername	=	$ememberpermission->username;
		$ememberpassword	=	$ememberpermission->password;
		$esectionid		=	explode(",",$ememberpermission->sectionid);
		//print_r($esectionid);
	}
}
/****************************************/
/********************permissions***********************/

$req		=	array(
						'controller' 		=>	'Permission',
						'action'			=>	'readmemberpermission',
						'artistuniqueid' 	=>	$artistuniqueid
						);
$memberpermissions = $apicaller->sendRequest($req);

//$apicaller->dump($memberpermissions);
//$apicaller->dump($artists);
/*foreach($memberpermissions as $memberpermission)
{
	$pkmemebrid		=	$memberpermission->pkmemebrid;
	$memberusername	=	$memberpermission->memberusername;
	$memberpassword	=	$memberpermission->memberpassword;
}*/
?>
<link href="css/flat.css" type="text/css" />
<script type="text/x-javascript">
function deletemember(e,memberid)
{
	if(confirm("Are you sure to delete?"))
	{ 
		$.post("deletepermissionaction.php?pkmemberid="+memberid, function(data){
		if(data)
		{
			$("#msg1").html(data);
		}
		else
		{
			window.location.href	=	"permission.php";
		}
		});
		return;
	}
}
function ShowPageLinkFun1()
{
	var selectedsections = new Array();
	var chvalue	=	document.getElementsByClassName('checkbox checked');
	for(var i=0; i<chvalue.length; i++)
	{
		selectedsections[i]	=	chvalue[i].id;
	}
	$.post("permissionaction.php?artistuniqueid=<?php echo $artistuniqueid; ?>&pkmemberid=<?php echo  $epkmemberid; ?>&selectedsections="+selectedsections, $("#frmpermission").serialize(),function(data){
	if(data)
	{
		//$("#msg1").html(data);
		$("#msg1").html(displaymessage(data,0));
	}
	else
	{
		$("#msg1").html(displaymessage('Permissions granted to new user successfully.',1));
		//window.location.href	=	"permission.php";
	}
	})
}
</script>

<div class="span9 permission">
  <div>
    <h2>Give access to another person</h2>
  </div>
  <?php
		if(@in_array(1,$esectionid))
		{
			
  ?>
  <label class="checkbox checked" id="1" >
    <input type="checkbox"  >
    Releases </label>
    <?php
		}
		else
		{
		?>
        <label class="checkbox" id="1" >
    <input type="checkbox"  >
    Releases </label>
        <?php
		}
		if(@in_array(2,$esectionid))
		{
			
		?>
  <label class="checkbox checked" id="2">
    <input type="checkbox" >
    Buzz </label>
    <?php
		}
		else
		{
		?>
        <label class="checkbox" id="2" >
    <input type="checkbox"  >
    Buzz </label>
    <?php
		}
		if(@in_array(3,$esectionid))
		{
		?>
  <label class="checkbox checked" id="3">
    <input type="checkbox" >
    Fans </label>
    <?php
		}
		else
		{
		?>
        <label class="checkbox" id="3" >
    <input type="checkbox"  >
    Fans </label>
       
    <?php
		}
		if(@in_array(4,$esectionid))
		{
		?>
  <label class="checkbox checked" id="4">
    <input type="checkbox" >
    Account </label>
    <?php
		}
		else
		{
		?>
        <label class="checkbox" id="4" >
    <input type="checkbox"  >
    Account </label>
        
    <?php
		}
		if(@in_array(5,$esectionid))
		{
		?>
  <label class="checkbox checked" id="5">
    <input type="checkbox" >
    Permissions </label>
    <?php
		}
		else
		{
		?>
        <label class="checkbox" id="5" >
    <input type="checkbox"  >
    Permissions </label>
        
    <?php
		}
	?>
  <form name="frmpermission" id="frmpermission">
    <fieldset class="one-column-layout">
      <label>E-mail</label>
      <input class="input-xlarge" type="email" placeholder="" name="username" value="<?php echo $ememberusername; ?>" >
      <label>Password</label>
      <input class="input-xlarge" type="password" placeholder="" name="password" value="<?php echo $ememberpassword; ?>" >
      <input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="GIVE USER ACCESS" />
      <br />
      <div id="msg1" style="color:#F00"></div>
    </fieldset>
  </form>
</div>
<?php /*?><div class="span12">
  <table class="otherpice" style="width:48%; margin-left:289px;">
    <tr>
      <th>Username</th>
      <th>Password</th>
      <th>Action</th>
    </tr>
    <?php
	if($memberpermissions)
	{
	foreach($memberpermissions as $memberpermission)
	{
	?>
    <tr>
     
      <td><?php echo $memberpermission->memberusername; ?></td>
      <td><?php echo $memberpermission->memberpassword; ?></td>
       <td><a href="permission.php?pkmemberid=<?php echo $memberpermission->pkmemberid; ?>" >EDIT</a>/<a href="javascript:;" onClick="deletemember(this,<?php echo $memberpermission->pkmemberid; ?>); return false" >DELETE</a></td>
    </tr>
    <?php
	}
	}
    ?>
  </table>
</div><?php */?>
</div>
</div>

<!-- End Desktop View --> 

<?php /*?><!-- Start mobile View -->
<div class="permission visible-phone">
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
  
  <!--contain -->
  <div class="row-fluid">
    <div class="span9">
      <div class="checkbox-title">
        <h2>Give access to another person</h2>
      </div>
      <label class="checkbox">
        <input type="checkbox" value="">
        Profile </label>
      <label class="checkbox">
        <input type="checkbox" value="">
        Buzz </label>
      <label class="checkbox">
        <input type="checkbox" value="">
        Fans </label>
      <label class="checkbox">
        <input type="checkbox" value="">
        Account </label>
      <label class="checkbox">
        <input type="checkbox" value="">
        Permissions </label>
      <form>
        <fieldset class="one-column-layout">
          <label>Name</label>
          <input class="input-xlarge" type="text" placeholder="">
          <label>E-mail</label>
          <input class="input-xlarge" type="email" placeholder="">
          <div class="pagelink-button"> <img src="images/tauch-hand.png" alt="" />
            <input class="submit-tweet btn btn-large btn-block btn-info btn-large" type="button" value="GIVE USER ACCESS" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  
  <!--end contain -->
  
  <footer class="mobile-footer">
    <p>Powered by Trackloop</p>
  </footer>
</div><?php */?>
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script> 
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/custom_checkbox_and_radio.js"></script> <!-- End Mobile View -->
<?php
require_once($path."/artist/footer.php");
?>