<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class DesktopImageSize extends BaseAction
{
	/**
     * get new size
     *
     * @return string $data
     */
	public function get($data, $image = [])
	{
		$result = $this->create($data, $image, '1920x1080', BaseAction::DESKTOP);
		return $result;
	}
}