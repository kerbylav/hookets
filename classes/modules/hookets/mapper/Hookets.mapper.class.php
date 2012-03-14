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

Class PluginHookets_ModuleHookets_MapperHookets extends Mapper {

	public function GetHookets()
	{
		$res=array();
		$sql = "SELECT * FROM ".Config::Get('plugin.hookets.table.hookets')." ORDER BY hooket_hook_name,hooket_priority desc";
		if ($aRows=$this->oDb->select($sql)) {
			foreach ($aRows as $row) {
				$res[]=Engine::GetEntity('PluginHookets_ModuleHookets_EntityHooket',$row);
			}

			return $res;
		}
		return null;
	}

	public function GetHooketById($hooket_id)
	{
		$sql = "SELECT * FROM ".Config::Get('plugin.hookets.table.hookets')." WHERE hooket_id=?";
		if ($aRow=$this->oDb->selectRow($sql,$hooket_id)) {
			return Engine::GetEntity('PluginHookets_ModuleHookets_EntityHooket',$aRow);
		}
		return false;
	}

	public function AddHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		$sql = "INSERT INTO ".Config::Get('plugin.hookets.table.hookets')."
			(
				hooket_description,
				hooket_active,
				hooket_name,
				hooket_hook_name,
				hooket_type,
				hooket_text,
				hooket_priority
			)
			VALUES(?,?,?,?,?,?,?d)
		";			
		if (($iId=$this->oDb->query($sql,
		$oHooket->getDescription(),
		$oHooket->getActive(),
		$oHooket->getName(),
		$oHooket->getHookName(),
		$oHooket->getType(),
		$oHooket->getText(),
		$oHooket->getPriority()
		)))
		{
			return $iId;
		}
		return false;
	}

	public function DeleteHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		$sql = "DELETE FROM ".Config::Get('plugin.hookets.table.hookets')."
			WHERE hooket_id=?d	
		";			
		if (($this->oDb->query($sql,
		$oHooket->getId()
		))!==false)
		{
			return true;
		}
		return false;
			}
	
	public function UpdateHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		$sql = "UPDATE ".Config::Get('plugin.hookets.table.hookets')."
			SET 
				hooket_description=?,
				hooket_active=?,
				hooket_name=?,
				hooket_hook_name=?,
				hooket_type=?,
				hooket_text=?,
				hooket_priority=?d
			WHERE hooket_id=?d	
		";			
		if (($this->oDb->query($sql,
		$oHooket->getDescription(),
		$oHooket->getActive(),
		$oHooket->getName(),
		$oHooket->getHookName(),
		$oHooket->getType(),
		$oHooket->getText(),
		$oHooket->getPriority(),
		$oHooket->getId()
		))!==false)
		{
			return true;
		}
		return false;
	}

}
?>