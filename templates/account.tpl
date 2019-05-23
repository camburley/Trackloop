{block name=sidebar} 
	{if !empty($smarty.session.role)}
		{sidebar}
	{/if}
{/block}

{block name=content}


<div class="span9 smallprofile-contain trackloop-content">
	<div>
		<h2>Let us know who you are</h2>
	</div>
	<form id="accountform">
		<div class="successmsg"></div>
		<fieldset class="one-column-layout">
			<label>First Name</label>
			<input class="input-xlarge" name="firstname" type="text" value="{$artist->firstname}" placeholder="">
			<label>Last Name</label>
			<input class="input-xlarge" name="lastname" type="text" value="{$artist->lastname}" placeholder="">
			<label>E-mail</label>
			<input class="input-xlarge"  type="email" name="username" value="{$artist->username}" placeholder="" {if $username neq ''} readonly="readonly" disabled="disabled"{/if}>
			<label>Password</label>
			<input class="input-xlarge" type="password" name="password" value="{$artist->password}" placeholder="">
			<label>Location</label>
			<input type="text" id="searchval" name="location" class="input-xlarge" value="{$artist->location}"  onKeyDown="initialize();" size="50" >
			<ul id="results"></ul>
			<label>Mobile Number</label>
			<input class="input-xlarge" type="text" name="mobile" value="{$artist->mobile}" placeholder="">
			<label>Twitter Handle</label>
			<input class="input-xlarge" type="text" name="twitterid" value="{$artist->twitterid}" placeholder="">

			<input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="SAVE CHANGES" />
			 <br />
			<div class="successmsg"></div>
		</fieldset>
	</form>
</div>
{/block}

{block name=mobileViewContainer}
<div>
    <h2 class="text-center">Let us know who you are</h2>
</div>
<form>
    <fieldset class="one-column-layout">
		<label>First Name</label>
		<input class="input-xlarge" name="firstname" type="text" value="{$artist->firstname}" placeholder="">
		<label>Last Name</label>
		<input class="input-xlarge" name="lastname" type="text" value="{$artist->lastname}" placeholder="">
		<label>E-mail</label>
		<input class="input-xlarge"  type="email" name="username" value="{$artist->username}" placeholder="" {if $username neq ''} readonly="readonly" disabled="disabled"{/if}>
		<label>Password</label>
		<input class="input-xlarge" type="password" name="password" value="{$artist->password}" placeholder="">
		<label>Location</label>
		<input type="text" id="mobsearchval" name="location" class="input-xlarge" value="{$artist->location}"  onKeyDown="mobinitialize();" size="50" >
		<ul id="results"></ul>
		<label>Mobile Number</label>
		<input class="input-xlarge" type="text" name="mobile" value="{$artist->mobile}" placeholder="">
		<label>Twitter Handle</label>
		<input class="input-xlarge" type="text" name="twitterid" value="{$artist->twitterid}" placeholder="">
        <input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="SAVE CHANGES" />

    </fieldset>
</form>
{/block}

{block name=scripts}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&v=3.exp"></script>
<script type="text/javascript">
function initialize() {
	var searchval	=	document.getElementById('searchval').value;
	if(searchval)
	{
		var service = new google.maps.places.AutocompleteService();
		service.getQueryPredictions({ input: searchval }, callback);
	}
}

function callback(predictions, status) {
  if (status != google.maps.places.PlacesServiceStatus.OK) {
    
    return;
  }
  var input =	(document.getElementById('searchval'));
  var autocomplete = new google.maps.places.Autocomplete(input);
};

google.maps.event.addDomListener(window, 'load', initialize);

//For mobile view
function mobinitialize() {
	var searchval	=	document.getElementById('mobsearchval').value;
	if(searchval)
	{
		var service = new google.maps.places.AutocompleteService();
		service.getQueryPredictions({ input: searchval }, mobcallback);
	}
}

function mobcallback(predictions, status) {
  if (status != google.maps.places.PlacesServiceStatus.OK) {
    
    return;
  }
  var input =	(document.getElementById('mobsearchval'));
  var autocomplete = new google.maps.places.Autocomplete(input);
};

google.maps.event.addDomListener(window, 'load', mobinitialize);

function pausecomp(ms) {
	ms += new Date().getTime();
	while (new Date() < ms){}
}
 
function ShowPageLinkFun1() {
	//var location			=	document.getElementById('searchval').value
	$.post("artist/account", $("#accountform").serialize(),function(data){
		if (data == 'update') {
			$(".successmsg").html(displaymessage("Account data saved.", 1));
		}
		else if (data == 'signup') {
			$(".successmsg").html(displaymessage('Your account has been successfully created.', 1));
			window.location	= 'artist/releases';
		} else {
			$(".successmsg").html(displaymessage(data, 0));
		}
	});
}
</script>
{/block}