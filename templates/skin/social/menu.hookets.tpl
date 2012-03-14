<ul class="switcher">
    <li {if $sMenuSubItemSelect=='list' || $sMenuSubItemSelect==''}class="active"{/if}><div><a href="{router page=hookets}list/">{$aLang.hookets_menu_hookets_list}</a></div></li>
    <li {if $sMenuSubItemSelect=='new'}class="active"{/if}><div><a href="{router page=hookets}add/">{$aLang.hookets_menu_hookets_add}</a></div></li>
    <li {if $sMenuSubItemSelect=='import'}class="active"{/if}><div><a href="{router page=hookets}import/">{$aLang.hookets_menu_hookets_import}</a></div></li>
    {if $sMenuSubItemSelect=='edit'}<li class="active" style="font-weight:bold"><div>{$aLang.hookets_menu_hookets_edit}</div></li>{/if}
</ul>

