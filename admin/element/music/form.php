<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="200" height="24">
	<param name="movie" value="<?=__racine__?>/tpl/images/player-viral.swf" />
	<param name="allowfullscreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<param name="flashvars" value="file=<?=value_print($myvalue)?>" />
	<embed
		type="application/x-shockwave-flash"
		id="player2"
		name="player2"
		src="<?=__racine__?>/tpl/images/player-viral.swf" 
		width="200" 
		height="24"
		allowscriptaccess="always" 
		allowfullscreen="true"
		flashvars="file=<?=value_print($myvalue)?>" 
	/>
</object>