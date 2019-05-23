<script type="text/javascript">
	function submitform()
	{
		validateusername();		
		if(error)
		{
			alert('Please correct the errors notified infront of each field.');
			return;
		}
			validatepassword();
		if(error)
		{
			alert('Please correct the errors notified infront of each field.');
			return;
		}
		
		var chvalue	=	document.getElementsByClassName('tl-chk active');
		for(var i=0; i<chvalue.length; i++)
		{
			var check1	=	chvalue[i].value;
		}
		if(check1)
		{
			$.post("loginaction.php?check1="+check1, $("#frmadminuser").serialize(),function(data)
			{
				if(data)
				{
					window.location.href	=	"welcome.php";
				}
				else
				{
					$('#error').show();

					//alert("Username or password incorrect.");
				}
			})
		}
		else
		{
			$.post("loginaction.php", $("#frmadminuser").serialize(),function(data)
			{
				if(data)
				{
					window.location.href	=	"welcome.php";
				}
				else
				{
					$('#error').show();
					//alert("Username or password incorrect.");
				}
			})
		}	
	}
	
	function validateusername()
	{
		var uname	=	$('#username').val();
		if(uname=="")
		{
			displayerror('msg1','not provided.');
			return;
		}
		else
		{
			displaysuccess('msg1');
		}
	}
	function validatepassword()
	{
		var uname	=	$('#password').val();
		if(uname=="")
		{
			displayerror('msg2','not provided.');
			return;
		}
		else
		{
			displaysuccess('msg2');
		}
	}
</script>
<title>ADMIN SIGN IN</title>
<div id="error" class="login-error" style="display:none;"><span class="error-icon"><span class="error-icon"><img src="../img/cross-red.png" /></span><span class="error-msg">Nope. Wrong username / password combination. Get it together and resubmit. </span></div>
<div class="content-fm">
  <div class="fm-head"></div>
  <h2>TRACKLOOP.FM</h2>
  <div class="signintop"><span class="plus"></span><span class="txtsignin">Admin Sign In</span></div>

  	<form id="frmadminuser" name="frmadminuser" action="">	
  <div class="signin">
    <p style="margin:0; padding:0">
      <input type="text" class="fm-user" name="username" id="username" placeholder="Username" value="{$cusername}" onBlur="validateusername()" />
    </p>
    <p style="margin:0; padding:0;">
      <input type="password" name="password" id="password" class="fm-pw" placeholder="Password" value="{$cpassword}" onBlur="validatepassword()" />
    </p>
    <div class="btn-group" data-toggle="buttons-checkbox">
      <p style="margin-top:15px; height:60px; width:360px;">
      <button class="tl-chk" style="margin-top:20px;"  name="check1" type="button" id="check1" value="rem">
      
      </button>
      <span>
      <label style="padding-top:20px;">Remember Passsword</label>
      </span>
      <button style="float:right; margin-top:-35px;" class="btn-signin " type="button" onclick="submitform()"></button >
      </p>
    </div>
    </div>
    	</form>
  </div>
</div>
