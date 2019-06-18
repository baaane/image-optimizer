<?php

namespace Baaane\ImageUploader\Action;

use Baaane\ImageUploader\Action\BaseAction;

class ThumbnailImageSize extends BaseAction
{	
	/**
     * Get new size
     *
     * @return string
     */
	public function get($data, $size = [])
	{
		$name = BaseAction::THUMBNAIL;
		$defaultSize = $this->setDefaultSize(300,300);
		$data_result = $this->create($data, $size, $defaultSize, $name);
		
		return $data_result;
	}
}