<script type="text/javascript" src="{$domain}/artist/js/jquery-1.7.1.min.js"></script>
<div class="contain">
  <h1>Grow Your Fan Base</h1>
  <p>The easiest way to spread your music</p>
  <button onclick="window.location='account.php'">
  <a href="#">TRY IT NOW </a>
  </button>
  <div class="browser-preview"> <img src="images/browser-preview.png" alt="" /> </div>
</div>
<div class="clouds"> <img src="images/clouds.png" alt="" /> </div>
</div>
<form name="frmlogin" id="frmlogin">
  <fieldset class="one-column-layout" style="margin-left:300px;">
    <label>E-mail</label>
    <input class="input-xlarge" type="email" placeholder="" name="username">
    <label>Password</label>
    <input class="input-xlarge" type="password" placeholder="" name="password">
    <input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="Login" />
    <br />
	<div id="msg1"></div>
  </fieldset>
</form>
<script type="text/javascript">
function ShowPageLinkFun1()
{
	//alert('Hi');
	$.post("loginaction.php", $("#frmlogin").serialize(),function(data){
		if(data)
		{
			$("#msg1").html(displaymessage(data,0));
		}
		else
		{
			window.location.href	=	"loggedin.php";
		}
	})
}
</script>