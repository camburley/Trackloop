<script type="text/javascript">
function submitForm()
{
	if($("#code").val()=="")
	{
		alert("Promo code cannot be empty.");
		return;
	}
	$('#btnDone').hide();
	$('#promoform').submit();
	$('#btnDone').show();
}
</script>
















<title>Manage Promo</title>
<form name='promoform' id="promoform" action="updatepromo.php" method="post">
  <input type="hidden" name="promoid" id="promoid" value="{$pkpromoid}"/>
  {if $promoid}
  <h1 class="title">Edit Promo</h1>
  {else}
  <h1 class="title">Add New Promo</h1>
  {/if}
  <div class="content-admin clearfix"> <span class="new-admin" style="width:20%; margin-right:45px;">
    <label class="lbluser"> Code :</label>
    <input class="user"  type="text" name="code" placeholder="Code" id="code" value="{$promocode}"/>
    </span> <span class="new-admin new-admin-s" style="width:20%;margin-right:45px;"">
    <label class="lbluser"> Staff Memeber :</label>
    

    <select name="username" id="username" style="display: none;" class="selectpicker">
      
            {section name=outer loop=$pkadminuserid}
            
      <option value="{$pkadminuserid[outer]}" {if $pkadminuserid[outer]==$fkadminuserid} selected="selected"{/if}>{$username[outer]}</option>
      
            {/section}
         
    </select>
    

    
    						
    
    
    
    
    
    
    
    
    
    
    </span> <span class="new-admin new-admin-s" style="width:20%;margin-right:45px;">
    <label class="lbluser"> Discount :</label>
    
    

    <select name="discount" id="discount" style="display: none;" class="selectpicker">
      
          {for $i=1 to 100}
			 
      <option value="{$i}" {if $i==$discount} selected="selected" {/if}>{$i}%</option>
      
          {/for}
          
    </select>
    
    
 
    
    
    					

    
    
    
    
    
    
    
    
    </span> <span class="new-admin new-admin-s" style="width:20%;">
    <label class="lbluser"> Apply to :</label>
    
    
    
    <select name="promotype" id="promotype" style="display: none;" class="selectpicker">
      
            {section name=outer loop=$pkpromotypeid}
            
      <option value="{$pkpromotypeid[outer]}" {if $pkpromotypeid[outer]==$fkpromotypeid} selected="selected"{/if}>{$promotypes[outer]}</option>
      
            {/section}
     	
    </select>
    

    
    
    
    
    
    
    </span>
    <p style="margin-top:15px; margin-right:18px; float:right;">
      <button style="float:left; margin-top:30px; margin-left:3px;" class="btn-submit" name="btnDone" id="btnDone" type="button" onclick="submitForm()">Submit</button>
    </p>
  </div>
</form>