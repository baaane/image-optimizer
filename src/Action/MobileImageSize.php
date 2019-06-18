<?php

namespace Baaane\ImageUploader\Action;

use Baaane\ImageUploader\Action\BaseAction;

class MobileImageSize extends BaseAction
{
	/**
     * Get new size
     *
     * @return string
     */
	public function get($data, $size = [])
	{
		$name = BaseAction::MOBILE;
		$defaultSize = $this->setDefaultSize(690,960);
		$data_result = $this->create($data, $size, $defaultSize, $name);
		
		return $data_result;
	}
}