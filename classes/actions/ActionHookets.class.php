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

class PluginHookets_ActionHookets extends ActionPlugin {
	/**
	 * Текущий юзер
	 *
	 * @var ModuleUser_EntityUser
	 */
	protected $oUserCurrent=null;

	/**
	 *
	 * Массив блоков.
	 *
	 * @var unknown_type
	 */
	protected $aBlocks=array();

	/**
	 * Инициализация
	 *
	 * @return null
	 */
	public function Init() {
		$this->sMenuHeadItemSelect='hookets';
		$this->sMenuItemSelect='hookets';
		$this->sMenuSubItemSelect='list';

		/**
		 * Проверяем авторизован ли юзер
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'));
			return Router::Action('error');
		}
		/**
		 * Получаем текущего юзера
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
		/**
		 * Проверяем является ли юзер администратором
		 */
		if (!$this->oUserCurrent->isAdministrator()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'));
			return Router::Action('error');
		}

		$this->Viewer_AddHtmlTitle($this->Lang_Get('hookets_title'));
		$this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('hookets').'css/style.css');
		$this->aBlocks['right'][] = Plugin::GetTemplatePath('hookets').'block.info.tpl';

		$this->SetDefaultEvent('list');
	}

	protected function RegisterEvent() {
		$this->AddEvent('list','EventList');
		$this->AddEvent('edit','EventNewEdit');
		$this->AddEvent('add','EventNewEdit');
		$this->AddEvent('import','EventImport');
		$this->AddEvent('delete','EventDelete');
		$this->AddEvent('enable','EventEnable');
		$this->AddEvent('disable','EventDisable');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	public function Message($type, $msg, $cmd=null,$bUseSession=false) {
		if (Config::Get('plugin.avalogs.admin_enable') && $this->oLogs) {
			$this->aLogsMsg[]=' * type=>'.$type.', cmd=>'.$cmd.', msg=>'.$msg;
		}
		if ($type=='error') {
			$this->Message_AddError($msg, null, $bUseSession);
		} else {
			$this->Message_AddNotice($msg, null, $bUseSession);
		}
		return $msg;
	}

	protected function MessageError($msg, $cmd=null,$bUseSession=false) {
		return $this->Message('error', $msg, $cmd, $bUseSession);
	}

	protected function MessageNotice($msg, $cmd=null,$bUseSession=false) {
		return $this->Message('notice', $msg, $cmd, $bUseSession);
	}

	/**
	 * Получение REQUEST-переменной с проверкой "ключа секретности"
	 *
	 * @param <type> $sName
	 * @param <type> $default
	 * @param <type> $sType
	 * @return <type>
	 */
	protected function GetRequestCheck($sName, $default=null, $sType=null) {
		$result = getRequest($sName, $default, $sType);

		if (!is_null($result)) $this->Security_ValidateSendForm();

		return $result;
	}

	protected function EventList() {
		$this->Viewer_AddHtmlTitle($this->Lang_Get('hookets_list_title'));
		$aEasyHooks=$this->PluginHookets_Hookets_GetHookets();
		$this->Viewer_Assign('aEasyHooks',$aEasyHooks);
	}

	protected function EventEditCheckFields() {
		$bOk=true;

		if (!func_check(getRequest('hooket_name'),'text',2,200)) {
			$this->MessageError($this->Lang_Get('hookets_create_name_check'), $this->Lang_Get('error'));
			$bOk=false;
		}
		if (!func_check(getRequest('hooket_hook_name'),'text',2,200)) {
			$this->MessageError($this->Lang_Get('hookets_create_hook_name_check'), $this->Lang_Get('error'));
			$bOk=false;
		}
		if (!func_check(getRequest('hooket_description'),'text',10,1000)) {
			$this->MessageError($this->Lang_Get('hookets_create_desc_check'), $this->Lang_Get('error'));
			$bOk=false;
		}
		if (!is_numeric(trim(getRequest('hooket_priority')))) {
			$this->MessageError($this->Lang_Get('hookets_create_priority_check'), $this->Lang_Get('error'));
			$bOk=false;
		}

		return $bOk;
	}

	protected function EventNewEdit() {
		$param=$this->GetParam(0);
		$is_creation=!((getRequest('hooket_id')) || (!empty($param)));

		if ($is_creation)
		{
			$this->sMenuSubItemSelect='new';
		}
		else
		{
			$this->sMenuSubItemSelect='edit';
		}

		if ($this->getRequestCheck('submit_save')) {
			// * Проверяем корректность полей
			if ($this->EventEditCheckFields())
			{
				if ($is_creation)
				{
					$oHooket = Engine::GetEntity('PluginHookets_ModuleHookets_EntityHooket');

					$oHooket->setDescription(htmlspecialchars(getRequest('hooket_description')));
					$oHooket->setActive(getRequest('hooket_active'));
					$oHooket->setName(htmlspecialchars(getRequest('hooket_name')));
					$oHooket->setHookName(htmlspecialchars(getRequest('hooket_hook_name')));
					$oHooket->setType(getRequest('hooket_type'));
					$oHooket->setText(getRequest('hooket_text'));
					$oHooket->setPriority(getRequest('hooket_priority'));

					// * Добавляем проект
					if (!($a=$this->PluginHookets_ModuleHookets_AddHooket($oHooket)))
					{
						$this->Message_AddError($this->Lang_Get('hookets_add_error'),$this->Lang_Get('error'),true);
					}
					else
					{
						$this->MessageNotice($this->Lang_Get('hookets_add_success'), "", true);
					}
					Router::Location('/'.Router::GetAction('hookets'));
				}
				else
				{
					$oHooket = $this->PluginHookets_ModuleHookets_GetHooketById(getRequest('hooket_id'));

					if ($oHooket)
					{
						$oHooket->setDescription(htmlspecialchars(getRequest('hooket_description')));
						$oHooket->setActive(getRequest('hooket_active'));
						$oHooket->setName(htmlspecialchars(getRequest('hooket_name')));
						$oHooket->setHookName(htmlspecialchars(getRequest('hooket_hook_name')));
						$oHooket->setType(getRequest('hooket_type'));
						$oHooket->setText(getRequest('hooket_text'));
						$oHooket->setPriority(getRequest('hooket_priority'));

						// * Добавляем проект
						if ($this->PluginHookets_ModuleHookets_UpdateHooket($oHooket)===null)
						{
							$this->MessageError($this->Lang_Get('hookets_edit_error'), $this->Lang_Get('error'), true);
						}
						else
						{
							$this->MessageNotice($this->Lang_Get('hookets_edit_success'), "", true);
							Router::Location('/'.Router::GetAction('hookets'));
						}
					}
				}
			}
			else return;
		}
		else
		{
			if ($is_creation)
			{
				$_REQUEST['hooket_type']="code";
				$_REQUEST['hooket_priority']="100";
				if (isset($_REQUEST['himport']))
				{
					$aImport=unserialize($_REQUEST['himport']);
					if (is_array($aImport))
					{
						foreach ($aImport as $key=>$val) $_REQUEST[$key]=$val;
					}
				}
			}
		}


		if (!$is_creation)
		{
			$aa=$this->GetParam(0);
			if (($oHooket=$this->PluginHookets_ModuleHookets_GetHooketById($aa))) {
				$_REQUEST['isConfigDisabled']=$oHooket->isConfigDisabled();
				$_REQUEST['hooket_id']=$oHooket->getId();
				$_REQUEST['hooket_description']=$oHooket->getDescription();
				$_REQUEST['hooket_active']=$oHooket->getActive();
				$_REQUEST['hooket_name']=$oHooket->getName();
				$_REQUEST['hooket_hook_name']=$oHooket->getHookName();
				$_REQUEST['hooket_type']=$oHooket->getType();
				$_REQUEST['hooket_text']=$oHooket->getText();
				$_REQUEST['hooket_priority']=$oHooket->getPriority();
				$this->Viewer_Assign('oHooket',$oHooket);
				$export=array();
				foreach ($_REQUEST as $key=>$val)
				{
					if (strpos($key,'hooket_')===0)
					{
						$export[$key]=$val;
					}
				}
				$export['hooket_active']=0;
				unset($export['hooket_id']);
				$_REQUEST['hexport']=serialize($export);
			} else {
				$this->MessageError($this->Lang_Get('hookets_edit_error'), $this->Lang_Get('error'));
				$this->SetParam(0, null);
			}
		}

		$this->Viewer_AddHtmlTitle($this->Lang_Get("hookets_{$this->sMenuSubItemSelect}_title"));
		$this->Viewer_Assign('sPageTitle', $this->Lang_Get("hookets_{$this->sMenuSubItemSelect}_title"));
		//$this->Viewer_Assign('vd',var_export($bb,true));
	}

	protected function EventImport() {
		$this->sMenuSubItemSelect='import';

		$this->Viewer_AddHtmlTitle($this->Lang_Get("hookets_{$this->sMenuSubItemSelect}_title"));
		$this->Viewer_Assign('sPageTitle', $this->Lang_Get("hookets_{$this->sMenuSubItemSelect}_title"));
	}

	protected function EventDelete() {
		$this->Security_ValidateSendForm();


		$iHookId =$this->GetParam(0);
		$oHooket = $this->PluginHookets_ModuleHookets_GetHooketById($iHookId);
		if ($oHooket)
		{
			if ($this->PluginHookets_ModuleHookets_DeleteHooket($oHooket)) {
				$this->Message_AddNotice($this->Lang_Get('hookets_delete_ok'), '', true);
			} else {
				$this->Message_AddError($this->Lang_Get('hookets_delete_fail'),$this->Lang_Get('error'),true);
			}
		}
		else
		{
			$this->Message_AddError($this->Lang_Get('hookets_delete_fail'), '', true);
		}
		Router::Location('/'.Router::GetAction('hookets'));
	}

	protected function EventEnable() {
		$this->Security_ValidateSendForm();


		$iHookId =$this->GetParam(0);
		$oHooket = $this->PluginHookets_ModuleHookets_GetHooketById($iHookId);
		if ($oHooket)
		{
			if ($this->PluginHookets_ModuleHookets_EnableHooket($oHooket)!==false)
			$this->Message_AddNotice($this->Lang_Get('hookets_enable_ok'), '', true);
			else
			$this->Message_AddError($this->Lang_Get('hookets_enable_fail'),$this->Lang_Get('error'),true);
		} else
		{
			$this->Message_AddError($this->Lang_Get('hookets_enable_fail'),$this->Lang_Get('error'),true);
		}
		Router::Location('/'.Router::GetAction('hookets'));
	}

	protected function EventDisable() {
		$this->Security_ValidateSendForm();


		$iHookId =$this->GetParam(0);
		$oHooket = $this->PluginHookets_ModuleHookets_GetHooketById($iHookId);
		if ($oHooket)
		{
			if ($this->PluginHookets_ModuleHookets_DisableHooket($oHooket)!==false)
			$this->Message_AddNotice($this->Lang_Get('hookets_disable_ok'), '', true);
			else
			$this->Message_AddError($this->Lang_Get('hookets_disable_fail'),$this->Lang_Get('error'),true);
		} else
		{
			$this->Message_AddError($this->Lang_Get('hookets_disable_fail'),$this->Lang_Get('error'),true);
		}
		Router::Location('/'.Router::GetAction('hookets'));
	}

	public function EventShutdown() {
		$this->Viewer_Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
		$this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
		$this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
		$this->Viewer_AddMenu('hookets', Plugin::GetTemplatePath('hookets').'menu.hookets.tpl');
		$this->Viewer_Assign('menu', 'hookets');
		$this->Viewer_Assign('sTemplatePath', Plugin::GetTemplatePath('hookets'));
		$this->Viewer_Assign('bEnabled', Config::Get('plugin.hookets.enabled'));
		foreach ($this->aBlocks as $sGroup=>$aGroupBlocks) {
			$this->Viewer_AddBlocks($sGroup, $aGroupBlocks);
		}
	}
}



?>