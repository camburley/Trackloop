<?php
@session_start();
//print_r($_SESSION);
$firstname	=	$_SESSION['firstname'];
$lastname	=	$_SESSION['lastname'];
?>
<div class="row-fluid">
<div class="span3 sidebar">
  <div class="sidebar-title">
    <h1><?php echo $firstname." ".$lastname; ?></h1>
  </div>
  <ul class="menu">
  <?php
  $leftFilename =     basename($_SERVER['PHP_SELF']);

  if($_SESSION['sectionid'])
  {
	  if(in_array(1,$_SESSION['sectionid']))
	  {
	  ?>
		<li <?php if($leftFilename=="managealbum.php"){  ?>class="active"<?php } ?> ><a href="managealbum.php"> <img src="images/menu-1.png" alt="" />releases</a></li>
	   
	   <?php
	  }
	  if(in_array(2,$_SESSION['sectionid']))
	  {
	  ?>
		<li <?php if($leftFilename=="buzz.php"){  ?>class="active"<?php } ?> ><a href="buzz.php"> <img src="images/menu-2.png" alt="" />Buzz</a></li>
         
	   <?php
	  }
	  
	  if(in_array(3,$_SESSION['sectionid']))
	  {
	  ?>
		<li <?php if($leftFilename=="fans.php"){  ?>class="active"<?php } ?> ><a href="#"> <img src="images/menu-3.png" alt="" />Fans </a></li>
		 <?php
	  }
	  
	  if(in_array(4,$_SESSION['sectionid']))
	  {
	  ?>
		<li <?php if($leftFilename=="account.php"){  ?>class="active"<?php } ?> ><a href="account.php"> <img src="images/menu-4.png" alt="" />Account</a></li>
         <?php
	  }
	 
	  if(in_array(5,$_SESSION['sectionid']))
	  {
	  ?>
		<li <?php if($leftFilename=="permission.php"){  ?>class="active"<?php } ?> ><a href="permission.php"> <img src="images/menu-5.png" alt="" />Permissions</a></li>
         <?php
	  }
	  ?>
		<li><a href="logout.php"> <img src="images/menu-5.png" alt="" />Logout</a></li>
  <?php
  }
  else
  {
   ?>
    <li <?php if($leftFilename=="managealbum.php"){  ?>class="active"<?php } ?> ><a href="managealbum.php"> <img src="images/menu-1.png" alt="" />Releases</a></li>
    <li <?php if($leftFilename=="buzz.php"){  ?>class="active"<?php } ?> ><a href="buzz.php"> <img src="images/menu-2.png" alt="" />Buzz</a></li>
    <li <?php if($leftFilename=="fans.php"){  ?>class="active"<?php } ?> ><a href="#"> <img src="images/menu-3.png" alt="" />Fans </a></li>
    <li <?php if($leftFilename=="account.php"){  ?>class="active"<?php } ?> ><a href="account.php"> <img src="images/menu-4.png" alt="" />Account</a></li>
    <li <?php if($leftFilename=="permission.php"){  ?>class="active"<?php } ?> ><a href="permission.php"> <img src="images/menu-5.png" alt="" />Permissions</a></li>
    <li><a href="logout.php"> <img src="images/menu-5.png" alt="" />Logout</a></li>
    <?php
  }
  ?>
  </ul>
</div>