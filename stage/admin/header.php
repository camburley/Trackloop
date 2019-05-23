<div class="tl-container">
  <div class="top-nav"> <a class="settings" href="#"><img src="../img/settings.png" /></a>
<?php
if($currentFile!="index.php")
{
$query4	=	"SELECT sectionname FROM tblsection WHERE pksectionid = '$currentsection'" ;	
$selectsections	=	$db->query($query4);
foreach($selectsections as $selectsection)
{
	?>
    <div class="dropdown" style="float:right; margin-top:20px; margin-right:30px;"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php if($selectsection['sectionname']) { echo $selectsection['sectionname']; } else { echo "Welcome"; } ?></a>
<?php
}
?>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
<?php
$query4	=	"SELECT * FROM tblsection,tbladminusersection WHERE pksectionid = fksectionid AND fkadminuserid = '$admin' GROUP BY sectionname" ;	
$resultsections	=	$db->query($query4);
foreach($resultsections as $resultsection)
{
?>
    <li class="<?php echo $resultsection['classname'];  ?>"><a href="<?php echo $resultsection['sectionurl']; ?>"><?php echo $resultsection['sectionname']; ?></a></li>
<?php
}
?>
<li class="li-subscriber"><a href="logout.php">Logout</a></li>

      </ul>
      <?php
}
?>
    </div>
  </div>
  <!-- end top-nav -->