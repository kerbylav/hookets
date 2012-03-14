{include file='header.tpl'}
<h3>
{$sPageTitle}
</h3>
<br/>
{if $include_tpl}
    {include file="$include_tpl"}
{else}
<div><pre>{$dv}</pre></div>
<form action="" method="POST" id="fff"><input type="hidden"
	name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> <pre>{$vd}</pre>

<div id="myDebugArea"></div>

<label for="hooket_name">{$aLang.hookets_label_name}:</label><br/>
<input type="text" id="hooket_name" name="hooket_name"	value="{$_aRequest.hooket_name}" class="w100p"/><br/><br/>
	
<input type="checkbox" name="hooket_active" value="1" {if $_aRequest.hooket_active=="1"}checked="checked"{/if} />{$aLang.hookets_label_active} {if $_aRequest.isConfigDisabled}{$aLang.hookets_configdisabled}{/if}<br/><br/>
			
<label for="hooket_description">{$aLang.hookets_label_desc}:</label> 
<textarea name="hooket_description" id="hooket_description" class="w100p"  style="height:100px;">{$_aRequest.hooket_description}</textarea><br /><br />
			
<label for="hooket_hook_name">{$aLang.hookets_label_hook_name}:</label> 
<input type="text" id="hooket_hook_name" name="hooket_hook_name"	value="{$_aRequest.hooket_hook_name}" class="w100p" /><br/><br/>
	
<label for="hooket_type">{$aLang.hookets_label_type}: </label><br/>
<input type="radio" name="hooket_type" value="text" {if $_aRequest.hooket_type=="text"}checked="checked"{/if}/>{$aLang.hookets_type_text}<br />
<input type="radio" name="hooket_type" value="code" {if $_aRequest.hooket_type=="code"}checked="checked"{/if}/>{$aLang.hookets_type_code}<br/>
<input type="radio" name="hooket_type" value="template" {if $_aRequest.hooket_type=="template"}checked="checked"{/if}/>{$aLang.hookets_type_template}<br/><br/>
			
<label for="hooket_text">{$aLang.hookets_label_text}:</label> 
<textarea name="hooket_text" id="hooket_text" rows="20" class="w100p" >{$_aRequest.hooket_text}</textarea><br /><br/>
			
<label for="hooket_priority">{$aLang.hookets_label_priority}:</label> 
<input type="text" id="hooket_priority" name="hooket_priority"	value="{$_aRequest.hooket_priority}" class="w100p" /><br/>
<br />
<p class="buttons"><input type="submit" name="submit_save"
	value="{$aLang.hookets_submit_save}"/>&nbsp; <input type="submit"
	name="submit_cancel" value="{$aLang.hookets_submit_cancel}"
	onclick="window.location='{router page='hookets'}'; return false;" />&nbsp;
</p>

{if $_aRequest.hexport}
<br/><br/><label for="hexport">{$aLang.hookets_label_export}:</label> <br/>
<textarea name="hexport" id="hexport" rows="20" style="height: 150px;" class="w100p"  readonly="readonly" >{$_aRequest.hexport}</textarea><br/>
{/if}			

<input type="hidden" name="hooket_id" value="{$_aRequest.hooket_id}" /></form>
{/if}

{include file='footer.tpl'}

