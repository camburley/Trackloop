{block name=sidebar}{sidebar}{/block}
{block name=content}
<div class="span9 permission trackloop-content">
	<div>
    	<h2>Give access to another person</h2>
  	</div>
  
  	<form name="frmpermission" id="frmpermission">
    	<fieldset class="one-column-layout">
		  	<label class="checkbox checked" id="1"  onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
		    	<input type="checkbox" checked>
		    	Releases
		  	</label>
		  
		  	<label class="checkbox checked" id="2"  onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
		    	<input type="checkbox" checked>
		    	Buzz
		  	</label>
		  
		  	<label class="checkbox checked" id="3"  onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
		    	<input type="checkbox" checked>
		    	Fans
		  	</label>
		  	
		  	<label class="checkbox checked" id="4"  onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
		    	<input type="checkbox" checked>
		    	Account
		  	</label>
		  
		  	<label class="checkbox checked" id="5"  onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
		    	<input type="checkbox" checked>
		    	Permissions
		  	</label>
  	
      		<label>E-mail</label>
      		<input class="input-xlarge" type="email" placeholder="" name="username" value="{$ememberusername}" >
      		
      		<label>Password</label>
      		<input class="input-xlarge" type="password" placeholder="" name="password" value="{$ememberpassword}" >
      
      		<input class="btn btn-large btn-block btn-info account-button" onclick="savePermissions(this.form);" type="button" value="GIVE USER ACCESS" />
      		<br />
      		<div id="msg1" style="color:#F00"></div>
    	</fieldset>
  	</form>
</div>
{/block}

{block name=mobileViewContainer}
<div class="permission">
<div class="checkbox-title">
	<h2>Give access to another person</h2>
</div>
  
<form name="frmpermission" id="frmpermission">
	<fieldset class="one-column-layout">
		<label class="checkbox checked" id="1" onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
			<input type="checkbox">
			Releases
		</label>
		  
		<label class="checkbox checked" id="2" onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
			<input type="checkbox" checked>
			Buzz
		</label>
		  
		<label class="checkbox checked" id="3" onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
			<input type="checkbox" checked>
			Fans
		</label>
		
		<label class="checkbox checked" id="4" onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
			<input type="checkbox" checked>
			Account
		</label>
		  
		<label class="checkbox checked" id="5" onclick="setupLabel();">
		  		<span class='icon'></span><span class='icon-to-fade'></span>
			<input type="checkbox" checked>
			Permissions
		</label>

  		<label>E-mail</label>
  		<input class="input-xlarge" type="email" placeholder="" name="username" value="{$ememberusername}" >
  		
  		<label>Password</label>
  		<input class="input-xlarge" type="password" placeholder="" name="password" value="{$ememberpassword}" >
  
  		<input class="btn btn-large btn-block btn-info account-button" onclick="savePermissions(this.form);" type="button" value="GIVE USER ACCESS" />
  		<br />
  		<div id="msg1" style="color:#F00"></div>
	</fieldset>
</form>
</div>
{/block}

{block name=scripts}
<script type="text/javascript" src="public/js/custom_checkbox_and_radio.js"></script>
<script type="text/x-javascript">
function deletemember(e,memberid) {
	if(confirm("Are you sure to delete?")) {
		$.post("deletepermissionaction.php?pkmemberid="+memberid, function(data) {
			if(data) {
				$("#msg1").html(data);
			} else {
				window.location.href	=	"permission.php";
			}
		});
		return;
	}
}

function savePermissions(parent) {
	var selectedsections = new Array();
	var chvalue	= $(parent).find('.checked');
	for(var i=0; i<chvalue.length; i++) {
		selectedsections[i]	= chvalue[i].id;
	}
	//console.log(selectedsections); return;
	$.post("artist/permissions?artistuniqueid={$artistuniqueid}&pkmemberid={$epkmemberid}&selectedsections="+selectedsections, $(parent).serialize(),function(data){
		if(data) {
			$("#msg1").html(displaymessage(data,0));
		} else {
			$("#msg1").html(displaymessage('Permissions granted to new user successfully.',1));
		}
	})
}
</script>
{/block}