{block name=sidebar}{sidebar}{/block}

{block name=content}
<div class="span9 smallprofile-contain">
	<div class="message"></div>
	<div class="music-upload-header">
		<span class="music-upload">Welcome {$smarty.session.firstname} {$smarty.session.lastname}</span>
	</div>
</div>
{/block}

{block name=scripts}
<script type="text/javascript">
	(function() {
		if ("{$message}") {
			var messageType = ('success' == '{$messageType}') ? 1 : 0;
			$(".message").html(displaymessage("{$message}", messageType));
		}
	})();
</script>
{/block}