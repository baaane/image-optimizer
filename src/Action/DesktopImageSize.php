<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class DesktopImageSize extends BaseAction
{
	/**
     * Get new size
     *
     * @return string
     */
	public function get($data, $size = [])
	{
		$name = BaseAction::DESKTOP;
		$defaultSize = $this->setDefaultSize(1920,1080);
		$data_result = $this->create($data, $size, $defaultSize, $name);
		
		return $data_result;
	}
}