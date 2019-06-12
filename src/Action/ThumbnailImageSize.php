<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class ThumbnailImageSize extends BaseAction
{	
	/**
     * get new size
     *
     * @return string $data
     */
	public function get($data, $image = [])
	{
		$result = $this->create($data, $image, '300x300', BaseAction::THUMBNAIL);
		return $result;
	}
}