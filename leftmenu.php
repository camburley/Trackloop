<?php
@session_start();
$firstname = $_SESSION['firstname'];
$lastname  = $_SESSION['lastname'];
?>
<div class="span3 sidebar">
  <div class="sidebar-title">
    <h1><?php echo $firstname." ".$lastname; ?></h1>
  </div>
  <ul class="menu">
  <?php
  $leftFilename = basename($_SERVER['PHP_SELF']);
  $here = trim($_SERVER['REQUEST_URI'], '/');
  
  $items = array(
	1 => array('artist/releases', 'menu-1.png', 'Releases'),
	2 => array('artist/buzz', 'menu-2.png', 'Buzz'),
	/*3 => array('artist/fans', 'menu-3.png', 'Fans'),*/
	4 => array('artist/account', 'menu-4.png', 'Account'),
	5 => array('artist/permissions', 'menu-5.png', 'Permissions'),
  );
  
  foreach ($items AS $sectionid => $sectionparams) {
	if (!empty($_SESSION['sectionid']) && !in_array($sectionid, $_SESSION['sectionid'])) {
		continue;
	}
	$active = ($sectionparams[0] == $here) ? 'active' : '';
	echo '<li class="'.$active.'"><a href="'.$sectionparams[0].'"> <img src="public/img/'.$sectionparams[1].'" alt="" />'.$sectionparams[2].'</a></li>';
  }
  ?>
  <li><a href="logout"> <img src="public/img/menu-5.png" alt="" />Logout</a></li>
  </ul>
</div>