<?php

namespace App\Traits;

use App\Configuration;

trait Configurable
{
	public function getConfig($key, $default = null)
	{
		if (!isset($this->configuration) || !isset($this->configuration->config[$key]) || empty($this->configuration->config[$key])) {
			return $default;
		}

		return $this->configuration->config[$key];
	}

	/**
	 * @return array
	 */
	public abstract function getConfigKeys();

	/**
	 * @param array $array
	 * @return boolean
	 */
	public function saveConfig($array)
	{
		if (!$this->configuration) {
			$configuration = $this->setConfigKeys(new Configuration(), $array);
			return $this->configuration()->save($configuration);
		}
		return $this->setConfigKeys($this->configuration, $array)->save();
	}

	/**
	 * @param Configuration $configuration
	 * @param $array
	 * @return Configuration
	 */
	private function setConfigKeys(Configuration $configuration, $array)
	{
		$config = $configuration->config;
		foreach ($array as $key => $value) {
			if (in_array($key, $this->getConfigKeys())) {
				$config[$key] = $value;
			}
		}
		$configuration->config = $config;
		return $configuration;
	}

}
