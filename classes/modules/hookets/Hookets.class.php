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

/**
 * Модуль роботостатистики
 *
 */
class PluginHookets_ModuleHookets extends Module {
	/**
	 * Меппер для сохранения логов в базу данных и формирования выборок по данным из базы
	 *
	 * @var Mapper_Profiler
	 */
	protected $oMapper;

	/**
	 * Инициализация модуля
	 */
	public function Init() {
		$this->oMapper=Engine::GetMapper(__CLASS__);
	}

	public function GetHookets()
	{
		return $this->oMapper->GetHookets();
	}

	public function GetHooketById($hooket_id)
	{
		return $this->oMapper->GetHooketById($hooket_id);
	}

	public function AddHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		return $this->oMapper->AddHooket($oHooket);
	}

	public function UpdateHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		return $this->oMapper->UpdateHooket($oHooket);
	}

	public function DeleteHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		return $this->oMapper->DeleteHooket($oHooket);
	}


	protected function SetHooketActivity(PluginHookets_ModuleHookets_EntityHooket $oHooket,$isActive)
	{
		$oHooket->setActive($isActive);
		return $this->UpdateHooket($oHooket);
	}

	protected function SetHooketActivityById($iId,$isActive)
	{
		$oHooket=$this->GetHooketById($iId);
		if ($oHooket)
		{
			return $this->SetHooketActivity($oHooket, $isActive);
		}
		else return false;
	}

	public function EnableHooketById($iId)
	{
		return $this->SetHooketActivityById($iId, true);
	}

	public function DisableHooketById($iId)
	{
		return $this->SetHooketActivityById($iId, false);
	}

	public function EnableHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		return $this->SetHooketActivity($oHooket, true);
	}

	public function DisableHooket(PluginHookets_ModuleHookets_EntityHooket $oHooket)
	{
		return $this->SetHooketActivity($oHooket, false);
	}

}
?>