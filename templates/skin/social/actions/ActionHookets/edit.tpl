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

<label for="hooket_name">{$aLang.hookets_label_name}:</label> 
<input type="text" id="hooket_name" name="hooket_name"	value="{$_aRequest.hooket_name}" class="input-wide" /><br/>
	
<br/><label for=""><input type="checkbox" name="hooket_active" value="1" class="checkbox" {if $_aRequest.hooket_active=="1"}checked="checked"{/if} />{$aLang.hookets_label_active} {if $_aRequest.isConfigDisabled}{$aLang.hookets_configdisabled}{/if}</label><br/>
			
<br/><label for="hooket_description">{$aLang.hookets_label_desc}:</label> <br/>
<textarea name="hooket_description" id="hooket_description" class="input-wide"  style="height:80px;">{$_aRequest.hooket_description}</textarea><br />
			
<br/><label for="hooket_hook_name">{$aLang.hookets_label_hook_name}:</label> <br/>
<input type="text" id="hooket_hook_name" name="hooket_hook_name" value="{$_aRequest.hooket_hook_name}" class="input-wide" /><br/>
	
<br/><label for="hooket_type">{$aLang.hookets_label_type}: </label><br/>
<label for=""><input class="checkbox" type="radio" name="hooket_type" value="text" {if $_aRequest.hooket_type=="text"}checked="checked"{/if}/>{$aLang.hookets_type_text}</label><br/>
<label for=""><input class="checkbox" type="radio" name="hooket_type" value="code" {if $_aRequest.hooket_type=="code"}checked="checked"{/if}/>{$aLang.hookets_type_code}</label><br/>
<label for=""><input class="checkbox" type="radio" name="hooket_type" value="template" {if $_aRequest.hooket_type=="template"}checked="checked"{/if}/>{$aLang.hookets_type_template}</label><br/>
			
<br/><label for="hooket_text">{$aLang.hookets_label_text}:</label> <br/>
<textarea name="hooket_text" id="hooket_text" rows="20" style="height: 150px;" class="input-wide" >{$_aRequest.hooket_text}</textarea><br/>
			
<br/><label for="hooket_priority">{$aLang.hookets_label_priority}:</label> <br/>
<input type="text" id="hooket_priority" name="hooket_priority"	value="{$_aRequest.hooket_priority}" class="input-wide" /><br/>
<br />
<input class="submit" type="submit" name="submit_save"	value="{$aLang.hookets_submit_save}"/>&nbsp; 
<input class="submit" type="submit" name="submit_cancel" value="{$aLang.hookets_submit_cancel}" onclick="window.location='{router page='hookets'}'; return false;" />&nbsp;

{if $_aRequest.hexport}
<br/><br/><label for="hexport">{$aLang.hookets_label_export}:</label> <br/>
<textarea readonly="readonly" name="hexport" id="hexport" rows="20" style="height: 150px;" class="input-wide" >{$_aRequest.hexport}</textarea><br/>
{/if}			

<input type="hidden" name="hooket_id" value="{$_aRequest.hooket_id}" /></form>
{/if}

{include file='footer.tpl'}

