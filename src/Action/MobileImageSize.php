<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class MobileImageSize extends BaseAction
{
	/**
     * @param array $data
     */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
     * get new size
     *
     * @return string $data
     */
	public function get($image = [])
	{
		$data = $this->create($this->data, $image, '690x960', BaseAction::MOBILE);
		return $data;
	}
}