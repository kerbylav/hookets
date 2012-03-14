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

class PluginHookets_ModuleHookets_EntityHooket extends Entity
{
	public function getId() {
		return $this->_aData['hooket_id'];
	}
	public function getActive() {
		return $this->_aData['hooket_active'];
	}
	public function getName() {
		return $this->_aData['hooket_name'];
	}
	public function getHookName() {
		return $this->_aData['hooket_hook_name'];
	}
	public function getDescription() {
		return $this->_aData['hooket_description'];
	}
	public function getType() {
		return $this->_aData['hooket_type'];
	}
	public function getPriority() {
		return intval($this->_aData['hooket_priority']);
	}
	public function getText() {
		return $this->_aData['hooket_text'];
	}
	public function isConfigDisabled() {
		$disabled=Config::Get('plugin.hookets.disabled');
		return (isset($disabled[$this->getId()]) && ($disabled[$this->getId()]));
	}
	public function isDisabled() {
		return (!$this->getActive()) || ($this->isConfigDisabled());
	}
	public function setId($data) {
		$this->_aData['hooket_id']=$data;
	}
	public function setActive($data) {
		$this->_aData['hooket_active']=$data?1:0;
	}
	public function setName($data) {
		$this->_aData['hooket_name']=$data;
	}
	public function setHookName($data) {
		$this->_aData['hooket_hook_name']=$data;
	}
	public function setDescription($data) {
		$this->_aData['hooket_description']=$data;
	}
	public function setType($data) {
		$this->_aData['hooket_type']=$data;
	}
	public function setPriority($data) {
		$this->_aData['hooket_priority']=intval($data);
	}
	public function setText($data) {
		$this->_aData['hooket_text']=$data;
	}
}
?>