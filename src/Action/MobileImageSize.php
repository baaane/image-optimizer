<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class MobileImageSize extends BaseAction
{
	/**
     * get new size
     *
     * @return string $data
     */
	public function get($data, $image = [])
	{
		$result = $this->create($data, $image, '690x960', BaseAction::MOBILE);
		return $result;
	}
}