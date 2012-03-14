{include file='header.tpl'}
<h3>{$aLang.hookets_list_title}</h3>
<br/>
{if $bEnabled}
<div class="hookets">
{if $aEasyHooks}
	<table class="table">
		<thead>
			<tr>
				<td style="width: 80px">{$aLang.hookets_actions}</td>	
				<td>ID</td>	
				<td>{$aLang.hookets_name}</td>	
				<td>{$aLang.hookets_description}</td>	
				<td>{$aLang.hookets_type}</td>	
				<td>{$aLang.hookets_hook_name}</td>	
				<td>{$aLang.hookets_priority}</td>	
			</tr>
		</thead>
		
		<tbody>
		{foreach from=$aEasyHooks item=oHooket}
		<tr>
				<td><ul class="action">
				<li class="edit"><a href="{router page='hookets'}edit/{$oHooket->getId()}" title="{$aLang.hookets_a_edit}"></a></li>
				<li class="delete"><a title="{$aLang.hookets_a_delete}" href="{router page='hookets'}delete/{$oHooket->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" onclick="return confirm('{$aLang.hookets_delete_confirm}');"></a></li>
				{if $oHooket->isDisabled()}
				<li class="enable"><a title="{$aLang.hookets_a_enable}" href="{router page='hookets'}enable/{$oHooket->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}">
				{else}
				<li class="disable"><a title="{$aLang.hookets_a_disable}" href="{router page='hookets'}disable/{$oHooket->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}">
				{/if}
				</a></li>
				</ul></td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{$oHooket->getId()}</td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{$oHooket->getName()|escape:html}</td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{if $oHooket->isConfigDisabled()}{$aLang.hookets_configdisabled}<br/>{/if}{$oHooket->getDescription()|escape:html}</td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{$oHooket->getType()}</td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{$oHooket->getHookName()|escape:html}</td>														
				<td {if $oHooket->isDisabled()}class="strike"{/if}>{$oHooket->getPriority()}</td>														
			</tr>
		{/foreach}						
		</tbody>
	</table>
{else}
	{$aLang.hookets_no_hooks}
{/if}
</div>
{else}
{$aLang.hookets_disabled}
{/if}
{include file='footer.tpl'}