<?php
/*
 * 
 * Project Name : Hookets plugin
 * Copyright (C) 2011 Alexei Lukin. All rights reserved.
 * GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * $Rev: 9 $
 * $Date: 2011-01-17 17:12:16 +0300 (Mon, 17 Jan 2011) $
 * $LastChangedDate: 2011-01-17 17:12:16 +0300 (Mon, 17 Jan 2011) $
 * 
 */

$config['table']['hookets']                = '___db.table.prefix___hookets';

// Включен ли вообще механизм хукетов
$config['enabled'] = true;

// Массив принудительно-выключенных хукетов
//$config['disabled'][711]=true;

Config::Set('router.page.hookets', 'PluginHookets_ActionHookets');
//Config::Set('router.page.testpage', 'PluginHookets_ActionFreebie');

return $config;
?>