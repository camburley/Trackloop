<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&v=3.exp"></script>
<script type="text/javascript">
function initialize()
{	
	var searchval	=	document.getElementById('searchval').value;
	if(searchval)
	{
		var service = new google.maps.places.AutocompleteService();
		service.getQueryPredictions({ input: searchval }, callback);
	}
}
function callback(predictions, status)
{
  if (status != google.maps.places.PlacesServiceStatus.OK) {
    
    return;
  }
  var input =	(document.getElementById('searchval'));
  var autocomplete = new google.maps.places.Autocomplete(input);

  /*var results = document.getElementById('results');

  for (var i = 0, prediction; prediction = predictions[i]; i++) {
    results.innerHTML += '<li>' + prediction.description + '</li>';
  }*/
};

google.maps.event.addDomListener(window, 'load', initialize);
function pausecomp(ms) {
ms += new Date().getTime();
while (new Date() < ms){}
} 
function ShowPageLinkFun1()
{
	//var location			=	document.getElementById('searchval').value
	$.post("accountaction.php", $("#accountform").serialize(),function(data){
		if(data=='update')
		{
			//$_SESSION['artistuniqueid']
			//$("#successmsg").addClass('alert');
			//$(".successmsg").css('width',"90%");
			$(".successmsg").html(displaymessage("Account data saved.",1));
		}
		else if(data =='signup')
		{
			//$("#successmsg").addClass('alert');
			$(".successmsg").html(displaymessage('Your account has been successfully.>Sign In</a> here.',1));
			//$("#successmsg").html('Your account has been successfully. If you are not redirected automatically, please <a href="index.php">Sign In</a> here.');
			//pausecomp(5000);
			window.location	=	'managealbum.php';
		}
		else
		{
			$(".successmsg").html(displaymessage(data,0));
		}
	});
}
</script>
<div class="contain" {if $artistuniqueid} style="margin-left:320px;"{/if}>
            <div class="row-fluid">
            <div class="span12">
                <div>
                    <h2>Let us know who you are</h2>
                </div>
                <form id="accountform">
                	<div class="successmsg"></div>
                    <fieldset class="one-column-layout">
                        <label>First Name</label>
                        <input class="input-xlarge" name="firstname" type="text" value="{$firstname}" placeholder="">
                        <label>Last Name</label>
                        <input class="input-xlarge" name="lastname" type="text" value="{$lastname}" placeholder="">
                        <label>E-mail</label>
                        <input class="input-xlarge"  type="email" name="username" value="{$username}" placeholder="" {if $username neq ''} readonly="readonly" disabled="disabled"{/if}>
                        <label>Password</label>
                        <input class="input-xlarge" type="password" name="password" value="{$password}" placeholder="">
                        <label>Location</label>
                        <input type="text" id="searchval" name="location" class="input-xlarge" value="{$location}"  onKeyDown="initialize();" size="50" >
    					<ul id="results"></ul>
                        <label>Mobile Number</label>
                        <input class="input-xlarge" type="text" name="mobile" value="{$mobile}" placeholder="">
                        <label>Twitter Handle</label>
                        <input class="input-xlarge" type="text" name="twitterid" value="{$twitterid}" placeholder="">

                        <input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="SAVE CHANGES" />
                         <br />
                        <div class="successmsg"></div>
                    </fieldset>
                </form>
            </div>
        </div>
        </div>
        <!--end contain -->

        
    <!-- End Desktop View -->

    <!-- Start Mobile View -->
    <div class="visible-phone account">
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
                <div>
                    <h2 class="text-center">Let us know who you are</h2>
                </div>
                <form>
                    <fieldset class="one-column-layout">
                        <label>Name</label>
                        <input class="input-xlarge" type="text" placeholder="">
                        <label>E-mail</label>
                        <input class="input-xlarge" type="email" placeholder="">
                        <label>Password</label>
                        <input class="input-xlarge" type="password" placeholder="">
                        <label>Location</label>
                        <select id="Select1">
                            <option></option>
                            <option value="AL">Alabama</option>
                            <option value="WY">Wyoming</option>
                            <option value="CA">CA</option>
                        </select>
                        <label>Mobile Number</label>
                        <input class="input-xlarge" type="text" placeholder="">
                        <label>Twitter Handle</label>
                        <input class="input-xlarge" type="text" placeholder="">

                        <input class="btn btn-large btn-block btn-info account-button" onclick="ShowPageLinkFun1()" type="button" value="SAVE CHANGES" />

                    </fieldset>
                </form>
            </div>
        </div>
        <!--end contain -->

        <footer class="mobile-footer">
            <p>Powered by Trackloop</p>
        </footer>
    </div>
<!-- End Mobile View --> 

<!-- JavaScript --> 
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script> 
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/custom_checkbox_and_radio.js"></script> 
<script type="text/javascript" src="js/select2.js"></script> 
<script>
        $(document).ready(function () {
            $("#e1").select2({ maximumSelectionSize: -1 });
        });

        $(document).ready(function () {
            $("#Select1").select2({ maximumSelectionSize: -1 });
        });
    </script>
</body></html>