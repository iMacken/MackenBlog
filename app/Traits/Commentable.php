<?php

namespace App\Traits;

use XblogConfig;

trait Commentable
{
	/**
	 * @return array
	 */
	public function getCommentInfo()
	{
		$configuration = $this->configuration ? $this->configuration->config : null;
		if (!$configuration) {
			$configuration = [];
			$configuration['comment_info'] = 'default';
			$configuration['comment_type'] = 'default';
		}
		return $configuration;
	}

	/**
	 * @return bool
	 */
	public function isShownComment()
	{
		$configuration = $this->getCommentInfo();
		return $configuration['comment_info'] != 'force_disable' && ($configuration['comment_info'] == 'force_enable' || XblogConfig::getValue('comment_type') != 'none');
	}

	/**
	 * @return bool
	 */
	public function allowComment()
	{
		$allow_resource_comment = $this->getConfig('allow_resource_comment', 'default');
		return $allow_resource_comment == 'default' ? XblogConfig::getBoolValue('allow_comment', true) : $this->getBoolConfig('allow_resource_comment', true);
	}

	/**
	 * @return string
	 */
	public function getCommentType()
	{
		$comment_type = XblogConfig::getValue('comment_type', 'raw');
		$commentable_config = $this->getCommentInfo()['comment_type'];
		return ($commentable_config == 'default' ? $comment_type : $commentable_config);
	}
}