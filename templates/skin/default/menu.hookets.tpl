<ul class="menu">
    <li {if $sMenuItemSelect=='hookets'}class="active"{/if}>
        <a href="{router page=hookets}">{$aLang.hookets_menu_hookets}</a>
	{if $sMenuItemSelect=='hookets'}
        <ul class="sub-menu" >
            <li {if $sMenuSubItemSelect=='list' || $sMenuSubItemSelect==''}class="active"{/if}><div><a href="{router page=hookets}list/">{$aLang.hookets_menu_hookets_list}</a></div></li>
	    <li {if $sMenuSubItemSelect=='new'}class="active"{/if}><div><a href="{router page=hookets}add/">{$aLang.hookets_menu_hookets_add}</a></div></li>
	    <li {if $sMenuSubItemSelect=='import'}class="active"{/if}><div><a href="{router page=hookets}import/">{$aLang.hookets_menu_hookets_import}</a></div></li>
	    {if $sMenuSubItemSelect=='edit'}<li class="active"><div><a href="#">{$aLang.hookets_menu_hookets_edit}</a></div></li>{/if}
        </ul>
	{/if}
    </li>
</ul>
