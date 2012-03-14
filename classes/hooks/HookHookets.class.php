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

class HooketsVariableStream {
	var $position;
	var $varname;

	function stream_open($path, $mode, $options, &$opened_path)
	{
		$url = parse_url($path);
		$this->varname = $url["host"];
		$this->position = 0;

		return true;
	}

	function stream_stat()
	{
	    return NULL;
	}

	function stream_read($count)
	{
		$ret = substr($GLOBALS[$this->varname], $this->position, $count);
		$this->position += strlen($ret);
		return $ret;
	}

	function stream_write($data)
	{
		$left = substr($GLOBALS[$this->varname], 0, $this->position);
		$right = substr($GLOBALS[$this->varname], $this->position + strlen($data));
		$GLOBALS[$this->varname] = $left . $data . $right;
		$this->position += strlen($data);
		return strlen($data);
	}

	function stream_tell()
	{
		return $this->position;
	}

	function stream_eof()
	{
		return $this->position >= strlen($GLOBALS[$this->varname]);
	}

	function stream_seek($offset, $whence)
	{
		switch ($whence) {
			case SEEK_SET:
				if ($offset < strlen($GLOBALS[$this->varname]) && $offset >= 0) {
					$this->position = $offset;
					return true;
				} else {
					return false;
				}
				break;

			case SEEK_CUR:
				if ($offset >= 0) {
					$this->position += $offset;
					return true;
				} else {
					return false;
				}
				break;

			case SEEK_END:
				if (strlen($GLOBALS[$this->varname]) + $offset >= 0) {
					$this->position = strlen($GLOBALS[$this->varname]) + $offset;
					return true;
				} else {
					return false;
				}
				break;

			default:
				return false;
		}
	}
}

/**
 * Регистрация хуков
 *
 */
class PluginHookets_HookHookets extends Hook {

	public function RegisterHook() {
		if (!Config::Get('plugin.hookets.enabled')) return;

		$disabled=Config::Get('plugin.hookets.disabled');

		stream_wrapper_register("hvar", "HooketsVariableStream")
		or die("Failed to register protocol");

		$aHooks=$this->PluginHookets_Hookets_GetHookets();

		if ($aHooks)
		{
			foreach ($aHooks as $hooket)
			{
				$hid=$hooket->getId();
					
				if ($hooket->isDisabled()) continue;
					
				$code=$hooket->getText();
				if ($hooket->getType()=='text')
				{
					$code="return '".str_replace("'", "\'", $code)."';";
				}
				else
				if (($hooket->getType()=='code'))
				{
					$code='$oEngine=Engine::GetInstance(); '.$code;
				}
				if ($hooket->getType()=='template')
				{
					$GLOBALS["easy_hooket_template_".$hid]=$code;
					$code='$oEngine=Engine::GetInstance();  $oEngine->Viewer_Assign("hookets_source",\''.str_replace("'", "\'", $code).'\'); return $oEngine->Viewer_Fetch(Plugin::GetTemplatePath(\'hookets\')."/actions/ActionHookets/helper.tpl");';
				}

				$code="<? function Hooket_".$hid."(\$aVars) { $code } ?>";
				$GLOBALS["easy_hooket_func_".$hid]=$code;
				include "hvar://easy_hooket_func_".$hid;
				$this->Hook_AddExecFunction($hooket->getHookName(),"Hooket_".$hid,$hooket->getPriority());
			}
		}
	}

}
?>