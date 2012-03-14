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

class PluginHookets_ActionFreebie extends ActionPlugin {
	/**
	 * Текущий юзер
	 *
	 * @var ModuleUser_EntityUser
	 */
	protected $oUserCurrent=null;

	/**
	 * Инициализация
	 *
	 * @var bool
	 */
	protected $bIsAdmin=false;

	/**
	 * Инициализация
	 *
	 * @return null
	 */
	public function Init() {
		/**
		 * Проверяем авторизован ли юзер
		 */
		if ($this->User_IsAuthorization()) {
			$this->oUserCurrent=$this->User_GetUserCurrent();
			$this->bIsAdmin=$this->oUserCurrent->isAdministrator();
		}

		$this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('hookets').'css/style_freebie.css');
	}

	protected function RegisterEvent() {
		$this->AddEventPreg('/(.*)+/i','EventRouter');
	}

	public function EventRouter() {
		$this->Viewer_Assign('sRouterTemplatePath',Plugin::GetTemplatePath('hookets').'actions/ActionFreebie/');
		
		$ac=Router::GetAction();
		$ev=Router::GetActionEvent();
		$this->sMenuHeadItemSelect=$ac;
		$this->sMenuItemSelect=$ac;
		$this->sMenuSubItemSelect=$ev;
		if (trim($ev)=="") $ev="_";
		$template=Plugin::GetTemplatePath("hookets")."actions/ActionFreebie/$ac/$ev.tpl";
		if (!file_exists($template)) return Router::Action('error','404');
		
		$this->SetTemplate($template);
	}

	public function EventShutdown() {
		$this->Viewer_Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
		$this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
		$this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
		$this->Viewer_Assign('bIsAdmin', $this->bIsAdmin);
		$this->Viewer_Assign('oUserCurrent', $this->oUserCurrent);
		$this->Viewer_Assign('sTemplatePath', Plugin::GetTemplatePath('hookets'));
	}
}



?>