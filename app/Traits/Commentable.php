<?php

namespace App\Traits;

use App\Facades\BlogConfig;
use XblogConfig;

trait Commentable
{
	/**
	 * @return bool
	 */
	public function ifShowComments()
	{
		return BlogConfig::getValue('if_show_comments', true) && $this->getConfig('if_show_comments', true);
	}

	/**
	 * @return bool
	 */
	public function ifAllowComment()
	{
		return BlogConfig::getValue('if_allow_comment', true) && $this->getConfig('if_allow_comment', true);
	}
}