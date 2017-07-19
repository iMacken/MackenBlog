<?php

namespace App\Traits;

trait Commentable
{
	/**
	 * @return bool
	 */
	public function ifShowComments()
	{
		return setting('if_show_comments', true) && $this->getConfig('if_show_comments', true);
	}

	/**
	 * @return bool
	 */
	public function ifAllowComment()
	{
		return setting('if_allow_comment', true) && $this->getConfig('if_allow_comment', true);
	}
}
