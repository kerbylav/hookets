{include file='header.tpl'}
<h3>
{$sPageTitle}
</h3>
<br/>
{if $include_tpl}
    {include file="$include_tpl"}
{else}
<form action="{router page=hookets}add/" method="POST" id="fff"><input type="hidden"
	name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
<label for="himport">{$aLang.hookets_label_import}:</label> <br/>
<textarea name="himport" id="himport" rows="20" style="height: 150px;" class="w100p" ></textarea><br/>

<br/><input class="submit" type="submit" name="submit_import"	value="{$aLang.hookets_submit_import}"/>&nbsp; 
</form>
{/if}

{include file='footer.tpl'}

